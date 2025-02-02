function isNumberKey(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
 
return true;
}

function asignaSetid(){
	if(document.getElementById("empresa").value=="Penoles"){
		document.getElementById("setid").value="IPSA1" 
	}	
	if(document.getElementById("empresa").value=="Fresnillo PLC"){
		document.getElementById("setid").value="FRPLC" 
	}
	if(document.getElementById("empresa").value=="Externo"){
		document.getElementById("setid").value="EXT" 
	}	
}

function copiar(id_elemento) {
	// Crea un campo de texto "oculto"
	var aux = document.createElement("input");

	// Asigna el contenido del elemento especificado al valor del campo
	aux.setAttribute("value", document.getElementById(id_elemento).value);

	// Añade el campo a la página
	document.body.appendChild(aux);

	// Selecciona el contenido del campo
	aux.select();

	// Copia el texto seleccionado
	document.execCommand("copy");

	// Elimina el campo de la página
	document.body.removeChild(aux);

	alert("texto copiado");
}


function conPool(){
	document.getElementById("form2").submit();
}

function saveEM(){
	document.getElementById("frmEM").action = "multas_save.php";
	document.getElementById("frmEM").submit();
}

function conExt(){

	if(document.getElementById("vpn").value == ""){
		alert("Introduce el operador del responsable interno");
		document.getElementById("vpn").focus();
		return;
	}
	if(document.getElementById("nombreE").value == ""){
		alert("Introduce el nombre completo del usuario externo");
		document.getElementById("nombreE").focus();
		return;
	}
	if(document.getElementById("ciaE").value == ""){
		alert("Introduce la compania del usuario externo");
		document.getElementById("ciaE").focus();
		return;
	}
	document.getElementById("frmUE").submit();

}

function notifica(){
	document.getElementById("frm_notifica").submit();
}

function conIp(){
	if(document.getElementById("ip").value > 0 && document.getElementById("ip").value < 256){
		document.getElementById("form2").submit();
	}else{
		alert("IP fuera de rango, valor permitido entre 1 y 255");
		document.getElementById("ip").value = "";
		document.getElementById("ip").focus();
	}
}

function asignaSave(){
	alert("Se va a registrar el Pool");
	document.getElementById("frmAsigna").submit();	
}

function asignaSerIP(){
	alert("Se van asignar las IP's a la VPN");
	document.getElementById("frmAsigna").submit();	
}

function eliminaSave(){
	alert("Se va a elminar el Pool");
	document.getElementById("frmElimina").submit();	
}

function asigna_grupo(cadena){
	valores = document.getElementById("cia").value;
	var valores = valores.split("-");
	document.getElementById("cia_hdn").value = valores[2];
	document.getElementById("grupo").value = valores[1];
	document.getElementById("gpo_hdn").value = valores[0];
}

function consultausuario(){
	var valores	=	document.getElementById("gpo").value;
	document.getElementById("hdn_gpo").value = valores;
	document.getElementById("frm").submit();
}

function consultaDetalleUsuariosVPN(){
	document.getElementById("form2").submit();
}

function consultaug(){
	var valores	=	document.getElementById("gpo").value;
	var aVal 	=	valores.split("+"); 
	document.getElementById("hdn_server").value = aVal[0];
	document.getElementById("hdn_gpo").value = aVal[1];
	document.getElementById("frm").submit();
}

function conVigencia(){
	document.getElementById("frm").submit();
}

function conCambio(){
	document.getElementById("frmConCam").submit();
}

function buscagpo(){
	//alert(document.getElementById("gpo").value);
	var valores = document.getElementById("gpo").value;
	var aVal 	=	valores.split("+"); 
	document.getElementById("hdn_server").value = aVal[0];
	document.getElementById("hdn_gpo").value = aVal[1];
	document.getElementById("form1").submit();
	
}

function buscapuerto(){
	if(document.getElementById("puerto").value == ""){
		alert("Introduzca un Puerto o Servicio");
		document.getElementById("puerto").focus();
	}else{
		document.getElementById("form1").submit();	
	}
}

function buscavlan(){
	var valores = document.getElementById("vlan").value;
	var aVal 	=	valores.split("+"); 
	document.getElementById("hdn_network").value = aVal[0];
	document.getElementById("hdn_vlan").value = aVal[1];
	document.getElementById("form1").submit();
}

function buscaser(){
	if(document.getElementById("ser").value == "SO"){
		alert("seleccione un Servicio porfavor");
	}else{
		document.getElementById("form1").submit();	
	}

	
}

function buscames(){
	document.getElementById("form1").submit();	
}

function buscapool(){
	
	var valores	=	document.getElementById("grupon").value;
	var aVal 	=	valores.split("+"); 
	document.getElementById("hdn_server").value = aVal[0];
	document.getElementById("hdn_gpo").value = aVal[1];
	document.getElementById("frmn").submit();
	
}

