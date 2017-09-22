<?php
/*********************************************************************************
 *       Filename: template.php
 *       PHP 5.0 & Templates Modified 18/11/2006
 *
 *       Usage:
 *       $tpl = new Template($app_path);
 *       $tpl->load_file($template_filename, "main");
 *       $tpl->set_var("ID", 2);
 *       $tpl->set_var("Value", "Name");
 *       $tpl->parse("DynBlock", false); // true if you want to create a list
 *
 *       $tpl->pparse("main", false); // parse and output block
 *                 OR
 *       $tpl->parse("main", false); // parse block
 *       $tpl->print_var("main");    // output block
 *********************************************************************************/

class Templates{
	private $sTemplate;
	private $DBlocks;       	/* initial data files and blocks */
	private $ParsedBlocks;   	/* resulted data and variables	*/
	private $sPath;
	private $tempout;
	private $sError;
	private $vLabels;
	private $startVarTag	= "{";
	private $endVarTag		= "}";
	private $sLabelPrefix 	= null;
	private $sFunTransaltion	= null;
	private $oDesc;
	private $strDebug;
	private $vObjVars;

	public function __construct($sTemplatesPath=".",$sLabelPrefix="lbl"){
		$this->DBlocks 			= array();
		$this->ParsedBlocks		= array();
		$this->sPath 			= $sTemplatesPath;
		$this->sTemplate		= null;
		$this->tempout			= null;
		$this->sError			= null;
		$this->vLabels			= null;
		$this->sLabelPrefix		= $sLabelPrefix;
	}

	public function __destruct(){
		if ($this->sError) {
			echo <<<ENDL
			<script type="text/javascript">
			function hideTemplateError(divErr){
			//var divErr = document.getElementById("TemplatesError");
			divErr.style.display = "none";
		}
		</script>
		<style type="text/css">
		.TemplateError{
		background-color: InfoBackground;
		width: 35%;
		border-style:solid;
		border-color:#000000;
		border-width:1px;
		margin: 30px;
		padding: 10px;
		display:block;
		position:absolute;
		top: 0px;
		left: 57%;
		bottom: auto;
		right: auto;
		clear: both;
		font-size:small;
		}
		.TemplateError i{
		text-decoration: underline;
		font-weight:bold;
		}

		.TemplateError div{
		background-color: InfoBackground;
		color: InfoText;
		}

		</style>
		<div class="TemplateError" id="TemplatesError" onclick="hideTemplateError(this);">{$this->sError}</div>
ENDL;
		$this->sError = null;
		}
		if ($this->strDebug) {
			echo <<<ENDL
			<script type="text/javascript">
			function hideTemplateDebug(divErr){
			//var divErr = document.getElementById("TemplateDebug");
			divErr.style.display = "none";
		}
		</script>
		<style type="text/css">
		.TemplateDebug{
		background-color: #333;
		width: 35%;
		border-style:solid;
		border-color:#000000;
		border-width:1px;
		margin: 30px;
		padding: 10px;
		display:block;
		position:absolute;
		top: 0px;
		left: 57%;
		bottom: auto;
		right: auto;
		clear: both;
		font-size:small;
		color: #EFEFEF;
		}
		.TemplateDebug i{
		text-decoration: underline;
		font-weight:bold;
		}

		.TemplateDebug div{
		background-color: InfoBackground;
		color: InfoText;
		}

		</style>
		<div class="TemplateDebug" id="TemplateDebug" onclick="hideTemplateDebug(this);">{$this->strDebug}</div>
ENDL;
		$this->strDebug = null;
		}
	}


	private function debug($str,$bExit = false){
		if($_SERVER["REMOTE_ADDR"] == "127.0.0.1"){
			$this->strDebug .= var_export($str,true) . "<br />";
			if($bExit){
				exit;
			}
		}
	}
	/**
	 * Load template from file
	 *
	 * @param string $sFilename
	 * @param string $sBlockName
	 */
	public function load_file($sFilename, $sBlockName,$bTranslate = true,$vReplaceVars = null){
		$nName = null;
		$template_path = $this->sPath . "/" . $sFilename;

		if (file_exists($template_path)){

		 $this->DBlocks[$sBlockName] = file_get_contents($template_path);
		 if(is_array($vReplaceVars)){
		 	foreach($vReplaceVars as $sOldVar => $sNewVar){
		 		$this->DBlocks[$sBlockName] =  str_replace("$sOldVar","$sNewVar",$this->DBlocks[$sBlockName] );
		 	}
		 }
			$this->blockLabels($sBlockName);
			$this->blockObjVars($sBlockName);

			$nName = $this->NextDBlockName($sBlockName);
			while ($nName != ""){
				$this->SetBlock($sBlockName, $nName);
				$nName = $this->NextDBlockName($sBlockName);
			}
		}else{
			throw new Exception("File don't exists:: $sFilename");
		}
		if($bTranslate){
			$this->Translate();
		}
	}

