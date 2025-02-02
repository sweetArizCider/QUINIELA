<?php

  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(11,$con);

  /*echo "Liga: " . $_POST['li_id'];
  echo "<br>torneo: " . $_POST['to_id'];
  echo "<br>jornada: " . $_POST['jo_id'];
  echo "<br>total: " . $_POST['total'];*/

  $total = $_POST['total'];
  $i = 1;

  while($i <= $total ){

  	$jp     = "jp_id_" . $i;
  	$local  = "eqloc_" . $i;
  	$visita = "eqvis_" . $i;
  	$fecha  = "fecha_" . $i;


  	//echo "<br>Partido No. " . $_POST[$jp] . " - LOCAL: " . $_POST[$local] . " - VISITA: " . $_POST[$visita] . " FECHA: " . $_POST[$fecha];


  	$InsPartido = "INSERT INTO sq_jornada_partido (li_id, to_id, jo_id, jp_id, eq_id_local, eq_id_local_score, eq_id_visita, eq_id_visita_score, jp_estadio, jp_fecha, ej_id, jp_LEV )
					VALUES ('".$_POST['li_id']."', '".$_POST['to_id']."', ".$_POST['jo_id'].", ".$i.", '".$_POST[$local]."', 0, '".$_POST[$visita]."', 0, 'ESTADIO', '".$_POST[$fecha]."', 'PRO', '')";

	$qryInsPartido = @odbc_exec($con,$InsPartido);

  	$i = $i + 1;

  }
?>

<head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
</head> 

<table id="fw" class="treinta" align="center" border="0" cellpadding="2" cellspacing="2">
    <tr>
        <th class="tabla_th">LIGA</td>
        <th class="tabla_th">TORNEO</td>
        <th class="tabla_th">JORNADA</td>
    </tr>

    <tr>
        <td class="tabla_td"><?php echo $_POST['li_id']; ?></td>
        <td class="tabla_td"><?php echo $_POST['to_id']; ?></td>
        <td class="tabla_td"><?php echo $_POST['jo_id']; ?></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="3"><hr></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="3"><H2>JORNADA REGISTRADA</td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="3"><hr></td>
    </tr>
</table>

<center><a href='lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>