function guardaUsuGru(){
	var lna		= document.getElementById("na").length;
	var lsa		= document.getElementById("sa").length;
	var cado	= "";
	var cadd	= "";
	
	for(var io=0; io<=lna-1; io++){
		if(cado == ""){
			cado = document.getElementById("na").options[io].value;
		}else{
			cado += "+" + document.getElementById("na").options[io].value;
		}
	}
	document.getElementById("hdn_na").value = cado;
	
	for(var id=0; id<=lsa-1; id++){
		if(cadd == ""){
			cadd = document.getElementById("sa").options[id].value;
		}else{
			cadd += "+" + document.getElementById("sa").options[id].value;
		}
	}
	document.getElementById("hdn_sa").value = cadd;	
	
	document.getElementById("frm").submit();
	
}

function asignaUsuario(){
	var lna = document.getElementById("na").length;
	var lsa = document.getElementById("sa").length;	
	
	if(document.getElementById("na").selectedIndex == -1){
		alert("Seleccione al menos un usuario");
	}else{
		io = document.getElementById("na").selectedIndex;
		document.getElementById("sa").options[lsa] = new Option(document.getElementById("na").options(io).value,document.getElementById("na").options(io).text);
		document.getElementById("na").options[io] = null;		
	}
}

function quitaAsignacion(){
	var lsa = document.getElementById("sa").length;
	var lna = document.getElementById("na").length;	
	
	if(document.getElementById("sa").selectedIndex == -1){
		alert("Seleccione al menos un usuario");
	}else{
		io = document.getElementById("sa").selectedIndex;
		document.getElementById("na").options[lna] = new Option(document.getElementById("sa").options(io).value,document.getElementById("sa").options(io).text);
		document.getElementById("sa").options[io] = null;		
	}
}

function gp(m,nombre){
	var letras = new Array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z");
	var numeros = new Array("9","2","8","4","1","6","3","7","5","0","%","#",")");
	var tipo	= 0;
	var i		= 0;
	var sap		= "";	
	
	for (var n = 1; n <= m; n++) {
		tipo = Math.floor(Math.random()*2);
		if(tipo == 1){
			i = Math.floor(Math.random()*52);
			sap += letras[i];
		}else{
			i = Math.floor(Math.random()*13);
			sap += numeros[i];
		}
	}
	document.getElementById(nombre).value = sap;
}

function gusuvpn(){
	if(document.getElementById("usu").value == ""){
		alert("Introduzca un valor para el campo Usuario");
		document.getElementById("usu").focus();
		return;
	}
	if(document.getElementById("desc").value == ""){
		alert("Introduzca un valor para el campo Descripci�n");
		document.getElementById("desc").focus();
		return;
	}
	if(document.getElementById("sap").value == ""){
		alert("Introduzca un valor para el campo Password");
		document.getElementById("sap").focus();
		return;
	}	
	if(document.getElementById("cia").value == "NA"){
		alert("Selecciones una compa��a");
		document.getElementById("cia").focus();
		return;
	}
	
	document.getElementById("frmUsu").submit();
}

function cambiovpn(){
	if(document.getElementById("camID").value == ""){
		alert("Introduzca el n�mero de cambio");
		document.getElementById("camID").focus();
		return;
	}
	if(document.getElementById("sol").value == ""){
		alert("Introduzca un valor para el campo Solicitante");
		document.getElementById("sol").focus();
		return;
	}
	if(document.getElementById("fechFin").value == ""){
		alert("Introduzca un valor para el campo de Fecha de Fin");
		document.getElementById("fechFin").focus();
		return;
	}
	
	document.getElementById("frmCam").submit();
}

function click(){
	if(event.button==2){
		alert('�rea de Seguridad de la Informaci�n - Site Plata');
	}
}

function cancela(){
	document.fr_gruvpn.frm.crypto.value		= "";
	document.fr_gruvpn.frm.key.value 			= "";
	document.fr_gruvpn.frm.pool.value			= "";
	document.fr_gruvpn.frm.scriptGrupo.value	= "";
	document.getElementById("can").disabled="true";
	document.getElementById("gua").disabled="true";
	document.getElementById("nue").disabled="";
	document.getElementById("fr_gruvpn").style.display="none";
}

function sgruvpn(){
	document.getElementById("can").disabled="true";
	document.fr_gruvpn.frm.submit();
}

function sgruvpnasa(){
	document.getElementById("can").disabled="true";
	//document.getElementById("frm").submit();
	document.fr_gruvpn.frm.submit();
}

