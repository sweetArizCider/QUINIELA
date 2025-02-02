<?php
	session_start();
	include("../include/conexion.php");
	$con = Conexion();

	include("../include/valida.php");
	$sesion = Valida(108,$con);

	include("../include/conexionSYS.php");
	
	require 'PHPMailerAutoload.php';

	$year 	= date('Y');
	$day 	= date('d');
	$month	= date("m"); 
	$actualTime = date('H:i:s');

	// set default header data
	if ($month == 1) { $month = "ENERO"; } 
	else if ($month == 2) { $month = "FEBRERO"; }
	else if ($month == 3) { $month = "MARZO"; }
	else if ($month == 4) { $month = "ABRIL"; }
	else if ($month == 5) { $month = "MAYO"; }
	else if ($month == 6) { $month = "JUNIO"; }
	else if ($month == 7) { $month = "JULIO"; }
	else if ($month == 8) { $month = "AGOSTO"; }
	else if ($month == 9) { $month = "SEPTIEMBRE"; }
	else if ($month == 10) { $month = "OCTUBRE"; }
	else if ($month == 11) { $month = "NOVIEMBRE"; }
	else if ($month == 12) { $month = "DICIEMBRE"; }
?>

<link href="../css/style.css" rel="stylesheet" />
<script language="javascript" src="../include/library.js"></script>

<script language="JavaScript" type="text/javascript">
	document.onmousedown=click
</script>
<html>
	<head>
    	<meta charset="utf-8">
