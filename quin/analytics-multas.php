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
    echo "<table id='fw' class='noventa' border='0' cellspacing='0' cellpadding='0' align='center'>";

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

      echo "<table id='fw' class='noventa' align='center' border='0' cellspacing='2' cellpadding='0' bgcolor='#FFFFFF'>";

      echo "<tr>";
        echo "<th class='tabla_td_pos'>FOTO";
        echo "<th class='tabla_td_pos'>NOMBRE";
        echo "<th class='tabla_td_pos'>ENTRADA";

        $i = 3;

        $sqlJor = "SELECT jo_id, jo_nombre FROM softquin_prod.sq_jornada
                    WHERE li_id = '".$_GET['li_id']."' AND
                        to_id = '".$_GET['to_id']."'
                    ORDER BY jo_id";

          $qryJor = @odbc_exec($con,$sqlJor);

          while($row=@odbc_fetch_row($qryJor)){
            echo "<th class='tabla_td_pos'>" . @odbc_result($qryJor,2);  
            $i = $i + 1;
          }

          echo "<th class='tabla_th_pos'>TOTAL";
        
      
      $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor, B.u_foto 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND 
                          A.qu_id = '" . $_GET['qu_id'] . "' ORDER BY u_id ASC";

      $qryAmigos = @odbc_exec($con,$sqlAmigos);

      while($row=@odbc_fetch_row($qryAmigos)){

        $totalMul = 0;

        echo "<tr>";
        
        echo "<td class='tabla_td'><img src='../img/".@odbc_result($qryAmigos,5)."' width='30' height='32'>";        

        echo "<td class='tabla_td'>" . @odbc_result($qryAmigos,4);

        //ENTRADA

        $sqlEnt = "SELECT qu_id, u_id, jo_id, mu_tipo, mu_monto 
                  FROM softquin_prod.sq_multas
                  WHERE qu_id = '".$_GET['qu_id']."' AND
                        u_id = '".@odbc_result($qryAmigos,2)."' AND
                        mu_tipo = 'ENTRADA'";
        $qryEnt = @odbc_exec($con,$sqlEnt);

        echo "<td class='tres_10'>$ " . @odbc_result($qryEnt,5);

        $totalMul = @odbc_result($qryEnt,5);

        //multas por jornada
        $sqlJor = "SELECT jo_id, jo_nombre FROM softquin_prod.sq_jornada
                    WHERE li_id = '".$_GET['li_id']."' AND
                        to_id = '".$_GET['to_id']."'
                    ORDER BY jo_id";

        $qryJor = @odbc_exec($con,$sqlJor);

        while($row=@odbc_fetch_row($qryJor)){

          $sqlMulAmi = "SELECT qu_id, u_id, jo_id, mu_tipo, mu_monto 
                        FROM softquin_prod.sq_multas
                        WHERE qu_id = '".$_GET['qu_id']."' AND
                              u_id = '".@odbc_result($qryAmigos,2)."' AND
                              jo_id = ".@odbc_result($qryJor,1)." AND
                              mu_tipo = 'MULTA'";
          $qryMulAmi = @odbc_exec($con,$sqlMulAmi);

          if(@odbc_num_rows($qryMulAmi) == 0){
            echo "<td class='tabla_td'>$ 0";  
          }else{
            echo "<td class='cero_10'>$ " . @odbc_result($qryMulAmi,5);
            $totalMul = $totalMul + @odbc_result($qryMulAmi,5);  
          }

          @odbc_free_result($qryMulAmi);
        }

        echo "<td class='tres_10'>$ " . $totalMul;

        $i = $i + 1;
      

        echo "<tr><td class='tabla_td' colspan='".$i."'><hr>";


      }

      echo "</table>";

    include("../include/cierraConexion.php");

    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>