	/**
	 * Load only a template section from file
	 *
	 * @param string $filename
	 * @param string $targetBlock
	 * @param string $sectionName
	 */
	public function load_file_section($sFilename, $sBlockName, $sSectionName,$bTranslate = true) {
		$nName = null;
		$template_path = $this->sPath . "/" . $sFilename;
		if (file_exists($template_path)) {
			$holeFile = file_get_contents($template_path);
			$posStart =  strpos($holeFile, "<!--Begin" . trim($sSectionName) . "-->");
			$posEnd = strpos($holeFile, "<!--End" . trim($sSectionName) . "-->") + strlen("<!--End" . trim($sSectionName) . "-->");
			$this->DBlocks[$sBlockName] = substr($holeFile, $posStart,  $posEnd - $posStart);
			$this->blockLabels($sBlockName);
			$this->blockObjVars($sBlockName);

			$nName = $this->NextDBlockName($sBlockName);
			while ($nName != "") {
				$this->SetBlock($sBlockName, $nName);
				$nName = $this->NextDBlockName($sBlockName);
			}
		}else{
			throw new Exception("File don't exists:: $sFilename");
		}
		if($bTranslate){
			$this->Translate();
		}
	}

	/**
	 * Load template from string
	 * - Use load_from_string instead of this -
	 * @param string $sTemplate
	 * @param string $sName
	 */
	public function load_html($html, $sName) {
		$this->load_from_string($html, $sName);
	}

	/**
	 * Load template from string
	 *
	 * @param string $sTemplate
	 * @param string $sName
	 */
	public function load_from_string($sTemplate,$sBlockName,$bTranslate = true){
		if (strlen($sTemplate)){
			$this->DBlocks[$sBlockName] = $sTemplate;
			$this->blockLabels($sBlockName);
			$this->blockObjVars($sBlockName);
			$nName = $this->NextDBlockName($sBlockName);
			while ($nName != ""){
				$this->SetBlock($sBlockName, $nName);
				$nName = $this->NextDBlockName($sBlockName);
			}
		}
		if($bTranslate){
			$this->Translate();
		}
	}

	/**
	 * Load template from string
	 * - Use load_from_string($sTemplate,$sBlockName) -
	 *
	 * @param string $sTemplate
	 * @param string $sName
	 */
	public function load_BlockFromVar ($sName, $sVariable){
		//		$this->load_from_string($sString,$sBlockName);
		$this->DBlocks[$sName] = $sVariable;
		$nName = $this->NextDBlockName($sName);
		while ($nName != "") {
			$this->SetBlock($sName, $nName);
			$nName = $this->NextDBlockName($sName);
		}
	}


	private function NextDBlockName($sTemplateName){
		$sTemplate 	= $this->DBlocks[$sTemplateName];
		$BTag 		= strpos($sTemplate, "<!--Begin");
		if($BTag === false){
			return null;
		}else{
			$ETag 	= strpos($sTemplate, "-->", $BTag);
			$sName 	= substr($sTemplate, $BTag + 9, $ETag - ($BTag + 9));
			if(strpos($sTemplate, "<!--End" . $sName . "-->") > 0){
				return $sName;
			}else{
				return null;
			}
		}
	}

	private function SetBlock($sTplName, $sBlockName){
		if(!isset($this->DBlocks[$sBlockName])){
			$this->DBlocks[$sBlockName] = $this->getBlock($this->DBlocks[$sTplName], $sBlockName);
		}

		$this->DBlocks[$sTplName] = $this->replaceBlock($this->DBlocks[$sTplName], $sBlockName);

		$nName = $this->NextDBlockName($sBlockName);
		while($nName != ""){
			$this->SetBlock($sBlockName, $nName);
			$nName = $this->NextDBlockName($sBlockName);
		}
	}

	private function getBlock($sTemplate, $sName){
		$alpha 		= strlen($sName) + 12;
		$BBlock 	= strpos($sTemplate, "<!--Begin" . $sName . "-->");
		$EBlock 	= strpos($sTemplate, "<!--End" . $sName . "-->");
		if($BBlock === false || $EBlock === false){
			return null;
		}else{
			return substr($sTemplate, $BBlock + $alpha, $EBlock - $BBlock - $alpha);
		}
	}


