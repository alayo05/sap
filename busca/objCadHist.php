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
	$sql = $sql . " 	assessorVinculado=".$_SESSION['idUser'].", ";
	$sql = $sql . " 	status='aberto' ";
	$sql = $sql . " WHERE idAssistencia=".$idassis;
	
	$db->Execute($sql);	
	$db->Commit();
	$dataagora = date('Y-m-d H:i:s');	
	if($idh == ""){				//NAO USADA MAIS
		$sql = "INSERT INTO historicoassistencia( ";
		$sql = $sql . " idAssistencia, ";
		$sql = $sql . " idUsuario, ";
		$sql = $sql . " idProvidencia, ";
		$sql = $sql . " descricao, ";
		$sql = $sql . " dataCadastro ";
		$sql = $sql . " )VALUES( ";
		$sql = $sql . $idassis.",";
		$sql = $sql . $_SESSION['idUser'].",";
		$sql = $sql . $idp.",";
		$sql = $sql . "'".$desc."',";
		$sql = $sql . "'".$dataagora."'";
		$sql = $sql . " ) ";		
	}else{
		$sql = "UPDATE historicoassistencia ";
		$sql = $sql . " SET descricao='".$desc."', ";
		$sql = $sql . " 	idProvidencia=".$idp.", ";
		$sql = $sql . " 	assessorVinculado=".$_SESSION['idUser'].", ";
		$sql = $sql . " 	dataCadastro='".$dataagora."'";
		$sql = $sql . " WHERE idHistorico=".$idh;		
	}	
	$db->Execute($sql);		
	$db->Commit();	
	
	/*$sql = "SELECT h.descricao, h.idUsuario, u.nomeUsuario, DATE_FORMAT(h.dataCadastro,'%d/%m/%Y %H:%i:%s') as dataCadastro FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia  ";
	$sql = $sql . " LEFT OUTER JOIN usuarios u ON h.idUsuario=u.idUsuario ";
	$sql = $sql . " WHERE h.idAssistencia=".$idassis;	
	$sql = $sql . " ORDER BY h.dataCadastro DESC ";		
	
	$dt = $db->Execute($sql);    	*/
?>

<!--<table class="classtable">
<? // while($dt->MoveNext()): ?>
<tr>
	<td align="left" style="padding:8px 0px; text-align: justify; padding-left:5px; width:280px;"><?=$dt->descricao?></td>
	<td align="center" style="width:57px; padding: 8px;"><?=ucwords($dt->nomeUsuario)?></td>
	<td align="left" style="width:147px;"><?=$dt->dataCadastro?></td>
</tr>		
<? // endwhile; ?>
</table>-->