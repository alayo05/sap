<?	
	echo "<script>
			function recarrega(){
				location.href='principal.php';
			}			
		  </script>";		  
		  
	if(isset($_POST['bt_cad_usuario']) AND $_POST['bt_cad_usuario'] == "Salvar"){
		if(isset($_POST['iddadosuser']) AND $_POST['iddadosuser'] != ""){
			$sql = "UPDATE dadosusuarios ";
			$sql = $sql." SET nomeCompleto = '".utf8_encode($_POST['nomecompleto'])."',";		
			$sql = $sql."	  idCidade = ".$_POST['cid_usuario'].",";			
			$sql = $sql."	  email = '".$_POST['email']."',";			
			$sql = $sql."	  sala = '".utf8_encode($_POST['sala'])."' ";			
			$sql = $sql." WHERE idDadosUsuario = ".$_POST['iddadosuser'];
			
			$db->Execute($sql);	
			$db->Commit();
		}
		
		$sql = "UPDATE usuarios ";
		$sql = $sql." SET nomeUsuario = '".utf8_encode($_POST['nomeusuario'])."' ";
		if(isset($_POST['iddadosuser']) AND $_POST['iddadosuser'] != ""){
			$sql = $sql."	  ,defensorVinculado = ".$_POST['defensorvinc'];	
		}
		if($_POST['senhaantiga'] != "" AND $_POST['senhanova'] != "" AND $_POST['confirmesenha'] != ""):
			$sql = $sql."	  ,senha = '".md5($_POST['senhanova'])."'";	
		endif;		
		$sql = $sql." WHERE idUsuario = ".$_POST['pegaiduser'];
		if($_POST['senhaantiga'] != "" AND $_POST['senhanova'] != "" AND $_POST['confirmesenha'] != ""):
			$sql = $sql." AND  senha = '".md5($_POST['senhaantiga'])."' ";	
		endif;
		
		$db->Execute($sql);		
		$db->Commit();	  
?>		
		<div id="div_msg" class="msg_confirm" style="display:none;">Usuário alterado com sucesso!</div>	
<?	}else{
		if(isset($_POST['bt_cad_usuario']) AND $_POST['bt_cad_usuario'] == "Cadastrar"){
			$dataagora = date('Y-m-d H:i:s');
			$sql = "INSERT INTO usuarios( ";
			$sql = $sql . " idTipoAcesso, ";
			$sql = $sql . " nomeUsuario, ";
			$sql = $sql . " login, ";
			$sql = $sql . " senha, ";
			$sql = $sql . " defensorVinculado, ";
			$sql = $sql . " dataCadastro ";
			$sql = $sql . " )VALUES( ";			
			$sql = $sql . $_POST['tpusuario'].",";
			$sql = $sql ."'".utf8_encode($_POST['nomeusuario'])."', ";
			$sql = $sql ."'".$_POST['login']."',";
			$sql = $sql ."'".md5($_POST['senhanova'])."',";
			$sql = $sql .$_POST['defensorvinc'].",";
			$sql = $sql ."'".$dataagora."' ";
			$sql = $sql . " ) ";
			
			$db->Execute($sql);
			$idAssistencia = $db->GetLastInsertID();
			$db->Commit();
			
			/** SE TIPO DE USUARIO DEFENSOR ENTAO INSERE DADOS **/
			if($_POST['tpusuario'] >= 3){
				$sql = "INSERT INTO dadosusuarios( ";
				$sql = $sql . " idUsuario, ";
				$sql = $sql . " idCidade, ";				
				$sql = $sql . " email, ";
				$sql = $sql . " nomeCompleto, ";			
				$sql = $sql . " sala ";
				$sql = $sql . " )VALUES( ";			
				$sql = $sql . $idAssistencia.",";
				$sql = $sql . $_POST['cid_usuario'].",";				
				$sql = $sql ."'".$_POST['email']."',";
				$sql = $sql ."'".utf8_encode($_POST['nomecompleto'])."',";
				$sql = $sql ."'".utf8_encode($_POST['sala'])."' ";			
				$sql = $sql . " ) ";
				$db->Execute($sql);
				$db->Commit();
			}		
?>
			<div id="div_msg_cad" class="msg_confirm" style="display:none;">Usuário cadastrado com sucesso!</div>	
<?
		}
	}
	
	if((isset($_SESSION['valdp']) AND $_SESSION['valdp'] == "dp1") OR (isset($_POST['codusuario']) AND $_POST['codusuario'] != "")){
		$pegaiduser = (isset($_POST['codusuario']) AND $_POST['codusuario']!= "")?$_POST['codusuario']:$_SESSION['idUser'];

		$sql = "SELECT u.idUsuario, u.nomeUsuario, u.login, u.idTipoAcesso ";	
		$sql = $sql . " FROM usuarios u ";
		$sql = $sql . " WHERE u.idUsuario = ".$pegaiduser;
		$dtD = $db->Execute($sql);    				
		$dtD->MoveNext();
		
		if($dtD->idTipoAcesso >= 3){
			$showdefe = "display:;";
			$shownomecompleto = "display:;";
			
			$sql = "SELECT  d.idDadosUsuario, ";
			$sql = $sql . " d.idCidade, ";
			$sql = $sql . " c.idEstado, ";			
			$sql = $sql . " d.email, ";
			$sql = $sql . " d.nomeCompleto, ";
			$sql = $sql . " d.sala, ";		
			$sql = $sql . " u.idTipoAcesso, ";		
			$sql = $sql . " u.defensorVinculado, ";		
			$sql = $sql . " u.nomeUsuario, ";
			$sql = $sql . " u.login, ";
			$sql = $sql . " u.senha, ";		
			$sql = $sql . " c.nomeCidade ";
			$sql = $sql . " FROM dadosusuarios d left outer join cidades c on d.idCidade=c.idCidade ";
			$sql = $sql . " 					 left outer join usuarios u on d.idUsuario=u.idUsuario ";
			$sql = $sql . " WHERE d.idUsuario =".$pegaiduser;		
			
			$dtD = $db->Execute($sql);    				
			$dtD->MoveNext();
			
			$varidDadosu = $dtD->idDadosUsuario;
			$varidCid = $dtD->idCidade;
			$varidEst = $dtD->idEstado;
			$varVincDef = $dtD->defensorVinculado;
			$varEmail = $dtD->email;
			$varNomeComp = utf8_decode($dtD->nomeCompleto);
			$varSala = utf8_decode($dtD->sala);
			$varnomeUser = utf8_decode($dtD->nomeUsuario);
			$varLogin = $dtD->login;
			$varSenha = $dtD->senha;
			$varnomeCid = $dtD->nomeCidade;			
		}else{
			$showdefe = "display:none;";			
			$shownomecompleto = "display:none;";

			$varidDadosu = "";
			$varidCid = "";
			$varidEst = "";
			$varVincDef = "";
			$varEmail = "";
			$varNomeComp = "";
			$varSala = "";			
			$varnomeUser = utf8_decode($dtD->nomeUsuario);
			$varLogin = $dtD->login;
			$varSenha = "";
			$varnomeCid = "";				
		}
		$idtipoaccess = $dtD->idTipoAcesso;
		$tpacao = "Editar";
		$bt_form_assis = "Salvar";	
	}else{
		if(isset($_SESSION['valdp']) AND $_SESSION['valdp'] == "dp2"){	
			$tpacao = "Cadastrar Usuário";
			$bt_form_assis = "Cadastrar";
			$idtipoaccess = 5;
			$varidDadosu = "";
			$varVincDef = "";
			$varidCid = 4079;
			$varidEst = 12;
			
		}
	}
	