	/**
	 * Replaces an entire block with a var
	 * <strong>Before</strong> &lt;!--BeginMyBlock-->Block content&lt;!--EndBlock-->
	 * <strong>After</strong>  {MyBlock}
	 *
	 * @param string $sTemplate
	 * @param string $sName
	 * @return string
	 */
	private function replaceBlock($sTemplate, $sName){
		$BBlock = strpos($sTemplate, "<!--Begin" . $sName . "-->");
		$EBlock = strpos($sTemplate, "<!--End" . $sName . "-->");
		if($BBlock === false || $EBlock === false){
			return $sTemplate;
		}else{
			return substr($sTemplate,0,$BBlock) . "{" . $sName . "}" . substr($sTemplate, $EBlock + strlen("<!--End" . $sName . "-->"));
		}
	}

	/**
	 * Returns a block without parsing
	 *
	 * @param string $sBlockName
	 * @return string
	 */
	public function GetVar($sBlockName){
		return $this->DBlocks[$sBlockName];
	}

	/**
	 * Return a block that has been parsed already
	 *
	 * @param string $sBlockName
	 * @return string
	 */
	function getParsedVar($sBlockName) {
		return $this->ParsedBlocks[$sBlockName];
	}

	/**
	 * Replaces the value of a variable in template
	 *
	 * @param string $sName
	 * @param string $sValue
	 */
	public function set_var($sVarName, $sValue){
		
		if(is_object($sValue)){
			if(get_class($sValue) == "stdClass"){
				foreach( $sValue as $k=>$v ){
					$this->set_var("{$sVarName}.{$k}", $v);
				}
			}
		}else if( ( is_array($sValue) /*|| ( get_class($sValue) == "stdClass")*/ ) ) {
			foreach( $sValue as $k=>$v ){
				$this->set_var("{$sVarName}.{$k}", $v);
			}
		} else {
			$this->ParsedBlocks[$sVarName] = $sValue;
		}
	}

	/**
	 * Improved version of set_var
	 *
	 * @param string $sVarName
	 * @param mixed $oValue
	 *
	 * If $oValue is a string, acts as the previous version
	 * If $oValue is stdClass or Associative Array, replaces each array key with value
	 * If $oValue is an object, checks if exist a getter method and replaces using
	 */
	public function setVar($sVarName, $oValue,$sType = null){
		if( ( is_array($oValue) || ( get_class($oValue) == "stdClass") ) ) {
			foreach( $oValue as $k=>$v ){
				if(isset($this->vObjVars[$sVarName]->$k)){
					$dummy = $this->vObjVars[$sVarName]->$k;
					if(is_a($dummy,"stdClass")){
						foreach($dummy as $tmpAttr=>$cc){
							if($tmpVal instanceof stdClass){
								$this->setVar("$sVarName.$sAtt.$tmpAttr",$tmpVal->$tmpAttr);
							}else{
								$stmpMethod = "get" . $tmpAttr;
								if(method_exists($oValue->$k,$stmpMethod)){
									$this->setVar("$sVarName.{$k}.$tmpAttr",$oValue->$k->$stmpMethod());
								}
							}
						}
					}else{
						$this->setVar("{$sVarName}.{$k}", $v);
					}
				}

			}
		}elseif(is_object($oValue)){

			if( isset($this->vObjVars[$sVarName])){
				foreach($this->vObjVars[$sVarName] as $sAtt=>$dummy){
					list($sAtt,$sType) = split(":",$sAtt);
					$sMethodName = "get" . $sAtt;

					if(method_exists($oValue,$sMethodName)){
						$tmpVal = $oValue->$sMethodName();

						if( is_a($dummy,"stdClass")){
							foreach($dummy as $tmpAttr=>$cc){
								if(is_a($tmpVal,"stdClass")){
									$this->setVar("$sVarName.$sAtt.$tmpAttr",$tmpVal->$tmpAttr,$sType);
								}else{
									$stmpMethod = "get" . $tmpAttr;
									if(method_exists($tmpVal,$stmpMethod)){
										$this->setVar("$sVarName.$sAtt.$tmpAttr",$tmpVal->$stmpMethod(),$sType);
									}
								}
							}
						}
						$this->setVar("$sVarName.$sAtt",$tmpVal,$sType);
					}
				}
			}
		}else {
			if($sType != null)  {
				$sType = strtolower($sType);
				$sVarName .=":$sType";
				$sM = "format_$sType";
				if(method_exists($this,$sM)){
					$oValue = $this->$sM($oValue);
				}
			}
			$this->ParsedBlocks[$sVarName] = $oValue;
		}
	}

