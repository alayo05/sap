<?	
	if(!isset($_POST['codacao'])){
		header('Location: http://'.$url.'/'.$raiz);
	}

	echo "<script>
			function recarrega(){
				location.href='principal.php?pg=ba';
			}			
		  </script>";
		  
	if(isset($_POST['bt_edit_acao']) AND $_POST['bt_edit_acao'] == "Salvar"){
		
		$sql = "UPDATE acoes ";
		$sql = $sql." SET nomeAcao = '".utf8_encode($_POST['nomeacao'])."', ";		
		$sql = $sql." 	  idNucleo = ".$_POST['nucleoacao'].", ";		
		$sql = $sql." 	  statusAcao = ".$_POST['statusacao'];		
		$sql = $sql." WHERE idAcao = ".$_POST['codacao'];
	
		$db->Execute($sql);		
		$db->Commit();

		echo "<script>
				function setadivcad(){
					document.getElementById('frm_edit_acao').style.display='none';
					document.getElementById('div_msg_cad').style.display='block';					
				}
				setTimeout('setadivcad()',0);
				
				setTimeout('recarrega()',1500);
			  </script>";			
?>
		<div id="div_msg_cad" class="msg_confirm" style="display:none;">Ação editada com sucesso!</div>	
<?
	}
	
	$sql = "SELECT idAcao, idNucleo, nomeAcao, statusAcao ";	
	$sql = $sql . " FROM acoes ";
	$sql = $sql . " WHERE idAcao =".$_POST['codacao'];	
	
	$dt = $db->Execute($sql);		
	$dt->MoveNext();
?>

<form id="frm_edit_acao" name="frm_edit_acao" method="post" onclick="" onSubmit="return VerificaAcao()">
	<p class="titulo" style="text-align:center;">Editar Ação</p>
	<div id="error_acao" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	
	<tr>
		<td align="right" style="padding-top:20px;"><label for="nomeacao" class="label">Nome Ação: </label></td>
		<td align="left" style="padding-top:20px;"><input type="text" class="text" id="nomeacao" name="nomeacao" value="<?=utf8_decode($dt->nomeAcao)?>" style="font-size:12px; width:250px;"/></td>
	</tr>	

	<tr>
		<td align="right"><label for="nucleoacao" class="label" style="font-size:12px; margin-left:10px;">Núcleo da Ação: </label></td>
		<td align="left">					
			<select id="nucleoacao" name="nucleoacao" style="font-size:12px; margin-left:10px;">				
				<option value="">Selecione</option>
				<?
					$sql = "SELECT * FROM nucleos ";					
					$sql = $sql . " ORDER BY nomeNucleo ASC ";
					$dtN = $db->Execute($sql);    
					while($dtN->MoveNext()):?>
					<option value="<?=$dtN->idNucleo?>" <?=$dtN->idNucleo==$dt->idNucleo?"selected":""?>><?=utf8_decode($dtN->nomeNucleo)?></option>	
				<?	endwhile; ?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td align="right"><label for="statusacao" class="label" style="font-size:12px; margin-left:10px;">Status Ação: </label></td>
		<td align="left">					
			<select id="statusacao" name="statusacao" style="font-size:12px; margin-left:10px;">				
				<option value="1" <?=$dt->statusAcao==1?"selected":""?>>Ativado</option>
				<option value="0" <?=$dt->statusAcao==0?"selected":""?>>Desativado</option>
			</select>
		</td>
	</tr>
	
	<input type="hidden" id="codacao" name="codacao" value="<?=$_POST['codacao']?>"/>
	
	<tr>
		<td colspan="2" style="text-align:center; padding-top:40px;">
			<input type="submit" id="bt_edit_acao" name="bt_edit_acao" value="Salvar"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>
