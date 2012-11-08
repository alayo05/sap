<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAP - Painel</title>
</head>

<body>
<? 		
	require_once("../includes/dbcon_obj.php");
	
	$idaten = $_POST['idate'];
	$assis = $_POST['assis'];
	$defen = $_POST['defen'];	
	$acao = $_POST['acao'];
	$senha = $_POST['senha'];
	
	if($acao == "chamar"){
		$sqlP = "SELECT idPainel, senha  ";
		$sqlP = $sqlP . " FROM painelatendimento ";
		$sqlP = $sqlP . " WHERE idAssistencia=".$idaten." AND status='chamar' AND DATE_FORMAT(dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
		$dtP = $db->Execute($sqlP);   
		$dtP->MoveNext();	
	
		if($dtP->Count() == 0){						
			$sql = "INSERT INTO painelatendimento( ";
			$sql = $sql . " idAssistencia, ";
			$sql = $sql . " idAssistido, ";
			$sql = $sql . " idUsuario, ";
			$sql = $sql . " dataRegistro, ";
			$sql = $sql . " senha, ";
			$sql = $sql . " status ";
			$sql = $sql . " )VALUES( ";
			$sql = $sql . $idaten.",";
			$sql = $sql . $assis.",";
			$sql = $sql . $defen.",";
			$sql = $sql . "'".date('Y-m-d H:i:s')."',";
			$sql = $sql . "'".$senha."',";
			$sql = $sql . "'chamar'";
			$sql = $sql . " ) ";	
			
			$db->Execute($sql);	
			$db->Commit();			
		}else{
			if($dtP->senha != $senha){		
				$sql = "UPDATE painelatendimento ";
				$sql = $sql . " SET status='historico' ";
				$sql = $sql . " WHERE idPainel=".$dtP->idPainel; 

				$db->Execute($sql);	
				$db->Commit();							

				$sql = "INSERT INTO painelatendimento( ";
				$sql = $sql . " idAssistencia, ";
				$sql = $sql . " idAssistido, ";
				$sql = $sql . " idUsuario, ";
				$sql = $sql . " dataRegistro, ";
				$sql = $sql . " senha, ";
				$sql = $sql . " status ";
				$sql = $sql . " )VALUES( ";
				$sql = $sql . $idaten.",";
				$sql = $sql . $assis.",";
				$sql = $sql . $defen.",";
				$sql = $sql . "'".date('Y-m-d H:i:s')."',";
				$sql = $sql . "'".$senha."',";
				$sql = $sql . "'chamar'";
				$sql = $sql . " ) ";	
				
				$db->Execute($sql);	
				$db->Commit();	
				
				$midi = "toca";
				
				$sqlP = "SELECT p.idPainel, p.idAssistido, p.idUsuario, p.idAssistencia, a.nome, p.senha, a2.preferencial, d.nomeCompleto, d.sala  ";
				$sqlP = $sqlP . " FROM painelatendimento p ";
				$sqlP = $sqlP . " LEFT OUTER JOIN assistidos a ON p.idAssistido=a.idAssistido ";
				$sqlP = $sqlP . " LEFT OUTER JOIN dadosusuarios d ON p.idUsuario=d.idUsuario ";
				$sqlP = $sqlP . " LEFT OUTER JOIN assistencias a2 ON a2.idAssistencia=p.idAssistencia ";
				$sqlP = $sqlP . " WHERE p.status='chamar' AND DATE_FORMAT(p.dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
				$sqlP = $sqlP . " ORDER BY p.dataRegistro ASC ";
				
				$sqlP = $sqlP . " LIMIT 1 ";
				
				$dtP = $db->Execute($sqlP);   
				$dtP->MoveNext();	
?>
				<br>		
				<? if($dtP->Count() == 0){ ?>
						<p class="boasvindas_nomesuperior">BEM VINDOS(AS)</p>
						<p class="boasvindas_imagem"><img src="../imagens/logo_dpge_azul.png" width="250px"/></p>
						<p class="boasvindas_nomeinferior">DEFENSORIA <?=htmlentities("PÚBLICA")?></p>
						<input type="hidden" id="assispainel" name="assispainel" value="">
						<input type="hidden" id="defenpainel" name="defenpainel" value="">
						<input type="hidden" id="idassis_aux" name="idassis_aux" value="">
						<input type="hidden" id="idpainel" name="idpainel" value="">						
				<? }else{ ?>			
						<p class="nome">SENHA</p><br>
						<p class="numerosenha"><?=strtoupper(utf8_decode($dtP->senha))?></p>
						<input type="hidden" id="assispainel" name="assispainel" value="<?=$dtP->idAssistido?>">				
						<br>				
						<p class="defensor">SALA</p><br>
						<p class="salasenha"><?=$dtP->sala?></p>
						<span class="preferencial"><?=$dtP->preferencial=="sim"?"PREF.":""?></span>
						<input type="hidden" id="defenpainel" name="defenpainel" value="<?=$dtP->idUsuario?>">
						<input type="hidden" id="idassis_aux" name="idassis_aux" value="<?=$dtP->idAssistencia?>">
						<input type="hidden" id="idpainel" name="idpainel" value="<?=$dtP->idPainel?>">						
						<? if($midi == "toca"): ?>
						<embed src="../campainha.wav" loop="0" autostart="true" volume="300" hidden="true">						
						<? endif; ?>
				<? } ?>
				<p class="rodape"><?=date("d/m/Y H:i")?></p>						
<?			}
		}
	}else{	
	
		$sqlP = "SELECT p.idPainel, p.idAssistido, p.idUsuario, p.idAssistencia, a.nome, p.senha, a2.preferencial, d.nomeCompleto, d.sala  ";
		$sqlP = $sqlP . " FROM painelatendimento p ";
		$sqlP = $sqlP . " LEFT OUTER JOIN assistidos a ON p.idAssistido=a.idAssistido ";
		$sqlP = $sqlP . " LEFT OUTER JOIN dadosusuarios d ON p.idUsuario=d.idUsuario ";
		$sqlP = $sqlP . " LEFT OUTER JOIN assistencias a2 ON a2.idAssistencia=p.idAssistencia ";
		$sqlP = $sqlP . " WHERE p.status='chamar' AND DATE_FORMAT(p.dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
		$sqlP = $sqlP . " ORDER BY p.dataRegistro ASC ";
		
		$dtPc = $db->Execute($sqlP);   
		$dtPc->MoveNext();
		
		$midi = "naotoca";
		if($acao != "" AND $dtPc->Count() > 1){
			$sql = "UPDATE painelatendimento ";
			$sql = $sql . " SET status='historico' ";
			$sql = $sql . " WHERE idPainel=".$acao; 

			$db->Execute($sql);	
			$db->Commit();
			$midi = "toca";
		}
		if($dtPc->Count() >= 1 AND $acao == ""){
			$midi = "toca";
		}
	
		$sqlP = $sqlP . " LIMIT 1 ";
		
		$dtP = $db->Execute($sqlP);   
		$dtP->MoveNext();
	?>
		<br>		
		<? if($dtP->Count() == 0){ ?>
				<p class="boasvindas_nomesuperior">BEM VINDOS(AS)</p>
				<p class="boasvindas_imagem"><img src="../imagens/logo_dpge_azul.png" width="250px"/></p>
				<p class="boasvindas_nomeinferior">DEFENSORIA <?=htmlentities("PÚBLICA")?></p>
				<input type="hidden" id="assispainel" name="assispainel" value="">
				<input type="hidden" id="defenpainel" name="defenpainel" value="">
				<input type="hidden" id="idassis_aux" name="idassis_aux" value="">
				<input type="hidden" id="idpainel" name="idpainel" value="">						
		<? }else{ ?>			
				<p class="nome">SENHA</p><br>
				<p class="numerosenha"><?=strtoupper(utf8_decode($dtP->senha))?></p>
				<input type="hidden" id="assispainel" name="assispainel" value="<?=$dtP->idAssistido?>">				
				<br>				
				<p class="defensor">SALA</p><br>
				<p class="salasenha"><?=$dtP->sala?></p>
				<span class="preferencial"><?=$dtP->preferencial=="sim"?"PREF.":""?></span>
				<input type="hidden" id="defenpainel" name="defenpainel" value="<?=$dtP->idUsuario?>">
				<input type="hidden" id="idassis_aux" name="idassis_aux" value="<?=$dtP->idAssistencia?>">
				<input type="hidden" id="idpainel" name="idpainel" value="<?=$dtP->idPainel?>">						
				<? if($midi == "toca"): ?>
				<embed src="../campainha.wav" loop="0" autostart="true" volume="300" hidden="true">						
				<? endif; ?>
		<? } ?>
		<p class="rodape"><?=date("d/m/Y H:i")?></p>		
<? } ?>

</body>
</html>