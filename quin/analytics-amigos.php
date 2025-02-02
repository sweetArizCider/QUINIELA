<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(12,$con); 

  include("imp_partido_jornada.php");

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
    echo "<table id='fw' class='ochenta' border='0' cellspacing='0' cellpadding='0' align='center'>";

      echo "<tr>";
          echo "<th class='tabla_th_pos'>LIGA";
          echo "<th class='tabla_th_pos'>TORNEO";
          echo "<th class='tabla_th_pos'>QUINIELA";
          
      echo "<tr>";
          echo "<td class='tabla_td'>" . $_GET['li_id'];
          echo "<td class='tabla_td'>" . $_GET['to_id'];
          echo "<td class='tabla_td'>" . $_GET['qu_nombre'];
          
      echo "<tr>";
          echo "<th class='tabla_td' colspan='3'><hr>";

    echo "</table>";

      echo "<table id='fw' class='ochenta' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>";

      echo "<tr>";
        echo "<th class='tabla_td_pos'>FOTO";
        echo "<th class='tabla_td_pos'>NOMBRE";
        echo "<th class='tabla_td_pos'>JORNADAS";
        echo "<th class='tabla_td_pos'>PRONOSTICOS";
        echo "<th class='tres'>ACIERTOS DE 3";
        echo "<th class='tres'>ACIERTOS DE 3 - %";
        echo "<th class='uno'>ACIERTOS DE 1";
        echo "<th class='uno'>ACIERTOS DE 1 - %";
        echo "<th class='cero'>DESACIERTOS";
        echo "<th class='cero'>DESACIERTOS - %";
        echo "<th class='posibles'>PUNTOS POSIBLES";
        echo "<th class='posibles'>TOTAL DE PUNTOS";
        echo "<th class='posibles'>% TOTAL";
      
      $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor, B.u_foto 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND 
                          A.qu_id = '" . $_GET['qu_id'] . "' ORDER BY u_id ASC";

      $qryAmigos = @odbc_exec($con,$sqlAmigos);

      while($row=@odbc_fetch_row($qryAmigos)){

        echo "<tr>";
        
        echo "<td class='tabla_td'><img src='../img/".@odbc_result($qryAmigos,5)."' width='30' height='32'>";        

        echo "<td class='tabla_td'>" . @odbc_result($qryAmigos,4);

        //JORNADAS
        $sqlJor = "SELECT MAX(jo_id) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."'";
        $qryJor = @odbc_exec($con,$sqlJor);   

        $jor = @odbc_result($qryJor,1);
        $totPosPtos = $jor * 27;               

        echo "<td class='tabla_td'>" . @odbc_result($qryJor,1);

        //TOTAL PRONOSTICOS
        $sqlPro = "SELECT COUNT(*) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."' AND jp_LEV != '-'";
        $qryPro = @odbc_exec($con,$sqlPro);   

        $totPro = @odbc_result($qryPro,1);           
        
        echo "<td class='tabla_td'>" . @odbc_result($qryPro,1);

        //TOTAL 3 PUNTOS
        $sql3Ptos = "SELECT COUNT(*) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."' AND jp_puntos = 3";
        $qry3Ptos = @odbc_exec($con,$sql3Ptos);              
        
        $tot3 = @odbc_result($qry3Ptos,1);

        echo "<td class='tabla_td'>" . @odbc_result($qry3Ptos,1);

        //% 3 PUNTOS
        $por3 = ($tot3/$totPro)*100;

        echo "<td class='tabla_td'>" . round($por3,1) . " %";

        //TOTAL 1 PUNTO
        $sql1Ptos = "SELECT COUNT(*) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."' AND jp_puntos = 1";
        $qry1Ptos = @odbc_exec($con,$sql1Ptos);   

        $tot1 = @odbc_result($qry1Ptos,1);
        
        echo "<td class='tabla_td'>" . @odbc_result($qry1Ptos,1);

        //% 1 PUNTOS
        $por1 = ($tot1/$totPro)*100;

        echo "<td class='tabla_td'>" . round($por1,1) . " %";

        //TOTAL 0 PUNTOS
        $sql0Ptos = "SELECT COUNT(*) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."' AND jp_LEV != '-' AND jp_puntos = 0";
        $qry0Ptos = @odbc_exec($con,$sql0Ptos);     

        $tot0 = @odbc_result($qry0Ptos,1);         
        
        echo "<td class='tabla_td'>" . @odbc_result($qry0Ptos,1);

        //% 0 PUNTOS
        $por0 = ($tot0/$totPro)*100;

        echo "<td class='tabla_td'>" . round($por0,1) . " %";

        //PUNTOS POSIBLES
        echo "<td class='tabla_td'>" . $totPosPtos;

        //TOTAL DE PUNTOS
        $sqltptos = "SELECT SUM(jp_puntos) FROM softquin_prod.sq_quiniela_pronostico
                    WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                          li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND
                          u_id = '".@odbc_result($qryAmigos,2)."'";
        $qrytptos = @odbc_exec($con,$sqltptos);   

        $totptos = @odbc_result($qrytptos,1);
        echo "<td class='tabla_td'>" . @odbc_result($qrytptos,1);

        //% TOTAL
        $porTotal = ($totptos/$totPosPtos)*100;
        echo "<td class='tabla_td'>" . round($porTotal,1) . " %";

        echo "<tr><td class='tabla_td' colspan='13'><hr>";


      }

      echo "</table>";

    include("../include/cierraConexion.php");

    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>