	private function format_int($sValue){
		return number_format($sValue,0,",",".");
	}

	private function format_float($sValue){
		return number_format($sValue,2,",",".");
	}

	/**
	 * Print the value of a variable
	 *
	 * @param string $sVarName
	 */
	public function print_var($sVarName){
		if(isset($this->ParsedBlocks[$sVarName])){
			echo $this->ParsedBlocks[$sVarName];
		}
	}

	function assign_var($sName){
		$this->tempout.= $this->ParsedBlocks[$sName];
	}

	/**
	 * Parse a Block or full template
	 *
	 * @param string $sBlockName
	 * @param bool $bRepeat
	 */
	public function parse($sBlockName, $bRepeat=false){
		if(isset($this->DBlocks[$sBlockName])){
			if($bRepeat && isset($this->ParsedBlocks[$sBlockName])){
				$this->ParsedBlocks[$sBlockName] .= $this->ProceedTpl($this->DBlocks[$sBlockName]);
			}else{
				$this->ParsedBlocks[$sBlockName] = $this->ProceedTpl($this->DBlocks[$sBlockName]);
			}
		}else{
			if(E_ERROR & error_reporting() == E_ERROR){
				//throw new Exception("Block with name $sBlockName does't exist");
			}else{
				$this->sError .= "<div>Block with name <i>$sBlockName</i> does't exist</div>";
			}
		}
	}


	// This function should be called after parse main page
	// For examples see on project "New-Nina" page templatesabm.php
	public function put_without_parse ($sTplName, $sKeyName, $sValue) {
		$pBlock = $this->ParsedBlocks[$sTplName] ;
		$this->ParsedBlocks[$sTplName] = str_replace("@##_".$sKeyName."_##@", $sValue, $pBlock);
	}


	/**
	 * Parse a Block or full template and then print it
	 *
	 * @param string $sTplName
	 * @param bool $bRepeat
	 */
	public function pparse($sBlockName, $bRepeat=false,$bTranslate=false){
		$this->parse($sBlockName, $bRepeat,$bTranslate);
		echo $this->ParsedBlocks[$sBlockName];
	}

	/**
	 * Load all vars from a block in an array
	 *
	 * @param string $sTpl
	 * @param string $beginSymbol
	 * @param string $endSymbol
	 * @return array
	 */
	private function blockVars($sTpl,$beginSymbol = "{",$endSymbol="}"){
		$iCount = preg_match_all("|$beginSymbol([a-zA-Z0-9:\_\.]*)$endSymbol|U", $sTpl, $vResult, PREG_PATTERN_ORDER);
		if( ($iCount > 0) && isset($vResult[1])){
			$vRes = array_values(array_unique($vResult[1]));
			//array_walk($vRes,array($this,"objectVars"),& $this->vObjVars);
			return $vRes;
		}else{
			return null;
		}
	}

	private function blockObjVars($sBlockName){
		$sTpl				= $this->DBlocks[$sBlockName];
		$beginSymbol		= $this->startVarTag;
		$endSymbol			= $this->endVarTag;

		$iCount = preg_match_all("|$beginSymbol([a-zA-Z0-9\:\_\.]*)$endSymbol|U", $sTpl, $vResult, PREG_PATTERN_ORDER);
		if( ($iCount > 0) && isset($vResult[1])){

			$vRes = array_values(array_unique($vResult[1]));
			//array_walk($vRes,array($this,"objectVars"),& $this->vObjVars);
			foreach($vRes as $dummy=>$sValue){
				if(strpos($sValue,".") !== false){
					list($sVarname,$sAttribute,$sMoreAtt) = split("\.",$sValue);

					if($sMoreAtt){
						$this->vObjVars[$sVarname]->$sAttribute->$sMoreAtt = 1;
					}else{
						$this->vObjVars[$sVarname]->$sAttribute = 1;
					}

				}
			}

		}

	}

