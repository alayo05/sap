<?php

function escapestrings($b){
	if (!get_magic_quotes_gpc()) //se magic_quotes nуo estiver ativado, escapa a string
	{
		return mysql_escape_string($b); // funчуo nativa do php para escapar variсveis
	}
	else // caso contrario
	{
		return $b; // retorna a variсvel sem necessidade de escapar duas vezes
	}
}

function strtoupper_utf8($string){
	$string=utf8_decode($string);
	$string=strtoupper($string);
	//$string=utf8_encode($string);
	return $string;
}

?>