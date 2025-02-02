<?php
  session_start();

  require __DIR__ . "/vendor/autoload.php";

  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(11,$con); 

  $fecha = date('Y/m/d'); 
  $hora  = date('H:i:s');

  $sqlArchivo = "SELECT arc_nombre FROM sms_archivo where arc_id = '".$_GET['id']."' AND u_amigo= '" .$_GET['amigo']."'" ;

  $qryArchivo = @odbc_exec($con,$sqlArchivo);

  $file = "../files/" . @odbc_result($qryArchivo, 1);

  $sqlAmigo = "SELECT u_nom, u_mai FROM softquin_prod.sq_usr WHERE u_id='" . $_GET['amigo'] . "'";
  $qryAmigo = @odbc_exec($con,$sqlAmigo);

?>

<head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head> 

<p><p><p><p> 


<table id="fw" class="treinta" align="center" border="1">
  <tr>
      <th class="tabla_th" colspan="5"><?php echo @odbc_result($qryAmigo,1); ?>  
  </tr>
  <tr>
      <th class="tabla_th">LOCAL</th>
      <th class="tabla_th" colspan="3">MARCADOR</th>    
      <th class="tabla_th">VISITA</th>
  </tr>

<?php

  $archivo = "../files/" . $file;
  $documento = IOFactory::load($archivo);

  $sheet = $documento->getSheet(0);

  $row = 2;

  $qu_id   = $sheet->getCell("A".$row);
  $u_id    = $_GET['amigo'];
  $li_id   = $sheet->getCell("B".$row);
  $to_id   = $sheet->getCell("C".$row);
  $jo_id   = $sheet->getCell("D".$row);

  /////////////////////////////////////////////////////

  $sqlQuiniela = "SELECT qu_nombre FROM softquin_prod.sq_quiniela WHERE qu_id = '". $qu_id ."'";
  $qryQuiniela = @odbc_exec($con,$sqlQuiniela);

  $sqlJornada = "SELECT jo_nombre FROM softquin_prod.sq_jornada WHERE li_id='".$li_id."' AND to_id='".$to_id."' AND jo_id=" . $jo_id;
  $qryJornada = @odbc_exec($con,$sqlJornada);


  //Validamos si ya se ha capturado un pronostico antes...

    $sqlVal = "SELECT count(*) 
              FROM softquin_prod.sq_quiniela_pronostico 
              WHERE qu_id = '".$qu_id."' AND u_id = '".$u_id."' AND li_id = '".$li_id."' AND to_id = '".$to_id."'";

    //echo $sqlVal;
    $qryVal = @odbc_exec($con,$sqlVal);

    if(@odbc_result($qryVal,1) > 0){
      $sqlDelPro = "DELETE FROM softquin_prod.sq_quiniela_pronostico 
                    WHERE qu_id = '".$qu_id."' AND u_id = '".$u_id."' AND li_id = '".$li_id."' AND to_id = '".$to_id."'";
      $qryDelPro = @odbc_exec($con,$sqlVal);

      //echo "<br>" . $sqlDelPro;
    }
  
  //////////////////////////////////////////////////////////////////////    

  
  for ($i=11; $i < 20 ; $i++) { 
    
    $jp_id = $sheet->getCell("S".$i);
    $eq_id_local = $sheet->getCell("K".$i);
    $eq_id_local_score = $sheet->getCell("M".$i);
    $eq_id_visita = $sheet->getCell("P".$i);
    $eq_id_visita_score = $sheet->getCell("O".$i);
    $jp_LEV = $sheet->getCell("N".$i);

    $insPro = "INSERT INTO sq_quiniela_pronostico 
                            ( qu_id,
                              u_id,
                              li_id,
                              to_id,
                              jo_id,
                              jp_id,
                              eq_id_local,
                              eq_id_local_score,
                              eq_id_visita,
                              eq_id_visita_score,
                              ej_id,
                              jp_LEV )
                    VALUES (  '".$qu_id."',
                              '".$u_id."',
                              '".$li_id."',
                              '".$to_id."',
                              ".$jo_id.",
                              ".$jp_id.",
                              '".$eq_id_local."',
                              ".$eq_id_local_score.",
                              '".$eq_id_visita."',
                              ".$eq_id_visita_score.",
                              'PRO',
                              '".$jp_LEV."')";

                              //echo "<p>" . $insPro;

      $qryInsPro = @odbc_exec($con,$insPro);

      //echo "<br>" . $insPro;

      $UpdArc = "UPDATE sms_archivo SET arc_procesado = 1 WHERE arc_id = '" . $_GET['id'] . "'";
      $qryUpdArc = @odbc_exec($con,$UpdArc);

      $sqlEqLocal = "SELECT eq_id, eq_nombre, eq_logo FROM softquin_prod.sq_equipo WHERE eq_id = '" . $eq_id_local . "'";
      $qryEqLocal = @odbc_exec($con,$sqlEqLocal);

      $sqlEqVisita = "SELECT eq_id, eq_nombre, eq_logo FROM softquin_prod.sq_equipo WHERE eq_id = '" . $eq_id_visita . "'";
      $qryEqVisita = @odbc_exec($con,$sqlEqVisita);


    echo "<tr>";
      echo "<td class='tabla_td'><img src='".@odbc_result($qryEqLocal,3)."' with='30' height='30'>";
      echo "<td class='tabla_td'>" . $eq_id_local_score;
      echo "<td class='tabla_td'>" . $jp_LEV;
      echo "<td class='tabla_td'>" . $eq_id_visita_score;
      echo "<td class='tabla_td'><img src='".@odbc_result($qryEqVisita,3)."' with='30' height='30'>";
    echo "</tr>";
  }
?>
    <tr>
      <th class="tabla_th" colspan="5"><?php echo @odbc_result($qryQuiniela,1); ?>  
    </tr>

    <tr>
      <th class="tabla_th" colspan="5"><?php echo @odbc_result($qryJornada,1); ?>  
    </tr>

</table>
<center><a href='../ufi/procesa.php'><img src='../img/Back.jpg' alt='Back' /></a></center>

