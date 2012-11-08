<?	
	echo "<script>
			function recarrega(){
				location.href='principal.php?pg=bp';
			}			
		  </script>";		  
		  
	if(isset($_POST['bt_cad_prov']) AND $_POST['bt_cad_prov'] == "Cadastrar"){
		
		$sql = "INSERT INTO providencias( ";		
		$sql = $sql . " nomeProvidencia ";
		$sql = $sql . " )VALUES( ";					
		$sql = $sql ."'".utf8_encode($_POST['nomeprovidencia'])."' ";
		$sql = $sql . " ) ";
		
		$db->Execute($sql);		
		$db->Commit();

		echo "<script>
				function setadivcad(){
					document.getElementById('frm_prov').style.display='none';
					document.getElementById('div_msg_cad').style.display='block';					
				}
				setTimeout('setadivcad()',0);
				
				setTimeout('recarrega()',1500);
			  </script>";			
?>
		<div id="div_msg_cad" class="msg_confirm" style="display:none;">Providência cadastrada com sucesso!</div>	
<?
	}
?>

<form id="frm_prov" name="frm_prov" method="post" onclick="" onSubmit="return VerificaProv()">
	<p class="titulo" style="text-align:center;">Cadastrar Providência</p>
	<div id="error_prov" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	
	<tr>
		<td align="right" style="padding-top:20px;"><label for="nomeprovidencia" class="label">Nome da Providência: </label></td>
		<td align="left" style="padding-top:20px;"><input type="text" class="text" id="nomeprovidencia" name="nomeprovidencia" value="" style="font-size:12px; width:250px;"/></td>
	</tr>	

	<tr>
		<td colspan="2" style="text-align:center; padding-top:40px;">
			<input type="submit" id="bt_cad_prov" name="bt_cad_prov" value="Cadastrar"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>
