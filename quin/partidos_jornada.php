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

  $totParJor = @odbc_num_rows($qryPartidos);

  //Armamos parametros
  $parametros_jornada = "?li_id=" . $_GET['li_id'] . "&to_id=" . $_GET['to_id'] . "&jo_id=" . $_GET['jo_id'] . "&jornada=" . $_GET['jornada'];


?>

<head>
    <meta charset="utf-8">
    <link href="../css/style.css" rel="stylesheet">
</head> 

<p><p><p><p> 

<?php 
  //echo "<center>" . $totParJor;
  if($totParJor > 0){
?>
      <table id="fw" class="treinta" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="tabla_td" colspan="5"><hr></td>
        </tr>

        <tr>
            <td class="tabla_td" colspan="5"><a href="partidos_jornada_editar.php<?php echo $parametros_jornada; ?>"><img src="../img/editar.gif" valign="middle" with='20' height='20'></a>&nbsp;<?php echo $_GET['jornada']; ?></td>
        </tr>

        <tr>
            <td class="tabla_td" colspan="5"><hr></td>
        </tr>

      <?php

        while($row=@odbc_fetch_row($qryPartidos)){

          $sqlLocal = "SELECT eq_nombre, eq_logo, eq_mote FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryPartidos,4)."'";
          $qryLocal = @odbc_exec($con,$sqlLocal);

          $sqlVisita = "SELECT eq_nombre, eq_logo, eq_mote FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryPartidos,6)."'";
          $qryVisita = @odbc_exec($con,$sqlVisita);

          echo "<tr>";
            echo "<td class='tabla_td'><img src='".@odbc_result($qryLocal,2)."' with='30' height='30'>";
            echo "<td class='tabla_td'>" . @odbc_result($qryPartidos,5);
            echo "<td class='tabla_td'>" . @odbc_result($qryPartidos,9);
            echo "<td class='tabla_td'>" . @odbc_result($qryPartidos,7);
            echo "<td class='tabla_td'><img src='".@odbc_result($qryVisita,2)."' with='30' height='30'>";
          echo "</tr>";

          echo "<tr>";  
            echo "<td class='tabla_td' colspan='5'><img src='../img/calendar.png' align='center' valing='middle' width='16' height='16'> &nbsp;" . @odbc_result($qryPartidos,8) . " &nbsp;&nbsp; <img src='../img/reloj.png' align='center' valing='middle' width='16' height='16'> &nbsp;" . @odbc_result($qryPartidos,11);
          echo "</tr>";

          echo "<tr>";  
            echo "<td class='tabla_td' colspan='5'><img src='../img/estadio.png' align='center' valing='middle' width='20' height='20'> &nbsp; ESTADIO " . @odbc_result($qryPartidos,10) ;
          echo "</tr>";

          echo "<tr>";  
            echo "<td class='tabla_td' colspan='5'><hr></td>";
          echo "</tr>";  
        
        }
        
      ?>
        
      </table>

<?php

  }else{

    $sqlEqQui = "SELECT A.li_id, A.to_id, A.eq_id, B.eq_nombre
                  FROM softquin_prod.sq_torneo_equipo as A, softquin_prod.sq_equipo as B
                  WHERE   A.eq_id = B.eq_id AND A.li_id = '".$_GET['li_id']."' AND A.to_id = '".$_GET['to_id']."' ORDER BY A.eq_id;";

    $qryEqQui = @odbc_exec($con,$sqlEqQui);
    $te = @odbc_num_rows($qryEqQui);
    $r=0;
    while($row=@odbc_fetch_row($qryEqQui)){

      $arr_equipos[$r][0] = @odbc_result($qryEqQui,3);
      $arr_equipos[$r][1] = @odbc_result($qryEqQui,4);  

      $r=$r+1;

    }

?>    


<form method="POST" action="partidos_jornada_alta.php">

  <input type="hidden" name="li_id" id="li_id" value="<?php echo $_GET['li_id'];?>">
  <input type="hidden" name="to_id" id="to_id" value="<?php echo $_GET['to_id'];?>">
  <input type="hidden" name="jo_id" id="jo_id" value="<?php echo $_GET['jo_id'];?>">
    
  <table id="fw" class="cuarenta" align="center" border="0" cellpadding="1" cellspacing="1">
    <tr>
        <td class="tabla_td" colspan="3"><hr></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="3"><?php echo $_GET['jornada']; ?></td>
    </tr>

    <tr>
        <td class="tabla_td" colspan="3"><hr></td>
    </tr>

    <tr>
        <td class="tabla_td">LOCAL</td>
        <td class="tabla_td">VISITA</td>
        <td class="tabla_td">FECHA</td>
    </tr>

<?php 

    
    for ($i=1; $i <= 9; $i++) { 

      echo "<tr>";

        echo "<td class='tabla_td'><input type='hidden' name='jp_id_".$i."' id='jp_id_".$i."' value='".$i."'>";

        

          echo "<select id='eqloc_".$i."' name='eqloc_".$i."' class='tabla_td'>";

            for ($y=0; $y < $te ; $y++) { 
              
              echo "<option value='".$arr_equipos[$y][0]."'>".$arr_equipos[$y][1]."</option>";            

            }

          echo "</select>";

        echo "<td class='tabla_td'>";

          echo "<select id='eqvis_".$i."' name='eqvis_".$i."' class='tabla_td'>";

            for ($y=0; $y < $te ; $y++) { 
              
              echo "<option value='".$arr_equipos[$y][0]."'>".$arr_equipos[$y][1]."</option>";            

            }

          echo "</select>";

        echo "<td class='tabla_td'>";

          echo "<input type='datetime-local' name='fecha_".$i."' id='fecha_".$i."' class='tabla_td'>";
          

      echo "</tr>";

      echo "<tr>";

        echo "<td class='tabla_td' colspan='3'><hr>";

      echo "</tr>";

    }

    $i = $i - 1;

?>


  </table>
  <input type="hidden" name="total" id="total" value="<?php echo $i; ?>">
  <center><button type="submit" value="Submit">Guardar</button>

</form>


<?php 
  }

?>      

<center><a href='lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>

