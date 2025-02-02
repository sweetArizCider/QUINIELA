<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(11,$con); 

  $fecha = date('Y/m/d'); 
  $hora  = date('H:i:s');


  //echo $_POST['li_id'] . "<br>";
  //echo $_POST['to_id'] . "<br>";
  //echo $_POST['jo_id'] . "<br>";

?>

<head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
</head> 

<p><p><p><p> 


<?php

  $i = 1;

  while($i <= $_POST['total']){

    $jp_id = "jp_id_" . $i;
    //echo $_POST[$jp_id] . " - ";

    $eq_id_local = "eq_id_local_" .$i;
    //echo $_POST[$eq_id_local];

    $eq_id_local_score = "eq_id_local_score_" .$i;
    //echo "&nbsp;" . $_POST[$eq_id_local_score];

    $jp_lev = "jp_lev_" .$i;
    //echo "&nbsp;-&nbsp;" . $_POST[$jp_lev] . " - ";

    $eq_id_visita_score = "eq_id_visita_score_" .$i;
    //echo "&nbsp;" . $_POST[$eq_id_visita_score] . " - ";

    $eq_id_visita = "eq_id_visita_" .$i;
    //echo $_POST[$eq_id_visita] . "<br>";


    //actualizamos partido
   $UpdJor = "UPDATE sq_jornada_partido 
              SET eq_id_local_score = ".$_POST[$eq_id_local_score].", jp_LEV = '".$_POST[$jp_lev]."', eq_id_visita_score = ".$_POST[$eq_id_visita_score]." 
              WHERE li_id = '".$_POST['li_id']."' AND
                    to_id = '".$_POST['to_id']."' AND
                    jp_id = ".$i." AND
                    jo_id = " . $_POST['jo_id'];

    $qryJor = @odbc_exec($con,$UpdJor);

    $i = $i + 1;

  }

  echo "<center><h2><b>SE ACTUALIZO LA JORNADA " . $_POST['jo_id'];

?>  



  
</table>
<center><a href='lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>

