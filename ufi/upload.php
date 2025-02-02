<?php
session_start();

include("../include/conexion.php");
$con = Conexion();

include("../include/valida.php");
$sesion = Valida(10,$con);

$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'SUBIR ARCHIVO')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    //$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $newFileName = $fileName; //. '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('xlsx', 'csv');

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = '../files/';
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $fecha = date('Y/m/d'); 
        $hora  = date('H:i:s');

        echo $_POST['amigo'];

        $insArc = "INSERT INTO sms_archivo
                             ( arc_id,
                               arc_nombre,
                               arc_fecha,
                               arc_hora,
                               arc_procesado,
                               u_id,
                               u_amigo )
                      values ( '".md5(time() . $fileName)."',
                               '".$newFileName."',
                               '".$fecha."',
                               '".$hora."',
                               0,
                               '".$_SESSION['sUsu']."',
                               '".$_POST['amigo']."')";  

        $qryArc = @odbc_exec($con,$insArc);

        $message ='<H2>EL ARCHIVO SE HA SUBIDO EXITOSAMENTE</H2>';
      }
      else 
      {
        $message = '<H3>Hay un error al subir archivo al servidor, Asegurate de tener permisos de escritura en el Directorio.</H3>';
      }
    }
    else
    {
      $message = '<H3>Tipo de archivo NO PERMITIDO, solo se permiten las siguientes extensiones: ' . implode(',', $allowedfileExtensions) . " </H3>";
    }
  }
  else
  {
    $message = '<H3>Ocurrio un error, por favor reporta este mensaje al Administrador: Sergio Arizpe sergio_arizpe@penoles.com.mx.</H3>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }
}
$_SESSION['message'] = $message;
header("Location: index.php");