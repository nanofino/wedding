<?php

require('./dbConnect.php');
$title = "Nos casamos!";

$sql = "SELECT * FROM guests WHERE sent=0";
$link->real_query($sql);

$query = $link->store_result();
while ($guest = $query->fetch_assoc()) {
	$to  = $guest["email"]; 
	$toName = $guest["longName"];
	$toShortName = $guest["name"];
	$toCode = $guest["code"];
	// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=\"utf-8\"" . "\r\n";
	
	// Cabeceras adicionales
	$headers .= "To: $toName <$to>" . "\r\n";
	$headers .= "From:Dolo y Nano <nano@nanofino.com.ar>" . "\r\n";
		
	//EL MAIL LO ARME EN MAILCHIMP
	$message = "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
			<meta name=\"viewport\" content=\"width=device-width, initial=-scale=1.0\">
			<title>Nos casamos!</title>
			<!--[if gte mso 6]>
			<style>
				table.mcnFollowContent {width:100% !important;}
				table.mcnShareContent {width:100% !important;}
			</style>
			<![endif]-->
			<style type=\"text/css\">
				body,#bodyTable,#bodyCell{
					height:100% !important;
					margin:0;
					padding:0;
					width:100% !important;
				}
				table{
					border-collapse:collapse;
				}
				img,a img{
					border:0;
					outline:none;
					text-decoration:none;
				}
				h1,h2,h3,h4,h5,h6{
					margin:0;
					padding:0;
				}
				p{
					margin:1em 0;
					padding:0;
				}
				a{
					word-wrap:break-word;
				}
				.ReadMsgBody{
					width:100%;
				}
				.ExternalClass{
					width:100%;
				}
				.ExternalClass,
				.ExternalClass p,
				.ExternalClass span,
				.ExternalClass font,
				.ExternalClass td,
				.ExternalClass div{
					line-height:100%;
				}
				table,td{
					mso-table-lspace:0pt;
					mso-table-rspace:0pt;
				}
				#outlook a{
					padding:0;
				}
				img{
					-ms-interpolation-mode:bicubic;
				}
				body,table,td,p,a,li,blockquote{
					-ms-text-size-adjust:100%;
					-webkit-text-size-adjust:100%;
				}
				#bodyCell{
					padding:20px;
				}
				.mcnImage{
					vertical-align:bottom;
				}
				.mcnTextContent img{
					height:auto !important;
				}
				body,#bodyTable{
					background-color:#ffffff;
				}
				#bodyCell{
					border-top:0;
				}
				#templateContainer{
					border:0;
				}
				h1{
					color:#dc143c !important;
					display:block;
					font-family:'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
					font-size:48px;
					font-style:italic;
					font-weight:normal;
					line-height:125%;
					letter-spacing:normal;
					margin:0;
					text-align:center;
				}
				h2{
					color:#dc143c !important;
					display:block;
					font-family:Helvetica;
					font-size:26px;
					font-style:italic;
					font-weight:normal;
					line-height:125%;
					letter-spacing:-.75px;
					margin:0;
					text-align:center;
				}
				h3{
					color:#dc143c !important;
					display:block;
					font-family:'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
					font-size:18px;
					font-style:normal;
					font-weight:normal;
					line-height:125%;
					letter-spacing:-.5px;
					margin:0;
					text-align:center;
				}
				h4{
					color:#808080 !important;
					display:block;
					font-family:Helvetica;
					font-size:16px;
					font-style:normal;
					font-weight:bold;
					line-height:125%;
					letter-spacing:normal;
					margin:0;
					text-align:left;
				}
				#templatePreheader{
					background-color:#FFFFFF;
					border-top:0;
					border-bottom:0;
				}
				.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
					color:#606060;
					font-family:Helvetica;
					font-size:11px;
					line-height:125%;
					text-align:left;
				}
				.preheaderContainer .mcnTextContent a{
					color:#606060;
					font-weight:normal;
					text-decoration:underline;
				}
				#templateHeader{
					background-color:#FFFFFF;
					border-top:0;
					border-bottom:0;
				}
				.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
					color:#606060;
					font-family:Helvetica;
					font-size:15px;
					line-height:150%;
					text-align:left;
				}
				.headerContainer .mcnTextContent a{
					color:#6DC6DD;
					font-weight:normal;
					text-decoration:underline;
				}
				#templateBody{
					background-color:#FFFFFF;
					border-top:0;
					border-bottom:0;
				}
				.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
					color:#606060;
					font-family:Helvetica;
					font-size:15px;
					line-height:150%;
					text-align:center;
				}
				.bodyContainer .mcnTextContent a{
					color:#6DC6DD;
					font-weight:normal;
					text-decoration:underline;
				}
				#templateFooter{
					background-color:#FFFFFF;
					border-top:0;
					border-bottom:0;
				}
				.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
					color:#cccccc;
					font-family:Helvetica;
					font-size:9px;
					line-height:125%;
					text-align:left;
				}
				.footerContainer .mcnTextContent a{
					color:#aaaaaa;
					font-weight:normal;
					text-decoration:underline;
				}
				@media only screen and (max-width: 480px){
					body,table,td,p,a,li,blockquote{
						-webkit-text-size-adjust:none !important;
					}
				}
				@media only screen and (max-width: 480px){
					body{
						width:100% !important;
						min-width:100% !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[id=bodyCell]{
						padding:10px !important;
					}
			
				}
				@media only screen and (max-width: 480px){
					table[class=mcnTextContentContainer]{
						width:100% !important;
					}
				}
				@media only screen and (max-width: 480px){
					table[class=mcnBoxedTextContentContainer]{
						width:100% !important;
					}
				}
				@media only screen and (max-width: 480px){
					table[class=mcpreview-image-uploader]{
						width:100% !important;
						display:none !important;
					}
				}
				@media only screen and (max-width: 480px){
					img[class=mcnImage]{
						width:100% !important;
						}
				}
				@media only screen and (max-width: 480px){
						table[class=mcnImageGroupContentContainer]{
							width:100% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						td[class=mcnImageGroupContent]{
							padding:9px !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						td[class=mcnImageGroupBlockInner]{
							padding-bottom:0 !important;
							padding-top:0 !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						tbody[class=mcnImageGroupBlockOuter]{
							padding-bottom:9px !important;
							padding-top:9px !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
							width:100% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
					table[class=mcnCaptionLeftTextContentContainer],
					table[class=mcnCaptionRightTextContentContainer],
					table[class=mcnCaptionLeftImageContentContainer],
					table[class=mcnCaptionRightImageContentContainer],
					table[class=mcnImageCardLeftTextContentContainer],
					table[class=mcnImageCardRightTextContentContainer]{
							width:100% !important;
						}
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
						padding-right:18px !important;
						padding-left:18px !important;
						padding-bottom:0 !important;
					}
			
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardBottomImageContent]{
						padding-bottom:9px !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardTopImageContent]{
						padding-top:18px !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
						padding-right:18px !important;
						padding-left:18px !important;
						padding-bottom:0 !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardBottomImageContent]{
						padding-bottom:9px !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=mcnImageCardTopImageContent]{
						padding-top:18px !important;
					}
				}
				@media only screen and (max-width: 480px){
					table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
						padding-top:9px !important;
					}
				}
				@media only screen and (max-width: 480px){
						td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
							padding-top:18px !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						td[class=mcnBoxedTextContentColumn]{
							padding-left:18px !important;
							padding-right:18px !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						td[class=mcnTextContent]{
							padding-right:18px !important;
							padding-left:18px !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
							max-width:600px !important;
							width:100% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						h1{
							font-size:40px !important;
							line-height:125% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
					h2{
						font-size:20px !important;
						line-height:125% !important;
					}
				}
				@media only screen and (max-width: 480px){
					h3{
						font-size:18px !important;
						line-height:125% !important;
					}
				
				}
				@media only screen and (max-width: 480px){
						h4{
							font-size:16px !important;
							line-height:125% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
						table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
							font-size:18px !important;
							line-height:125% !important;
						}
				
				}
				@media only screen and (max-width: 480px){
					table[id=templatePreheader]{
						display:block !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
						font-size:14px !important;
						line-height:115% !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
						font-size:18px !important;
						line-height:125% !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
						font-size:18px !important;
						line-height:125% !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
						font-size:14px !important;
						line-height:115% !important;
					}
				}
				@media only screen and (max-width: 480px){
					td[class=footerContainer] a[class=utilityLink]{
						display:block !important;
					}
				}
			</style>
		</head>
		<body leftmargin=\"0\" marginwidth=\"0\" topmargin=\"0\" marginheight=\"0\" offset=\"0\" style=\"margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #ffffff;height: 100% !important;width: 100% !important;\">
			<center>
				<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\" id=\"bodyTable\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #ffffff;height: 100% !important;width: 100% !important;\">
					<tr>
						<td align=\"center\">
							<!-- BEGIN TEMPLATE // -->
							<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"templateContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;\">
								<tr>
									<td align=\"center\" valign=\"top\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
										<!-- BEGIN PREHEADER // -->
										<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"templatePreheader\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
											<tr>
												<td valign=\"top\" class=\"preheaderContainer\" style=\"padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
													<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
														<tbody class=\"mcnTextBlockOuter\">
															<tr>
																<td valign=\"top\" class=\"mcnTextBlockInner\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																	<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"366\" class=\"mcnTextContentContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																		<tbody>
																			<tr>
																				<td valign=\"top\" class=\"mcnTextContent\" style=\"padding-top: 9px;padding-left: 18px;padding-bottom: 9px;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;\">Hola $toShortName esta es una invitaci&oacute;n para un evento muy especial...</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</table>
										<!-- // END PREHEADER -->
									</td>
								</tr>
								<tr>
									<td align=\"center\" valign=\"top\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
										<!-- BEGIN BODY // -->
										<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" id=\"templateBody\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;\">
											<tr>
												<td valign=\"top\" class=\"bodyContainer\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
													<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
														<tbody class=\"mcnTextBlockOuter\">
															<tr>
																<td valign=\"top\" class=\"mcnTextBlockInner\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																	<table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"mcnTextContentContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																		<tbody>
																			<tr>
																				<td valign=\"top\" class=\"mcnTextContent\" style=\"padding: 9px 18px;font-size: 62px;font-weight: bold;line-height: 150%;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;\">
																					<h1 style=\"font-size: 48px;text-align: center;color: #e5277f!important;font-family: trebuchet ms,lucida grande,lucida sans unicode,lucida sans,tahoma,sans-serif;line-height: 1.6em;margin: 0;padding: 0;display: block;font-style: italic;font-weight: normal;letter-spacing: normal;\">Nos Casamos!</h1>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnImageBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
														<tbody class=\"mcnImageBlockOuter\">
															<tr>
																<td valign=\"top\" style=\"padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\" class=\"mcnImageBlockInner\">
																	<table align=\"left\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"mcnImageContentContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																		<tbody>
																			<tr>
																				<td class=\"mcnImageContent\" valign=\"top\" style=\"padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																					<img align=\"center\" alt=\"\" src=\"http://www.nanofino.com.ar/doloynano/imgs/draw400.png\" width=\"400\" style=\"max-width: 400px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;\" class=\"mcnImage\">
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
														<tbody class=\"mcnTextBlockOuter\">
															<tr>
																<td valign=\"top\" class=\"mcnTextBlockInner\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																	<table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"mcnTextContentContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																		<tbody>
																			<tr>
																				<td valign=\"top\" class=\"mcnTextContent\" style=\"padding: 9px 18px;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;\">
																					<h2 style=\"text-align: center;font-size: 24px;color: #e5277f!important;font-family: trebuchet ms,lucida grande,lucida sans unicode,lucida sans,tahoma,sans-serif;line-height: 1.6em;margin: 0;padding: 0;display: block;font-style: italic;font-weight: normal;letter-spacing: -.75px;\">Dolo y Nano</h2>
																					<em style=\"font-family:georgia,times,times new roman,serif; font-size:18px; text-align:center\">20 de Junio de 2014</em>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"mcnTextBlock\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
														<tbody class=\"mcnTextBlockOuter\">
															<tr>
																<td valign=\"top\" class=\"mcnTextBlockInner\" style=\"mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																	<table align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"mcnTextContentContainer\" style=\"border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;\">
																		<tbody>
																			<tr>
																				<td valign=\"top\" class=\"mcnTextContent\" style=\"padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: center;\">
																					<p style=\"text-align: center;margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;\">$toShortName, en esta direcci&oacute;n est&aacute;n todos los detalles:</p>
																					<div style=\"text-align: center;font-size:18px; margin: 10px 0;\"><a href=\"http://dolo.nanofino.com.ar/?w=$toCode\" target=\"_blank\" style=\"word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;\">http://dolo.nanofino.com.ar/?w=$toCode</a></div>
																					<p style=\"text-align: center;margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;\">Invitaci&oacute;n exclusiva para: $toName</p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</table>
									<!-- // END BODY -->
									</td>
								</tr>
							</table>
							<!-- // END TEMPLATE -->
						</td>
					</tr>
				</table>
			</center>
		</body>
	</html>
	
	";
	// Mail it
	mail($to, $title, $message, $headers);
	echo "sent";
//	echo $message;
}

?>
