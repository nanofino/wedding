<?php
	require('./dbConnect.php');
	require('./libs/class.Templates.php');
	include_once('functions.php');
	$tpl = new Templates("tpl");
	$tpl->load_file("main.html", "main");
	if(isset($_GET['i'])) {
		$tpl->set_var("ConfirmationBlock","");
		$tpl->set_var("PartyLinkBlock","");
		$tpl->set_var("PartyInfoBlock","");
	} else {
		if(isset($_GET['w'])){
			$guestCode = $_GET['w'];
		} else {
			$guestCode = "0";
		}
		if($guestCode != "0") {
			
			$sql = "SELECT * FROM guests WHERE code='$guestCode'";
			$result = mysqli_query($link, $sql) or die(mysql_error());
			
			$guest = mysqli_fetch_assoc($result);
			$guest["name"] = " ".$guest["name"];
			
			// ACA GUARDO LOS DATOS DEL ACCESO ACTUAL.
			$guestAccessQty = $guest["accessQty"]+1;
			$sqlSetAccessDate = "UPDATE guests SET lastAccessDate='".nowTime()."', accessQty='$guestAccessQty'";
//			$sqlSetAccessDate = "UPDATE guests SET lastAccessDate='".nowTime()."', accessQty='$guestAccessQty'";
			if($guestAccessQty === 1){
				$sqlSetAccessDate .=", firstAccessDate='".nowTime()."'";
			}
			$sqlSetAccessDate .=  "WHERE code='$guestCode'";
			$resultSetAccessDate = mysqli_query($link, $sqlSetAccessDate) or die(mysql_error());
		} else {
			$guest;
			$guestCode = "0";
			$guest["guestCode"]	= $guestCode;
			$guest["name"]	= "";
			$guest["guestQty"]	 = "1";
			$guest["response"] = 'unknown';
		}
		// traigo los datos del guest
		if($guest["guestQty"]>1) {
			$tpl->set_var("do", "hagan");
			$tpl->set_var("inviteYou", "invitarlos");
			$tpl->set_var("can", "puedan");
			$tpl->set_var("can2", "pueden");	
			$tpl->set_var("attendance", "Que estén presentes");
			$tpl->set_var("confirmAtt", "Confírmennos su presencia");
			$tpl->set_var("teLes", "les");
			$tpl->set_var("youNeed", "necesitan");
			$tpl->set_var("prende", "prendan");
			$tpl->set_var("youAre", "estén");
			$tpl->set_var("youHave", "tienen");
			$tpl->set_var("wantBeSit", "quieren estar sentados");
			$tpl->set_var("tryTo", "traten");
			$tpl->set_var("want", "quieren");
			$tpl->set_var("wantTo", "quieran");
			$tpl->set_var("contact", "contáctense");
	
			$tpl->set_var("confirmAtt1", "confirmen si vienen");
			$tpl->set_var("youCome", "vienen");
			$tpl->set_var("teLos", "Los");
			$tpl->set_var("go", "vamos");
			$tpl->set_var("Ican", "podemos");
			$tpl->set_var("change", "Cambiaron");
			$tpl->set_var("vanVas", "van");
		} else {
			$tpl->set_var("do", "hagas");
			$tpl->set_var("inviteYou", "invitarte");
			$tpl->set_var("can", "puedas");
			$tpl->set_var("can1", "podés");
			$tpl->set_var("attendance", "Tu presencia");
			$tpl->set_var("confirmAtt", "Confirmanos tu presencia");
			$tpl->set_var("teLes", "te");
			$tpl->set_var("youNeed", "necesitás");
			$tpl->set_var("prende", "prendé");
			$tpl->set_var("youAre", "estés");
			$tpl->set_var("youHave", "tenés");
			$tpl->set_var("wantBeSit", "querés estar sentado");
			$tpl->set_var("tryTo", "tratá");
			$tpl->set_var("want", "querés");
			$tpl->set_var("wantTo", "quieras");
			$tpl->set_var("contact", "contáctate");
	
			$tpl->set_var("confirmAtt1", "confirmes si venís");
			$tpl->set_var("youCome", "venís");
			$tpl->set_var("teLos", "Te");
			$tpl->set_var("go", "voy");
			$tpl->set_var("Ican", "puedo");
			$tpl->set_var("change", "Cambiaste");
			$tpl->set_var("vanVas", "vas");
		}
		$tpl->set_var("guestCode", $guestCode);
		$tpl->set_var("guestName", $guest["name"]);

		$tpl->load_file("form.html", "FormBlock");
		// var_dump($guest);
		// SI AUN NO CONTESTO, MUESTRO EL FORM
		switch($guest["response"]) {
			case NULL :
				$tpl->set_var("guestCode", $guestCode);
				$tpl->parse("FormToCompleteBlock",true);
				$tpl->set_var("AnswerYesBlock","");
				$tpl->set_var("AnswerNoBlock","");
			break;
			case 'yes' :
				$tpl->set_var("guestCode", $guestCode);
				$tpl->set_var("FormToCompleteBlock","");
				$tpl->parse("AnswerYesBlock",true);
				$tpl->set_var("AnswerNoBlock","");
	
			break;
			case 'no' :
				$tpl->set_var("guestCode", $guestCode);
				$tpl->set_var("FormToCompleteBlock","");
				$tpl->set_var("AnswerYesBlock","");
				$tpl->parse("AnswerNoBlock",true);
			break;
			case 'unknown' :
				$tpl->set_var("FormToCompleteBlock","");
				$tpl->set_var("AnswerYesBlock","");
				$tpl->set_var("AnswerNoBlock","");
				$tpl->set_var("ConfirmationBlock","");
			break;
		}
	}
	//PARSEO TODO.
	$tpl->pparse("main");

?>
