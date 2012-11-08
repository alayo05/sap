<?	
	echo "<script>
			function recarrega(){
				location.href='principal.php';
			}			
		  </script>";		  
		  
	if(isset($_POST['bt_cad_prof']) AND $_POST['bt_cad_prof'] == "Cadastrar"){
		
		$sql = "INSERT INTO profissoes( ";		
		$sql = $sql . " nomeprofissao ";
		$sql = $sql . " )VALUES( ";					
		$sql = $sql ."'".utf8_encode($_POST['nomeprofissao'])."' ";
		$sql = $sql . " ) ";
		
		$db->Execute($sql);		
		$db->Commit();

		echo "<script>
				function setadivcad(){
					document.getElementById('frm_prof').style.display='none';
					document.getElementById('div_msg_cad').style.display='block';					
				}
				setTimeout('setadivcad()',0);
				
				setTimeout('recarrega()',1500);
			  </script>";			
?>
		<div id="div_msg_cad" class="msg_confirm" style="display:none;">Profissão cadastrada com sucesso!</div>	
<?
	}
?>

<form id="frm_prof" name="frm_prof" method="post" onclick="" onSubmit="return VerificaProf()">
	<p class="titulo" style="text-align:center;">Cadastrar Profissão</p>
	<div id="error_prof" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	
	<tr>
		<td align="right" style="padding-top:20px;"><label for="nomeprofissao" class="label">Nome da Profissão: </label></td>
		<td align="left" style="padding-top:20px;"><input type="text" class="text" id="nomeprofissao" name="nomeprofissao" value="" style="font-size:12px; width:250px;"/></td>
	</tr>	

	<tr>
		<td colspan="2" style="text-align:center; padding-top:40px;">
			<input type="submit" id="bt_cad_prof" name="bt_cad_prof" value="Cadastrar"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>
