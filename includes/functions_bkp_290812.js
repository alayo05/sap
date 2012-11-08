// JavaScript Document

//********Detalhes dos eventos *********************/
function editarServidor(cod,dominio,cgcdominio,tipo){
	janelaDetalhes = window.open('servidorDetalhes.asp?cod='+cod+'&d='+dominio+'&cgcdom='+cgcdominio+'&tp='+tipo,'Detalhes','toolbar=0,titlebar=0,status=yes,scrollbars=no,resizable=yes,width=710,height=440');	
}

function criarServidor(rsnti,cod,dominio,cgcdominio,tipo){
	janelaDetalhes = window.open('servidorDetalhes.asp?rsnti='+rsnti+'&cod='+cod+'&d='+dominio+'&cgcdom='+cgcdominio+'&tp='+tipo,'Detalhes','toolbar=0,titlebar=0,status=yes,scrollbars=no,resizable=yes,width=710,height=440');	
}

function openRelLog(){
	window.open('relatorioLog.asp','Relatório','toolbar=0,titlebar=0,status=yes,scrollbars=yes,resizable=yes,width=1000,height=650');	
}

function openRelatorios(){
	window.open('relatorios.asp','Relatórios','toolbar=0,titlebar=0,status=no,scrollbars=yes,resizable=yes,width=350,height=300');	
}

function excluirServidor(cod)
{		
	   var comboserv = createXMLHTTP();
	   comboserv.open("post", "excluiServ.asp", true);
	   comboserv.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	   comboserv.onreadystatechange=function(){
		   if (comboserv.readyState==4){// abaixo o texto do gerado no arquivo executa.asp e colocado no div				   				
					document.getElementById("div"+cod).style.display = "none";
					document.getElementById("total").value = document.getElementById("total").value - 1;
					document.getElementById("valtot").innerHTML = "Total: "+document.getElementById("total").value;										
			   }}
			   comboserv.send("idserv=" + cod);

}

//******* Exibe e Oculta os detalhes ao clicar na linha********/
function mostrabody(cod){
	if(document.getElementById("tbody"+cod).style.display == "block"){
		document.getElementById("tbody"+cod).style.display="none";
		document.getElementById("cinza"+cod).style.background="#EEEEEE";
	}else{
		document.getElementById("tbody"+cod).style.display="block";
		document.getElementById("cinza"+cod).style.background="#DDEDFF";
	}
}

function cor(campo,newcolor){		
	document.getElementById(campo).style.background=newcolor;
}

//******* Marca todos os campos com o mesmo nome ********/
function MarcaTodos(campo){
	if(document.getElementById(campo+'0').checked == false){
			for (var i = 0; i <= document.formHistorico.elements.length; i++) {
				if (document.formHistorico.elements[i].name == campo) {
						document.formHistorico.elements[i].checked = false;
				}
			}
			document.getElementById(campo+'0').checked = false;
	}else{
			for (var i = 0; i <= document.formHistorico.elements.length; i++) {
				if (document.formHistorico.elements[i].name == campo) {
						document.formHistorico.elements[i].checked = true;
				}
			}
			document.getElementById(campo+'0').checked = true;
	}
}


function desmarcaTodos(campo){
	if(document.getElementById(campo+'0').checked == true){
		document.getElementById(campo+'0').checked = false;
	}
}


//******* Exibe e Oculta os campos da abrangencia na pesquisa do historico ********/
function mostraAbrng(valor){
	if(valor == "Regional"){
		document.getElementById("Local").style.display="none";
		document.getElementById("Regional").style.display="block";
		Regional();
	}else if(valor == "Local"){
		document.getElementById("Regional").style.display="none";
		document.getElementById('divRegional').style.display='none';
		document.getElementById("Local").style.display="block";
	}else{
		document.getElementById("Local").style.display="none";
		document.getElementById("Regional").style.display="none";
		document.getElementById('divRegional').style.display='none';
	}
}

function Regional(){
	if(document.getElementById("form_tipoabrangencia").value=="Regional"){
		if(document.getElementById("divRegional").style.display=='block'){
			document.getElementById('divRegional').style.display='none';
			document.getElementById('mostraRegional').style.display='block';
			document.getElementById('Regional').style.height="20px";
		}else{
			document.getElementById('divRegional').style.display='block';
			document.getElementById('mostraRegional').style.display='none';
			document.getElementById('Regional').style.height="380px";
		}
	}
}

/********* Preenche texto do editor com este passado na função **********/

		function msgPadrao(codigo){
			//alert(codigo);
			var msgObj = createXMLHTTP();
			msgObj.open("post", "includes/objMsg.asp", true);
			msgObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			msgObj.onreadystatechange=function(){
				if (msgObj.readyState==4){
					document.getElementById("editor").innerHTML = msgObj.responseText;
				}
			}
			msgObj.send("cod="+codigo);
		}





//***************** Valida cadastro de eventos *****************/
function ValidaEventosCadastro(){
	var retorno = true;
	
	if(document.getElementById("form_titulo").value == ""){
		alert("Favor informar um titulo para o evento");
		document.getElementById("form_titulo").focus();
		retorno = false;
	}
	
	return (retorno);
}



//***************** Valida cadastro de usuarios *****************/
function ValidaUsuariosCadastro(){
	var retorno = true;
	
	if(document.getElementById("form_matricula").value == ""){
		alert("Favor informar a matricula do usuário");
		document.getElementById("form_matricula").focus();
		retorno = false;
	}
	if(document.getElementById("form_nome").value == ""){
		alert("Favor informar o nome do usuário");
		document.getElementById("form_nome").focus();
		retorno = false;
	}
	if(document.getElementById("form_tipo").value == ""){
		alert("Favor informar o tipo do usuário");
		document.getElementById("form_tipo").focus();
		retorno = false;
	}
	
	return (retorno);
}


/******************* MASCARA ************************/

function mascara2(value){ 	
	var mydata = ''; 
	mydata = mydata + value; 
	if (mydata.length == 3){ 
	  mydata = mydata + '/'; 
	  document.formprincipal.pregao_txt.value = mydata; 
	} 

} 

