<?php 
	session_start();
		
	if($_SESSION['status'] != "logado"){
		echo "<script>location.href='index.php';</script>"; 
	}	
	
	ini_set('date.timezone','America/Campo_Grande');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="SHORTCUT ICON" HREF="imagens/pena_mini.ico"> 
<title>SAP - Sistema de Automação de Petições</title>
</head>

<link href="includes/padrao_index.css" rel="stylesheet" type="text/css">
<link href="jquery/css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="includes/MascaraValidacao.js"></script>
<script language="javascript" src="includes/ajax.js"></script>
<script language="javascript" src="includes/functions.js"></script>	

<script src="jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="jquery/jquery-ui-1.8.20.custom.min.js" type="text/javascript"></script>


<?php 		
	require_once("includes/funcoes.php");
	require_once("includes/dbcon.php");
 ?>

<body class="no-js" onLoad="">
	<div id="geral">
		<div id="cabecalho">
			<div id="logo"></div>
			<h3>DEFENSORIA PÚBLICA GERAL DO ESTADO DE MATO GROSSO DO SUL</h3>
			<h3>SAP - Sistema de Automação de Petições</h3>
		</div>
		<div id="menu">	<?php include('menu.html'); ?> </div>		
		  
