<link href="../css/style.css" rel="stylesheet" />
<script language="javascript" src="../include/library.js"></script>
<html>
<body>
<form name="frmr" action="../ini/lq.htm" method="GET" target="_parent"></form>
<?php
	include("../include/conexion.php");
	$con = Conexion();
	//Validamos que el usuario y password sean validos
	$sqlUP = "SELECT sq_usr.u_id, sq_usr.u_nom, sq_usr.u_mai, sq_usr.u_act, sq_usr.u_pass, sq_gpo_usu.g_id ";
	$sqlUP = $sqlUP . "FROM sq_usr, sq_gpo_usu ";
	$sqlUP = $sqlUP . "WHERE  (sq_usr.u_id = sq_gpo_usu.u_id) AND ";
	$sqlUP = $sqlUP . "( sq_usr.u_id = '".$_POST['u']."' ) AND ( sq_usr.u_pass = '".$_POST['p']."' )";

	$qryUP = @odbc_exec($con,$sqlUP);
	
	
	if(odbc_num_rows($qryUP) == 1){

		//Obtenemos el grupo al que pertenece el usuario
		//Creamos Variables de session
		//session_name(@odbc_result($qryUP,2)); 
		session_start();
		$_SESSION['sGru']		 = @odbc_result($qryUP,6);
		
		$_SESSION['sNom']		 = @odbc_result($qryUP,2);
			
		$_SESSION['sPad']		 = 0;
		
		$_SESSION['sUsu']		 = @odbc_result($qryUP,1);
		
		$_SESSION['sMailUsu']	 = @odbc_result($qryUP,3);

		//Header("Location: ../ini/main.php"); 
		?>
			<script language="javascript">
				document.frmr.submit();
			</script>
		<?php		
	}else{

?>
	<script language="javascript">
		alert("Usuario y Password NO v�lidos");
		location.href = "../ini/main.php";
	</script>
<?php

	}
	//mysqli_close( $con );
	include("../include/cierraConexion.php");
?>
</body>
</html>
