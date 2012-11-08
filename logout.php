
<?php
	
	session_start(); //iniciamos a sessão que foi aberta

	session_destroy(); //destruimos a sessão

	session_unset(); //limpamos as variaveis globais das sessão		
	
	require_once("config.php");	
		
	header("Location: http://".$url."/".$raiz."/");

?>		