function spoolvpn(){
	if(document.fr_gruvpn.frmn.validon.value == "POOL NO VALIDO"){
		alert("El Pool no es v�lido");
	}else{
		alert("El pool se va a registrar");
		document.fr_gruvpn.ifrmn.frmpool.submit();
	}
}


function genScrGru(){
	var str  = "";	
	
	str += "!\ncrypto isakmp client configuration group " + document.frm.crypto.value + "\n";
	str += "key " + document.frm.key.value + "\n";
	str += "dns " + document.frm.dns.value + "\n";
	str += "domain " + document.frm.domain.value + "\n";
	str += "pool " + document.frm.pool.value + "\n";
	str += "acl " + document.frm.acl.value + "\n";
	str += "include-local-lan\n";
	str += "max-users " + document.frm.user.value + "\n";
	str += "netmask " + document.frm.netmask.value + "\n!";
	document.frm.scriptGrupo.value = str;
}

function genScrUsu(){
	var str = "";
	
	str += "username " + document.frmUsu.usu.value + " secret " + document.frmUsu.sap.value;
	
	document.frmUsu.script.value = str;
	
	return;

}

function agruvpn(){
	//document.getElementById("nombre de frame").style.display="none";
	document.getElementById("fr_gruvpn").style.display="";
	document.getElementById("can").disabled="";
	document.getElementById("gua").disabled="";
	document.getElementById("nue").disabled="true";
	
}

function agru_f5det(){
	//document.getElementById("nombre de frame").style.display="none";
	document.getElementById("fr_gruf5det").style.display="";
	document.getElementById("can").disabled="";
	document.getElementById("gua").disabled="";
	document.getElementById("nue").disabled="true";
	
}

function agru_f5aplic(){
	//document.getElementById("nombre de frame").style.display="none";
	document.getElementById("fr_gruf5aplic").style.display="";
	document.getElementById("can").disabled="";
	document.getElementById("gua").disabled="";
	document.getElementById("nue").disabled="true";
	
}

function asignaNetMask(){
	if(document.frm.user.value == 2){
		document.frm.netmask.value = "255.255.255.252";
	}
	if(document.frm.user.value == 6){
		document.frm.netmask.value = "255.255.255.248";
	}
	if(document.frm.user.value == 14){
		document.frm.netmask.value = "255.255.255.240";
	}
	if(document.frm.user.value == 30){
		document.frm.netmask.value = "255.255.255.224";
	}
	if(document.frm.user.value == 62){
		document.frm.netmask.value = "255.255.255.192";
	}
	if(document.frm.user.value == 126){
		document.frm.netmask.value = "255.255.255.128";
	}
	if(document.frm.user.value == 254){
		document.frm.netmask.value = "255.255.255.0";
	}	
}

function asignaNetMaskn(){
	if(document.frmn.usern.value == 2){
		document.frmn.netmaskn.value = "255.255.255.252";
	}
	if(document.frmn.usern.value == 6){
		document.frmn.netmaskn.value = "255.255.255.248";
	}
	if(document.frmn.usern.value == 14){
		document.frmn.netmaskn.value = "255.255.255.240";
	}
	if(document.frmn.usern.value == 30){
		document.frmn.netmaskn.value = "255.255.255.224";
	}
	if(document.frmn.usern.value == 62){
		document.frmn.netmaskn.value = "255.255.255.192";
	}
	if(document.frmn.usern.value == 126){
		document.frmn.netmaskn.value = "255.255.255.128";
	}
	if(document.frmn.usern.value == 254){
		document.frmn.netmaskn.value = "255.255.255.0";
	}	
}

function asigPool(){
	document.frm.pool.value = document.frm.crypto.value;
}

function genScript(){

	var str  = "";
	var ipi = "";
	var ipic = "";
	var ipf = "";
	var ipfc = "";
	
	ipi = parseInt(document.frm.oct4.value) + 1;
	ipic = document.frm.oct1.value + "." + document.frm.oct2.value + "." + document.frm.oct3.value + "." + ipi;

	ipf = parseInt(document.frm.oct4.value) + parseInt(document.frm.user.value);
	ipfc = document.frm.oct1.value + "." + document.frm.oct2.value + "." + document.frm.oct3.value + "." + ipf;

	str += "!\ncrypto isakmp client configuration group " + document.frm.crypto.value + "\n";
	str += "key " + document.frm.key.value + "\n";
	str += "dns " + document.frm.dns.value + "\n";
	str += "domain " + document.frm.domain.value + "\n";
	str += "pool " + document.frm.pool.value + "\n";
	str += "acl " + document.frm.acl.value + "\n";
	str += "include-local-lan\n";
	str += "max-users " + document.frm.user.value + "\n";
	str += "netmask " + document.frm.netmask.value + "\n!";
	document.frm.scriptGrupo.value = str;
	
	str = "";
	str += "ip local pool " + document.frm.pool.value + " " + ipic + " " + ipfc;
	document.frm.scriptPool.value = str;
	
	str = "";
	str += "username " + document.frm.usuariovpn.value + " pass " + document.frm.passusuvpn.value + "\n";
	document.frm.scriptUsuario.value = str;
}

