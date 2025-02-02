<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(11,$con); 

  $fecha = date('Y/m/d'); 
  $hora  = date('H:i:s');

  $sqlPartidos = "SELECT  A.li_id, A.to_id, A.jp_id, A.eq_id_local, A.eq_id_local_score, A.eq_id_visita, A.eq_id_visita_score, date_format(A.jp_fecha,'%d-%m-%Y'), A.jp_LEV, B.eq_estadio, date_format(A.jp_fecha,'%H:%i:%s')  
                  FROM softquin_prod.sq_jornada_partido as A, softquin_prod.sq_equipo as B
                  WHERE eq_id_local=eq_id AND li_id='".$_GET['li_id']."' AND to_id='".$_GET['to_id']."' AND jo_id=" . $_GET['jo_id'] . " ORDER BY A.jp_id" ;
  $qryPartidos = @odbc_exec($con,$sqlPartidos);

  //Armamos parametros
  $parametros_jornada = "?li_id=" . $_GET['li_id'] . "&to_id=" . $_GET['to_id'] . "&jo_id=" . $_GET['jo_id'] . "&jornada=" . $_GET['jornada'];

?>

<head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
</head> 

<p><p><p><p> 

<form name="frm_save" id="frm_save" action="partidos_jornada_guardar.php" method="POST">
  <input type="hidden" name="li_id" id="li_id" value="<?php echo $_GET['li_id'];?>">
  <input type="hidden" name="to_id" id="to_id" value="<?php echo $_GET['to_id'];?>">
  <input type="hidden" name="jo_id" id="jo_id" value="<?php echo $_GET['jo_id'];?>">
  <table id="fw" class="treinta" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="tabla_td" colspan="5"><hr></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="5"><?php echo $_GET['jornada']; ?></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="5"><hr></td>
    </tr>

  <?php
    $i = 1;
    while($row=@odbc_fetch_row($qryPartidos)){

      $sqlLocal = "SELECT eq_nombre, eq_logo, eq_mote FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryPartidos,4)."'";
      $qryLocal = @odbc_exec($con,$sqlLocal);

      $sqlVisita = "SELECT eq_nombre, eq_logo, eq_mote FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryPartidos,6)."'";
      $qryVisita = @odbc_exec($con,$sqlVisita);

      echo "<tr>";

        echo "<td class='tabla_td'><img src='".@odbc_result($qryLocal,2)."' with='30' height='30'>";
        echo "<input type='hidden' name='eq_id_local_".$i."' id='eq_id_local_".$i."' value='".@odbc_result($qryPartidos,4)."'>";

        echo "<td class='tabla_td'>";
        echo "<input type='text' name='eq_id_local_score_".$i."' id='eq_id_local_score_".$i."' value='".@odbc_result($qryPartidos,5)."' class='score'>";
        
        echo "<td class='tabla_td'>";
        echo "<input type='text' name='jp_lev_".$i."' id='jp_lev_".$i."' value='".@odbc_result($qryPartidos,9)."' class='score'>";
        
        echo "<td class='tabla_td'>";
        echo "<input type='text' name='eq_id_visita_score_".$i."' id='eq_id_visita_score_".$i."' value='".@odbc_result($qryPartidos,7)."' class='score'>";
        
        echo "<td class='tabla_td'><img src='".@odbc_result($qryVisita,2)."' with='30' height='30'>";
        echo "<input type='hidden' name='eq_id_visita_".$i."' id='eq_id_visita_".$i."' value='".@odbc_result($qryPartidos,6)."'>";
      
      echo "</tr>";

      echo "<tr>";  
        echo "<td class='tabla_td' colspan='5'><img src='../img/calendar.png' align='center' valing='middle' width='16' height='16'> &nbsp;" . @odbc_result($qryPartidos,8) . " &nbsp;&nbsp; <img src='../img/reloj.png' align='center' valing='middle' width='16' height='16'> &nbsp;" . @odbc_result($qryPartidos,11);
      echo "</tr>";

      echo "<tr>";  
        echo "<td class='tabla_td' colspan='5'><input type='hidden' name='jp_id_".$i."' id='jp_id_".$i."' value='".$i."'><img src='../img/estadio.png' align='center' valing='middle' width='20' height='20'> &nbsp; ESTADIO " . @odbc_result($qryPartidos,10) ;
      echo "</tr>";

        echo "</td>";
      echo "</tr>";  

      echo "<tr>";

        echo "<td class='tabla_td' colspan='5'><hr>";

      echo "</tr>";

      $i = $i + 1;
      
    }
    $i = $i-1;
    echo "<input type='hidden' name='total' id='total' value='".$i."'>";
    
  ?>
    
  </table>
  <center><button type="submit" value="Submit">Actualizar</button>
  <br>
  <center><a href='lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
</form>



