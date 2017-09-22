<?php
	echo "id,name,longName,email,guestQty,code,response,responseDate,firstAccessDate,lastAccessDate,accessQty\n";
for($i = 1; $i <= 200 ;$i++){ // PARA ARMAR EL guest.csv (200 FILAS CON DUMMY TEXT)
	$newMD5 = md5(strval($i));
	echo "$i, Juan, Juan Perez, a@a.com, 1, $newMD5, NULL, NULL, NULL, NULL, NULL\n";
}

?>