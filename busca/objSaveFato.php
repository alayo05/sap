<? 
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	
	session_start();
	
	require_once("../includes/dbcon_obj.php");

	$idassis = $_POST['assis'];
	
	$fato = str_replace("nbsp"," ",$_POST['fato']);
	$fato = str_replace("<br>",PHP_EOL,$fato);
	$fato = str_replace("'","''",$fato);

	$sql = "UPDATE assistencias ";
	$sql = $sql . " SET fatonarrado='".$fato."' ";
	$sql = $sql . " WHERE idAssistencia=".$idassis;
	
	$db->Execute($sql);
	$db->Commit();
	
	echo htmlentities(utf8_decode($fato));
?>
