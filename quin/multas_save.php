<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(13,$con); 

  $EM     = explode(',',$_POST['monto']);
  $tipo   = $EM[0];
  $monto  = $EM[1];

  $sqlEntMul = "SELECT count(*) FROM softquin_prod.sq_multas;
                WHERE qu_ud = '".$_POST['qu_id']."' AND
                    u_id = '".$_POST['u_id']."' AND
                      jo_id = ".$_POST['jo_id']." AND mu_tipo = '".$tipo."'";
  $qryEntMul = @odbc_exec($con, $sqlEntMul);

  if(@odbc_result($qryEntMul,1) > 0){

    $updEntMul = "UPDATE sq_multas
                  SET mu_monto = 50
                  WHERE qu_id = '".$_POST['qu_id']."' AND
                      u_id = '".$_POST['u_id']."' AND
                        jo_id = ".$_POST['jo_id']." AND
                        mu_tipo = '".$tipo."'";

    //echo $updEntMul;

    $qryUpdEntMul = @odbc_exec($con,$updEntMul);

  }else{

    $insEntMul = "INSERT INTO sq_multas (qu_id, u_id, jo_id, mu_tipo, mu_monto) VALUES ('".$_POST['qu_id']."','".$_POST['u_id']."',".$_POST['jo_id'].",'".$tipo."',".$monto.") ";

    //echo $insEntMul;

    $qryInsEntMul = @odbc_exec($con,$insEntMul);
  }

  ?>

<html>
  <head>
      <meta charset="utf-8">
      <link href="../css/style.css" rel="stylesheet">
      <script language="javascript" src="../include/library.js"></script>
  </head>
  
  <body>

    <table class="treinta" border="0" align="center">
      <tr>
        <th class="tabla_td_est_tot" colspan="2">INFORMACIÓN REGISTRADA
      <tr>
        <td class="tabla_td_est">QUINIELA 
        <td class="tabla_td_est"><?php echo $_POST['qu_id'];?>

      <tr>  
        <td class="tabla_td_est">TORNEO 
        <td class="tabla_td_est"><?php echo $_POST['to_id'];?>

      <tr>  
        <td class="tabla_td_est">AMIGO 
        <td class="tabla_td_est"><?php echo $_POST['u_id'];?>

      <tr>  
        <td class="tabla_td_est">JORNADA 
        <td class="tabla_td_est"><?php echo $_POST['jo_id'];?>

      <tr>  
        <td class="tabla_td_est"><?php echo $tipo;?> 
        <td class="tabla_td_est"><?php echo $monto;?>

      <tr>  
        <td class="tabla_td_est" colspan="2"><?php echo $tipo;?> REGISTRADA

      <tr>  
        <td class="tabla_td_est" colspan="2"><a href="multas.php"><img src="../img/back.jpg"></a>


      </tr>  
    </table>
  </form>

  </body>
</html>