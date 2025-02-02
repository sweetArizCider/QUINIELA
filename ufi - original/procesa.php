<?php
  session_start();

  include("../include/conexion.php");
  $con = Conexion();
    
  include("../include/valida.php");
  $sesion = Valida(11,$con); 

  $sqlArchivos = "SELECT arc_id, 
                         arc_nombre, 
                         arc_fecha, 
                         arc_hora, 
                         u_id, 
                         arc_procesado,
                         u_amigo 
                  FROM sms_archivo 
                  WHERE arc_procesado = 0
                  ORDER BY arc_fecha ASC, arc_hora ASC"; 
  $qryArchivos = @odbc_exec($con, $sqlArchivos);
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
       <table id="fw" class="ochenta" align="center">                                
             <tr>
                <th class="tabla_th">ID ARCHIVO</th>
                <th class="tabla_th">NOMBRE ARCHIVO</th>
                <th class="tabla_th">FECHA</th>    
                <th class="tabla_th">HORA</th>
                <th class="tabla_th">RESPONSABLE</th>
                <th class="tabla_th">AMIGO</th>
                <th class="tabla_th">ESTADO</th>
                <th class="tabla_th">&nbsp;</th>
            </tr>

<?php

            $x = 0;
            while($row=@odbc_fetch_row($qryArchivos)){

                echo "<tr>";
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 1);  
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 2);
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 3);
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 4);  
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 5);  
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 7);                
                    echo "<td class='tabla_td'>" . @odbc_result($qryArchivos, 6);
                  if(@odbc_result($qryArchivos, 6) == 0){ 
                    echo "<td class='tabla_td'><a href='procesa_archivo2.php?id=".@odbc_result($qryArchivos, 1)."&amigo=".@odbc_result($qryArchivos, 7)."'><img src='../img/procesar.jpg'></a>"; 
                  }else{
                    echo "<td class='tabla_td'>PROCESADO";
                  }  
                echo "</tr>";    

                $x = $x + 1;
            }
 
?>
            <tr>
                <th colspan="8"><H3><HR></H3></th>
            </tr>  
            <tr>
                <th colspan="7"><H3>TOTAL DE ARCHIVOS</H3></th>
                <th><H3><?php echo $x;?></H3></th>
            </tr>

        </table>

        <center><a href='../ini/main.php?pad=0'><img src='../img/Back.jpg' alt='Back' /></a></center>


    </body>
</html>


<?php
  include("../include/cierraConexion.php");
?>