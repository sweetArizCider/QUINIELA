<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(12,$con); 

  //Obtenemos la lista de las jornadas de la liga

  $sqlJornadas = "SELECT * FROM softquin_prod.sq_jornada WHERE li_id='" . $_GET['li_id'] . "' AND to_id='" . $_GET['to_id'] . "' ORDER BY jo_id ASC";

  $sqlJornadas = "SELECT DISTINCT A.qu_id, A.li_id, A.jo_id, B.jo_nombre
                    FROM sq_quiniela_pronostico as A, sq_jornada as B
                    WHERE  A.jo_id = B.jo_id AND
                           A.qu_id = '".$_GET['qu_id']."' AND 
                           A.li_id = '" . $_GET['li_id'] . "' AND 
                           A.to_id = '" . $_GET['to_id'] . "'";

  $qryJornadas = @odbc_exec($con, $sqlJornadas);


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
       <table id="fw" class="treinta" align="center">   

            <tr>
                <th class="tabla_th" colspan="2"><?php echo $_GET['qu_nombre']?></th>
            </tr>


             <tr>
                <th class="tabla_th">JORNADA</th>
                <th class="tabla_th">&nbsp;</th>
            </tr>

<?php
            while($row=@odbc_fetch_row($qryJornadas)){

                echo "<tr>";

                        $parametros_jornada = "?qu_id=" . $_GET['qu_id'] . "&li_id=" . $_GET['li_id'] . "&to_id=" . $_GET['to_id'] . "&qu_nombre=" . $_GET['qu_nombre'] . "&jo_id=" . @odbc_result($qryJornadas,3) . "&jornada=" . @odbc_result($qryJornadas, 4);


                        echo "<td class='tabla_td'>" . @odbc_result($qryJornadas, 4);
                        echo "<td class='tabla_td'><a href='analytics-jornadas_est.php".$parametros_jornada."'><img src='../img/icons8-combo-chart.gif' width='32' height='32'></a>";
                echo "</tr>";    

            }


?> 
            <tr>
                <th colspan="2"><H3><HR></H3></th>
            </tr>  

        </table>

        <center><a href='../ini/main.php?pad=0'><img src='../img/Back.jpg' alt='Back' /></a></center>


    </body>
</html>


<?php
  include("../include/cierraConexion.php");
?>