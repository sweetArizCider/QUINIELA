<?php
session_start(); 

include("../include/conexion.php");
$con = Conexion();

include("../include/valida.php");
$sesion = Valida(10,$con);

//Obtengo la lista de amigos
$sqlAmigos = "SELECT u_id, u_nom FROM softquin_prod.sq_usr ORDER BY u_nom";
$qryAmigos = @odbc_exec($con,$sqlAmigos);

?>
<!DOCTYPE html>
<html>
<head>
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
  <center>
    <p><p> 
      <table id="address" class="cuarente" border="0" cellspacing="10" cellpadding="10"> 
        <form method="POST" action="upload.php" enctype="multipart/form-data">
          <tr>
            <td>
              <?php
                if (isset($_SESSION['message']) && $_SESSION['message'])
                {
                  printf('<basename(path)>%s</b>', $_SESSION['message']);
                  unset($_SESSION['message']);
                }
              ?>
            </td>
          </tr>

          <tr>
            
            <td class="tabla_td">AMIGO: 
              <select name="amigo" class="select">
              
                <?php 

                  while($row=@odbc_fetch_row($qryAmigos)){

                    echo "<option value='".@odbc_result($qryAmigos,1)."'>".@odbc_result($qryAmigos,2)."</options>";

                  }

                ?>

              </select>

          </tr>
       
          <tr>
            <td>
              <div>
                    <span>Upload a File:</span>
                    <input type="file" name="uploadedFile" />
                  </div>
              </td>
          </tr>  

          <tr>
            <td align="center">
                <input class="btnBuscar" type="submit" name="uploadBtn" value="SUBIR ARCHIVO" />
            </td>
          </tr>
                
        </form>
      </table>

      <center><a href='../ini/main.php?pad=9'>Back</a></center>

</body>
</html>