<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(12,$con); 

  include("imp_partido_jornada.php");


  $sqlinfoAmigo = "SELECT u_id, u_nom, u_mai, u_nom_cor, u_foto
                FROM softquin_prod.sq_usr
                WHERE u_id = '" . $_GET['u_id'] . "'";

 

  $qryInfoAmigo = @odbc_exec($con,$sqlinfoAmigo);

  ?>

<html>
  <head>
      <meta charset="utf-8">
      <link href="../css/style.css" rel="stylesheet">
  </head>
  
  <body>

    <?php


    //Obtenemos la lista de las jornadas de la liga

    /*echo "<HR>";
    echo "LIGA:" . $_GET['li_id'] . "<br>";
    echo "TORNEO:" . $_GET['to_id'] . "<br>";
    echo "QUINIELA:" . $_GET['qu_id'] . "<br>";
    echo "NOMBRE:" . $_GET['qu_nombre'] . "<br>";
    echo "<HR>";*/

    echo "<p><p><p>";
    echo "<table id='fw' class='cincuenta' border='0' cellspacing='0' cellpadding='0' align='center'>";

      /*echo "<tr>";
          echo "<th class='tabla_th_pos'>LIGA";
          echo "<th class='tabla_th_pos'>TORNEO";
          echo "<th class='tabla_th_pos'>QUINIELA";
          
      echo "<tr>";
          echo "<td class='tabla_td'>" . $_GET['li_id'];
          echo "<td class='tabla_td'>" . $_GET['to_id'];
          echo "<td class='tabla_td'>" . $_GET['qu_nombre'];*/
          
      echo "<tr>";
          echo "<th class='tabla_th' colspan='3'><hr>";

    echo "</table>";

    echo "<table id='fw' class='noventa' align='center' border='0' cellspacing='1' cellpadding='0' bgcolor='#FFFFFF'>";

    echo "<tr>";
    echo "<td align='center'>";

      echo "<table id='fw' class='setenta' border='0'>";

        echo "<tr><td colspan='2'><hr>";

        echo "<tr>";
        echo "<td align='center'><img src='../img/" . @odbc_result($qryInfoAmigo,5)."' width='70' height='70' class='foto_pos_fic'>";

        //Calculamos no de estrellas
        $sqlStar = "SELECT * FROM softquin_prod.sq_historico
                      WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."' AND qu_pos = 1  ";

        $qryStar = @odbc_exec($con, $sqlStar);

        echo "<br>";

        while($row=@odbc_fetch_row($qryStar)){

          echo "<img src='../img/estrella.gif' width='20' height='20'> &nbsp;";

        }


        echo "<td class='ficha'>" . @odbc_result($qryInfoAmigo,2) . "";
        echo "<br>Alias: " . @odbc_result($qryInfoAmigo,4);
        echo "<br>Correo Electrónico: " . @odbc_result($qryInfoAmigo,3) . "<br>"; 

        echo "<tr><td colspan='2'><hr>";

        //Obtenemos estadística del amigo

        $sqlTP = "SELECT count(*) FROM softquin_prod.sq_historico WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."'";
        $qryTP = @odbc_exec($con,$sqlTP);

        $sqlCamp = "SELECT count(*) FROM softquin_prod.sq_historico WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."' AND qu_pos = 1";
        $qryCamp = @odbc_exec($con,$sqlCamp);

        $sqlMAX = "SELECT max(jp_puntos) FROM softquin_prod.sq_historico WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."'";
        $qryMAX = @odbc_exec($con,$sqlMAX);

        $sqlMIN = "SELECT min(jp_puntos) FROM softquin_prod.sq_historico WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."'";
        $qryMIN = @odbc_exec($con,$sqlMIN);

        $sqlAVG = "SELECT avg(jp_puntos) FROM softquin_prod.sq_historico WHERE qu_tipo='".$_GET['qu_tipo']."' AND u_id = '".$_GET['u_id']."'";
        $qryAVG = @odbc_exec($con,$sqlAVG);

        echo "<tr><td class='ficha'>&nbsp;";

        echo "<td class='ficha_detalle'>";
        echo "<b>Total de Participaciones:</b> " . @odbc_result($qryTP,1);
        echo "<br><b>Quinielas ganadas:</b> " . @odbc_result($qryCamp,1);
        echo "<br><b>Mas puntos en una Quiniela:</b> " . @odbc_result($qryMAX,1);
        echo "<br><b>Menos puntos en una quiniela:</b> " . @odbc_result($qryMIN,1);
        echo "<br><b>Promedio de puntos por quiniela:</b> " . round(@odbc_result($qryAVG,1),2);

        echo "<tr><td colspan='2'><hr>";

        echo "<tr><td colspan='2'>";
          echo "<table id='his' class='cien' align='center' border='0' cellspacing='1' cellpadding='0' bgcolor='#FFFFFF'>";

            echo "<tr>";
            echo "<th class='tabla_th_ana_pro'>TORNEO";
            echo "<th class='tabla_th_ana_pro'>POSICIÓN";
            echo "<th class='tabla_th_ana_pro'>PUNTOS";
            echo "<th class='tabla_th_ana_pro'>CAMPEÓN";
            echo "<th class='tabla_th_ana_pro'>PUNTOS";
            echo "<th class='tabla_th_ana_pro'>DIFERENCIA";
            echo "<th class='tabla_th_ana_pro'>SOTANERO";
            echo "<th class='tabla_th_ana_pro'>PUNTOS";
            echo "<th class='tabla_th_ana_pro'>DIFERENCIA";


            $sqlHis = "SELECT qu_nombre, jp_puntos, qu_pos, qu_id FROM softquin_prod.sq_historico WHERE u_id = '".$_GET['u_id']."' AND qu_tipo='".$_GET['qu_tipo']."' ORDER BY his_anio";

            $qryHis = @odbc_exec($con, $sqlHis);

            echo "<tr><td colspan='9'><hr>";  

            while($row=@odbc_fetch_row($qryHis)){ 

              echo "<tr>";
              echo "<td class='tabla_td_posg'>" . @odbc_result($qryHis,1);

              if(@odbc_result($qryHis,3) == 1){
                echo "<td class='tabla_td_posg'><img src='../img/estrella.gif' width='15' height='15' valing='middle'>CAMPEÓN";
              }else{
                echo "<td class='tabla_td_posg'>" . @odbc_result($qryHis,3) . " o";
              }
              
              echo "<td class='tabla_td_posg'>" . @odbc_result($qryHis,2);
              $ptos_qu = @odbc_result($qryHis,2);

              //Obtenemos campeón de la quiniela

              $sqlCamp = "SELECT u_nom_cor, jp_puntos, qu_pos FROM softquin_prod.sq_historico WHERE qu_id = '".@odbc_result($qryHis,4)."' AND qu_tipo='".$_GET['qu_tipo']."' AND qu_pos = 1";

              $qryCamp = @odbc_exec($con,$sqlCamp);

              echo "<td class='tabla_td_posg'>" . @odbc_result($qryCamp,1);
              echo "<td class='tabla_td_posg'>" . @odbc_result($qryCamp,2);
              $ptosCamp = @odbc_result($qryCamp,2);

              $difptos = $ptos_qu - $ptosCamp;

              echo "<td class='tabla_td_posg'>" . $difptos;

              $sqlUP = "SELECT max(qu_pos) FROM softquin_prod.sq_historico WHERE qu_id = '".@odbc_result($qryHis,4)."' AND qu_tipo = '".$_GET['qu_tipo']."'";
              $qryUP = @odbc_exec($con,$sqlUP);

              $UP = @odbc_result($qryUP,1);
              
              $sqlSot = "SELECT u_nom_cor, jp_puntos, qu_pos FROM softquin_prod.sq_historico WHERE qu_id = '".@odbc_result($qryHis,4)."' AND qu_tipo='".$_GET['qu_tipo']."' AND qu_pos = " . $UP;
              $qrySot = @odbc_exec($con,$sqlSot);

              echo "<td class='tabla_td_posg'>" . @odbc_result($qrySot,1);
              echo "<td class='tabla_td_posg'>" . @odbc_result($qrySot,2);
              $ptosSot = @odbc_result($qrySot,2);

              $difptos = $ptos_qu - $ptosSot;

              echo "<td class='tabla_td_posg'>+" . $difptos;

              echo "<tr><td colspan='9'><hr>";


            }

          echo "</table>";

      echo "</table>";

    echo "</table>";
    
    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>