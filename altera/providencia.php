<?	
	if(!isset($_POST['codprovidencia'])){
		header('Location: http://'.$url.'/'.$raiz);
	}

	echo "<script>
			function recarrega(){
				location.href='principal.php?pg=bp';
			}			
		  </script>";
		  
	if(isset($_POST['bt_edit_prov']) AND $_POST['bt_edit_prov'] == "Salvar"){
		
		$sql = "UPDATE providencias ";
		$sql = $sql." SET nomeProvidencia = '".utf8_encode($_POST['nomeprovidencia'])."', ";		
		$sql = $sql." 	  statusProvidencia = ".$_POST['statusprov'];		
		$sql = $sql." WHERE idProvidencia = ".$_POST['codprovidencia'];
	
		$db->Execute($sql);		
		$db->Commit();

		echo "<script>
				function setadivcad(){
					document.getElementById('frm_edit_prov').style.display='none';
					document.getElementById('div_msg_cad').style.display='block';					
				}
				setTimeout('setadivcad()',0);
				
				setTimeout('recarrega()',1500);
			  </script>";			
?>
		<div id="div_msg_cad" class="msg_confirm" style="display:none;">Providência editada com sucesso!</div>	
<?
	}
	
	$sql = "SELECT idProvidencia, nomeProvidencia, statusProvidencia ";	
	$sql = $sql . " FROM providencias ";
	$sql = $sql . " WHERE idProvidencia =".$_POST['codprovidencia'];	
	
	$dt = $db->Execute($sql);		
	$dt->MoveNext();
?>

<form id="frm_edit_prov" name="frm_edit_prov" method="post" onclick="" onSubmit="return VerificaProv()">
	<p class="titulo" style="text-align:center;">Editar Providência</p>
	<div id="error_prov" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	
	<tr>
		<td align="right" style="padding-top:20px;"><label for="nomeprovidencia" class="label">Nome Providência: </label></td>
		<td align="left" style="padding-top:20px;"><input type="text" class="text" id="nomeprovidencia" name="nomeprovidencia" value="<?=utf8_decode($dt->nomeProvidencia)?>" style="font-size:12px; width:250px;"/></td>
	</tr>	
	
	<tr>
		<td align="right"><label for="statusprov" class="label" style="font-size:12px; margin-left:10px;">Status Providência: </label></td>
		<td align="left">					
			<select id="statusprov" name="statusprov" style="font-size:12px; margin-left:10px;">				
				<option value="1" <?=$dt->statusProvidencia==1?"selected":""?>>Ativado</option>
				<option value="0" <?=$dt->statusProvidencia==0?"selected":""?>>Desativado</option>
			</select>
		</td>
	</tr>
	
	<input type="hidden" id="codprovidencia" name="codprovidencia" value="<?=$_POST['codprovidencia']?>"/>
	
	<tr>
		<td colspan="2" style="text-align:center; padding-top:40px;">
			<input type="submit" id="bt_edit_prov" name="bt_edit_prov" value="Salvar"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>
