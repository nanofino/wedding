<?php

	
	function nowTime(){
		date_default_timezone_set('America/Argentina/Buenos_Aires');//or change to whatever timezone you want

		$datetime = new DateTime(date('Y-m-d H:i:s'));
//		$arg_time = new DateTimeZone('America/Argentina/Buenos_Aires');
//		$datetime->setTimezone($arg_time);
		$datetime = $datetime->format('Y-m-d H:i:s');
		return $datetime;
	}	
	
?>