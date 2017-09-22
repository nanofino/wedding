<?php
	require('./dbConnect.php');
	require('./libs/class.Templates.php');
	include_once('functions.php');
	$sql = "SELECT * FROM guests WHERE response='yes' ORDER BY responseDate DESC";
	$link->real_query($sql);
	$query = $link->store_result();
	$html = null;
	$html1 = null;
	$html2 = null;
	$qty = 0;
	while ($guest = $query->fetch_assoc()) {
		$html.= "<tr>";
		$html.= "<td>".$guest["id"]."</td>";
		$html.= "<td>".$guest["name"]."</td>";
		$html.= "<td>".$guest["longName"]."</td>";
		$html.= "<td>".$guest["guestQty"]."</td>";
		$html.= "<td>".$guest["email"]."</td>";
		$html.= "<td>".$guest["code"]."</td>";
		$html.= "<td>".$guest["response"]."</td>";
		$html.= "<td>".$guest["accessQty"]."</td>";
		$html.= "<td>".$guest["responseDate"]."</td>";
		$html.= "<td>".$guest["firstAccessDate"]."</td>";
		$html.= "<td>".$guest["lastAccessDate"]."</td>";
		$html.= "</tr>";
		$qty = $qty + $guest["guestQty"];
	}
	?>
	<h1>VIENEN <? echo $qty ?> invitados <span style="font-weight:normal; font-size: .7em;">(Se contestaron <?echo $query->num_rows?> invitaciones)</span></h1>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Nombre Completo</th>
			<th>Invitados</th>
			<th>Email</th>
			<th>Code</th>
			<th>Respuesta</th>
			<th>Accesos</th>
			<th>FECHA RESPUESTA</th>
			<th>PRIMER INGRESO</th>
			<th>ULTIMO INGRESO</th>
		</tr>
		<?php
		print $html;
		?>
	</table>

	<?php
	$sql1 = "SELECT * FROM guests WHERE response='no' ORDER BY responseDate DESC";
	$link->real_query($sql1);
	$query1 = $link->store_result();
	$html1;
	$qty1 = 0;
	while ($guest1 = $query1->fetch_assoc()) {
		$html1 .= "<tr>";
		$html1 .= "<td>".$guest1["id"]."</td>";
		$html1 .= "<td>".$guest1["name"]."</td>";
		$html1 .= "<td>".$guest1["longName"]."</td>";
		$html1 .= "<td>".$guest1["guestQty"]."</td>";
		$html1 .= "<td>".$guest1["email"]."</td>";
		$html1 .= "<td>".$guest1["code"]."</td>";
		$html1 .= "<td>".$guest1["response"]."</td>";
		$html1 .= "<td>".$guest1["accessQty"]."</td>";
		$html1 .= "<td>".$guest1["responseDate"]."</td>";
		$html1 .= "<td>".$guest1["firstAccessDate"]."</td>";
		$html1 .= "<td>".$guest1["lastAccessDate"]."</td>";
		$html1 .= "</tr>";
		$qty1 = $qty1 + $guest1["guestQty"];
	}
	?>
	<h1>NO VIENEN <? echo $qty1 ?> invitados <span style="font-weight:normal; font-size: .7em;">(Se contestaron <?echo $query1->num_rows?> invitaciones)</span></h1>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Nombre Completo</th>
			<th>Invitados</th>
			<th>Email</th>
			<th>Code</th>
			<th>Respuesta</th>
			<th>Accesos</th>
			<th>FECHA RESPUESTA</th>
			<th>PRIMER INGRESO</th>
			<th>ULTIMO INGRESO</th>
		</tr>
		<?php
		print $html1;
		?>
	</table>

	<?php
	$sql2 = "SELECT * FROM guests WHERE response IS NULL ORDER BY accessQty DESC";
	$link->real_query($sql2);
	$query2 = $link->store_result();
	$qty2 = 0;
	while ($guest2 = $query2->fetch_assoc()) {
		$html2 .= "<tr>";
		$html2 .= "<td>".$guest2["id"]."</td>";
		$html2 .= "<td>".$guest2["name"]."</td>";
		$html2 .= "<td>".$guest2["longName"]."</td>";
		$html2 .= "<td>".$guest2["guestQty"]."</td>";
		$html2 .= "<td>".$guest2["email"]."</td>";
		$html2 .= "<td>".$guest2["code"]."</td>";
		$html2 .= "<td>".$guest2["response"]."</td>";
		$html2 .= "<td>".$guest2["accessQty"]."</td>";
		$html2 .= "<td>".$guest2["responseDate"]."</td>";
		$html2 .= "<td>".$guest2["firstAccessDate"]."</td>";
		$html2 .= "<td>".$guest2["lastAccessDate"]."</td>";
		$html2 .= "</tr>";
		$qty2 = $qty2 + $guest2["guestQty"];
	}
	?>
	<h1>NO CONTESTARON AUN <? echo $qty2 ?> invitados <span style="font-weight:normal; font-size: .7em;">(<?echo $query2->num_rows?> invitaciones sin contestar)</span></h1>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Nombre Completo</th>
			<th>Invitados</th>
			<th>Email</th>
			<th>Code</th>
			<th>Respuesta</th>
			<th>Accesos</th>
			<th>FECHA RESPUESTA</th>
			<th>PRIMER INGRESO</th>
			<th>ULTIMO INGRESO</th>
		</tr>
		<?php
		print $html2;
		?>
	</table>
