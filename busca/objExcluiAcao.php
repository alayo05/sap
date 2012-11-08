<? 	
	require_once("../includes/dbcon_obj.php");

	$idacao = $_POST['idacao'];
	$acao = $_POST['acao'];
	
	if($acao == "excluir"){
		$sql = "SELECT idAssistencia ";	
		$sql = $sql . " FROM assistencias ";	
		$sql = $sql . " WHERE idAcao=".$idacao;	
		$dt = $db->Execute($sql);
		$tot = $dt->Count();
		
		if($tot == 0){	
			$sql = "DELETE FROM acoes ";	
			$sql = $sql . " WHERE idAcao=".$idacao;
			
			$db->Execute($sql);
			$db->Commit();	
		}else{
			echo "nao";
		}
	}else{
		$sql = "UPDATE acoes ";
		$sql = $sql . " SET statusAcao=0";
		$sql = $sql . " WHERE idAcao=".$idacao;
		
		$db->Execute($sql);
		$db->Commit();						
?>				
		<img title="Ação desativada" src="imagens/remove_fav_cinza.png"/>
<?	} ?>
