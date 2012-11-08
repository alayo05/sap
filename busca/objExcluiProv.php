<? 	
	require_once("../includes/dbcon_obj.php");

	$idprov = $_POST['idprov'];
	$acao = $_POST['acao'];
	
	if($acao == "excluir"){
		$sql = "SELECT idHistorico ";	
		$sql = $sql . " FROM historicoassistencia ";	
		$sql = $sql . " WHERE idProvidencia=".$idprov;	
		$dt = $db->Execute($sql);
		$tot = $dt->Count();
		
		if($tot == 0){	
			$sql = "DELETE FROM providencias ";	
			$sql = $sql . " WHERE idProvidencia=".$idprov;
			
			$db->Execute($sql);
			$db->Commit();	
		}else{
			echo "nao";
		}
	}else{
		$sql = "UPDATE providencias ";
		$sql = $sql . " SET statusProvidencia=0";
		$sql = $sql . " WHERE idProvidencia=".$idprov;
		
		$db->Execute($sql);
		$db->Commit();						
?>				
		<img title="Providência desativada" src="imagens/remove_fav_cinza.png"/>
<?	} ?>