<body>

	<?php 
	    /*información general de LDAP*/
	    $dia    =  date("d");
	    $mes    =  date("m");
	    $anio   = date("Y");
	    $at 	= date('His');

	    $srv    = "segacc01.splata.penoles.mx";
	    $port   = 389;
	    $cldap  = conecta_ldap($srv,$port);  

	    $b      = ldap_bind($cldap,"cn=SP_PROXSEG,ou=SERVICIOS,o=penoles","P3n0l3sMMXII");

	    $dn     = "ou=EMPLEADOS,ou=PEOPLE,o=PENOLES";
	    $filtro = "(&(createTimestamp>=20080101000000Z) (createTimestamp<=" . $anio . $mes . $dia . "235959Z))";
	    //$filtro = "(uid=KG010504)";
        //$filtro = "(uid=SA003851)";
	    $campos = array("givenName","sn","mail","uid","groupmembership","PNLUserPosicion","PNLUserPosicionJefe","manager");
	    $datos  = busca_info_ldap($cldap,$dn,$filtro,$campos,1,"uid");
	    $emp    = $datos["count"];

	    $total  = $emp;

	    /** Error reporting */
		//error_reporting(E_ALL);
		//ini_set('display_errors', TRUE);
		//ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		/** Include PHPExcel */
		require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

		// Create new PHPExcel object
	    $objPHPExcel = new PHPExcel();

			$estilo = array(
				'font'  => array(
				'bold'  => true,
				'size'  => 10,
				'name'  => 'Calibri',
				'color' => array( 'rgb' => 'FFFFFF' )
			));
		
			$estiloR = array(
				'font'  => array(
				'bold'  => false,
				'size'  => 10,
				'name'  => 'Calibri',
				'color' => array( 'rgb' => '000000' )
			));
		
			$centro = array( 
				'alignment' => array( 
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);
		
			$vertical = array( 
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); //Usuario
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35); //Colaborador
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); //Usuario Jefe
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); //Posición Jefe
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35); //Nombre Jefe 
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); //Posición Jefe actual
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); //Estado
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); //Estado

		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill('') 
		->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 
		'startcolor' => array('rgb' => '000000') 
		));

		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estilo);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($centro);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('REPORTABILIDAD LDAP');


		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', 'REPORTABILIDAD EN LDAP')
			->setCellValue('A3', 'Generado: ' . $day . '/' . $month . '/' . $year . ' - ' . $actualTime);

			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A6', 'USUARIO')
					->setCellValue('B6', 'COLABORADOR')
					->setCellValue('C6', 'USUARIO JEFE')
					->setCellValue('D6', 'POSICIÓN JEFE')
					->setCellValue('E6', 'NOMBRE JEFE')
					->setCellValue('F6', 'POSICIÓN JEFE ACTUAL')
					->setCellValue('G6', 'ESTADO')
					->setCellValue('H6', 'NOTA');

		$x = 7;	

		$ok    		= 0;
        $inc 	    = 0;
        $inactivo   = 0;

        for ($i=1; $i<$datos["count"]; $i++) {

        	$userJefe = substr($datos[$i]["manager"][0],3,8);

        	//Obtenemos información del jefe
            $filtroJefe = "(uid=" . $userJefe . ")";
            $dn         = "ou=EMPLEADOS,ou=PEOPLE,o=PENOLES";
            $camposJefe = array("givenName","sn","mail","uid","groupmembership","PNLUserPosicion","PNLUserPosicionJefe","manager");
            $datosJefe  = busca_info_ldap($cldap,$dn,$filtroJefe,$camposJefe,1,"uid");
            $jefe    = $datosJefe["count"];

            //Validamos si el jefe sigue activo
            if($jefe == 0){

                $dn     = "ou=INACTIVOS,ou=PEOPLE,o=PENOLES";
                $camposJefe = array("givenName","sn","mail","uid","groupmembership","PNLUserPosicion","PNLUserPosicionJefe","manager");
                $datosJefe  = busca_info_ldap($cldap,$dn,$filtroJefe,$camposJefe,1,"uid");
                $inactivo = 1;

            }



            $posJefeAsig = $datos[$i]["pnluserposicionjefe"][0];
            $posJefeActual = $datosJefe[0]["pnluserposicion"][0];

            if($posJefeAsig == $posJefeActual AND $inactivo == 0){

                $estrep = "CORRECTO";
                $ultcol = "";
                $ok = $ok + 1;

            }else{

                $estrep = "INCONSISTENCIA";
                $inc = $inc + 1;

                 if($inactivo == 1){

                    $ultcol = "JEFE INACTIVO";
                    $inactivo = 0;

                }else{

                    $ultcol = "";

                }



            }

        	$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A' . $x, utf8_encode($datos[$i]["uid"][0]))
						->setCellValue('B' . $x, utf8_encode($datos[$i]["givenname"][0] . " " . $datos[$i]["sn"][0]))
						->setCellValue('C' . $x, utf8_encode($userJefe))
						->setCellValue('D' . $x, utf8_encode($datos[$i]["pnluserposicionjefe"][0]))
						->setCellValue('E' . $x, utf8_encode($datosJefe[0]["givenname"][0] . " " . $datosJefe[0]["sn"][0]))
						->setCellValue('F' . $x, utf8_encode($datosJefe[0]["pnluserposicion"][0]))
						->setCellValue('G' . $x, utf8_encode($estrep))
						->setCellValue('H' . $x, utf8_encode($ultcol));

			$objPHPExcel->getActiveSheet()->getStyle('A' . $x)->applyFromArray($centro);
			$objPHPExcel->getActiveSheet()->getStyle('C' . $x)->applyFromArray($centro);
			$objPHPExcel->getActiveSheet()->getStyle('D' . $x)->applyFromArray($centro);
			$objPHPExcel->getActiveSheet()->getStyle('F' . $x)->applyFromArray($centro);
			$objPHPExcel->getActiveSheet()->getStyle('G' . $x)->applyFromArray($centro);
			$objPHPExcel->getActiveSheet()->getStyle('H' . $x)->applyFromArray($centro);

			$x = $x + 1;

        }

        
        $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('F' . $x, utf8_encode('INCONSISTENCIAS'))
						->setCellValue('G' . $x, utf8_encode($inc));

		$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':H'.$x)->getFill('') 
		->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 
		'startcolor' => array('rgb' => '000000') 
		));

		$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':H'.$x)->applyFromArray($estilo);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':H'.$x)->applyFromArray($centro);

        // Save Excel 2007 file
		$ruta = "../reporteLDAP/";
		$archivo = "REPORTABILIDAD_LDAP_". $day . $month . $year . "-" . $at . ".xlsx";
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('.php', '.xlsx', $ruta . $archivo));

		echo "<p><center><hr><h1>ARCHIVO GENERADO: ". $archivo."</h1><hr>";
		echo "<p><center><hr><h1>GENERADO POR:  ". $_SESSION['sNom']."</h1><hr>";


		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//																													  //
		//												Envío del reporte por mail   								    	  //
		//																													  //
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer;

		$mail->isSMTP();                                    		// Set mailer to use SMTP
		$mail->Host = 'agmail.penoles.mx';  						// Specify main and backup SMTP servers
		$mail->SMTPAuth = false;                            		// Enable SMTP authentication
		$mail->From = 'Seguridad_Informatica@penoles.com.mx';
		$mail->FromName = 'Seguridad Informatica Site Plata'; 
		$mail->addAddress($_SESSION['sMailUsu'], $_SESSION['sNom']);
		$mail->AddCC('Sergio_Arizpe@penoles.com.mx', 'Sergio Arizpe');	// Add a recipient

		$mail->WordWrap = 50;                                 		// Set word wrap to 50 characters
		$mail->addAttachment($ruta . $archivo);    		// Add attachments
		$mail->isHTML(true);                                  		// Set email format to HTML
		$mail->Subject = 'Reportabilidad LDAP - ' . $day . '/' . $month . '/' . $year . ' - ' . $actualTime;

		$mail->Body = utf8_decode('<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td style="padding: 0 0 30px 0;">
											<!-- Table1 -->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="80%" style="border: 1px solid #cccccc; border-collapse: collapse;">
												<tr>
													<td width="693" bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															
															<tr>
															<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
															Adjunto se encuentra el reporte llamado <strong>\'' . $archivo . '\' </strong>, generado el ' . $day . ' de ' . $month . ' de ' . $year . ' a las ' . $actualTime . ' por el Área de Seguridad Informática del Site Plata. 
															</td>
															</tr>
															<tr>
																<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 12px; line-height: 20px; text-align: justify;">
																	*Este es un correo automático. Cualquier comentario, favor de contactar a <strong>Sergio_Arizpe@penoles.com.mx</strong></td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td bgcolor="#e5e5e5" style="padding: 10px 30px 10px 30px; color: #FFF;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td align="right" style="color: #000000; font-family: Arial, sans-serif; font-size: 14px;">
																	Área de Seguridad Informática - Site Plata</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<!-- Table1 -->
										</td>
									</tr>
								</table>');

								if(!$mail->send()) {
									echo 'Message could not be sent.';
									echo 'Mailer Error: ' . $mail->ErrorInfo;
								} else { 
									echo "<p><center><hr><h1>ENVIADO A:  ". $_SESSION['sMailUsu']."</h1><hr>";
								}

	?>





</body>

<?php
		include("../include/cierraConexion.php");
?>

</html>