if((isset($_SESSION['valdp']) AND $_SESSION['valdp'] != "dp3") OR (isset($_POST['codusuario']) AND $_POST['codusuario'] != "")){
	$pegaiduser = (isset($_POST['codusuario']) AND $_POST['codusuario']!= "")?$_POST['codusuario']:$_SESSION['idUser'];
?>

<form id="frm_dados_pessoais" name="frm_dados_pessoais" method="post" onclick="" onSubmit="return VerificaDP()">
	<p class="titulo" style="text-align:center;"><?=$tpacao?></p>
	<div id="error" class="error"></div>
	
	<table cellpadding="4" style="margin:auto;">
	<tbody width="margin:auto; text-align:center;">
	<tr>
		<td align="right"><label for="tpusuario" class="label" style="font-size:12px; margin-left:10px;">Tipo de Usuário: </label></td>
		<td align="left">					
			<select id="tpusuario" name="tpusuario" onchange="alteratipoacesso(this)" style="font-size:12px; margin-left:10px;">				
				<?
					$sql = "SELECT * FROM tipoacesso ";					
					$sql = $sql . " ORDER BY idTipoAcesso ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idTipoAcesso?>" <?=$dt->idTipoAcesso==$idtipoaccess?"selected":""?> ><?=$dt->nome?></option>	
				<?	endwhile; ?>
			</select>
		</td>
	</tr>

	
	<? if(isset($_SESSION['valdp']) AND $_SESSION['valdp'] == "dp1"){
			$nomesenha = "Senha Nova";
			$readonly = "readonly";
	   }else{
			$nomesenha = "Senha";			
			if(isset($_POST['codusuario']) AND $_POST['codusuario'] != ""){
				$readonly = "readonly";
			}else{
				$readonly = "";
			}
	   }?>
	   
    <input type="hidden" id="iddadosuser" name="iddadosuser" value="<?=$varidDadosu?>">
	<input type="hidden" id="pegaiduser" name="pegaiduser" value="<?=$pegaiduser?>">
	
	
	<tr id="shownomecompleto" style="margin:auto; <?=$shownomecompleto?> text-align:center;">
		<td align="right"><label for="nomecompleto" class="label">Nome Completo: </label></td>
		<td align="left"><input type="text" class="text" id="nomecompleto" name="nomecompleto" value="<?=$varNomeComp?>" size="60" style="font-size:12px; width:97%"/></td>
	</tr>
	
	<tr>
		<td align="right"><label for="nomeusuario" class="label">Nome Usuário: </label></td>
		<td align="left"><input type="text" class="text" id="nomeusuario" name="nomeusuario" value="<?=$varnomeUser?>" style="font-size:12px; width:97%"/></td>
	</tr>
	
	<tbody id="showdefe" style="margin:auto; <?=$showdefe?> text-align:center;">
	<tr>
		<td align="right"><label for="uf_usuario" class="label" style="font-size:12px; margin-left:10px;">UF:</label></td>
		<td align="left">					
			<select id="uf_usuario" name="uf_usuario" onchange="changeCidadeUser(this.value)" style="font-size:12px; margin-left:10px;">				
				<?
					$sql = "SELECT * FROM estados ";					
					$sql = $sql . " ORDER BY sigla ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idEstado?>" <?=($varidEst==$dt->idEstado)?"selected":""?>><?=$dt->sigla?></option>	
				<?	endwhile; ?>
			</select>
		
			<label for="cid_usuario" class="label" style="margin-left:20px;">Cidade: </label>
		
			<div id="div_showcid" style="display:inline;">
			<select id="cid_usuario" name="cid_usuario" style="font-size:12px; margin-left:10px;">
				<option value="">Selecione</option>
				<?				
					$sql = "SELECT * FROM cidades ";
					
					if($_SESSION['valdp'] == "dp1" OR ($varidEst != "" AND $varidEst != 0)){
						if($pegaiduser != ""){						
							$sql = $sql . " WHERE idEstado=".$varidEst;
						}
					}
					$sql = $sql . " ORDER BY nomeCidade ASC ";
					//echo "<script>alert('".$pegaiduser."')</script>";
					$dt = $db->Execute($sql);    
					
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idCidade?>" <?=$varidCid==$dt->idCidade?"selected":""?>><?=utf8_decode($dt->nomeCidade)?></option>	
				<?	endwhile; ?>
			</select>
			</div>
		</td>
	</tr>	
	<tr>
		<td align="right"><label for="defensorvinc" class="label">Defensor(a) Vinculado: </label></td>
		<td align="left">
			<select id="defensorvinc" name="defensorvinc" style="font-size:12px; margin-left:10px;">				
				<option value="0">Selecione</option>
				<?
					$sql = "SELECT * FROM usuarios ";
					$sql = $sql . " WHERE idTipoAcesso = 4 OR idTipoAcesso = 5 ";					
					$sql = $sql . " ORDER BY nomeUsuario ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idUsuario?>" <?=$dt->idUsuario==$varVincDef?"selected":""?> ><?=htmlentities(strtoupper(utf8_decode($dt->nomeUsuario)))?></option>	
				<?	endwhile; ?>
			</select>
		</td>
	</tr>	
	<tr>
		<td align="right"><label for="email" class="label">Email: </label></td>
		<td align="left"><input type="text" class="text" id="email" name="email" value="<?=$varEmail?>" style="font-size:12px; width:97%"/></td>
	</tr>
	<tr>
		<td align="right"><label for="sala" class="label">Sala: </label></td>
		<td align="left"><input type="text" class="text" id="sala" name="sala" value="<?=$varSala?>" style="font-size:12px; width:97%"/></td>
	</tr>
	</tbody>

	<tbody style="margin:auto; display:; text-align:center;">
	<tr><td colspan="2" style="padding:10px 0px;"><hr color="#C0C0C0"/></td></tr>
	<tr>
		<td align="right"><label for="login" class="label">Login: </label></td>
		<td align="left"><input type="text" class="text" id="login" name="login" <?=$readonly?> value="<?=$varLogin?>" style="width:120px; font-size:12px;"/></td>
	</tr>
	<? if((isset($_SESSION['valdp']) AND $_SESSION['valdp'] == "dp1") OR (isset($_POST['codusuario']) AND $_POST['codusuario'] != "")){			
	?>
	<tr>
		<td align="right"><label for="senhaantiga" class="label">Senha Antiga: </label></td>
		<td align="left"><input type="password" class="text" id="senhaantiga" name="senhaantiga" value="" style="font-size:12px; width:120px;"/></td>
	</tr>
	<? 		
		}?>
	<tr>
		<td align="right"><label for="senhanova" class="label"><?=$nomesenha?> </label></td>
		<td align="left"><input type="password" class="text" id="senhanova" name="senhanova" value="" style="font-size:12px; width:120px;"/></td>
	</tr>
	<tr>
		<td align="right"><label for="confirmesenha" class="label">Confirme Senha: </label></td>
		<td align="left"><input type="password" class="text" id="confirmesenha" name="confirmesenha" value="" style="font-size:12px; width:120px;"/></td>
	</tr>	
	<tr>
		<td colspan="2" style="text-align:center; padding-top:25px;">
			<input type="submit" id="bt_cad_usuario" name="bt_cad_usuario" value="<?=$bt_form_assis?>"/>
		</td>
	</tr>
	</tbody>
	</table>
<form>

<?
	if(isset($_POST['bt_cad_usuario']) AND $_POST['bt_cad_usuario'] == "Salvar"){
		echo "<script>
				function setadiv(){
					document.getElementById('frm_dados_pessoais').style.display='none';
					document.getElementById('div_msg').style.display='block';					
				}
				
				setTimeout('setadiv()',0);				
			  </script>";		
			  
		if($_SESSION['valdp'] != "dp3"){
			echo "<script> setTimeout('recarrega()',2000); </script>";
		}		
	}else{	
		if(isset($_POST['bt_cad_usuario']) AND $_POST['bt_cad_usuario'] == "Cadastrar"){	
			echo "<script>
					function setadivcad(){
						document.getElementById('frm_dados_pessoais').style.display='none';
						document.getElementById('div_msg_cad').style.display='block';					
					}
					setTimeout('setadivcad()',0);
					
					setTimeout('recarrega()',2000);
				  </script>";
		}
	}
		
}else{?>

<form id="frm_usuarios" name="frm_usuarios" method="post" action="" style="margin:auto; text-align:center;">
<p class="titulo" style="margin-top:0px; margin-bottom:25px;">Editar Usuário</p>
<table cellpadding="3" style="margin:auto;">
	<thead>
	<tr>
		<th width="200px">Nome Usuário</th>
		<th width="150px">Login</th>
		<th width="110px">Tipo de Acesso</th>		
	</tr>
	</thead>	
	<tbody>
<?	
	$recordPerPage = 12;
	
	$sql = "SELECT u.idUsuario ";	
	$sql = $sql . " FROM usuarios u ";
	$sql = $sql . " LEFT OUTER JOIN tipoacesso t ON t.idTipoAcesso=u.idTipoAcesso ";
	if($_SESSION['idnivel'] >= 6){
		$sql = $sql . " WHERE u.idTipoAcesso < 6 ";	
	}else{
		if($_SESSION['idnivel'] < 6){
			$sql = $sql . " WHERE u.idTipoAcesso < 6 ";	
		}
	}
	$sql = $sql . " ORDER BY nomeUsuario ASC ";

	$dt = $db->Execute($sql);    	
	$total = $dt->Count();
	
	$sql = "SELECT u.idUsuario, u.nomeUsuario, u.login, t.nome as tpacesso ";	
	$sql = $sql . " FROM usuarios u ";
	$sql = $sql . " LEFT OUTER JOIN tipoacesso t ON t.idTipoAcesso=u.idTipoAcesso ";
	if($_SESSION['idnivel'] >= 6){
		$sql = $sql . " WHERE u.idTipoAcesso < 6 ";	
	}else{
		if($_SESSION['idnivel'] < 6){
			$sql = $sql . " WHERE u.idTipoAcesso < 6 ";	
		}
	}
	$sql = $sql . " ORDER BY nomeUsuario ASC ";
	
	/** Paginação **/
	$npage = intval($_POST['page']);
	$maxpage = ceil($total/$recordPerPage)-1;
	$maxlimit = $recordPerPage*$npage;
	if(isset($npage) AND $npage > 1){	
		$sql = $sql . " LIMIT ".$maxlimit.", ".intval($recordPerPage);
		$pg = $npage;		
	}else{
		$sql = $sql . " LIMIT 0, ".$recordPerPage;
		$pg = 1;
	}
	
	$dt = $db->Execute($sql);   
		
	$totalpag = $dt->Count();

	if($dt->Count() > 0){
		while($dt->MoveNext()):
?>
			<tr id="cod<?=$dt->idUsuario?>" onmouseover="document.getElementById('cod<?=$dt->idUsuario?>').className='corlinha';" onmouseout="document.getElementById('cod<?=$dt->idUsuario?>').className='';">
				<td align="left" onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=strtoupper_utf8($dt->nomeUsuario)?></td>				
				<td onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=strtoupper_utf8($dt->login)?></td>				
				<td onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=strtoupper_utf8($dt->tpacesso)?></td>				
			</tr>
<? 		endwhile; ?>
			<input type="hidden" id="codusuario" name="codusuario" value=""/>
		</tbody>
		<tfoot>
		<tr>			
			<td colspan="3" align="right" style="padding-top:15px;"><b>Página <?=$pg?> de <?=$maxpage?></b></td>			
		</tr>
		<tr>
			<td colspan="3">
				<?	
					if($pg == 1 AND $pg < $maxpage ):
						$antes = "Primeiro";
						$depois = htmlentities("Próximo");
						$pgant = $pg;
						$pgdep = $pg+1;											
					elseif($pg == 1 AND $maxpage == $pg):					
						$antes = "Primeiro";
						$depois = htmlentities("Último");
						$pgant = $pg;
						$pgdep = $pg;						
					elseif($pg > 1 AND $pg < $maxpage):
						$antes = "Anterior";
						$depois = htmlentities("Próximo");
						$pgant = $pg-1;
						$pgdep = $pg+1;						
					elseif($pg == $maxpage):
						$antes = "Anterior";
						$depois = htmlentities("Último");
						$pgant = $pg-1;
						$pgdep = $pg;						
					elseif($maxpage==0):
						$antes = "Primeiro";
						$depois = htmlentities("Último");
						$pgant = $pg;
						$pgdep = $pg;												
					endif; 
				?>
				<a id="idpagant" style="cursor:pointer; color:#91ac41;" onmouseover="document.getElementById('idpagant').style.color='#5b6b28'" onmouseout="document.getElementById('idpagant').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgant?>'; document.frm_usuarios.submit();">&#171; <?=$antes?></a> <a style="cursor:pointer; color:#91ac41;" id="idpagdep" onmouseover="document.getElementById('idpagdep').style.color='#5b6b28'" onmouseout="document.getElementById('idpagdep').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgdep?>'; document.frm_usuarios.submit(); "><?=$depois?> &#187;</a>
			</td>
			<input type="hidden" id="page" name="page" value=""/>
		</tr>
		</tfoot>
<?	}else{ ?>
		<tr>
			<td colspan="3" align="center">Nenhum registro encontrado!</td>
		</tr>	
	</tbody>		
<?	} ?>
</table>
</form>
<?
}
?>
