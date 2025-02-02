<?php 
	/*
		AUTOR:			SERGIO GABRIEL ARIZPE MORA
		FECHA:			26-AGOSTO-2009
		ARCHIVO:		valida.php
		DESCRIPCIÓN:	Archivo que válida que se tiene permiso a la tarea"
	*/
	
	function Valida($tarea,$con)
		{
			$sql = "SELECT sq_gpo_tar.g_id, sq_gpo_tar.t_id FROM sq_gpo_tar ";
			$sql = $sql . "WHERE ( sq_gpo_tar.g_id = '".$_SESSION['sGru']."' ) AND ( sq_gpo_tar.t_id = ".$tarea." )";
			
			$qry = @odbc_exec($con,$sql);	
			
			$no = @odbc_num_rows($qry);
			
			if($no == 0){
				echo "<br><br><hr><center><h1>NO TIENE PERMISO PARA ESTA TAREA</h1><hr><br>";
				echo "<a href='../ini/aasi.htm' target='_top'>Regresar</a>";
				exit;
			}
			
		}
?>

