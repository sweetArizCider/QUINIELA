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

    $aJornada = [];

    //Obtenemos la lista de las jornadas de la liga

    /*echo "<HR>";
    echo "LIGA:" . $_GET['li_id'] . "<br>";
    echo "TORNEO:" . $_GET['to_id'] . "<br>";
    echo "JORNADA:" . $_GET['jo_id'] . "<br>";
    echo "QUINIELA:" . $_GET['qu_id'] . "<br>";
    echo "NOMBRE:" . $_GET['qu_nombre'] . "<br>";
    echo "<HR>";*/

    echo "<table id='fw' class='noventa' align='center'>";

    echo "<tr>";
          echo "<th class='tabla_th_ana'>Liga";
          echo "<th class='tabla_th_ana'>Torneo";
          echo "<th class='tabla_th_ana'>Quiniela";
          echo "<th class='tabla_th_ana'>Jornada";

echo "<tr>";
          echo "<td class='tabla_td_ana'>" . $_GET['li_id'];
          echo "<td class='tabla_td_ana'>" . $_GET['to_id'];
          echo "<td class='tabla_td_ana'>" . $_GET['qu_nombre'];
          echo "<td class='tabla_td_ana'>" . $_GET['jo_id'];
echo "<tr>";
          echo "<th colspan='4'><hr>";

    echo "</table>";

    // Amigos de la quniela
    $sqlAmigos = "SELECT A.qu_id, A.u_id, B.u_nom 
                  FROM sq_quiniela_amigos AS A, sq_usr AS B 
                  WHERE B.u_id = A.u_id AND qu_id='".$_GET['qu_id']."' ORDER BY u_id ASC";

    $qryAmigos = @odbc_exec($con,$sqlAmigos);

    while($row=@odbc_fetch_row($qryAmigos)){ // Se recorre amigo por amigo

      $sqlProAmi = "SELECT qu_id, u_id, li_id, jo_id, jp_id, eq_id_local, eq_id_local_score, eq_id_visita, eq_id_visita_score, jp_LEV,to_id 
                    FROM softquin_prod.sq_quiniela_pronostico 
                    WHERE qu_id = '".$_GET['qu_id']."' AND
                        li_id = '".$_GET['li_id']."' AND
                          to_id = '".$_GET['to_id']."' AND 
                          jo_id = ".$_GET['jo_id']." AND
                          u_id = '".@odbc_result($qryAmigos,2)."'
                    ORDER BY jp_id ASC";

      //echo "<br>" . $sqlProAmi;

      $qryProAmi = @odbc_exec($con,$sqlProAmi);

      //echo "<br>" . @odbc_num_rows($qryProAmi);

      $puntos_jornada = 0;

      echo "<center>";
      echo "<table id='fw' class='noventa' align='center'>";

        echo "<tr>";
          echo "<th class='tabla_th_ana' colspan='14'>" . @odbc_result($qryAmigos,3);

        echo "<tr>";
          echo "<th class='tabla_th_ana_pro' colspan='7'>Pronostico<th class='tabla_th_ana_mo' colspan='7'>Marcador Oficial<td>";
        echo "<tr>";
          echo "<th class='tabla_th_ana_pro' colspan='2'>Local";
          echo "<th class='tabla_th_ana_pro' colspan='3'>Marcador";
          echo "<th class='tabla_th_ana_pro' colspan='2'>Visita";

          echo "<th class='tabla_th_ana_mo' colspan='2'>Local";
          echo "<th class='tabla_th_ana_mo' colspan='3'>Marcador";
          echo "<th class='tabla_th_ana_mo' colspan='2'>Visita";
          echo "<td class='tabla_th_ana'>Puntos";

          echo "<tr>";
          echo "<td colspan='15'><hr>";

        $totalAmigos = 0;  
          
        while($row=@odbc_fetch_row($qryProAmi)){

           $glp = 0;
           $gvp = 0;
           $rpr = "";

           $glo = 0;
           $gvo = 0;
           $rof = "";

           $tpu = 0;
           $clase = 'cero';

          echo "<tr>";
            echo "<td class='tabla_td_ana_eq' colspan='2'>&nbsp;";

                $sqlBan = "SELECT eq_logo, eq_nombre FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryProAmi,6)."'"; 
                $qryBan = @odbc_exec($con,$sqlBan);
                echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";
                echo "<br>";
                echo @odbc_result($qryBan,2);

            echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
              echo @odbc_result($qryProAmi,7) . "&nbsp;&nbsp;";
              $glp = @odbc_result($qryProAmi,7);
            echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
              echo @odbc_result($qryProAmi,10) . "&nbsp;&nbsp;";
              $rpr = @odbc_result($qryProAmi,10);
            echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
              echo @odbc_result($qryProAmi,9) . "&nbsp;&nbsp;";
              $gvp = @odbc_result($qryProAmi,9);
            
              echo "<td class='tabla_td_ana_eq' colspan='2'>&nbsp;";

              $sqlBan = "SELECT eq_logo, eq_nombre  FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryProAmi,8)."'"; 
              $qryBan = @odbc_exec($con,$sqlBan);
              echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";
              echo "<br>";
              echo @odbc_result($qryBan,2);

          /*echo "<tr><td colspan='7'>";
          echo "<br>PARTIDO " . @odbc_result($qryProAmi,5) . " - LOCAL: " . @odbc_result($qryProAmi,6) . " " . @odbc_result($qryProAmi,7) . " - VISITA: " . @odbc_result($qryProAmi,8) . " " . @odbc_result($qryProAmi,9) . "<br>";   */

            $sqlRO = "SELECT li_id, to_id, jo_id, jp_id, eq_id_local, eq_id_local_score, eq_id_visita, eq_id_visita_score, jp_LEV 
                      FROM softquin_prod.sq_jornada_partido 
                      WHERE li_id = '" . @odbc_result($qryProAmi,3) . "' AND
                            to_id = '" . @odbc_result($qryProAmi,11). "' AND 
                            jo_id = " . @odbc_result($qryProAmi,4) . " AND
                            jp_id = " . @odbc_result($qryProAmi,5) . " ";

            $qryRO = @odbc_exec($con,$sqlRO);

            echo "<td class='tabla_td_ana_eq' colspan='2'>&nbsp;";

              $sqlBan = "SELECT eq_logo, eq_nombre FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryRO,5)."'"; 
              $qryBan = @odbc_exec($con,$sqlBan);
              echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";
              echo "<br>";
              echo @odbc_result($qryBan,2);

                echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
                echo @odbc_result($qryRO,6) . "&nbsp;&nbsp;";
                $glo = @odbc_result($qryRO,6);
              echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
                echo @odbc_result($qryRO,9) . "&nbsp;&nbsp;";
                $rof = @odbc_result($qryRO,9);
              echo "<td class='tabla_td_ana_mar'>&nbsp;&nbsp;";
                echo @odbc_result($qryRO,8) . "&nbsp;&nbsp;";
                $gvo = @odbc_result($qryRO,8);

            echo "<td class='tabla_td_ana_eq' colspan='2'>&nbsp;";

              $sqlBan = "SELECT eq_logo, eq_nombre FROM softquin_prod.sq_equipo WHERE eq_id = '".@odbc_result($qryRO,7)."'"; 
              $qryBan = @odbc_exec($con,$sqlBan);
              echo "<img src='".@odbc_result($qryBan,1)."' with='25' height='25'>";
              echo "<br>";
              echo @odbc_result($qryBan,2);

            if($rpr == $rof){ 
             
              $tpu = 1;
              $clase = 'uno';
            
              if(($glp == $glo) && ($gvp == $gvo)){
                $tpu = 3;
                $clase = 'tres ';
              }
            
            }

            echo "<td class='".$clase."'>" . $tpu;

            $puntos_jornada = $puntos_jornada + $tpu;

            $updPro = "UPDATE sq_quiniela_pronostico
                      SET jp_puntos = " . $tpu . "
                      WHERE qu_id = '" . $_GET['qu_id'] . "' AND
                            u_id = '" . @odbc_result($qryAmigos,2) . "' AND
                            li_id = '" . $_GET['li_id'] . "' AND
                            to_id = '" . $_GET['to_id'] . "' AND
                            jo_id = " . @odbc_result($qryProAmi,4) . " AND
                            jp_id = " . @odbc_result($qryProAmi,5) . " ";
            $qryUpdPro = @odbc_exec($con,$updPro);

          echo "<tr>";
            echo "<td colspan='15'><hr>";  

           
        }

      echo "<tr>";
          echo "<th class='tabla_th_ana' colspan='14'>TOTAL PUNTOS EN LA JORNADA";
          echo "<th class='total'>" . $puntos_jornada;
          $totalAmigos = $totalAmigos + 1;  
      echo "</table>";
      
      echo "<hr>";

      @odbc_free_result($qryProAmi);

    }

    //echo "<br>" . $totalAmigos;
    
   ///////////////////////////////////////////////////////////////////////////////
   ?>
    <!--
      <div class="board">
            <div class="titulo_grafica">
                <h3 class="t_grafica">Título del Gráfico</h3>
            </div>
            <div class="sub_board">
                <div class="sep_board"></div>
                <div class="cont_board">
                    <div class="graf_board">
                        <div class="barra">
                            <div class="sub_barra b1">
                                <div class="tag_g">35%</div>
                                <div class="tag_leyenda">día 1</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b2">
                                <div class="tag_g">45%</div>
                                <div class="tag_leyenda">día 2</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b3">
                                <div class="tag_g">55%</div>
                                <div class="tag_leyenda">día 3</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b4">
                                <div class="tag_g">75%</div>
                                <div class="tag_leyenda">día 4</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                        <div class="barra">
                            <div class="sub_barra b5">
                                <div class="tag_g">85%</div>
                                <div class="tag_leyenda">día 5</div>
                            </div>
                        </div>
                    </div>
                    
               </div> 
                <div class="sep_board"></div>
           </div>    
        </div>
    -->
   <?php
   ///////////////////////////////////////////////////////////////////////////////

    include("../include/cierraConexion.php");
    ?>
    <center><a href='../quin/lista_quiniela.php'><img src='../img/Back.jpg' alt='Back' /></a></center>
  </body>
</html>