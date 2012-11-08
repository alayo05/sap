<? 
	session_start();
	
	require_once("../includes/dbcon_obj.php");

	$ndef = intval($_POST['ndef']);
	
	$sql = "SELECT count(h.idAssistencia) as total ";
	$sql = $sql . " FROM historicoassistencia h ";
	$sql = $sql . " WHERE h.idUsuario=".$ndef." AND h.dataAtendimento BETWEEN TIMESTAMP(CURDATE()) ";
	$sql = $sql . " AND TIMESTAMP(CURDATE(),MAKETIME(23,59,59)) ";	
	
	$dt = $db->Execute($sql);
	$dt->MoveNext();	
	
	echo $dt->total;
?>
