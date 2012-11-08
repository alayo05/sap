<?	
	echo "<script>
			function recarrega(){
				location.href='principal.php?pg=ba';
			}			
		  </script>";		  
		  
	if(isset($_POST['bt_cad_acao']) AND $_POST['bt_cad_acao'] == "Cadastrar"){
		
		$sql = "INSERT INTO acoes( ";		
		$sql = $sql . " nomeAcao, ";
		$sql = $sql . " idNucleo ";
		$sql = $sql . " )VALUES( ";					
		$sql = $sql ."'".utf8_encode($_POST['nomeacao'])."', ";
		$sql = $sql .$_POST['nucleoacao'];
		$sql = $sql . " ) ";
		
		$db->Execute($sql);		
		$db->Commit();

		echo "<script>
				function setadivcad(){
					document.getElementById('frm_acao').style.display='none';
					document.getElementById('div_msg_cad').style.display='block';					
				}
				setTimeout('setadivcad()',0);
				
				setTimeout('recarrega()',1500);
			  </script>";			
?>
		<div id="div_msg_cad" class="msg_confirm" style="display:none;">Ação cadastrada com sucesso!</div>	
<?
	}
?>

<form id="frm_acao" name="frm_acao" method="post" onclick="" onSubmit="return VerificaAcao()">
	<p class="titulo" style="text-align:center;">Cadastrar Ação</p>
	<div id="error_acao" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	
	<tr>
		<td align="right" style="padding-top:20px;"><label for="nomeacao" class="label">Nome da Ação: </label></td>
		<td align="left" style="padding-top:20px;"><input type="text" class="text" id="nomeacao" name="nomeacao" value="" style="font-size:12px; width:250px;"/></td>
	</tr>	

	<tr>
		<td align="right"><label for="nucleoacao" class="label" style="font-size:12px; margin-left:10px;">Núcleo da Ação: </label></td>
		<td align="left">					
			<select id="nucleoacao" name="nucleoacao" style="font-size:12px; margin-left:10px;">				
				<option value="">Selecione</option>
				<?
					$sql = "SELECT * FROM nucleos ";					
					$sql = $sql . " ORDER BY nomeNucleo ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idNucleo?>"><?=utf8_decode($dt->nomeNucleo)?></option>	
				<?	endwhile; ?>
			</select>
		</td>
	</tr>	

	<tr>
		<td colspan="2" style="text-align:center; padding-top:40px;">
			<input type="submit" id="bt_cad_acao" name="bt_cad_acao" value="Cadastrar"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>
