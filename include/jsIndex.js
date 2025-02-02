// JavaScript Document

function genReporte(){
	
	if(document.getElementById("hdnTipo").value == "I"){
		
		document.getElementById("frmFun").target = "frameincpen";
 		document.getElementById("frmFun").action = "IncidentesPendientes.php";
	
	}else{
	
		document.getElementById("frmFun").target = "frameincpen";
 		document.getElementById("frmFun").action = "IncidentesPendientes_ll.php";
		
	}

	document.getElementById("frmFun").submit();
	
}


function defineTipoBusqueda(TB){
	if(TB == "P"){
		document.getElementById("personas").checked = true;
		document.getElementById("grupo").checked = false;
		
		document.getElementById("workgroup").disabled = true;
		document.getElementById("funtec").disabled = false;
		
		document.getElementById("hdn_tb").value = "P";
	}else{
		document.getElementById("grupo").checked = true;
		document.getElementById("personas").checked = false;
		
		document.getElementById("funtec").disabled = true;
		document.getElementById("workgroup").disabled = false;

		document.getElementById("hdn_tb").value = "G";
	}
}

function inicializa(TB){
	
	document.getElementById("frmFun").target = "";
	document.getElementById("frmFun").action = "index.php";
	document.getElementById("frmFun").submit();
	
}