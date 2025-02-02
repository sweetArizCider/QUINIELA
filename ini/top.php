<?php
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/style.css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script language="javascript" src="../include/library.js"></script>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:106px;
	top:82px;
	width:404px;
	height:22px;
	z-index:1;
	font-family: Calibri, Verdana;
	font-size:14px;
	color:#FFFFCC;
	font-weight:bold;
}
#Layer2 {
	position:absolute;
	left:24px;
	top:7px;
	width:78px;
	height:76px;
	z-index:2;
}
-->
</style>
</head>

	<body>
		<script language="JavaScript" type="text/javascript">
			document.onmousedown=click
		</script>
		<div id="Layer1" ></div>

		<table width="60%" border="0" align="center">

			<?php if (!isset($_SESSION['sGru'])){ echo "<p>";}?>
				<td>&nbsp;</td>
			<?php ?>

			  <tr>
			  	<td colspan="3" align="center"><span class="bannerTop">LA QUINIELA</span></td>
			  </tr>
			<?php if (isset($_SESSION['sGru'])){ ?>
				<tr>
			  	<td colspan="3" align="center"><HR></td>
			  </tr>
				<tr>
			    <td align="center" width="20%"><label class="banner"><a href="../ini/main.php?pad=0" target="mainFrame">Inicio</a></label></td>
			    <td align="center" width="60%"><label class="banner"><?php echo $_SESSION['sNom'];?></label></td>
			    <td align="center" width="20%"><label class="banner"><a href="../lio/lcs.php">Cerrar sesi&oacute;n</a></label></td>
			  </tr>
			<?php } ?>
		</table>
	</body>
</html>