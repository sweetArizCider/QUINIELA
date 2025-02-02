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
    echo "JORNADA:" . $_GET['jo_id'] . "<br>";
    echo "QUINIELA:" . $_GET['qu_id'] . "<br>";
    echo "NOMBRE:" . $_GET['qu_nombre'] . "<br>";
    echo "<HR>";*/
    echo "<p><p><p>";
    echo "<table id='fw' class='cien' align='center'>";

      echo "<tr>";
          echo "<th class='tabla_th'>LIGA";
          echo "<th class='tabla_th'>TORNEO";
          echo "<th class='tabla_th'>QUINIELA";
          echo "<th class='tabla_th'>JORNADA";

      echo "<tr>";
          echo "<td class='tabla_td'>" . $_GET['li_id'];
          echo "<td class='tabla_td'>" . $_GET['to_id'];
          echo "<td class='tabla_td'>" . $_GET['qu_nombre'];
          echo "<td class='tabla_td'>" . $_GET['jo_id'];
      echo "<tr>";
          echo "<th class='tabla_th' colspan='4'><hr>";

    echo "</table>";

    //Consultamos los partidos de la jornada
    $sqlJornada = "SELECT li_id, to_id, jo_id, jp_id, eq_id_local, eq_id_local_score, eq_id_visita, eq_id_visita_score, jp_LEV 
                  FROM softquin_prod.sq_jornada_partido 
                  WHERE li_id = '". $_GET['li_id'] . "' AND
                        to_id = '" . $_GET['to_id'] . "' AND 
                        jo_id = " . $_GET['jo_id'] . " ORDER BY jp_id";

    $qryJornada = @odbc_exec($con,$sqlJornada);

    echo "<table id='fw' class='cien' align='center' border='1' cellspacing='1' cellpadding='1' bgcolor='#FFFFFF'>";

      echo "<tr>";
        echo "<th class='tabla_th_est'>LOCAL";
        echo "<th class='tabla_th_est' colspan='3'>MARCADOR";
        echo "<th class='tabla_th_est'>VISITA";
        
      $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND qu_id='" . $_GET['qu_id'] . "' ORDER BY u_id ASC";
      $qryAmigos = @odbc_exec($con,$sqlAmigos);

      while($row=@odbc_fetch_row($qryAmigos)){
        echo "<th class='tabla_th_est' colspan='4'>" . odbc_result($qryAmigos,4);
      }

      while($row=@odbc_fetch_row($qryJornada)){

        echo "<tr>";
          echo "<td class='tabla_td_est'>";
          $sqlBan = "SELECT eq_logo, eq_nombre  FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryJornada,5)."'"; 
            $qryBan = @odbc_exec($con,$sqlBan);
            echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";

          echo "<td class='tabla_td_est_gris'>" . @odbc_result($qryJornada,6);
          echo "<td class='tabla_td_est'>" . @odbc_result($qryJornada,9);
          echo "<td class='tabla_td_est_gris'>" . @odbc_result($qryJornada,8);

          echo "<td class='tabla_td_est'>";
          $sqlBan = "SELECT eq_logo, eq_nombre  FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryJornada,7)."'"; 
            $qryBan = @odbc_exec($con,$sqlBan);
            echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";

          $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND qu_id='" . $_GET['qu_id'] . "' ORDER BY u_id ASC";
          $qryAmigos = @odbc_exec($con,$sqlAmigos);

           while($row=@odbc_fetch_row($qryAmigos)){

              $sqlAmiPro = "SELECT qu_id, u_id, li_id, to_id, jo_id, jp_id, eq_id_local, eq_id_local_score, eq_id_visita, eq_id_visita_score, jp_LEV, jp_puntos 
                            FROM softquin_prod.sq_quiniela_pronostico
                            WHERE qu_id = '".$_GET['qu_id']."' AND
                                  u_id = '".@odbc_result($qryAmigos,2)."' AND
                                  li_id = '".$_GET['li_id']."' AND
                                  to_id = '".$_GET['to_id']."' AND
                                  jo_id = ".$_GET['jo_id']." AND
                                  jp_id = ".@odbc_result($qryJornada,4)." ";
              $qryAmiPro = @odbc_exec($con,$sqlAmiPro);

              echo "<td class='tabla_td_est_gris'>&nbsp;" . @odbc_result($qryAmiPro,8) . "&nbsp;";
              echo "<td class='tabla_td_est'>&nbsp;" . @odbc_result($qryAmiPro,11) . "&nbsp;";
              echo "<td class='tabla_td_est_gris'>&nbsp;" . @odbc_result($qryAmiPro,10) . "&nbsp;";

              if(@odbc_result($qryAmiPro,12)==0){$clase="cero";}
              if(@odbc_result($qryAmiPro,12)==1){$clase="uno";}
              if(@odbc_result($qryAmiPro,12)==3){$clase="tres";}

              echo "<td class='".$clase."'>&nbsp;" . @odbc_result($qryAmiPro,12). "&nbsp;";

              
            }


      }

      echo "<tr>";
        echo "<td class='tabla_td_est_tot' colspan='5'>ACIERTOS DE LA JORNADA " . $_GET['jo_id'];

        $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND qu_id='" . $_GET['qu_id'] . "' ORDER BY u_id ASC";
          $qryAmigos = @odbc_exec($con,$sqlAmigos);

           while($row=@odbc_fetch_row($qryAmigos)){

              $sqlAmiPro = "SELECT sum(jp_puntos) 
                            FROM softquin_prod.sq_quiniela_pronostico
                            WHERE qu_id = '".$_GET['qu_id']."' AND
                                  u_id = '".@odbc_result($qryAmigos,2)."' AND
                                  li_id = '".$_GET['li_id']."' AND
                                  to_id = '".$_GET['to_id']."' AND
                                  jo_id = ".$_GET['jo_id'];
              $qryAmiPro = @odbc_exec($con,$sqlAmiPro);

              echo "<td class='tabla_td_est_tot' colspan='4'>" . @odbc_result($qryAmiPro,1);

            }

      echo "<tr>";
        echo "<td class='tabla_td_est_tot' colspan='5'>ACUMULADO";

        $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom, B.u_nom_cor 
                    FROM sq_quiniela_amigos AS A, sq_usr AS B 
                    WHERE B.u_id = A.u_id AND qu_id='" . $_GET['qu_id'] . "' ORDER BY u_id ASC";
          $qryAmigos = @odbc_exec($con,$sqlAmigos);

           while($row=@odbc_fetch_row($qryAmigos)){

              $sqlAmiPro = "SELECT sum(jp_puntos) 
                            FROM softquin_prod.sq_quiniela_pronostico
                            WHERE qu_id = '".$_GET['qu_id']."' AND
                                  u_id = '".@odbc_result($qryAmigos,2)."' AND
                                  li_id = '".$_GET['li_id']."' AND
                                  to_id = '".$_GET['to_id']."'";
              $qryAmiPro = @odbc_exec($con,$sqlAmiPro);

              echo "<td class='tabla_td_est_tot' colspan='4'>" . @odbc_result($qryAmiPro,1);

            }

    echo "</table>";

    include("../include/cierraConexion.php");
    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>