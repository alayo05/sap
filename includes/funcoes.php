<?php

function escapestrings($b){
	if (!get_magic_quotes_gpc()) //se magic_quotes n�o estiver ativado, escapa a string
	{
		return mysql_escape_string($b); // fun��o nativa do php para escapar vari�veis
	}
	else // caso contrario
	{
		return $b; // retorna a vari�vel sem necessidade de escapar duas vezes
	}
}

function strtoupper_utf8($string){
	$string=utf8_decode($string);
	$string=strtoupper($string);
	//$string=utf8_encode($string);
	return $string;
}

?>