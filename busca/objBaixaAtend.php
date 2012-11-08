<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
?>

<? 
	require_once("../includes/dbcon_obj.php");
	
	$idassis = $_POST['assis'];	
	
	$sql = "UPDATE assistencias ";
	$sql = $sql . " SET status='concluido', ";
	$sql = $sql . "		dataFim='".date('Y-m-d H:i:s')."' ";
	$sql = $sql . " WHERE idAssistencia=".$idassis;
	
	$db->Execute($sql);	
	$db->Commit();
	echo "sucesso";
?>