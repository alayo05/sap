<?	ini_set('date.timezone','America/Campo_Grande'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
require_once("includes/dbcon.php");

function strtoupper_utf8($string){
	$string=utf8_decode($string);
	$string=strtoupper($string);
	//$string=utf8_encode($string);
	return $string;
}	

echo "Exemplo de como inserir novo usuário <br><br>";
echo "tp = 2(servidor), tp = 3(defensor)<br><br>";
echo "?tp=3&user=Gabriel Vieira&login=gabriel&psw=123456&nc=Gabriel Vieira Santos";

$idtp = $_GET['tp'];
$user = strtoupper_utf8($_GET['user']);
$login = $_GET['login'];
$psw = $_GET['psw'];
$nomecompleto = $_GET['nc'];

if($idtp != "" AND $user != "" AND $login != "" AND $psw != ""){ 
	$sql = "INSERT INTO usuarios(idTipoAcesso,nomeUsuario,login,senha,dataCadastro) VALUES($idtp,'$user','$login','".md5($psw)."','".date("Y-m-d")."')";	
	echo "<br>";

	$db->Execute($sql);	
	$id = $db->GetLastInsertID();
	$db->Commit();	
	
	$db->Execute("INSERT INTO dadosusuarios(idUsuario,idCidade,enderecamento,email,nomeCompleto) VALUES($id,1,'EXCELENTÍSSIMO SENHOR DOUTOR JUIZ DE DIREITO DA 1ª VARA CÍVEL','test@gmail.com','$nomecompleto')");
    $db->Commit();
}
	
?>
</body>
</html>