	private function objectVars($sValue,$sKey,& $vDest){
		/*
		 if(strpos($sValue,".") !== false){
			list($sVarname,$sAttribute,$sMoreAtt) = split("\.",$sValue);
			$vDest[$sVarname]->$sAttribute = 1;
			}
			*/


		if(strpos($sValue,".") !== false){
			list($sVarname,$sAttribute,$sMoreAtt) = split("\.",$sValue);

			if($sMoreAtt){
				$vDest[$sVarname]->$sAttribute->$sMoreAtt = 1;
			}else{
				$vDest[$sVarname]->$sAttribute = 1;
			}

		}
	}

	/**
	 * Load all the labels in an array
	 * - Useful for traductions -
	 *
	 * @param string $sBlockName
	 */
	private function blockLabels($sBlockName){
		$sTpl				= $this->DBlocks[$sBlockName];
		$beginSymbol		= $this->startVarTag .  $this->sLabelPrefix;
		$endSymbol			= $this->endVarTag;
		$beginSymbolLength 	= strlen($beginSymbol);
		$endTag 			= 0;
		$vVars				= null;
		while (($beginTag = strpos($sTpl,$beginSymbol,$endTag)) !== false){
			if (($endTag = strpos($sTpl,$endSymbol,$beginTag)) !== false){
				$this->vLabels[] = $this->sLabelPrefix . substr($sTpl, $beginTag + $beginSymbolLength, $endTag - $beginTag - $beginSymbolLength);
			}
		}
		if(is_array($this->vLabels)){
			$this->vLabels = array_unique($this->vLabels);
		}
	}

	/**
	 * Delete Label from labels list
	 *
	 * @param string $sLabel
	 */
	public function delLabel($sLabel){
		if(isset($this->vLabels[$sLabel])){
			unset($this->vLabels[$sLabel]);
		}
	}

	/**
	 * @param string $sLabelPrefix
	 */
	public function setLabelPrefix($sLabelPrefix){
		$this->sLabelPrefix = $sLabelPrefix;
	}

	/**
	 * Return all collected labels
	 *
	 * @return array
	 */
	public function getLabels(){
		return $this->vLabels;
	}

	/**
	 * Set Callback function to translate labels
	 *
	 * @param string $sFunctionName
	 * @param Descriptions $oDesc
	 */
	public function setTranlateCallback($sFunctionName = null,$oDesc){
		if(!$sFunctionName || !($oDesc instanceof Descriptions)){
			throw new Exception("[ setTranlateCallback ] Function name emtpy or incorrect Object Descrition");
		}

		$this->sFunTransaltion = $sFunctionName;
		$this->oDesc = $oDesc;
	}

	private function Translate(){
		if($this->sFunTransaltion){
			call_user_func($this->sFunTransaltion,$this,$this->oDesc);
			$this->vLabels = null;
		}

	}

	private function ProceedTpl($sTpl){
		$vars = $this->blockVars($sTpl,"{","}");

		if(is_array($vars)){
			foreach ($vars as $value){
				if(preg_match("/^[\w\_\.:][\w\_\.:]*$/",$value)){
					if(isset($this->ParsedBlocks[$value])){
						$sTpl = str_replace("{".$value."}",$this->ParsedBlocks[$value],$sTpl);
					}else{
						if(isset($this->DBlocks[$value])){
							$this->parse($value, false);
							$sTpl = str_replace("{".$value."}", $this->ParsedBlocks[$value], $sTpl);
						}else{
							$sTpl = str_replace("{".$value."}","",$sTpl);
						}
					}
				}
			}
		}
		return $sTpl;
	}

	public function PrintAll(){
		$res = "<table border=\"1\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
		$res .= "<tr bgcolor=\"#C0C0C0\" align=\"center\"><td>Key</td><td>Value</td></tr>";
		$res .= "<tr bgcolor=\"#FFE0E0\"><td colspan=\"2\" align=\"center\">ParsedBlocks</td></tr>";
		reset($this->ParsedBlocks);
		while(list($key, $value) = each($this->ParsedBlocks)){
			$res .= "<tr><td><pre>" . htmlspecialchars($key) . "</pre></td>";
			$res .= "<td><pre>" . htmlspecialchars($value) . "</pre></td></tr>";
		}
		$res .= "<tr bgcolor=\"#E0FFE0\"><td colspan=\"2\" align=\"center\">DBlocks</td></tr>";
		reset($this->DBlocks);
		while(list($key, $value) = each($this->DBlocks)){
			$res .= "<tr><td><pre>" . htmlspecialchars($key) . "</pre></td>";
			$res .= "<td><pre>" . htmlspecialchars($value) . "</pre></td></tr>";
		}
		$res .= "</table>";
		return $res;
	}
}

?>