<?php 
	/*
		AUTOR:			SERGIO GABRIEL ARIZPE MORA
		FECHA:			01-ABRIL-2023
		ARCHIVO:		imp_partido_jornada.php
		DESCRIPCI�N:	Archivo que imprime cada partido de la jornada del torneo seleccionado"
	*/
	
	function ImpParJor($li_id,$to_id,$jo_id,$jp_id,$jornada)
		{


			$sql = "SELECT li_id,
							to_id,
					        jo_id,
					        jp_id,
					        eq_id_local,
					        eq_id_local_score,
					        eq_id_visita,
					        eq_id_visita_score,
					        jp_estadio,
					        jp_fecha,
					        ej_id,
					        jp_LEV
					FROM softquin_prod.sq_jornada_partido
					WHERE li_id = ' " . $li_id .  " ' AND to_id =' " . $to_id .  " ' AND jo_id =' " . $jo_id .  " ' AND jp_id =' " . $jornada .  " '";	

					echo "<p>" . $sql;




			$qry = @odbc_exec($con,$sql);	
			
			$no = @odbc_num_rows($qry);

			echo "<p>" . $no;
			
			if($no >= 1){
				
				echo "<table id='fw' class='treinta' align='center' border=1>";

					echo "<td colspan='3'>" . $jornada;
					echo "<td colspan='3'>" . @odbc_result($qry, 10);

				echo "</table>";

			}else{

				echo "<br><br><hr><center><h1>NO HAY PARTIDO PARA ESTA JORNADA</h1><hr><br>";
				echo "<a href='../ini/aasi.htm' target='_top'>Regresar</a>";
				exit;	

			}

			
		}
?>

