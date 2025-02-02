<?php
    session_start();
    include("../include/conexion.php");
    $con = Conexion();

    //Verificamos si el usuario esta firmado
    if (isset($_SESSION['sGru'])){
  
        $gru = $_SESSION['sGru'];

    }else{
  
        $gru = "PUBLIC";
  
    }

    $padant = 0;
    //Definimos el Padre para construir el Menu
    if(isset($_GET['pad'])){
        $pad = $_GET['pad'];
    }else{
        $pad = 0; 
    }

    //Obtenemos las Tareas a las que tiene permiso el grupo del usuario
    $sqlT = "SELECT sq_tar.t_id, sq_tar.t_nom, sq_tar.t_url, sq_tar.t_pad, sq_tar.t_img1, sq_tar.t_img2, sq_tar.t_act, sq_tar.t_target ";
    $sqlT = $sqlT . "FROM sq_gpo_tar, sq_tar WHERE ( sq_gpo_tar.t_id = sq_tar.t_id ) and ";
    $sqlT = $sqlT . "( ( sq_gpo_tar.g_id = '".$gru."' ) AND ( sq_tar.t_pad = ".$pad." ) )";
    
    $qryT = @odbc_exec($con,$sqlT);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="../css/style.css" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <script language="javascript" src="../include/library.js"></script>
    <script type="text/JavaScript">
    <!--
    function MM_swapImgRestore() { //v3.0
      var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }

    function MM_preloadImages() { //v3.0
      var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }

    function MM_findObj(n, d) { //v4.01
      var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_swapImage() { //v3.0
      var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
       if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }
    //-->
    </script>
</head>
<body onload="MM_preloadImages('img/btn_adm_on.jpg')">
<p>
 <!-- <script language="JavaScript" type="text/javascript">
  document.onmousedown=click
</script>   -->

<?php if (!isset($_SESSION['sGru'])){?>
  <br>
  <br>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
  <br>
</p>
<form id="frm" name="form1" method="post" action="">
  <table width="404" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
  <tr>
    <td colspan="3" align="center"><hr /></td>
    </tr>
  <tr>
    <td align="right" valign="middle"><span class="login">Usuario</span>:</td>
    <td align="left" valign="middle"><input name="u" type="text" class="login" id="u" size="13" maxlength="15" placeholder="Introduce tu usuario" /></td>
  <td rowspan="2"><img src="../img/login.jpg" width="174" height="80" /></td>
    </tr>
  <tr valign="middle">
    <td align="right"><span class="login">Contraseña</span>:</td>
    <td align="left"><input name="p" type="password" class="login" id="p" size="13" maxlength="15" placeholder="Introduce tu contraseña" /></td>
    </tr>
  <tr>
    <td colspan="3" align="center" valign="middle"><input name="Submit" type="button" class="my-form__button" value="Ingresar" onclick="li();" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle"><hr /></td>
  </tr>
  </table>

  <p>&nbsp;</p>
</form>
<?php } ?>

</table>
<?php
if($gru <> "PUBLIC"){

  $padant = 0;

  echo "<a href='main.php?pad=".$_SESSION['sPad']."'>";
?>
<!--<img src="../img/Back.jpg" border="0" align="right"></a>-->
<?php } ?>
<p>&nbsp;</p>

<table width="10%" border="0" align="center">

  <?php
    $_SESSION['sPad'] = $pad;
      $i  = 1;
    $cc = 1; // Contador de Columna
    
      echo "<tr><td><hr></td></tr>";
      while($row=@odbc_fetch_row($qryT)){



      echo "<tr>";

      echo "<td class='celdaBoton'>";
                
        echo "<a href=\"".@odbc_result($qryT,3)."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','../img/".@odbc_result($qryT,6)."',1)\" target=\"".@odbc_result($qryT,8)."\">";
        echo "<img src=\"../img/".@odbc_result($qryT,5)."\" alt=\"".@odbc_result($qryT,2)."\" name=\"Image".$i."\" width=\"200\" height=\"50\" border=\"0\" id=\"Image".$i."\" /></a>";
        
        echo "</td>";
        echo "</tr>";

        echo "<tr><td><hr></td></tr>";

      $cc = $cc + 1;
      $i = $i + 1;
      
      }



      /*if($i==1){
        echo "<tr>";
      }
    
      if($cc > 4){
        echo "<tr><td colspan=4>&nbsp;</td>";
        echo "<tr>";
        $cc = 1;
      }
        
      
        echo "<td class='celdaBoton' width='25%'>";
        
        //if (intval(@odbc_result($qryT,1))==55 || intval(@odbc_result($qryT,1))==59 || intval(@odbc_result($qryT,1))==60 || intval(@odbc_result($qryT,1))==61){
        if (intval($row['t_id'])==55 || intval($row['t_id'])==59 || intval($row['t_id'])==60 || intval($row['t_id'])==61){  
          //echo "<a href=\"".@odbc_result($qryT,3)."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','../img/".@odbc_result($qryT,6)."',1)\" target='_blank'>";
          echo "<a href=\"".$row['t_url']."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','../img/".$row['t_img2']."',1)\" target='_blank'>";
        } else {
          //echo "<a href=\"".@odbc_result($qryT,3)."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','../img/".@odbc_result($qryT,6)."',1)\">";
          echo "<a href=\"".$row['t_url']."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image".$i."','','../img/".$row['t_img2']."',1)\">";
        }
        
        //echo "<img src=\"../img/".@odbc_result($qryT,5)."\" alt=\"".@odbc_result($qryT,2)."\" name=\"Image".$i."\" width=\"130\" height=\"130\" border=\"0\" id=\"Image".$i."\" /></a>";
        echo "<img src=\"../img/".$row['t_img1']."\" alt=\"".$row['t_nom']."\" name=\"Image".$i."\" width=\"350\" height=\"178\" border=\"0\" id=\"Image".$i."\" /></a>";
      
      $cc = $cc + 1;
      $i = $i + 1;
    }
    
    $cv = 4-($cc-1);
    while($cv>0){
      echo "<td width='25%'>&nbsp;";
      $cv = $cv-1;
    }*/
  ?>

</table>

<?php
  //Obtenemos el padre de la p�gina
  //$sqlP = "SELECT sq_tar.t_pad FROM sq_tar WHERE t_id = ".$row['t_id']."";
  //echo $sqlP;
  //$qryP = @odbc_exec($con, $sqlP);
  //$qryP = mysqli_query($con, $sqlP) or die('Consulta fallida: ' . mysql_error());
  //$sqlP2 = "SELECT sq_tar.t_pad FROM sq_tar WHERE t_id = ".$row['t_id']."";
  //$qryP2 = @odbc_exec($con, $sqlP2);
  //$qryP2 = mysqli_query($con, $sqlP2) or die('Consulta fallida: ' . mysql_error());
  
  //Agregamos el bot�n para las tareas que tengan hijos
  /*if (intval($row['t_id'])== 5 || intval($row['t_id'])== 8 || intval($row['t_id'])== 10 || intval($row['t_id'])== 12 ||
  intval($row['t_id'])== 14 || intval($row['t_id'])== 16 || intval($row['t_id'])== 18 || intval($row['t_id'])== 19 ||
  intval($row['t_id'])== 22 || intval($row['t_id'])== 27 || intval($row['t_id'])== 36 || intval($row['t_id'])== 42 ||
  intval($row['t_id'])== 46 || intval($row['t_id'])== 47 || intval($row['t_id'])== 56 || intval($row['t_id'])== 63 || intval($row['t_id'])== 48){
    echo "<p align='center'><a href='../ini/main.php?pad=".@odbc_result($qryP2,1)."'><img src='../img/Back.jpg' alt='Back' /><br />Back</a></p>";
  }*/
?>

</body>

<?php
    include("../include/cierraConexion.php");
?>