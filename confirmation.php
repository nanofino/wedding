<?php
	require('./dbConnect.php');
	require('./libs/class.Templates.php');
	
	include_once('functions.php');
	

	$tpl = new Templates("tpl");
	$tpl->load_file("form.html", "FormBlock");

	$answer = $_POST['answer'];
	$guestCode = $_POST['guestCode'];

	$sql = "SELECT * FROM guests WHERE code='$guestCode'";
	$result = mysqli_query($link, $sql) or die(mysql_error());
	$guest = mysqli_fetch_assoc($result);	// traigo los datos del guest
	if($guest["guestQty"]>1) {
		$tpl->set_var("confirmAtt1", "confirmen si vienen");
		$tpl->set_var("youCome", "vienen");			
		$tpl->set_var("teLos", "Los");		
		$tpl->set_var("go", "vamos");			
		$tpl->set_var("Ican", "podemos");
		$tpl->set_var("change", "Cambiaron");
		$tpl->set_var("vanVas", "van");
	} else {
		$tpl->set_var("confirmAtt1", "confirmes si venís");
		$tpl->set_var("youCome", "venís");		
		$tpl->set_var("teLos", "Te");		
		$tpl->set_var("go", "voy");			
		$tpl->set_var("Ican", "puedo");			
		$tpl->set_var("change", "Cambiaste");
		$tpl->set_var("vanVas", "vas");
	}
	if($guest != NULL) {
		switch($answer) {
			case 'yes': 
				$tpl->set_var("guestCode",$guestCode);
				$tpl->set_var("FormToCompleteBlock","");
				$tpl->parse("AnswerYesBlock",true);
				$tpl->set_var("AnswerNoBlock","");
			break;
			case 'no': 
				$tpl->set_var("guestCode",$guestCode);
				$tpl->set_var("FormToCompleteBlock","");
				$tpl->set_var("AnswerYesBlock","");
				$tpl->parse("AnswerNoBlock",true);
			break;
			default: 
			break;
		}
		
		$sqlUpdate = "UPDATE guests SET response='$answer'";
		
		$sqlUpdate .= ", responseDate='".nowTime()."'";
		
		if($guest['response']!=NULL){
		
			// AGREGAR ACA LOS DEMAS DATOS A UPDATEAR
		}					

		$sqlUpdate .= " WHERE code='$guestCode'";
		$resultUpdate = mysqli_query($link, $sqlUpdate) or die(mysql_error());
	}
	
	$tpl->pparse("FormBlock");

?>