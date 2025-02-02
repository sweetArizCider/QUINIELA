<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(13,$con); 

  //include("imp_partido_jornada.php");

  if(is_null($_POST['qu_id'])){  $qu_id = "";}
  else{ $qu_id = $_POST['qu_id']; }

  if(is_null($_POST['u_id'])){  
    $u_id = "";
  }
  else{ $u_id = $_POST['u_id']; }

  ?>

<html>
  <head>
      <meta charset="utf-8">
      <link href="../css/style.css" rel="stylesheet">
      <script language="javascript" src="../include/library.js"></script>
  </head>
  
  <body>

    <form method="POST" name="frmEM" id="frmEM" action="multas.php">
      <table class="treinta" border="0" align="center">
        <?php

          echo "<tr>";
            echo "<th class='tabla_th_est'>QUINIELA";
              echo "<tr>";
                echo "<td align='center'>";

                  echo "<select name='qu_id' id='qu_id' class='select_mul' onChange='submit();'>";
                  
                  $sqlQu = "SELECT qu_id, qu_nombre FROM softquin_prod.sq_quiniela";
                  $qryQu = @odbc_exec($con,$sqlQu);
                  
                  while($row=@odbc_fetch_row($qryQu)){
                    if($qu_id == @odbc_result($qryQu,1)){
                      echo "<option value='".@odbc_result($qryQu,1)."' selected>" . @odbc_result($qryQu,2) . "</option>";

                      //Obtenemos toreno
                      $sqlTo = "SELECT to_id FROM softquin_prod.sq_quiniela_torneo WHERE qu_id = '".$_POST['qu_id']."'";
                      $qryTo = @odbc_exec($con,$sqlTo);

                    }else{
                      echo "<option value='".@odbc_result($qryQu,1)."'>" . @odbc_result($qryQu,2) . "</option>";
                    }
                  }
                  
                  echo "</select>";
                  echo "<br>";
              


                  echo "<input type='text' class='select_mul' name='to_id' id='to_id' value='" . @odbc_result($qryTo,1) . "'>";

            echo "<tr>";
            echo "<th class='tabla_th_est'>AMIGO";
              echo "<tr>";
                echo "<td align='center'>";

                  echo "<select name='u_id' id='u_id' class='select_mul' onChange='submit();'>";
                  
                  $sqlAmi = "SELECT A.qu_id, A.u_id, B.u_nom 
                              FROM sq_quiniela_amigos AS A, sq_usr AS B 
                              WHERE B.u_id = A.u_id AND qu_id='".$_POST['qu_id']."' 
                              ORDER BY u_id ASC";
                  $qryAmi = @odbc_exec($con,$sqlAmi);
                  
                  while($row=@odbc_fetch_row($qryAmi)){
                    if($u_id == @odbc_result($qryAmi,2)){
                      echo "<option value='".@odbc_result($qryAmi,2)."' selected>" . @odbc_result($qryAmi,3) . "</option>";
                    }else{
                      echo "<option value='".@odbc_result($qryAmi,2)."'>" . @odbc_result($qryAmi,3) . "</option>";
                    }
                  }
                  
                  echo "</select>";

            echo "<tr>";
            echo "<th class='tabla_th_est'>JORNADA";
              echo "<tr>";
                echo "<td align='center'>";

                  echo "<select name='jo_id' id='jo_id' class='select_mul'>";
                  
                  $sqlJor = "SELECT A.qu_id, A.li_id, A.to_id, B.jo_id, B.jo_nombre
                              FROM sq_quiniela_torneo as A, sq_jornada as B
                              WHERE A.li_id = B.li_id AND
                                    A.to_id = B.to_id AND
                                    A.qu_id = '".$_POST['qu_id']."'
                              ORDER BY B.jo_id";
                  $qryJor = @odbc_exec($con,$sqlJor);
                  
                  while($row=@odbc_fetch_row($qryJor)){
                    echo "<option value='".@odbc_result($qryJor,4)."'>" . @odbc_result($qryJor,5) . "</option>";
                  }
                  
                  echo "</select>";

            echo "<tr>";
            echo "<th class='tabla_th_est'>ENTRADA / MULTA";

                  $sqlEM = "SELECT qu_id, qu_entrada, qu_multa FROM softquin_prod.sq_quiniela WHERE qu_id = '".$_POST['qu_id']."'";
                  $qryEM = @odbc_exec($con,$sqlEM);

              echo "<tr>";
                echo "<td align='center'>";

                  echo "<select name='monto' id='monto' class='select_mul'>";
                  
                    echo "<option value='MULTA,".@odbc_result($qryEM,3)."'>MULTA - $".@odbc_result($qryEM,3)."</option>";
                    echo "<option value='ENTRADA,".@odbc_result($qryEM,2)."'>ENTRADA - $".@odbc_result($qryEM,2)."</option>";
                                    
                  echo "</select>";   

            echo "<tr>";
                echo "<td align='center'><button type='button' class='select_mul' onclick='saveEM();'>Guardar</button>";

            echo "<tr>";
                echo "<td align='center'><hr>";   

          include("../include/cierraConexion.php");
        ?>
    </table>
  </form>

  </body>
</html>