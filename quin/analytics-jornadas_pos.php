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

    $parametros = "?li_id=" . $_GET['li_id'] . "&to_id=" . $_GET['to_id'] . "&qu_id=" . $_GET['qu_id'] . "&qu_nombre=" . $_GET['qu_nombre'] . "&qu_tipo=" . $_GET['qu_tipo'];

    echo "<p><p><p>";
    echo "<table id='fw' class='cincuenta' border='0' cellspacing='0' cellpadding='0' align='center'>";

      echo "<tr>";
          echo "<th class='tabla_th_ana'>LIGA";
          echo "<th class='tabla_th_ana'>TORNEO";
          echo "<th class='tabla_th_ana'>QUINIELA";
          
      echo "<tr>";
          echo "<td class='tabla_td_ana'>" . $_GET['li_id'];
          echo "<td class='tabla_td_ana'>" . $_GET['to_id'];
          echo "<td class='tabla_td_ana'>" . $_GET['qu_nombre'];
          
      echo "<tr>";
          echo "<th colspan='3'><hr>";

    echo "</table>";

    //limpiamos tabla
    $DelPos = "DELETE FROM sq_pos_temp
                WHERE li_id = '".$_GET['li_id']."' AND
                    to_id = '".$_GET['to_id']."' AND
                      qu_id = '".$_GET['qu_id']."' ";

    $qryDelPos = odbc_exec($con,$DelPos);

    //echo $DelPos . "<br>";


    $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor,B.u_foto 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND 
                          A.qu_id = '" . $_GET['qu_id'] . "' ORDER BY u_id ASC";

      //echo $sqlAmigos;

      $qryAmigos = @odbc_exec($con,$sqlAmigos);

      while($row=@odbc_fetch_row($qryAmigos)){

        //Obtenemos puntos
        $sqlPunAmi = "SELECT u_id, sum(jp_puntos) AS puntos
                      FROM softquin_prod.sq_quiniela_pronostico
                      WHERE qu_id = '".$_GET['qu_id']."' AND 
                            li_id = '".$_GET['li_id']."' AND 
                            to_id = '".$_GET['to_id']."' AND
                            u_id = '".@odbc_result($qryAmigos,2)."'
                      GROUP BY u_id
                      ORDER BY puntos DESC";

        //echo $sqlPunAmi;              

        $qryPunAmi = @odbc_exec($con,$sqlPunAmi);

        $puntos = @odbc_result($qryPunAmi,2);

        //Obtenemos entrada
        $sqlEnt = "SELECT u_id, mu_monto 
                    FROM softquin_prod.sq_multas
                    WHERE qu_id = '".$_GET['qu_id']."' AND
                        u_id = '".@odbc_result($qryAmigos,2)."' AND
                          mu_tipo = 'ENTRADA'";

        $qryEnt = @odbc_exec($con,$sqlEnt);

        $entrada = @odbc_result($qryEnt,2);

        //Obtenemos multas
        $sqlMul = "SELECT u_id, sum(mu_monto) 
                  FROM softquin_prod.sq_multas
                  WHERE qu_id = '".$_GET['qu_id']."' AND
                        u_id = '".@odbc_result($qryAmigos,2)."' AND
                        mu_tipo = 'MULTA'";

        $qryMul = @odbc_exec($con,$sqlMul);

        if(@odbc_result($qryMul,2)==""){
          $multas = 0;
        }else{
          $multas = @odbc_result($qryMul,2);
        }

        $InsPos = "INSERT INTO sq_pos_temp (li_id, to_id, qu_id, u_id, jp_puntos,qu_entrada, qu_multas)
                   VALUES ('".$_GET['li_id']."','".$_GET['to_id']."','".$_GET['qu_id']."','".@odbc_result($qryAmigos,2)."',".$puntos.",".$entrada.",".$multas.")";

        $qryInsPos = @odbc_exec($con,$InsPos);

        /*echo "<br>" . @odbc_result($qryAmigos,2) . " - " . $puntos;
        echo "<br>" . @odbc_result($qryAmigos,2) . " - " . $entrada;
        echo "<br>" . @odbc_result($qryAmigos,2) . " - " . $multas;
        echo "<hr>";*/

        @odbc_free_result($qryMul);

      }

      $sqlRan = "SELECT A.li_id, A.to_id, A.qu_id, A.u_id, B.u_nom, A.jp_puntos, A.qu_entrada, A.qu_multas, A.qu_entrada+A.qu_multas as total, B.u_foto, A.u_id 
                  FROM sq_pos_temp as A, sq_usr as B
                  WHERE A.u_id = B.u_id AND
                        A.li_id = '".$_GET['li_id']."' AND
                        A.to_id = '".$_GET['to_id']."' AND
                        A.qu_id = '".$_GET['qu_id']."'
                  ORDER BY jp_puntos DESC, total ASC, u_nom ASC";

      $qryRan = @odbc_exec($con,$sqlRan);

      echo "<table id='fw' class='cincuenta' align='center' border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>";

      echo "<tr>";
        echo "<th class='tabla_th_ana_pro'>FOTO";
        echo "<th class='tabla_th_ana_pro'>POSICIÓN";
        echo "<th class='tabla_th_ana_pro'>NOMBRE";
        echo "<th class='tabla_th_ana_pro'>TOTAL PUNTOS";
        echo "<th class='tabla_th_ana_pro'>ENTRADA";
        echo "<th class='tabla_th_ana_pro'>MULTAS";
        echo "<th class='tabla_th_ana_pro'>$ TOTAL";
      
      $p = 1;  
      $premio = 0;
      
      while($row=@odbc_fetch_row($qryRan)){

        //$parametros = $parametros . "&u_id=" . @odbc_result($qryRan,11);

        echo "<tr>";
          echo "<td class='tabla_td_posg'><img src='../img/".@odbc_result($qryRan,10)."' width='40' height='43' class='foto_pos'>";        
          echo "<td class='tabla_td_posg'>" . $p . "<br>";
          echo "<td class='tabla_td_posg'><a href='analytics-ficha.php".$parametros." &u_id=".@odbc_result($qryRan,11)."'>" . @odbc_result($qryRan,5) . "</a>";
          echo "<td class='tabla_td_posg'>" . @odbc_result($qryRan,6);
          echo "<td class='tabla_td_posg'>$" . @odbc_result($qryRan,7);
          echo "<td class='tabla_td_posg'>$" . @odbc_result($qryRan,8);
          echo "<td class='tabla_td_posg'>$" . @odbc_result($qryRan,9);

          $p = $p + 1;

          $premio = $premio + @odbc_result($qryRan,9);

        echo "<tr>";
          echo "<td class='tabla_td_est' colspan='7'><hr>";


      }

      echo "<tr>";
        echo "<th class='tabla_th_ana_pro' colspan='6'>&nbsp;";
        echo "<th class='tabla_th_ana_pro'>$" . $premio;

      echo "</table>";

    include("../include/cierraConexion.php");

    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>