function verifica_campo() { 
	campo1 = (document.getElementById('pregao_txt').value.substring(0,3)); 
	campo2 = (document.getElementById('pregao_txt').value.substring(4,8)); 
	
	if (isNaN(campo1) || isNaN(campo2)){
		alert('Por favor, digite apenas números!');
		document.getElementById('pregao_txt').focus();
		return false;
	}
	return true;

}
//***************** Valida alteração servidor *****************/
function ValidaAlteracaoServidor(){
	var retorno = true;
	var incon = true;
	var msg = "Erro \n ";
		
	if(document.getElementById("cidade_txt").value == "" || document.getElementById("cidade_txt").value == "NI"){
		msg = msg+"Favor informar o nome da cidade ou Corrija a inconsistência \n ";
		document.getElementById("cidade_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("uf_txt").value == "" || document.getElementById("uf_txt").value == "NI"){
		msg = msg+"Favor informar a UF ou Corrija a inconsistência \n ";
		document.getElementById("uf_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("nl_txt").value == "" || document.getElementById("nl_txt").value == "NI"){
		msg = msg+"Favor informar o nome lógico ou Corrija a inconsistência \n ";
		document.getElementById("nl_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("qtd_cpu_txt").value == "" || document.getElementById("qtd_cpu_txt").value == "NI"){
		msg = msg+"Favor informar a quantidade de CPU ou Corrija a inconsistência \n ";
		document.getElementById("qtd_cpu_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("fhz_txt").value == "" || document.getElementById("fhz_txt").value == "NI"){
		msg = msg+"Favor informar frequência ou Corrija a inconsistência \n ";
		document.getElementById("fhz_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("familia_txt").value == "" || document.getElementById("familia_txt").value == "NI"){
		msg = msg+"Favor informar a família ou Corrija a inconsistência \n ";
		document.getElementById("familia_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("qtd_hd_txt").value == "" || document.getElementById("qtd_hd_txt").value == "NI"){
		msg = msg+"Favor informar quantidade de HD ou Corrija a inconsistência \n ";
		document.getElementById("qtd_hd_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("memoria_txt").value == "" || document.getElementById("memoria_txt").value == "NI"){
		msg = msg+"Favor informar o tamanho da memória ou Corrija a inconsistência \n ";
		document.getElementById("memoria_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("nserie_txt").value == "" || document.getElementById("nserie_txt").value == "NI"){
		msg = msg+"Favor informar o número de série ou Corrija a inconsistência \n ";
		document.getElementById("nserie_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("marca_txt").value == "" || document.getElementById("marca_txt").value == "NI"){
		msg = msg+"Favor informar a marca \n ou Corrija a inconsistência ";
		document.getElementById("marca_txt").focus();
		retorno = false;
	}else	
	if(document.getElementById("modelo_txt").value == "" || document.getElementById("modelo_txt").value == "NI"){
		msg = msg+"Favor informar o modelo ou Corrija a inconsistência \n ";
		document.getElementById("modelo_txt").focus();
		retorno = false;
	}else	
	if(document.getElementById("unigtrd_txt").value == "" || document.getElementById("unigtrd_txt").value == "NI"){
		msg = msg+"Favor informar a unidade GT 200 ou RD 5066 ou Corrija a inconsistência \n ";
		document.getElementById("unigtrd_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("pregao_txt").value == "" || document.getElementById("pregao_txt").value == "NI"){
		msg = msg+"Favor informar o pregão \n ou Corrija a inconsistência ";
		document.getElementById("pregao_txt").focus();
		retorno = false;
	}else
	if(document.getElementById("contrato_txt").value == "" || document.getElementById("contrato_txt").value == "NI"){
		msg = msg+"Favor informar se o contrato é de manutenção/hardware ou Corrija a inconsistência \n ";
		document.getElementById("contrato_txt").focus();
		retorno = false;
	}else	
	if(document.getElementById("encargos_txt").value == "" || document.getElementById("encargos_txt").value == "NI"){
		msg = msg+"Favor informar se esse contrato tem encargo mensal ou Corrija a inconsistência \n ";
		document.getElementById("encargos_txt").focus();
		retorno = false;
	}else	
	if(document.getElementById("qtdchamados_txt").value == "" || document.getElementById("qtdchamados_txt").value == "NI"){
		msg = msg+"Favor informar a quantidade de chamados nos últimos 3 mêses ou Corrija a inconsistência \n ";
		document.getElementById("qtdchamados_txt").focus();
		retorno = false;
	}else
	if(!verifica_campo()){
		return false;
	}else	
	if(document.getElementById("pregao_txt").value == "050/2009"){
		incon = false;
	}else
	if((document.getElementById("contrato_txt").value).toUpperCase() != "SIM" && (document.getElementById("contrato_txt").value).toUpperCase() != "NÃO"){		
		alert("Por favor, digite apenas 'SIM' ou 'NÃO' no campo Contrato Manutenção");
		document.getElementById("contrato_txt").focus();
		incon = false;
	}else
	if((document.getElementById("unigtrd_txt").value).toUpperCase() != "SIM" && (document.getElementById("unigtrd_txt").value).toUpperCase() != "NÃO"){		
		alert("Por favor, digite apenas 'SIM' ou 'NÃO' no clampo Unidade GT/RD");
		document.getElementById("unigtrd_txt").focus();
		incon = false;
	}else
	if((document.getElementById("contrato_txt").value).toUpperCase() == "SIM" && (document.getElementById("encargos_txt").value).toUpperCase() == "GF"){		
		alert("Se tem contrato de manutenção de hard. então campo Encargo Mensal não pode ser Garantia do Fornecedor!");
		document.getElementById("encargos_txt").focus();
		incon = false;
	}else
	if((document.getElementById("contrato_txt").value).toUpperCase() == "NÃO" && (document.getElementById("encargos_txt").value).toUpperCase() != "GF"){		
		alert("Se contrato de manutenção de hard. é NÃO então campo Encargo Mensal deve ser Garantia do Fornecedor!");
		document.getElementById("encargos_txt").focus();
		incon = false;
	}
	
	if(retorno == false){
		alert(msg);			
	}else if(!incon){	
			alert('Por favor, corrija o pregão!');
			document.getElementById("pregao_txt").setAttribute('class','bordav');
			document.getElementById("pregao_txt").focus();
			return false;		
	}else{
		window.close();
	}		
	return retorno;
}

//***************** Dicas **********************/
// Example:
// onMouseOver="toolTip('tool tip text here')";
// onMouseOut="toolTip()";
// -or-
// onMouseOver="toolTip('more good stuff', '#FFFF00', 'orange')";
// onMouseOut="toolTip()"; 
var ns4 = document.getElementById("toolTipLayer");
var ns6 = document.getElementById && !document.all;
var ie4 = document.all;
offsetX = 0;
offsetY = 20;
var toolTipSTYLE="";
function initToolTips()
{
		//alert(offsetX);
		//alert(offsetY);
	  if(ns4||ns6||ie4)
	  {
			if(ns4){
				toolTipSTYLE = document.toolTipLayer;
			} else if(ns6){ 
				toolTipSTYLE = document.getElementById("toolTipLayer").style;
			} else if(ie4) {
				toolTipSTYLE = document.all.toolTipLayer.style;
			}
			if(ns4) {
				document.captureEvents(Event.MOUSEMOVE);
			} else{
				toolTipSTYLE.visibility = "visible";
				toolTipSTYLE.display = "none";
			}
			document.onmousemove = moveToMouseLoc;
			
	  }
}
function closeToolTips()
{
		document.onmousemove = '';
}
function toolTip(msg, fg, bg)
{
  document.onmousemove = moveToMouseLoc;
  if(toolTip.arguments.length < 1) // hide
  {
	if(ns4){ toolTipSTYLE.visibility = "hidden";
	}else{ toolTipSTYLE.display = "none";}
  }
  else // show
  {
	if(!fg) fg = "#666666";
	if(!bg) bg = "#EDF2FC";
	var content =
		'<table style="padding:0px; margin:0px;"' +
		'border="0" cellspacing="0" cellpadding="1" bgcolor="' + fg + '"><td>' +
		'<table border="0" cellspacing="0" cellpadding="1" bgcolor="' + bg + 
		'"><td align="center" style="padding:0px; margin:0px;"><font face="sans-serif" color="' + fg +
		'" size="-3"><B style="font-weight:300">&nbsp\;' + msg +
		'&nbsp\;</B></font></td></table></td></table>';
	if(ns4)
	{
	  toolTipSTYLE.document.write(content);
	  toolTipSTYLE.document.close();
	  toolTipSTYLE.visibility = "visible";
	}
	if(ns6)
	{
	  document.getElementById("toolTipLayer").innerHTML = content;
	  toolTipSTYLE.display='block';
	}
	if(ie4)
	{
	  document.all("toolTipLayer").innerHTML=content;
	  toolTipSTYLE.display='block';
	}
  }
}
function moveToMouseLoc(e)
{
	if(ns4||ns6){
		x = e.pageX;
		y = e.pageY;
	}else{
		x = event.x + document.body.scrollLeft;
		y = event.y + document.body.scrollTop;
	}
	toolTipSTYLE.left = x + offsetX;
	toolTipSTYLE.top = y + offsetY;
	return true;
}
		
		
/****************** Formata e valida campo de data e hora **************************/
/*** Como usar:  onKeyPress="data(this.value,'id')" *****************************/

function data(data,campo){ 
	var mydata = '';
	mydata = mydata + data;
	if (mydata.length == 2){ 
	  mydata = mydata + '/'; 
	  document.getElementById(campo).value = mydata; 
	} 
	if (mydata.length == 5){ 
	  mydata = mydata + '/'; 
	  document.getElementById(campo).value = mydata; 
	}
	if (mydata.length == 9){ 
	  verifica_masc(campo); 
	} 
	if (mydata.length == 10){ 
	  mydata = mydata + ' '; 
	  document.getElementById(campo).value = mydata; 
	}   
	if (mydata.length == 13){ 
	  mydata = mydata + ':'; 
	  document.getElementById(campo).value = mydata; 
	}
	if(mydata.length == 15){
		verifica_hora(campo);
	}
} 

function verifica_masc (campo) { 
	dia = (document.getElementById(campo).value.substring(0,2)); 
	mes = (document.getElementById(campo).value.substring(3,5)); 
	ano = (document.getElementById(campo).value.substring(6,10)); 
	situacao = ""; 
	// verifica o dia valido para cada mes
	if ((dia < 1)||(dia < 1 || dia > 30) && (  mes == 4 || mes == 6 || mes == 9 || mes == 11 ) || dia > 31) { 
		situacao = "falsa"; 
	}
	// verifica se o mes e valido 
	if (mes < 1 || mes > 12 ) { 
		situacao = "falsa"; 
	} 
	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 1 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
		situacao = "falsa"; 
	} 
	if (document.getElementById(campo).value == "") { 
		situacao = "falsa"; 
	} 
	if (document.getElementById(campo).value.search(/^[0-3][0-9]\/[0-1][0-9]\/[0-9]{3,4}/)<0){
		situacao = "falsa"; 
	}
	if (situacao == "falsa") { 
		alert("Data inválida!"); 
		document.getElementById(campo).focus(); 
	} 
} 	
			
function verifica_hora(campo){ 
	hrs = (document.getElementById(campo).value.substring(11,13)); 
	minu = (document.getElementById(campo).value.substring(14,16)); 

	situacao = ""; 
	// verifica data e hora 
	if ((hrs < 00 ) || (hrs > 23) || ( minu < 00) ||( minu > 5)){ 
	  situacao = "falsa"; 
	} 
	
	if (document.getElementById(campo).value == "") { 
	  situacao = "falsa"; 
	} 
	
	if (document.getElementById(campo).value.search(/[0-3][0-9]\/[0-1][0-9]\/[0-9]{4}[\s][0-2][0-9][:][0-5][0-9]?/)<0){
		situacao = "falsa"; 
	}
	if (situacao == "falsa") { 
	  alert("Hora inválida!"); 
	  document.getElementById(campo).focus(); 
	} 
}	

function mascara(data,campo){ 	
	var mydata = ''; 
	mydata = mydata + data; 
	if (mydata.length == 2){ 
	  mydata = mydata + '/'; 	  
	  document.getElementById(campo).value = mydata; 
	} 
	alert(mydata.length);
	if (mydata.length == 5){ 
	  mydata = mydata + '/'; 
	  document.getElementById(campo).value = mydata; 
	} 
	if (mydata.length == 10){ 
		verifica(campo);
	}  
} 


function verifica(campo) { 
	dia = (document.getElementById(campo).value.substring(0,2)); 
	mes = (document.getElementById(campo).value.substring(3,5)); 
	ano = (document.getElementById(campo).value.substring(6,10)); 
	situacao = ""; 
	// verifica o dia valido para cada mes 
	if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31) { 
		situacao = "falsa"; 
	} 
	// verifica se o mes e valido 
	if (mes < 01 || mes > 12 ) { 
		situacao = "falsa"; 
	} 
	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
		situacao = "falsa"; 
	} 
	if (document.getElementById(campo).value == "") { 
		situacao = "falsa"; 
	} 
	if (situacao == "falsa") { 
		alert("Data inválida!"); 
		document.getElementById(campo).focus(); 
	} 
} 	

function excluirMud(cod)
{		
   var combomud = createXMLHTTP();
   combomud.open("post", "excluiMud.asp", true);
   combomud.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   combomud.onreadystatechange=function(){
	   if (combomud.readyState==4){// abaixo o texto do gerado no arquivo executa.asp e colocado no div				   				
				document.getElementById("div"+cod).style.display = "none";
				document.getElementById("total").value = document.getElementById("total").value - 1;
				document.getElementById("valtot").innerHTML = "Total: "+document.getElementById("total").value;										
		   }}
		   combomud.send("idmud=" + cod);

}

function removeChar(input) {			
	var output = "";
	for (var i = 0; i < input.length; i++) {
		if ((input.charCodeAt(i) == 13) && (input.charCodeAt(i + 1) == 10)) {
			i++;
			output += "<br>";
		} else if ((input.charCodeAt(i) == 32)) {			
			output += "nbsp";
		} else {
			output += input.charAt(i);
		}
	}
	return output;
}

function selectUsers(){	
	$("#selectUsuarios").dialog({modal:true, minHeight: null, maxHeight: null, height: null, width: 900, minWidth: null, title:"Selecione o(s) técnico(s) responsável pela mudança"});
	document.getElementById('selectUsuarios').style.display='block';
	document.getElementById('natureza').style.visibility='hidden';
	document.getElementById('tipo').style.visibility='hidden';
	document.getElementById('ap_reag').style.visibility='hidden';
	document.getElementById('risco').style.visibility='hidden';
}

function selectUsers2(){	
	$("#selectUsuarios").dialog({modal:true, minHeight: null, maxHeight: null, height: null, width: 900, minWidth: null, title:"Selecione o(s) técnico(s) responsável pela mudança"});
	document.getElementById('selectUsuarios').style.display='block';		
	document.getElementById('ap_reag').style.visibility='hidden';	
}

function selectTypeClassif(tipoclas){
	if(tipoclas == ""){
		alert("Selecione do tipo");
		document.getElementById('tipo').focus();
		return false;
	}
	
   var combosub = createXMLHTTP();
   combosub.open("post", "findSubClassi.asp", true);
   combosub.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   combosub.onreadystatechange=function(){
   if (combosub.readyState==4){// abaixo o texto do gerado no arquivo executa.asp e colocado no div				   							
			document.getElementById("selectClassif").innerHTML = combosub.responseText;
	   }}
   combosub.send("tipo="+tipoclas);	 
   
	$("#selectClassif").dialog({modal:true, minHeight: null, maxHeight: null, height: null, width: 700, minWidth: null, title:"Escolha a Classificação"});
	document.getElementById('selectClassif').style.display='block';
	
}

function addUsers(){
	//zera campos do formulário do usuário.
	document.getElementById('nomecompleto').value = "";
	document.getElementById('firstname').value = "";
	document.getElementById('matricula').value = "";
	document.getElementById('telefone').value = "";
	document.getElementById('celular').value = "";
	document.getElementById('funcao').value = "";
	document.getElementById('grupo').value = "";
	
	$("#divusers").dialog({modal:true, minHeight: null, maxHeight: null, height: null, width: 600, minWidth: null, title:"Adicionar novo usuário"});
	document.getElementById('divusers').style.display='block';
}

function guardaId(idexec){

	id = document.getElementById('idexec').value;			

	//substring(início,fim)
	//texto.indexOf("A")		
	if(id.length == 0)
		contador = 0;
	else
		contador = 1
	//conta a quantidade de id´s do campo input idexec para criar o vetor de manipulação
	for(i=0;i<id.length;i++){				
		if(id.indexOf(",") != -1){
			id = id.substring(id.indexOf(",")+1);
			contador = contador + 1;
		}
	}
	//alert("contador="+contador);
	str = new Array(contador)
	id = document.getElementById('idexec').value;
	//alert("valor do vetor="+id);
	pos = 0
	//alert("id="+id);
	//preenche o vetor com os id´s já existentes
	while(id.indexOf(",") != -1){								
		str[pos] = id.substring(0,id.indexOf(","));		
		id = id.substring(id.indexOf(",")+1,id.length);		
		pos = pos + 1;
	}	
	if(id.length > 0){
		str[pos] = id.substring(0,id.length);		
	}
	//alert("vetor="+str);
	//verifica se foi realizado um clique
	if(document.getElementById('checkuser'+idexec).checked){
		senaotem = true;
		strput = ""
		//alert("length="+str.length);
		for(i=0;i<str.length;i++){			
			if(str[i] == idexec){				
				senaotem = false;
			}
			if(i == 0 || strput == "")
				strput = str[i];
			else
				strput = strput +","+str[i];						
		}		
		if(senaotem){			
			if(strput == "")
				strput = idexec;
			else
				strput = strput +","+idexec;
		}		
		document.getElementById('idexec').value = strput;
		//alert(document.getElementById('idexec').value);
	}else{
		strput = "";
		for(i=0;i<str.length;i++){			
			if(str[i] != idexec){				
				if(i == 0 || strput == "")
					strput = str[i];
				else
					strput = strput +","+str[i];				
			}
		}
		//alert(strput);
		document.getElementById('idexec').value = strput;
	}
}


function valida(){
	if(document.getElementById('dtexecuta').value == ""){
		alert("Digite a data a ser executar a mundança.");
		document.getElementById('dtexecuta').focus();
		return false;
	}else if(document.getElementById('risco').value == ""){
		alert("Classificar a Mudança em ALTO, MÉDIO ou BAIXO");
		document.getElementById('risco').focus();
		return false;			
	}else if(document.getElementById('natureza').value == ""){
		alert("Selecione a natureza.");
		document.getElementById('natureza').focus();
		return false;	
	}else if(document.getElementById('tipo').value == ""){
		alert("Selecione do tipo");
		document.getElementById('tipo').focus();
		return false;	
	}else if(document.getElementById('idsubclass').value == ""){
		alert("Selecione a subclassificação");		
		return false;		
	}else if(document.getElementById('responsavel').value == ""){
		alert("Quem é o profissional responsável pela mudança!");		
		document.getElementById('responsavel').focus();
		return false;		
	}else if(document.getElementById('desc_impacto').value == ""){
		alert("Descrever os serviços, equipamentos, unidades, etc. tudo o que ficará ou poderá ficar indisponível no momento da implementação da mudança.");
		document.getElementById('desc_impacto').focus();
		return false;		
	}else if(document.getElementById('planoretorno').value == ""){
		alert("Descrever o plano de retorno.");
		document.getElementById('planoretorno').focus();
		return false;
	}else if(document.getElementById('beneficios').value == ""){
		alert("Descrever os benefícios da implementação. O que irá melhorar no ambiente com essa implementação");
		document.getElementById('beneficios').focus();
		return false;		
	}
	return true;
}

function validaFechamento(){	
	if(document.getElementById('dtexecuta').value == ""){
		alert("Digite a data a ser executar a mundança.");
		document.getElementById('dtexecuta').focus();
		return false;
	}else if(document.getElementById('idexec').value == ""){
		alert("Quem é o profissional responsável pela mudança!");		
		document.getElementById('idexec').focus();
		return false;				
	}else if(document.frmfechamento.feita_sucesso[0].checked == false && document.frmfechamento.feita_sucesso[1].checked == false){
		alert("Marque se a mudança foi realiza com sucesso");
		return false;
	}else if(document.frmfechamento.feita_sucesso[1].checked && (document.getElementById('resultado').value == "" || document.getElementById('resultado').value == "descreva o motivo")){
		alert("Descrever o resultado.");
		document.getElementById('resultado').innerHTML = "";
		document.getElementById('resultado').focus();
		return false;
	}else if(document.getElementById('ap_reag').value != "fe"){
		alert("Selecione o status \'Fechada\'");		
		document.getElementById('ap_reag').focus();
		return false;				
	}	
	if(!window.confirm('Clique em \'OK\' para confirmar os executores da mudança!')){
		document.getElementById('user_selecionado').focus();
		return false;
	}
	return true;
}

function del(tipo,id){
	if(window.confirm('Clique em \'OK\' para confirmar!')){
		document.getElementById("nitennovo").value = eval(document.getElementById("nitennovo").value) - 1; 
		document.getElementById("ordem").value = eval(document.getElementById("ordem").value) - 1;
		if(tipo == "alt"){
		   var combodel = createXMLHTTP();
		   combodel.open("post", "delativ.asp", true);
		   combodel.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		   combodel.onreadystatechange=function(){
		   if (combodel.readyState==4){// abaixo o texto do gerado no arquivo executa.asp e colocado no div				   											
				//se remove uma atividade tem que zeram a ordem ou validar						
			   }}
		   combodel.send("id="+id);
		}		
		tbl = document.getElementById('bodyativ')
		
		tamtbl = tbl.rows.length;		
		//alert(tamtbl);
		for (var i = 0; i < tamtbl; i++) {
			//linha atividade
			//alert(i);
			if(tbl.rows[i].getAttribute("alt") == "bd"){				
				if (navigator.appName == "Microsoft Internet Explorer"){
					cell = tbl.rows[i].cells[0].childNodes[0].id;					
				}else{
					cell = tbl.rows[i].cells[0].childNodes[1].id;					
				}				
				//alert("ativ"+document.getElementById(cell).value);								
				if(document.getElementById(cell).value > tamtbl-1){
					//alert("ceto zero");
					document.getElementById(cell).value = "";
				}
			}
			if(tbl.rows[i].getAttribute("alt") == "new"){
				cell = tbl.rows[i].cells[0].childNodes[0].id;								
				//alert("ativ"+cell);
				if(document.getElementById(cell).value > tamtbl-1){
					document.getElementById(cell).value = "";
				}
			}
		}		
		return true
	}
	return false;
}

function montalist(){
	if(validaativ()){ 		
		if(document.getElementById("nitennovo").value != 0){
			document.getElementById("nitennovo").value = eval(document.getElementById("nitennovo").value) + 1;
		}else{
			document.getElementById("nitennovo").value = 1;
			$("#default").remove();
		}	
		
		$("#bodyativ").append('<tr id="linha'+document.getElementById("nitennovo").value+'" alt="new" style="cursor:pointer; cursor:hand;" onmouseout="this.style.background=\'#FFFFFF\'" onmouseover="this.style.background=\'#e8f3ff\'"><td onclick="definepriority(\'ordem'+document.getElementById("nitennovo").value+'\');" style="text-align:left;"><input type="hidden" id="ativ'+document.getElementById("nitennovo").value+'" size="40" value="'+document.getElementById('ativ_realizar').value+'" readonly="true">'+document.getElementById('ativ_realizar').value+'</td><td align="center"><input type="text" id="ordem'+document.getElementById("nitennovo").value+'" size="1" maxlength="2" value="1" alt="0"></td><td><img src="img/apagar.png" style="cursor:pointer;" id="apaga" onclick="if(del(\'\',\'\')){ $(function(){$(\'#linha'+document.getElementById("nitennovo").value+'\').remove();});}"></td></tr>');
		document.getElementById('ativ_realizar').value = "";
		document.getElementById('ativ_realizar').focus();
	}
}

function validaativ(){
	if(document.getElementById('ativ_realizar').value == ""){
		alert("Descreva uma atividade.");
		document.getElementById('ativ_realizar').focus();
		return false;
	}
	return true;
}

function defineorder(idordem){
	if(document.getElementById("ordem").value < document.getElementById("nitennovo").value){
		if(document.getElementById("ordem").value != 0){
			document.getElementById("ordem").value = eval(document.getElementById("ordem").value) + 1;
		}else{
			document.getElementById("ordem").value = 1;			
		}		
		document.getElementById('ordem'+idordem).value=document.getElementById("ordem").value;
	}else{
		alert('A ordem das atividades jÃ¡ foi definida');
	}
}

function definepriority(idordem){	
	tbl = document.getElementById('bodyativ')
	tamtbl = tbl.rows.length;	
	
	if(document.getElementById(idordem).value < tamtbl){
			defineordem(idordem,tamtbl);
	}	
}

function defineordem(idcell,numcell){
	if(document.getElementById(idcell).value == ""){
		document.getElementById(idcell).value = 1;
	}else if(document.getElementById(idcell).value <= numcell){
		document.getElementById(idcell).value = eval(document.getElementById(idcell).value) + 1;		
	}
}

function apareceselect(){
	document.getElementById('natureza').style.visibility='visible';
	document.getElementById('tipo').style.visibility='visible';
	document.getElementById('ap_reag').style.visibility='visible';
	document.getElementById('risco').style.visibility='visible';
}

function apareceselect2(){		
	document.getElementById('ap_reag').style.visibility='visible';	
}

function saveExecutor(idexec){			
	   var comboe = createXMLHTTP();
	   comboe.open("post", "objsavexec.asp", true);
	   comboe.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	   comboe.onreadystatechange=function(){
	   if (comboe.readyState==4){// abaixo o texto do gerado no arquivo executa.asp e colocado no div				   								
				document.getElementById("user_selecionado").innerHTML = comboe.responseText;
		   }}		 
	   comboe.send("idexec="+idexec);
}

function changeStatus(campo,idativ,corAtiva){
	if(document.getElementById(campo+idativ).style.display == "none"){
		document.getElementById(campo+idativ).style.display = "";
		document.getElementById('corOver').value = corAtiva;
	}else{
		document.getElementById(campo+idativ).style.display = "none";
		document.getElementById('corOver').value = "#c7e2ff";
	}
}

function mostra_menu(menu){
	if(menu == "menu-inserir"){
		document.getElementById("menu-inserir").style.display="block";
		document.getElementById("menu-inserir2").style.display="none";
		document.getElementById("menu-inserir3").style.display="none";
	}else if(menu == "menu-inserir2"){
		document.getElementById("menu-inserir").style.display="none";
		document.getElementById("menu-inserir2").style.display="block";
		document.getElementById("menu-inserir3").style.display="none";
	}else if(menu == "menu-inserir3"){
		document.getElementById("menu-inserir").style.display="none";
		document.getElementById("menu-inserir2").style.display="none";
		document.getElementById("menu-inserir3").style.display="block";	
	}
}

function carregaBar(idunid,parcial,total){		
	$(idunid).progressBar(Math.floor(100 * parseInt(parcial) / parseInt(total)));			
}	

// -------------------------------------------- Olhar este codigo ---------------------------------------------------------
function mudaUF(valor)
{ 
	var vincula = createXMLHTTP();
	vincula.open("post","includes/objvincula.asp",true);
	vincula.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	vincula.onreadystatechange= function()//recebe uma função
	{
		if(vincula.readyState == 4)// abaixo o texto do gerado no arquivo executa.asp e colocado no div
		{
			document.getElementById("div_uf").innerHTML = vincula.responseText;
		}
	}		
	vincula.send("val="+ valor);
	
	var cidade = createXMLHTTP();
	cidade.open("post","includes/objcidade.asp",true);
	cidade.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	cidade.onreadystatechange= function()
	{
		if(cidade.readyState == 4){
			document.getElementById("div_cid").innerHTML = cidade.responseText;
		}
	}
	cidade.send("valorcid="+valor+"&cid2="+document.getElementById("cidade2").value);		
}

function conta_uabrev(){  /*Esta função valida o campo Discagem Abreviada*/
	var suabrev = String(theForm.uabrev.value) ;
	tamanho = suabrev.length;
	Nzero=suabrev;	
	if (tamanho < 5 && tamanho > 0){
		alert("Discagem Abreviada invÃ¡lida !!!");
		theForm.uabrev.value = '';
		theForm.uabrev.focus();
	}
	if (Nzero=='*0000'){
		alert("Discagem Abreviada invÃ¡lida, deve ser diferente de zero !!!");
		theForm.uabrev.value = '';
		theForm.uabrev.focus();
	}
}

function conta_cep(){ /*Esta função valida o campo CEP*/
	var scep = String(theForm.cep.value) ;
	tamanho = scep.length;
	Nzero=scep;	
	if (tamanho < 9 && tamanho > 0){
		alert("CEP invÃ¡lido !!!");
		theForm.cep.value = '';
		theForm.cep.focus();
	}
	if (Nzero =='00000-000'){
		alert('CEP invÃ¡lido, deve ser diferente de zero !!!');
		theForm.cep.value = '';
		theForm.cep.focus();
	}	
}

function conta_fone(){
	var fones = String(theForm.telefone.value) ;
	tamanho = fones.length;
	Nzero=fones;	
	if (tamanho < 14 && tamanho > 0){
		alert("Telefone invÃ¡lido !!!");
		theForm.cep.value = '';
		theForm.telefone.focus();
	}
	if (Nzero=='(00) 0000-0000'){
		alert("Telefone invÃ¡lido, deve ser diferente de zero !!!");
		theForm.telefone.value = '';
		theForm.telefone.focus();
	}
}

function conta_fax(){ /*Esta função valida o campo Fax*/

	var sfax = String(theForm.fax.value) ;
	tamanho = sfax.length;
	Nzero=sfax;	
	if (tamanho < 14 && tamanho > 0){
		alert("NÃºmero do Fax invÃ¡lido !!!");
		theForm.cep.value = '';
		theForm.fax.focus();
	}
	if (Nzero=='(00) 0000-0000'){
		alert("NÃºmero do Fax invalido, deve ser diferente de zero !!!");
		theForm.fax.value = '';
		theForm.fax.focus();
	}
}

function vinculo(valor){ 
	if (theForm.id_uf.value=="1"){
			document.getElementById("vinculacao").value="GISUT CG";
	}
	if (theForm.id_uf.value=="5"){
			document.getElementById("vinculacao").value="RESUT CB";			
	}
	
	var cidade = createXMLHTTP();
	cidade.open("post","includes/objcidade.asp",true);
	cidade.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	cidade.onreadystatechange= function()
	{
		if(cidade.readyState == 4){	
			document.getElementById("div_cid").innerHTML = cidade.responseText;
		}
	}	

	cidade.send("valorcid="+valor+"&cid2="+document.getElementById("cidade2").value);	
}

function changeVinc(valor){ 	
	var vinc = createXMLHTTP();
	vinc.open("post","includes/objvinc2.asp",true);
	vinc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	vinc.onreadystatechange= function()
	{
		if(vinc.readyState == 4){	
			document.getElementById("div_vinc").innerHTML = vinc.responseText;
		}
	}	

	vinc.send("vinc2="+valor);	
}

function changeTipoUnid(valor){ 	
	var tpunid = createXMLHTTP();
	tpunid.open("post","includes/objtipounid2.asp",true);
	tpunid.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	tpunid.onreadystatechange= function()
	{
		if(tpunid.readyState == 4){	
			document.getElementById("div_tipounidade").innerHTML = tpunid.responseText;
		}
	}	

	tpunid.send("tipounid2="+valor);	
}

function mascara_nova(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function executeBaixa(valor){ 
	var baixaunid = createXMLHTTP();
	baixaunid.open("post","objbaixaunid.asp",true);
	baixaunid.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	baixaunid.onreadystatechange= function()
	{
		if(baixaunid.readyState == 4){				
			with (document.frmprincipal)
			{	   
			   method = "POST";
			   action = "default.asp";	 			   
			   submit();
			}
		}
	}	

	baixaunid.send("idunid="+valor);	
}

/************************** ***************************/

function BuscaAssistido(){	
	var nome_assis = document.getElementById('nome_assis');	
	if(nome_assis.value == ""){
		alert("Por favor, digite o nome do assistido!");
		nome_assis.focus();
		return false;
	}
	
	var page = document.getElementById('page').value;
	
	var comboassis = createXMLHTTP();
	comboassis.open("post","busca/objBuscaAssistidos.php",true);
	comboassis.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboassis.onreadystatechange= function()
	{
		if(comboassis.readyState == 4){	
			document.getElementById("show_assis").innerHTML = comboassis.responseText;
		}
	}	

	comboassis.send("nome="+nome_assis.value+"&page="+page);
}

function verifEnter(e){
	if(OnEnter(e)){		
		BuscaAssistido();
	}
}

function BuscaAssistidoAtend(){	
	var nome_assis = document.getElementById('nameassisatend');	
	var dt_assis = document.getElementById('dtassisatend');	
	
	var comboassis = createXMLHTTP();
	comboassis.open("post","busca/objBuscaAssistidosAtend.php",true);
	comboassis.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboassis.onreadystatechange= function()
	{
		if(comboassis.readyState == 4){	
			document.getElementById("listassisatend").innerHTML = comboassis.responseText;
		}
	}	

	comboassis.send("nome="+nome_assis.value+"&dta="+dt_assis.value);
}

function verifEnterAtend(e){
	if(OnEnter(e)){		
		BuscaAssistidoAtend();
	}
}

/****** Função captura a tecla ENTER *****/
function OnEnter(evt)
{	
    var key_code = evt.keyCode  ? evt.keyCode  :
                       evt.charCode ? evt.charCode :
                       evt.which    ? evt.which    : void 0;


    if (key_code == 13)
    {	
        return true;
    }
}

function changeCidade(iduf){ 	
	var combocid = createXMLHTTP();
	combocid.open("post","cadastra/objCidade.php",true);
	combocid.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	combocid.onreadystatechange= function()
	{
		if(combocid.readyState == 4){	
			document.getElementById("div_showcid").innerHTML = combocid.responseText;
		}
	}	

	combocid.send("iduf="+iduf);	
}

function changeCidadeUser(iduf){ 	
	var combocid = createXMLHTTP();
	combocid.open("post","cadastra/objCidadeUser.php",true);
	combocid.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	combocid.onreadystatechange= function()
	{
		if(combocid.readyState == 4){	
			document.getElementById("div_showcid").innerHTML = combocid.responseText;
		}
	}	

	combocid.send("iduf="+iduf);	
}

function VerificaDP(){
	if(document.getElementById('tpusuario').value == 3){	
		if(document.getElementById('nomecompleto').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite o nome completo do(a) usuário(a)! \n";
			document.getElementById('nomecompleto').focus();		
			return false;
		}
	}	
	if(document.getElementById('nomeusuario').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o nome da usuário! \n";
		document.getElementById('nomeusuario').focus();		
		return false;
	}
	if(document.getElementById('tpusuario').value == 3){
		if(document.getElementById('cid_usuario').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, selecione a cidade! \n";
			document.getElementById('cid_usuario').focus();		
			return false;	
		}else	
		if(document.getElementById('sala').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite a sala do(a) usuário(a)! \n";
			document.getElementById('sala').focus();		
			return false;	
		}
	}
	if(document.getElementById('iddadosuser').value == ""){		
		if(document.getElementById('login').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite o login! \n";
			document.getElementById('login').focus();		
			return false;
		}else
		if(document.getElementById('senhaantiga').value != "" && document.getElementById('senhanova').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite a senha! \n";
			document.getElementById('senhanova').focus();		
			return false;	
		}else
		if(document.getElementById('senhaantiga').value != "" && document.getElementById('confirmesenha').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, confirme a senha! \n";
			document.getElementById('confirmesenha').focus();		
			return false;	
		}		
	}
	
	if(document.getElementById('senhanova').value != "" && document.getElementById('confirmesenha').value != ""){
		if(document.getElementById('tpusuario').value == 3){
			if(document.getElementById('iddadosuser').value != "" && document.getElementById('senhaantiga').value == ""){		
				document.getElementById("error").innerHTML = "Por favor, digite a senha antiga! \n";
				document.getElementById('senhaantiga').focus();		
				return false;	
			}
			if(document.getElementById('senhaantiga').value != ""){
				if(document.getElementById('senhanova').value == ""){
					document.getElementById("error").innerHTML = "Por favor, digite a nova senha! \n";
					document.getElementById('senhanova').focus();		
					return false;
				}
				if(document.getElementById('confirmesenha').value == ""){
					document.getElementById("error").innerHTML = "Por favor, digite a confirmação da nova senha! \n";
					document.getElementById('confirmesenha').focus();		
					return false;
				}			
			}
		}
		if(document.getElementById('senhanova').value != document.getElementById('confirmesenha').value){		
			document.getElementById("error").innerHTML = "A nova senha e confirmar nova senha devem ser igual! \n";
			document.getElementById('senhanova').focus();		
			return false;	
		}
	}
	return true;
}

function VerificaDPServ(){

	if(document.getElementById('nomeusuario').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o nome da usuário! \n";
		document.getElementById('nomeusuario').focus();		
		return false;
	}

	if(document.getElementById('iddadosuser').value == ""){		
		if(document.getElementById('login').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite o login! \n";
			document.getElementById('login').focus();		
			return false;
		}else
		if(document.getElementById('senhaantiga').value != "" && document.getElementById('senhanova').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, digite a senha! \n";
			document.getElementById('senhanova').focus();		
			return false;	
		}else
		if(document.getElementById('senhaantiga').value != "" && document.getElementById('confirmesenha').value == ""){		
			document.getElementById("error").innerHTML = "Por favor, confirme a senha! \n";
			document.getElementById('confirmesenha').focus();		
			return false;	
		}		
	}
	
	if(document.getElementById('senhanova').value != "" && document.getElementById('confirmesenha').value != ""){
		if(document.getElementById('senhanova').value != document.getElementById('confirmesenha').value){		
			document.getElementById("error").innerHTML = "A nova senha e confirmar nova senha devem ser igual! \n";
			document.getElementById('senhanova').focus();		
			return false;	
		}
	}
	return true;
}

function novoAtend(idassistido,idefensor){
	if(window.confirm('Clique em \'OK\' para Gerar Novo Atendimento para este Usuário(a)!')){
		var comboAtend = createXMLHTTP();
		comboAtend.open("post","busca/objGeraNovoAtend.php",true);
		comboAtend.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		comboAtend.onreadystatechange= function()
		{
			if(comboAtend.readyState == 4){	
				showlistassis();
			}
		}	

		comboAtend.send("ida="+idassistido+"&ide="+idefensor);	
	}
	return false;
}

function Verifica(){	
	if(document.getElementById('nome_assis_cad').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o nome do(a) assistido(a)! \n";
		document.getElementById('nome_assis_cad').focus();		
		return false;
	}else
	if(document.getElementById('filiacao_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o nome da filiação! \n";
		document.getElementById('filiacao_assis').focus();		
		return false;
	}else
	if(document.getElementById('dtnasc_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite a data de nascimento do(a) assistido(a)! \n";		
		document.getElementById('dtnasc_assis').focus();		
		return false;	
	}else
	if(document.getElementById('end_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o endereço do(a) assistido(a)! \n";
		document.getElementById('end_assis').focus();		
		return false;	
	}else
	if(document.getElementById('bairro_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, digite o bairro do(a) assistido(a)! \n";
		document.getElementById('bairro_assis').focus();		
		return false;	
	}else
	if(document.getElementById('cid_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, selecione a cidade! \n";
		document.getElementById('cid_assis').focus();		
		return false;	
	}else	
	if(document.getElementById('prof_assis').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, selecione a profissão do(a) assistido(a)! \n";
		document.getElementById('prof_assis').focus();		
		return false;	
	}else
	if(document.getElementById('estado_civil').value == ""){		
		document.getElementById("error").innerHTML = "Por favor, selecione o estado civil do(a) assistido(a)! \n";
		document.getElementById('estado_civil').focus();
		return false;	
	}
	return true;
}

function Verif_Desig(){	
	
	if(document.getElementById('defensor_assis').value == ""){			
		document.getElementById("error_desig").innerHTML = "Por favor, selecione o defensor! \n";				
		document.getElementById('defensor_assis').focus();	
		return false;		
	}
	if(document.getElementById('senha').value == ""){			
		document.getElementById("error_desig").innerHTML = "Por favor, digite a senha! \n";				
		document.getElementById('senha').focus();	
		return false;		
	}	
	
	if(document.getElementById('resultnumatend').value >= 15){
		if(window.confirm('Já foram designados '+document.getElementById('resultnumatend').value+' assistidos para esse defensor! \n\n Clique em \'OK\' para confirmar a designação. \n')){
			return true;
		}else{
			return false;
		}
	}
}



function confirmAtend(idef){

	var comboassis = createXMLHTTP();
	comboassis.open("post","busca/objNumAtend.php",true);
	comboassis.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboassis.onreadystatechange= function()
	{
		if(comboassis.readyState == 4){	
			document.getElementById('resultnumatend').value = comboassis.responseText;
		}		
	}	
	comboassis.send("ndef="+idef);	
}

function setadivDesig(){
	location.href='principal.php'
}

function checkTime(i){
	if (i<10){
		i="0" + i;
	}
	return i;
}

function showlistassis(){
	
	var comboshow = createXMLHTTP();
	comboshow.open("post","busca/objShowListAssis.php",true);
	comboshow.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboshow.onreadystatechange= function()
	{
		if(comboshow.readyState == 4){	
			document.getElementById("showlistassis").innerHTML = comboshow.responseText;		
			var today = new Date();
			var hora = today.getHours();
			var minuto = today.getMinutes();
			var segundo = today.getSeconds();
			
			minuto=checkTime(minuto);
			segundo=checkTime(segundo);
			
			document.getElementById("timelistassis").innerHTML = hora + " : " + minuto + " : " + segundo;
		}
	}	
	comboshow.send();	
}

function cadHistorico(){
	if(VerificaHistorico()){
		var combosalva = createXMLHTTP();
		combosalva.open("post","busca/objCadHist.php",true);
		combosalva.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combosalva.onreadystatechange= function()
		{
			if(combosalva.readyState == 4){				
				if(document.getElementById('idhist').value != ""){
					document.getElementById('idhist').value = "";
					document.getElementById("error_hist").innerHTML = "";
				}
				BaixaAtendimento();
				//showlistassis();
			}
		}	
		var ida = document.getElementById('idassis_aux').value;
		var idp = document.getElementById('providencia').value;
		var idacao = document.getElementById('acao').value;
		var idh = document.getElementById('idhist').value;				
		
		combosalva.send("assis="+ida+"&idp="+idp+"&idacao="+idacao+"&idh="+idh);	
	}else{
		return false;
	}
}


function chamarPainel(){
	if(document.getElementById('nomeassis_hist').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, clique no assistido a esquerda! \n";						
		return false;
	}else{
		var combopainel = createXMLHTTP();
		combopainel.open("post","busca/objRegPainel.php",true);
		combopainel.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combopainel.onreadystatechange= function()
		{
			if(combopainel.readyState == 4){				
				//document.getElementById("xxxx").innerHTML = combopainel.responseText;				
			}
		}	
		var assis = document.getElementById('assispainel').value;
		var defen = document.getElementById('defenpainel').value;				
		var idatend = document.getElementById('idassis_aux').value;
		var senha = document.getElementById('senhapainel').value;
		
		combopainel.send("assis="+assis+"&defen="+defen+"&idate="+idatend+"&acao=chamar"+"&senha="+senha);
	}
}




/*
function cadHistorico(){
	if(VerificaHistorico()){
		if(document.getElementById('descricao').value == "" && document.getElementById('providencia').value != 3){
			document.getElementById("error_hist").innerHTML = "Por favor, digite a descrição! \n";				
			document.getElementById('descricao').focus();
			return false;
		}		
		var combosalva = createXMLHTTP();
		combosalva.open("post","busca/objCadHist.php",true);
		combosalva.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combosalva.onreadystatechange= function()
		{
			if(combosalva.readyState == 4){								
				document.getElementById("div_hist_assis").innerHTML = combosalva.responseText;
				document.getElementById("descricao").value = "";
				if(document.getElementById('idhist').value != ""){
					document.getElementById('idhist').value = "";
					document.getElementById("error_hist").innerHTML = "";
				}
				showlistassis();
			}
		}	
		var ida = document.getElementById('idassis_aux').value;
		var idp = document.getElementById('providencia').value;
		var idacao = document.getElementById('acao').value;
		var idh = document.getElementById('idhist').value;		
		var desc = removeChar(document.getElementById('descricao').value);
		
		combosalva.send("assis="+ida+"&idp="+idp+"&idacao="+idacao+"&desc="+desc+"&idh="+idh);	
	}else{
		return false;
	}
}*/

function VerificaHistorico(){	
	if(document.getElementById('nomeassis_hist').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, clique no assistido a esquerda! \n";						
		return false;
	}else
	if(document.getElementById('acao').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, selecione a Ação! \n";				
		document.getElementById('acao').focus();
		return false;
	}else
	if(document.getElementById('providencia').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, selecione a Providência! \n";				
		document.getElementById('providencia').focus();		
		return false;
	}
	return true;
}


function VerificaAlt(){	
	if(document.getElementById('acao').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, selecione a Ação! \n";				
		document.getElementById('acao').focus();
		return false;
	}else
	if(document.getElementById('providencia').value == ""){			
		document.getElementById("error_hist").innerHTML = "Por favor, selecione a Providência! \n";				
		document.getElementById('providencia').focus();		
		return false;
	}
	return true;
}


function alterarHistorico(){
	if(VerificaAlt()){
		var combosalva = createXMLHTTP();
		combosalva.open("post","busca/objAltHist.php",true);
		combosalva.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combosalva.onreadystatechange= function()
		{
			if(combosalva.readyState == 4){				
				if(document.getElementById('idhist').value != ""){
					location.href='principal.php'
				}
				//BaixaAtendimento();
				//showlistassis();
			}
		}	
		var ida = document.getElementById('idassis_aux').value;
		var idp = document.getElementById('providencia').value;
		var idacao = document.getElementById('acao').value;
		var idh = document.getElementById('idhist').value;				
		
		combosalva.send("assis="+ida+"&idp="+idp+"&idacao="+idacao+"&idh="+idh);	
	}else{
		return false;
	}
}


function BaixaAtendimento(){
	/*if(VerificaHistorico()){
		if(document.getElementById('idhist').value != ""){
			document.getElementById("error_hist").innerHTML = "Deve ter pelo menos 1 registro cadastrado! \n";
			return false;		
		}else{
			if(window.confirm('Clique em \'OK\' para dar Baixa no Atendimento!')){*/
				var combobaixa = createXMLHTTP();
				combobaixa.open("post","busca/objBaixaAtend.php",true);
				combobaixa.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				combobaixa.onreadystatechange= function()
				{
					if(combobaixa.readyState == 4){							
						alert("Atendimento concluído com sucesso");						
						
						location.href='principal.php'
					}
				}	
				idassis = document.getElementById('idassis_aux').value;				
				
				combobaixa.send("assis="+idassis);								
			/*}else{				
				return false;
			}
		}
	}*/
}

function carregaHistorico(idAssis){
	var comboassis = createXMLHTTP();
	comboassis.open("post","busca/objCarregaHist.php",true);
	comboassis.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboassis.onreadystatechange= function()
	{
		if(comboassis.readyState == 4){	
			document.getElementById("div_hist_assis").innerHTML = comboassis.responseText;
		}
	}	

	comboassis.send("assis="+idAssis);	
}

function carregaRegistro(idAssis){	
	var comboreg = createXMLHTTP();
	comboreg.open("post","busca/objCarregaRegis.php",true);
	comboreg.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboreg.onreadystatechange= function()
	{
		if(comboreg.readyState == 4){	
			document.getElementById("div_frm_hist").innerHTML = comboreg.responseText;
			$("#nomeassis_hist").animate({
				opacity: 0.9,
				backgroundColor: "#FF6A6A"
			  }, 750);
			$("#nomeassis_hist").animate({				
				opacity: 1,
				backgroundColor: "#FFFFFFF"
			  }, 750);				  

				$(function(){	
					
					// Dialog
					$('#dialog').dialog({
						autoOpen: false,							
						width: 600,
						height: 350,
						buttons: {
							"Salvar": function() {
									var combofato = createXMLHTTP();
									
									combofato.open("post","busca/objSaveFato.php",true);
									combofato.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
									combofato.onreadystatechange= function()
									{
										if(combofato.readyState == 4){													
											document.getElementById("txtfatonarrado").innerHTML = combofato.responseText;										
										}
									}	
									var fatonarrado = removeChar(document.getElementById('txtfatonarrado').value);		
									combofato.send("fato="+fatonarrado+"&assis="+idAssis);								
									$(this).dialog("close");
							},
							"Imprimir": function() {								
								window.print();
							},							
							"Cancel": function() {								
								$(this).dialog("close");
							}
						}
					});

					// Dialog Link					
					$('#dialogFato').live('click',function(){
						$('#dialog').dialog('open');
						return false;
					});

				});	
		}
	}	

	comboreg.send("assis="+idAssis);	
}

function carregaRegAtend(idAssis){	
	var comboreg = createXMLHTTP();
	comboreg.open("post","busca/objCarregaRegisAtend.php",true);
	comboreg.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboreg.onreadystatechange= function()
	{
		if(comboreg.readyState == 4){	
			document.getElementById("div_frm_hist").innerHTML = comboreg.responseText;
			$("#nomeassis_hist").animate({
				opacity: 0.9,
				backgroundColor: "#FF6A6A"
			  }, 750);
			$("#nomeassis_hist").animate({				
				opacity: 1,
				backgroundColor: "#FFFFFFF"
			  }, 750);				  

				$(function(){					
					
					// Dialog
					$('#dialog').dialog({
						autoOpen: false,							
						width: 600,
						height: 350,
						buttons: {
							"Salvar": function() {
									var combofato = createXMLHTTP();
									
									combofato.open("post","busca/objSaveFato.php",true);
									combofato.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
									combofato.onreadystatechange= function()
									{
										if(combofato.readyState == 4){											
											document.getElementById("txtfatonarrado").innerHTML = combofato.responseText;										
										}
									}	
									var fatonarrado = removeChar(document.getElementById('txtfatonarrado').value);		
									combofato.send("fato="+fatonarrado+"&assis="+idAssis);								
									$(this).dialog("close");
							},
							"Imprimir": function() {								
								window.print();
							},	
							"Cancel": function() {						
								$(this).dialog("close");
							}
						}
					});

					// Dialog Link
					$('#dialogFato').live('click',function(){						
						$('#dialog').dialog('open');
						return false;
					});

					$('#dialogVisualizar').dialog({
						autoOpen: false,							
						width: 600,
						height: 350,
						buttons: {
							"Imprimir": function() {								
								window.print();
							},	
							"Cancel": function() {						
								$(this).dialog("close");
							}
						}
					});

					// Dialog Link
					$('#dialogFatoVisualizar').live('click',function(){						
						$('#dialogVisualizar').dialog('open');
						return false;
					});					

				});	
		}
	}	

	comboreg.send("assis="+idAssis);	
}

function NewPage(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable=1,status=0,toolbar=0,menubar=0,location=0'

	win = window.open(pagina,nome,settings);
}

function mudarLinha(idlinha){
	
	$(function() {

		$(idlinha).mouseover(function(event){			
			if(!$(idlinha).hasClass("corlinha")){			
				$(idlinha).addClass("corlinhatend");	
			}
		});
		$(idlinha).mouseout(function(event){						
				$(idlinha).removeClass("corlinhatend");			
		});
		
		$(idlinha).mousedown(function(event){
			$("#listadef > p").removeClass("corlinha");
			$(idlinha).addClass("corlinha");
		});
		//alert($("#listadef").find("p").size());
		//$("#listadef > p").css("color", "red");
		//$("#listadef > p").css("color", "red");
	});			

}

function mudarCorTexto(idlinha){
	
	$(function() {

		$(idlinha).mouseover(function(event){			
			if(!$(idlinha).hasClass("corTexto")){			
				$(idlinha).addClass("corTextoOver");	
			}
		});
		$(idlinha).mouseout(function(event){						
				$(idlinha).removeClass("corTextoOver");			
		});
		
		$(idlinha).mousedown(function(event){
			$("#listadef > p > span").removeClass("corTexto");
			$(idlinha).addClass("corTextoOver");
		});
		//alert($("#listadef").find("p").size());
		//$("#listadef > p").css("color", "red");
		//$("#listadef > p").css("color", "red");
	});			

}

function alteratipoacesso(campo){

	if(campo.value >= 3){
		document.getElementById("showdefe").style.display="";
		document.getElementById("shownomecompleto").style.display="";		
	}else{
		document.getElementById("showdefe").style.display="none";		
		document.getElementById("shownomecompleto").style.display="none";
	}
}

function VerificaAcao(){
	if(document.getElementById('nomeacao').value == ""){			
		document.getElementById("error_acao").innerHTML = "Por favor, digite o nome da Ação! \n";				
		document.getElementById('nomeacao').focus();
		return false;
	}else
	if(document.getElementById('nucleoacao').value == ""){			
		document.getElementById("error_acao").innerHTML = "Por favor, selecione o núcleo! \n";				
		document.getElementById('nucleoacao').focus();
		return false;
	}	
	return true;
}

function VerificaProf(){
	if(document.getElementById('nomeprofissao').value == ""){			
		document.getElementById("error_prof").innerHTML = "Por favor, digite o nome da Profissão! \n";				
		document.getElementById('nomeprofissao').focus();
		return false;
	}
	return true;
}

function VerificaProv(){
	if(document.getElementById('nomeprovidencia').value == ""){			
		document.getElementById("error_prov").innerHTML = "Por favor, digite o nome da Providência! \n";				
		document.getElementById('nomeprovidencia').focus();
		return false;
	}
	return true;
}

function delProvidencia(idprov){
	var acao = "excluir";
	var comboprov = createXMLHTTP();
	comboprov.open("post","busca/objExcluiProv.php",true);
	comboprov.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboprov.onreadystatechange= function()
	{
		if(comboprov.readyState == 4){				
			if(comboprov.responseText == "nao"){				
				if(window.confirm("Providência não excluída, pois possui vinculo! \n\n Deseja desativar essa providência? \n ")){					
					var comboprov2 = createXMLHTTP();
					comboprov2.open("post","busca/objExcluiProv.php",true);
					comboprov2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					comboprov2.onreadystatechange= function()
					{
						if(comboprov2.readyState == 4){				
							document.getElementById("codalt"+idprov).innerHTML = comboprov2.responseText;
							document.getElementById("codalt"+idprov).onclick = "";
						}
					}	

					comboprov2.send("idprov="+idprov+"&acao=desativar");	
				}
			}else{			
				var idr = '#cod'+idprov;
				$(idr).remove();
			}
		}
	}	

	comboprov.send("idprov="+idprov+"&acao="+acao);	
}

function delAcao(idacao){
	var acao = "excluir";
	var comboacao = createXMLHTTP();
	comboacao.open("post","busca/objExcluiAcao.php",true);
	comboacao.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboacao.onreadystatechange= function()
	{
		if(comboacao.readyState == 4){				
			if(comboacao.responseText == "nao"){				
				if(window.confirm("Ação não excluída, pois possui vinculo! \n\n Deseja desativar essa ação? \n ")){					
					var comboacao2 = createXMLHTTP();
					comboacao2.open("post","busca/objExcluiAcao.php",true);
					comboacao2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					comboacao2.onreadystatechange= function()
					{
						if(comboacao2.readyState == 4){				
							document.getElementById("codalt"+idacao).innerHTML = comboacao2.responseText;
							document.getElementById("codalt"+idacao).onclick = "";
						}
					}	

					comboacao2.send("idacao="+idacao+"&acao=desativar");	
				}
			}else{			
				var idr = '#cod'+idacao;
				$(idr).remove();
			}
		}
	}	

	comboacao.send("idacao="+idacao+"&acao="+acao);	
}