function cambiaAction(){
	if(form1.tipo.value = "RESUMEN"){
		form1.action = "servicioRes.php";
	}
}

function li(){
	if(document.getElementById("u").value==""){
		alert("Introduce tu Usuario");
		document.getElementById("u").focus();
		return;
	}
	if(document.getElementById("p").value==""){
		alert("Introduce tu Password");
		document.getElementById("p").focus();
		return;
	}
	
	//Se encripta la contrase�a
	document.getElementById("p").value = SHA1(document.getElementById("p").value);
	//document.frm.p.value = SHA1(document.frm.p.value);
	document.getElementById("frm").action = "../lio/lvuis.php";
	//document.frm.action = "../lio/lvuis.php";
	document.getElementById("frm").submit();	
	//document.frm.submit();
}

function generaReporte(){
	form1.submit();
}

function detPue(id,ip){
	url = "prdsi.php?id=" +  id + "&ip=" + ip;
	window.open(url, '','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=500,directories=no,location=no,left=150,top=100');
}

function detPue10mas(id,pue,ser,ver,vul){
	url = "pr10detvul.php?id=" +  id + "&pue=" + pue + "&ser=" + ser + "&ver=" + ver + "&vul=" + vul;
	window.open(url, '','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=500,directories=no,location=no,left=150,top=100');
}

function detAnaPue(pue,ser){
	url = "prap.php?pue=" +  pue + "&ser=" + ser;
	window.open(url, '','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=300,directories=no,location=no,left=200,top=150');
}

function cne(txt){
	document.frm.sha1.value = SHA1(txt);
}

function enc(){
	document.frm.sha1.value = SHA1(document.frm.pass.value);
}

/**
*
*  Secure Hash Algorithm (SHA1)
*  http://www.webtoolkit.info/
*
**/
 
function SHA1 (msg) {
 
	function rotate_left(n,s) {
		var t4 = ( n<<s ) | (n>>>(32-s));
		return t4;
	};
 
	function lsb_hex(val) {
		var str="";
		var i;
		var vh;
		var vl;
 
		for( i=0; i<=6; i+=2 ) {
			vh = (val>>>(i*4+4))&0x0f;
			vl = (val>>>(i*4))&0x0f;
			str += vh.toString(16) + vl.toString(16);
		}
		return str;
	};
 
	function cvt_hex(val) {
		var str="";
		var i;
		var v;
 
		for( i=7; i>=0; i-- ) {
			v = (val>>>(i*4))&0x0f;
			str += v.toString(16);
		}
		return str;
	};
 
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var blockstart;
	var i, j;
	var W = new Array(80);
	var H0 = 0x67452301;
	var H1 = 0xEFCDAB89;
	var H2 = 0x98BADCFE;
	var H3 = 0x10325476;
	var H4 = 0xC3D2E1F0;
	var A, B, C, D, E;
	var temp;
 
	msg = Utf8Encode(msg);
 
	var msg_len = msg.length;
 
	var word_array = new Array();
	for( i=0; i<msg_len-3; i+=4 ) {
		j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
		msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
		word_array.push( j );
	}
 
	switch( msg_len % 4 ) {
		case 0:
			i = 0x080000000;
		break;
		case 1:
			i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
		break;
 
		case 2:
			i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
		break;
 
		case 3:
			i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8	| 0x80;
		break;
	}
 
	word_array.push( i );
 
	while( (word_array.length % 16) != 14 ) word_array.push( 0 );
 
	word_array.push( msg_len>>>29 );
	word_array.push( (msg_len<<3)&0x0ffffffff );
 
 
	for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
 
		for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
		for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
 
		A = H0;
		B = H1;
		C = H2;
		D = H3;
		E = H4;
 
		for( i= 0; i<=19; i++ ) {
			temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}
 
		for( i=20; i<=39; i++ ) {
			temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}
 
		for( i=40; i<=59; i++ ) {
			temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}
 
		for( i=60; i<=79; i++ ) {
			temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
			E = D;
			D = C;
			C = rotate_left(B,30);
			B = A;
			A = temp;
		}
 
		H0 = (H0 + A) & 0x0ffffffff;
		H1 = (H1 + B) & 0x0ffffffff;
		H2 = (H2 + C) & 0x0ffffffff;
		H3 = (H3 + D) & 0x0ffffffff;
		H4 = (H4 + E) & 0x0ffffffff;
 
	}
 
	var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
 
	return temp.toLowerCase();
 
}