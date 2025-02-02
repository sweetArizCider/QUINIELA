<link href="../css/style.css" rel="stylesheet" />
<script language="javascript" src="../include/library.js"></script>
<html>
<body>
<?php
    include("../include/conexion.php");
    $con = Conexion();
    //Validamos que el usuario y password sean validos
    $sqlUP = "SELECT asi_usu.u_id, asi_usu.u_nom, asi_usu.u_mai, asi_usu.u_act, asi_usu.u_pass, asi_gpo_usu.asi_gpo_g_id ";
    $sqlUP = $sqlUP . "FROM asi_usu, asi_gpo_usu ";
    $sqlUP = $sqlUP . "WHERE  (asi_usu.u_id = asi_gpo_usu.asi_usu_u_id) AND ";
    $sqlUP = $sqlUP . "( asi_usu.u_id = '".$_POST['u']."' ) AND ( asi_usu.u_pass = '".$_POST['p']."' )";

    $qryUP = @odbc_exec($con,$sqlUP);
    
    if(odbc_num_rows($qryUP) == 1){
        //Obtenemos el grupo al que pertenece el usuario
        //Creamos Variables de session
//        session_name(@odbc_result($qryUP,2)); 
        session_start();
        $_SESSION['sGru']         = @odbc_result($qryUP,6);
        $_SESSION['sNom']         = @odbc_result($qryUP,2);
        $_SESSION['sPad']         = 0;
        $_SESSION['sUsu']         = @odbc_result($qryUP,1);
        $_SESSION['sMailUsu']     = @odbc_result($qryUP,3);;

        header("Location: ../ini/maasi.php"); 
    }else{
?>
    <script language="javascript">
        alert("Usuario y Password NO válidos");
        location.href = "../ini/maasi.php";
    </script>
<?php

    }
    
    include("../include/cierraConexion.php");
?>
</body>
</html>