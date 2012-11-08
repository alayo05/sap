<?php 

require_once("config.php");
include("includes/conexao.con");

if ($_GET)
{
  		if ($con)
   		{
			$login = $_GET["nom"];
			$senha = $_GET["senha"];
		}	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Realizar Login Sistema SAP</title>

<link href="estilos/selecoes.css" rel="stylesheet" type="text/css" />
<link href="css/cadastro.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-size: 12pt;
	font-weight: bold;
}

.style22 {
	font-size: 14pt;
	font-weight: bold;
	color: #00642F;
}
.style3 {color: #00642D}
.style4 {
	font-size: 18px
}
.style5 {font-size: 10pt}

-->
</style>
</head>
<script language="javascript" type="text/javascript">
function testa_senha()
{
	if (document.login.senha.value != document.login.snh.value)
	{
		alert ("Campo senha contem senha inválida!")
		document.login.senha.focus();
	}
		else
	{
		document.getElementById('div_ok').innerHTML = "<img src='imagens/ok.png' width='15' height='15'  />";
	}


}

function valida_senha(campo)
{
	if (document.login.senha.value == document.login.novasenha.value)
	{
		alert("Nova senha não pode ser igual!");
		document.login.novasenha.focus();
	}
	
	if (document.login.novasenha.value.length < "6")
	{
		alert("Nova senha não pode ser menor que 6 digitos!");
		document.login.novasenha.focus();
	}
	
valor = campo.value;  
contemNumeros = /[0-9]/;  
contemLetras = /[a-z]/i;  
contemEspecial = /[@#$%&amp;amp;*]/;  
contagem = 0;  
mensagem = "";  
  
if ( valor.length > 0 ) 
{  
     if ( contemNumeros.test( valor ) ) contagem++;  
     if ( contemLetras.test( valor ) ) contagem++;  
     if ( contemEspecial.test( valor ) ) contagem++;  
   
     switch ( contagem ) 
    {  
         case 1: mensagem = "Senha Fraca!";  
            break;  
         case 2: mensagem = "Senha Boa!";  
            break;  
         case 3: mensagem = "Senha Excelente!";  
            break;  
         default: mensagem = "ops! o que aconteceu?";  
    }  
  
    document.getElementById('div_forca_senha').innerHTML = mensagem;  
}  

}


function verifica()
{

	if (document.login.matricula.value == "")
	{
		alert("Campo Matricula não pode ser vazio!");
		document.login.matricula.focus();
	}
	
	else
	{
		if (document.login.senha.value == "")
		{
			alert("Campo senha não pode ser vazio!");
			document.login.senha.focus();
		}
		else
		{
			if (document.login.novasenha.value == "")
			{
				alert("Campo nova senha não pode ser vazio!");
				document.login.novasenha.focus();
			}

			else
			{
					document.login.action='grava_senha.php';
					document.login.submit();	
			}	
		}
	}
		
}


</script>
<body>
<form name="login" method="post" >

<table width="980" border="0">
  <tr>
    <td width="990"><div align="center"><img src="imagens/logo_DPGE_fundo.jpg" alt="" width="170" height="116" /></div></td>
  </tr>
</table>
<table width="980" border="0">

<td width="980"><p align="center" class="style3 style4"><strong>Defensoria Pública Geral do Estado de Mato Grosso do Sul</strong></p>
    <p align="center" class="style22">SAP - Sistema de Automação de Petições </p>
    <p align="center" class="style2">&nbsp;</p></td>
</table>  

<p align="center" class="style2">Nova Senha</p>

<table width="533" border="0" align="center">
  <tr>
    <td width="234"><div align="right" class="style2 style5">Matricula:</div></td>
    <td colspan="2"><input name="matricula" type="text" id="matricula" class="texto" value="<?php echo "$login"?>" /> <input name="snh" type="hidden" id="snh" value="<?php echo "$senha"?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="234"><div align="right" class="opcoes">Senha:</div></td>
    <td width="144"><input name="senha" type="password" id="senha" class="texto" onblur="testa_senha()"/></td>
    <td width="141"><div id="div_ok"></div></td>
  </tr>
  <tr>
    <td width="234"><div align="right" class="opcoes">Nova Senha:</div></td>
    <td><input name="novasenha" type="password" id="novasenha" onblur="valida_senha(this)"/></td>
    <td><div class="senha" id="div_forca_senha"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="222" border="0" align="center">
  <tr>
    <td width="216"><div align="center">
      <input name="entrar" type="button" id="entrar" onclick="verifica();" value="Troca" class="botao"/>
    </div></td>
  </tr>
</table>


</form>
</body>
</html>
