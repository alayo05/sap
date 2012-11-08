<?php 
	session_start();
	if($_SESSION['status'] != "logado"){		
		echo "<script>location.href='index.php';</script>"; 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

<script type="text/javascript">
function carregapage(){
	window.location = 'principal.php';
}
</script>

<body onLoad="javascript:setInterval('carregapage()',2000);">
<form name="login" method="post">

<table width="900" border="0" align="center">
  <tr>
    <td width="900">
		<div align="center">
			<img src="imagens/logo.jpg" alt="" width="170" height="116"/>
		</div>
	</td>
  </tr>
</table>

<table width="900" border="0" align="center">

<td width="900"><p align="center" class="style3 style4"><strong>Defensoria Pública Geral do Estado de Mato Grosso do Sul</strong></p>
    <p align="center" class="style22">DEFENSORIA</p>
    <p align="center" class="style22">SAP - Sistema de Automação de Petições</p>
    <p align="center" class="style2">&nbsp;</p></td>
</table>  

<table border="0" align="center">
  <tr>
	<td><div align="center" style="font-size:15px; vertical-align:middle; text-align:center; color:#006600;">
	  Login Efetuado ! Aguarde <img src="imagens/al_loading.gif">
	</div></td>
  </tr>
</table>

</form>
</body>
</html>
