<style>
	<!--[if !lt IE 6]>
	.classtable{
		width:97%;
	}
	<![endif]-->
	.classtable{
		width:100%;
	}
</style>
<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
	
	session_start();
	
	require_once("../includes/dbcon_obj.php");
	
	$ida = $_POST['ida'];
	$ide = $_POST['ide'];

	$dataagora = date('Y-m-d H:i:s');
	/**** Registra Assistência ****/
	$sql = "INSERT INTO assistencias( ";
	$sql = $sql . " idAssistido, ";
	$sql = $sql . " idUsuario, ";
	$sql = $sql . " dataInicio, ";
	$sql = $sql . " dataAtendimento, ";
	$sql = $sql . " preferencial, ";
	$sql = $sql . " status ";
	$sql = $sql . " )VALUES( ";			
	$sql = $sql . $ida.",";
	$sql = $sql . $ide.",";
	$sql = $sql ."'".$dataagora."',";
	$sql = $sql ."'".$dataagora."',";
	$sql = $sql ."'nao',";
	$sql = $sql ."'aberto'";
	$sql = $sql . " ) ";
	
	$db->Execute($sql);
	$idAssistencia = $db->GetLastInsertID();
	$db->Commit();
	
	/**** Registra Histórico da Assistência ****/
	$sql = "INSERT INTO HistoricoAssistencia( ";
	$sql = $sql . " idAssistencia, ";
	$sql = $sql . " idUsuario, ";
	$sql = $sql . " dataAtendimento, ";
	$sql = $sql . " idusercad, ";
	$sql = $sql . " preferencial ";	
	$sql = $sql . " )VALUES( ";			
	$sql = $sql . $idAssistencia.",";
	$sql = $sql . $ide.",";
	$sql = $sql ."'".$dataagora."', ";
	$sql = $sql . $_SESSION['idUser'].",";
	$sql = $sql ."'nao' ";
	$sql = $sql . " ) ";
	
	$db->Execute($sql);			
	$db->Commit();	
	
?>