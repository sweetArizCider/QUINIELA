<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(12,$con); 

  //Obtenemos la lista de las quinielas que pertenece

  $sqlQuinielas = "SELECT A.qu_id, A.qu_nombre, B.u_id FROM sq_quiniela as A, sq_quiniela_amigos as B
                   WHERE A.qu_id = B.qu_id AND B.u_id = '" . $_SESSION['sUsu'] . "'";

                   //echo $sqlQuinielas;

  $qryQuinielas = @odbc_exec($con, $sqlQuinielas);

  $totQuin = @odbc_num_rows($qryQuinielas);
?>

<html>
    <head>
        <meta charset="utf-8">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    
    <body>

      <p>
      <p>
      <p>
       <table id="fw" class="cien" align="center">   

            <tr>
                <th class="tabla_th_ana" colspan="12"><?php echo $_SESSION['sNom'] . " -  " . $_SESSION['sMailUsu']?></th>
            </tr>


             <tr>
                <th class="tabla_th_ana">Bandera</th>
                <th class="tabla_th_ana">Pais</th>
                <th class="tabla_th_ana">Liga</th>
                <th class="tabla_th_ana">Deporte</th>    
                <th class="tabla_th_ana">Torneo</th>
                <th class="tabla_th_ana">Quiniela</th>
                <th class="tabla_th_ana">Jornadas</th>
                <th class="tabla_th_ana">Procesar</th>
                <th class="tabla_th_ana">Estadisticas</th>
                <th class="tabla_th_ana">General</th>
                <th class="tabla_th_ana">Amigos</th>
                <th class="tabla_th_ana">Multas</th>
            </tr>

<?php
            $x = 0;
            if($totQuin > 0 ){

                
                while($row=@odbc_fetch_row($qryQuinielas)){

                    $sqlQuiTor = "SELECT C.pa_bandera, 
                                         C.pa_nombre, 
                                         B.li_nombre, 
                                         D.de_nombre, 
                                         A.qt_nombre, 
                                         E.qu_nombre, 
                                         A.qt_estado, 
                                         A.qu_id, 
                                         A.li_id, 
                                         A.to_id,
                                         E.qu_tipo    
                                    FROM sq_quiniela_torneo as A, 
                                         sq_liga as B, 
                                         sq_pais as C, 
                                         sq_deporte as D, 
                                         sq_quiniela as E
                                    WHERE A.li_id = B.li_id AND
                                          B.pa_id = C.pa_id AND
                                          A.qu_id = E.qu_id AND
                                          B.de_id = D.de_id AND
                                          A.qu_id = '" . @odbc_result($qryQuinielas,1) .  "'";

                    //echo $sqlQuiTor . "<p>";

                    $qryQuiTor = @odbc_exec($con,$sqlQuiTor);

                    echo "<tr>";
                        echo "<td class='tabla_td_lq'><img src='" . @odbc_result($qryQuiTor, 1) . "' class='foto_pos'>";  
                        echo "<td class='tabla_td_lq'>" . utf8_encode(@odbc_result($qryQuiTor, 2));
                        echo "<td class='tabla_td_lq'>" . @odbc_result($qryQuiTor, 3);
                        echo "<td class='tabla_td_lq'>" . @odbc_result($qryQuiTor, 4);  
                        echo "<td class='tabla_td_lq'>" . @odbc_result($qryQuiTor, 5);  
                        echo "<td class='tabla_td_lq'>" . @odbc_result($qryQuiTor, 6);                
                        //echo "<td class='tabla_td'>" . @odbc_result($qryQuiTor, 7);

                        $parametros_liga = "?qu_id=" . @odbc_result($qryQuiTor, 8) . "&li_id=" . @odbc_result($qryQuiTor,9) . "&to_id=" . @odbc_result($qryQuiTor, 10) . "&qu_nombre=" . @odbc_result($qryQuiTor, 6) . "&qu_tipo=" . @odbc_result($qryQuiTor, 11);
                        echo "<td class='tabla_td_lq'><a href='lista_quiniela-jornada_partidos.php" . $parametros_liga . "'><img src='../img/jornada.gif' width='32' height='32'></a>";
                        echo "<td class='tabla_td_lq'><a href='lista_quiniela-jornadas_pro.php" . $parametros_liga . "'><img src='../img/icons8-services.gif' width='32' height='32'></a>";
                        echo "<td class='tabla_td_lq'><a href='lista_quiniela-jornadas_est.php" . $parametros_liga . "'><img src='../img/icons8-combo-chart.gif' width='32' height='32'></a>";
                        echo "<td class='tabla_td_lq'><a href='analytics-jornadas_pos.php" . $parametros_liga . "'><img src='../img/icons8-trophy.gif' width='32' height='32'></a>";
                        echo "<td class='tabla_td_lq'><a href='analytics-amigos.php" . $parametros_liga . "'><img src='../img/amigos.gif' width='32' height='32'></a>";
                        echo "<td class='tabla_td_lq'><a href='analytics-multas.php" . $parametros_liga . "'><img src='../img/multas.gif' width='32' height='32'></a>";
                        
                    echo "</tr>";    

                    $x = $x + 1;
                }
            }else{

?> 
  
            <tr>
                <th colspan="9">NO TIENE QUINIELAS ASOCIADAS</th>
            </tr>  

<?php

            }
?>
            <tr>
                <th colspan="12"><H3><HR></H3></th>
            </tr>  
            <tr>
                <th class="tabla_th_ana" colspan="11">TOTAL DE QUINIELAS</th>
                <th class="tabla_th_ana"><?php echo $x;?></th>
            </tr>

        </table>

        <center><a href='../ini/main.php?pad=0'><img src='../img/Back.jpg' alt='Back' /></a></center>

    </body>
</html>


<?php
  include("../include/cierraConexion.php");
?>