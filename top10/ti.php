<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(16,$con); 

  ?>

<html>
  <head>
      <meta charset="utf-8">
      <link href="../css/style.css" rel="stylesheet">
  </head>
  
  <body>

    <?php


    //Obtenemos la lista de las jornadas de la liga

    echo "<p><p><p>";
    echo "<table id='fw' class='cincuenta' border='0' cellspacing='0' cellpadding='0' align='center'>";

      echo "<tr>";
          echo "<th class='tabla_th_pos'>TOP 10 HISTORICO - TI";
      echo "</tr>";
      
      echo "<tr>";
          echo "<th><hr>";
      echo "</tr>";

    echo "</table>";

    echo "<p>";


    $sql_cam = "SELECT u_nombre,u_nom_cor, u_foto,COUNT(qu_pos) AS LUGAR, u_id 
                FROM softquin_prod.sq_historico 
                WHERE qu_tipo = 'TI' AND qu_pos=1 
                GROUP BY u_nom_cor 
                ORDER BY LUGAR DESC, u_nombre ASC";  
    $qry_cam = @odbc_exec($con, $sql_cam);  

    $con = 1;

     echo "<table id='fw' class='cincuenta' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>";

      echo "<tr>";
        echo "<td class='tabla_td_pos_h'>POSCISION";
        echo "<th class='tabla_td_pos_h' colspan='2'>NOMBRE";
        
        echo "<th class='tabla_td_pos_h'>NICK NAME";
        echo "<th class='tabla_td_pos_h'>TORNEOS GANADOS";
        echo "<th class='tabla_td_pos_h'>ESTRELLAS";
      echo "</tr>";

      $pos = 1;

      while($row=@odbc_fetch_row($qry_cam)){

        echo "<tr>";

          echo "<td class='tabla_td_h'>" . $pos;
          echo "<td class='tabla_td_h'><img src='../img/".@odbc_result($qry_cam,3)."' width='60' height='63'>";
          echo "<td class='tabla_td_h'>" . @odbc_result($qry_cam, 1);
          echo "<td class='tabla_td_h'>" . @odbc_result($qry_cam,2);
          echo "<td class='tabla_td_h'>" . @odbc_result($qry_cam,4);
          echo "<td class='tabla_td_h'>";

            $y = 1;
            while($y <= @odbc_result($qry_cam,4)){

              echo "<img src='../img/estrella.gif' width='20' height='20'> &nbsp;";

              $y = $y + 1;

            }

        echo "</tr>";

        echo "<tr>";

          echo "<td colspan=6><hr>";

        echo "</tr>";

        $pos = $pos + 1;

      }

    /*    while($row=@odbc_fetch_row($qry_cam)){

          echo "<tr>";

            echo "<td class='tabla_td'>" . $con;
            echo "<td class='tabla_td'><img src='../img/". @odbc_result($qry_cam, 3) ."' width='50' height='53'>";
            echo "<td class='tabla_td'>" . @odbc_result($qry_cam,1);
            echo "<td class='tabla_td'>" . @odbc_result($qry_cam,2);

            echo "<td class='tabla_td'>" ;

              $sql_tg = "SELECT qu_nombre FROM softquin_prod.sq_historico WHERE u_id='".@odbc_result($qry_cam,5)."' AND qu_pos=1 ORDER BY his_anio ASC";
              
              echo $sql_tg;
              
              $qry_tg = @odbc_exec($con, $sql_tg);

              /*while($row=@odbc_fetch_row($qry_tg)){

                echo @odbc_result($qry_tg,1) . "<br>";
              
              }
            
            echo "<td class='tabla_td'>";

            $est = 1;

              while($est <= @odbc_result($qry_cam,4)){
                echo " <img src='../img/estrella.gif' width='20' height='20'>&nbsp; ";
                $est = $est + 1;
              }



          echo "</tr>";

          $con = $con + 1;

        }
      
      
      */
      echo "</table>"; 

    include("../include/cierraConexion.php");

    ?>
    <center><a href='../ini/main.php?pad=15'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>