<!DOCTYPE html>

<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(12,$con); 

  include("imp_partido_jornada.php");

  $parametros = "?li_id=" . $_GET['li_id'] . "&to_id=" . $_GET['to_id'] . "&qu_id=" . $_GET['qu_id'] . "&qu_nombre=" . $_GET['qu_nombre'] . "&qu_tipo=" . $_GET['qu_tipo'];

  //limpiamos tabla
    $DelPos = "DELETE FROM sq_pos_temp
                WHERE li_id = '".$_GET['li_id']."' AND
                    to_id = '".$_GET['to_id']."' AND
                      qu_id = '".$_GET['qu_id']."' ";

    $qryDelPos = odbc_exec($con,$DelPos);

    $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor,B.u_foto 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND 
                          A.qu_id = '" . $_GET['qu_id'] . "' ORDER BY u_id ASC";

      //echo $sqlAmigos;

      $qryAmigos = @odbc_exec($con,$sqlAmigos);

  ?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Team Table</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" type='text/css'>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<article class="table-widget">
		<div class="caption">
			<h2>
				<?php echo $_GET['li_id'] . " - " . $_GET['to_id'];?>
			</h2>
			<button class="export-btn" type="button">
				<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-export" width="24"
					height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
					stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
					<path d="M14 3v4a1 1 0 0 0 1 1h4" />
					<path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" />
				</svg>
				Export
			</button>
		</div>
		<table>
			<thead>
				<tr>
					<th>Foto</th>
					<th>Posición</th>
					<th>Nombre</th>
					<th>Total de Puntos</th>
					<th>Entrada</th>
					<th>Multas</th>
					<th>$Total</th>
				</tr>
			</thead>
			<tbody id="team-member-rows">

				<?php 

					while($row=@odbc_fetch_row($qryAmigos)){

						echo "<tr>";
							echo "<td class='team-member-profile'>";
								echo "<img src='../img/".@odbc_result($qryAmigos,5)."' alt='James Alexander'>";
								echo "<div class='profile-info'>";
									echo "<div class='profile-info__name'>James Alexander</div>";
								echo "</div>";
							echo "</td>";
						

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";

							echo "<td>";
								echo "<div class='status'>";
									echo "<div class='status__circle status--offline'></div>";
										echo "offline";
									echo "</div>";
							echo "</td>";	

						echo "</tr>";

					}

				?>

			</tbody>
		</table>
	</article>
	<script src="script.js"></script>
</body>

</html>