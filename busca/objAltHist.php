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
	
	$idassis = $_POST['assis'];
	$idp = $_POST['idp'];
	$idacao = $_POST['idacao'];
	$idh = $_POST['idh'];
	
	$sqlP = "SELECT nomeProvidencia  ";
	$sqlP = $sqlP . " FROM providencias ";
	$sqlP = $sqlP . " WHERE idProvidencia=".$idp;
	$dtP = $db->Execute($sqlP);   
	$dtP->MoveNext();
	
	/*** se providência igual "Ação Ajuizada" ***/
	//if($idp == 3 AND $desc == ""){
		$desc = $dtP->nomeProvidencia;
	/*}else{
		$desc = str_replace("nbsp"," ",$_POST['desc']);
		$desc = str_replace("<br>",PHP_EOL,$desc);
		$desc = str_replace("'","''",$desc);		
	}*/


	$sql = "UPDATE assistencias ";
	$sql = $sql . " SET idProvidencia=".$idp.", ";
	$sql = $sql . " 	idAcao=".$idacao.", ";
	$sql = $sql . " 	assessorVinculado=".$_SESSION['idUser']." ";
	$sql = $sql . " WHERE idAssistencia=".$idassis;
	
	$db->Execute($sql);	
	$db->Commit();
	$dataagora = date('Y-m-d H:i:s');	

	$sql = "UPDATE historicoassistencia ";
	$sql = $sql . " SET descricao='".$desc."', ";
	$sql = $sql . " 	idProvidencia=".$idp.", ";
	$sql = $sql . " 	assessorVinculado=".$_SESSION['idUser'].", ";
	$sql = $sql . " 	dataCadastro='".$dataagora."'";
	$sql = $sql . " WHERE idHistorico=".$idh;		
	
	$db->Execute($sql);		
	$db->Commit();	

?>
