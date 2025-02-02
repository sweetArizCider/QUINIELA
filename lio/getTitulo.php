<?php
	//Definimos el titulo del escritorio
	if($pad == 0 ){
		$titulo = "Principal";
		$back = 0;
	}else{
		
		//Obtenemos el nombre de la tarea
		$sqlTit = "SELECT asi_tar.t_pad, asi_tar.t_id, asi_tar.t_nom ";
		$sqlTit = $sqlTit . "FROM asi_tar WHERE asi_tar.t_id = " . $pad;
	
		$qryTit = @odbc_exec($con,$sqlTit);
		
		$titulo = @odbc_result($qryTit,3);
		
		//Obtenemos el id para regresar
		$sqlBack = "SELECT asi_tar.t_pad, asi_tar.t_id, asi_tar.t_nom ";
		$sqlBack = $sqlBack . "FROM asi_tar WHERE asi_tar.t_id = " . @odbc_result($qryTit,1);
		$qryBack = @odbc_exec($con,$sqlBack);
		$back = @odbc_result($qryBack,1);
		
	}
?>