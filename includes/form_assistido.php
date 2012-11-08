<?
	if(isset($_GET['pg']) AND $_GET['pg'] == "c1" AND isset($_POST['bt_cad_assis']) AND $_POST['bt_cad_assis'] == "Cadastrar"){
		/** BUSCA SE ASSISTIDO JÁ EXISTE NO SISTEMA **/
		/*$sqlN = "select nome from assistidos ";				
		$sqlN = $sqlN . " where nome = '".$_POST['nome_assis_cad']."' ";		
		$dt = $db->Execute($sqlN);
		$tot = $dt->Count();
		
		if($tot > 0){
			echo "<script> alert('Assistido já existente!'); setadivDesig(); </script>";
		}else{*/
			$sql = "INSERT INTO assistidos( ";
			$sql = $sql . " idUsuario, ";
			$sql = $sql . " idCidade, ";
			$sql = $sql . " idProfissao, ";
			$sql = $sql . " idEstadoCivil, ";
			$sql = $sql . " nome, ";
			$sql = $sql . " filiacao, ";
			$sql = $sql . " dataNascimento, ";
			$sql = $sql . " rg, ";
			$sql = $sql . " cpf, ";
			$sql = $sql . " sexo, ";
			$sql = $sql . " nacionalidade, ";
			$sql = $sql . " orgaoExpedidor, ";
			$sql = $sql . " telefone, ";
			$sql = $sql . " telefone2, ";
			$sql = $sql . " endereco, ";
			if($_POST['num_assis'] != ""){
				$sql = $sql . " numero, ";
			}
			$sql = $sql . " bairro, ";
			if($_POST['email'] != ""){
				$sql = $sql . " email, ";
			}				
			$sql = $sql . " cep ";		
			$sql = $sql . " )VALUES( ";
			$sql = $sql . $_SESSION['idUser'].",";
			$sql = $sql . $_POST['cid_assis'].",";
			$sql = $sql . $_POST['prof_assis'].",";
			$sql = $sql . $_POST['estado_civil'].",";
			$sql = $sql ."'".utf8_encode($_POST['nome_assis_cad'])."',";
			$sql = $sql ."'".utf8_encode($_POST['filiacao_assis'])."',";
			$dtx = explode("/",$_POST['dtnasc_assis']);
			$sql = $sql ."'".date("Y-m-d", mktime(0, 0, 0, $dtx[1], $dtx[0], $dtx[2]))."',";
			$sql = $sql ."'".$_POST['rg_assis']."',";
			$sql = $sql ."'".$_POST['cpf_assis']."',";
			$sql = $sql ."'".$_POST['sexo_assis']."',";
			$sql = $sql ."'".$_POST['nacionalidade']."',";			
			$sql = $sql ."'".$_POST['orgao_exp']."/".$_POST['uf_orgao_exp']."',";
			$sql = $sql ."'".$_POST['tel_assis']."',";
			$sql = $sql ."'".$_POST['tel_assis2']."',";
			$sql = $sql ."'".utf8_encode($_POST['end_assis'])."',";
			if($_POST['num_assis'] != ""){
				$sql = $sql . $_POST['num_assis'].",";
			}
			if($_POST['email'] != ""){
				$sql = $sql ."'".$_POST['email']."',";
			}
			$sql = $sql ."'".utf8_encode($_POST['bairro_assis'])."',";
			$sql = $sql ."'".$_POST['cep_assis']."'";		
			$sql = $sql . " ) ";
	
			$db->Execute($sql);    		
			$id = $db->GetLastInsertID();
			$db->Commit();
			$nameassiscad = $_POST['nome_assis_cad'];
?>
			<div id="div_msg_confirm" class="msg_confirm" style="display:block;">Cadastro efetuado com sucesso!</div>
<?
		//}
	}


	if(isset($_POST['ida']) AND $_POST['ida'] != ""){	
		$idassis = $_POST['ida'];		
		$tpacao = "Editar";
		$bt_form_assis = "Salvar";
		echo "<script>
				document.getElementById('cadastra_assis').style.display='block';
				document.getElementById('busca_assistido').style.display='none'; 
				document.getElementById('show_assis').style.display='none';
			 </script>";

		$sql = "SELECT  a.idUsuario, ";
		$sql = $sql . " a.idCidade, ";
		$sql = $sql . " a.idProfissao, ";
		$sql = $sql . " a.idEstadoCivil, ";
		$sql = $sql . " a.nome, ";
		$sql = $sql . " a.filiacao, ";
		$sql = $sql . " DATE_FORMAT(a.dataNascimento,'%d/%m/%Y') as dataNascimento, ";
		$sql = $sql . " a.rg, ";
		$sql = $sql . " a.cpf, ";
		$sql = $sql . " a.sexo, ";
		$sql = $sql . " a.nacionalidade, ";
		$sql = $sql . " a.orgaoExpedidor, ";
		$sql = $sql . " a.telefone, ";
		$sql = $sql . " a.telefone2, ";
		$sql = $sql . " a.endereco, ";
		$sql = $sql . " a.numero, ";
		$sql = $sql . " a.bairro, ";
		$sql = $sql . " a.cep, ";
		$sql = $sql . " a.email, ";		
		$sql = $sql . " a.endereco2, ";
		$sql = $sql . " a.numero2, ";
		$sql = $sql . " a.bairro2, ";
		$sql = $sql . " a.endereco3, ";
		$sql = $sql . " a.numero3, ";
		$sql = $sql . " a.bairro3, ";
		$sql = $sql . " c.idEstado ";		
		$sql = $sql . " FROM assistidos a left outer join cidades c on a.idCidade=c.idCidade ";
		$sql = $sql . " WHERE idAssistido =".$idassis;		
		
		$dtA = $db->Execute($sql);    				
		$dtA->MoveNext();
		$orgao = explode("/",$dtA->orgaoExpedidor);		
		$estado = $dtA->idEstado;
		
		$xend = 1;
		if($dtA->endereco2 != "" OR $dtA->numero2 != "" OR $dtA->bairro2 != ""){
			$xend++;
		}
		if($dtA->endereco3 != "" OR $dtA->numero3 != "" OR $dtA->bairro3 != ""){
			$xend++;
		}
		
	}else{
		$xend = 1;
		$tpacao = "Cadastrar";	
		$bt_form_assis = "Cadastrar";
		$orgao[0] = "SSP";
		$orgao[1] = "MS";
		$estado = 12;
	}
?>

<form id="frm_cad_assis" name="frm_cad_assis" method="post" onSubmit="return Verifica()">
	<p class="titulo" style="text-align:center;"><?=$tpacao?> Assistido</p>
	<div id="error" class="error"></div>
	<br>
	<? if($tpacao == "Editar"): ?>		
		<input type="hidden" id="idassisedit" name="idassisedit" value="<?=$idassis?>"/>
	<? endif; ?>
	<table cellpadding="4" style="margin:auto;">
	<tr>
		<td align="right"><label for="nome_assis_cad" class="label">Nome: </label></td>
		<td colspan="5" align="left"><input type="text" class="text" id="nome_assis_cad" name="nome_assis_cad" value="<?=utf8_decode($dtA->nome)?>" style="font-size:12px; width:97%"/></td>
	</tr>
	<tr>
		<td align="right"><label for="filiacao_assis" class="label">Filiação: </label></td>
		<td colspan="5" align="left"><input type="text" class="text" id="filiacao_assis" name="filiacao_assis" value="<?=utf8_decode($dtA->filiacao)?>" style="font-size:12px; width:97%"/></td>
	</tr>
	<tr>
		<td align="right"><label for="dtnasc_assis" class="label">Data Nasc.: </label></td>
		<td align="left" width="90px"><input type="text" style="font-size:12px; margin-left:10px" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" id="dtnasc_assis" name="dtnasc_assis" maxlength="10" size="10" value="<?=$dtA->dataNascimento?>"/></td>
		<td align="right" colspan="4">
			<label for="rg_assis" class="label">RG: </label>
			<input type="text" style="font-size:12px; margin-left:10px" id="rg_assis" name="rg_assis" maxlength="14" size="13" value="<?=$dtA->rg?>"/>

			<select id="orgao_exp" name="orgao_exp" style="font-size:12px;">
				<option value="">Selecione</option>
				<?
					$sql = "SELECT * FROM orgaoexp ";					
					$sql = $sql . " ORDER BY id_orgao_exp ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->sigla_orgao_exp?>" <?=$orgao[0]==$dt->sigla_orgao_exp?"selected":""?>><?=$dt->sigla_orgao_exp?></option>	
				<?	endwhile; ?>								
			</select> /

			<select id="uf_orgao_exp" name="uf_orgao_exp" style="font-size:12px;">
				<option value="">Selecione</option>			
				<?
					$sql = "SELECT * FROM estados ";					
					$sql = $sql . " ORDER BY sigla ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->sigla?>" <?=$orgao[1]==$dt->sigla?"selected":""?>><?=$dt->sigla?></option>	
				<?	endwhile; ?>				
			</select>			
		</td>		
	</tr>
	<tr>	
		<td align="right"><label for="cpf_assis" class="label">CPF: </label></td>
		<td align="left"><input style="font-size:12px; margin-left:10px" type="text" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);" id="cpf_assis" name="cpf_assis" value="<?=$dtA->cpf?>" maxlength="14" size="14"/></td>
		<td align="right" colspan="4">
			<label for="sexo_assis" class="label">Sexo: </label>
		
			<select id="sexo_assis" name="sexo_assis" style="font-size:12px; margin-left:10px">				
				<option value="F" <?=$dtA->sexo=="F"?"selected":""?>>F</option>
				<option value="M" <?=$dtA->sexo=="M"?"selected":""?>>M</option>
			</select>

			<label for="tel_assis2" style=" margin-left:10px" class="label">Telefone: </label>&nbsp;
			
			<input type="text" id="tel_assis" name="tel_assis" onKeyDown="Mascara(this,Telefone);" onKeyPress="Mascara(this,Telefone);" onKeyUp="Mascara(this,Telefone);" style="font-size:12px;" value="<?=$dtA->telefone?>" maxlength="14" size="14"/>
			
			<input type="text" id="tel_assis2" name="tel_assis2" onKeyDown="Mascara(this,Telefone);" onKeyPress="Mascara(this,Telefone);" onKeyUp="Mascara(this,Telefone);" style="font-size:12px;" value="<?=$dtA->telefone2?>" maxlength="14" size="14"/>						
		</td>
	</tr>
	<tr>
		<td align="right"><label for="end_assis" class="label">Endereço: </label></td>
		<td colspan="5" align="left">
			<input type="text" style="font-size:12px; margin-left:10px; width:200px;" id="end_assis" name="end_assis" value="<?=utf8_decode($dtA->endereco)?>"/>
			<label for="num_assis" class="label" style="font-size:12px; margin-left:10px;">Nº: </label>
			<input type="text" id="num_assis" name="num_assis" style="font-size:12px;" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);" value="<?=$dtA->numero?>" maxlength="8" size="2"/>
		
			<label for="bairro_assis" class="label" style="font-size:12px; margin-left:10px;">Bairro: </label>
			<input type="text" id="bairro_assis" style="font-size:12px; width:200px;" name="bairro_assis" value="<?=utf8_decode($dtA->bairro)?>"/>
		</td>
	</tr>
	<script>
		function add_newline(){
			var contaend = parseInt(document.getElementById('contaend').value);
			if(contaend >= 1 && contaend < 3){			
				document.getElementById('contaend').value = contaend + 1;
				document.getElementById('addend').style.display='';
				$('#addend').append('<tr><td align="right"><label for="end_assis'+document.getElementById('contaend').value+'" class="label">Endereço '+document.getElementById('contaend').value+': </label></td><td colspan="5" align="left"><input type="text" style="font-size:12px; margin-left:10px; width:200px;" id="end_assis'+document.getElementById('contaend').value+'" name="end_assis'+document.getElementById('contaend').value+'" value=""/><label for="num_assis'+document.getElementById('contaend').value+'" class="label" style="font-size:12px; margin-left:10px;">Nº: </label><input type="text" id="num_assis'+document.getElementById('contaend').value+'" name="num_assis'+document.getElementById('contaend').value+'" style="font-size:12px;" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);" value="" maxlength="8" size="2"/><label for="bairro_assis'+document.getElementById('contaend').value+'" class="label" style="font-size:12px; margin-left:10px;">Bairro '+document.getElementById('contaend').value+': </label><input type="text" id="bairro_assis'+document.getElementById('contaend').value+'" style="font-size:12px; width:200px;" name="bairro_assis'+document.getElementById('contaend').value+'" value=""/></td><tr>');
			}else{
				alert("Máximo 2 endereços novos podem ser adicionados!");
				return false;			
			}
		}
	</script>
	<tr>
		<td align="right"><label for="cep_assis" class="label">CEP: </label></td>
		<td align="left" colspan="5">
			<input style="font-size:12px; margin-left:10px" type="text" onKeyDown="Mascara(this,Cep);" onKeyPress="Mascara(this,Cep);" onKeyUp="Mascara(this,Cep);" id="cep_assis" name="cep_assis" value="<?=$dtA->cep?>" maxlength="9" size="9"/>
		
			<label for="uf_assis" class="label" style="font-size:12px; margin-left:10px;">UF: </label>		
			<select id="uf_assis" name="uf_assis" onchange="changeCidade(this.value)" style="font-size:12px;">				
				<?
					$sql = "SELECT * FROM estados ";					
					$sql = $sql . " ORDER BY sigla ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idEstado?>" <?=$dtA->idEstado==$dt->idEstado?"selected":($dt->sigla=="MS"?"selected":"");?>><?=$dt->sigla?></option>	
				<?	endwhile; ?>
			</select>
		
			<label for="cid_assis" class="label" style="margin-left:10px;">Cidade: </label>
		
			<div id="div_showcid" style="display:inline;">
			<select id="cid_assis" name="cid_assis" style="font-size:12px;">
				<option value="">Selecione</option>
				<?				
					$sql = "SELECT * FROM cidades ";					
					$sql = $sql . " WHERE idEstado=".$estado;
					$sql = $sql . " ORDER BY nomeCidade ASC ";
					$dt = $db->Execute($sql);    
					
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idCidade?>" <?=$dtA->idCidade==$dt->idCidade?"selected":($dt->idCidade=="4079"?"selected":"");?>><?=utf8_decode($dt->nomeCidade)?></option>	
				<?	endwhile; ?>
			</select>
			</div>
			<div style="cursor:pointer; display:inline; margin-left:15px;" onclick="return add_newline()"><font color="#228B22">Endereço</font> <img src="imagens/add.png" style="vertical-align:middle; cursor:pointer;"/></div>
		</td>
	</tr>
	<? for($i=2;$i <= $xend;$i++):
		$strend = "endereco".$i;
		$strnum = "numero".$i;
		$strbairro = "bairro".$i;
	?>
	<tr>
		<td align="right"><label for="end_assis" class="label">Endereço <?=$i?>: </label></td>
		<td colspan="5" align="left">
			<input type="text" style="font-size:12px; margin-left:10px; width:200px;" id="end_assis<?=$i?>" name="end_assis<?=$i?>" value="<?=utf8_decode($dtA->$strend)?>"/>
			<label for="num_assis<?=$i?>" class="label" style="font-size:12px; margin-left:10px;">Nº: </label>
			<input type="text" id="num_assis<?=$i?>" name="num_assis<?=$i?>" style="font-size:12px;" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);" value="<?=$dtA->$strnum?>" maxlength="8" size="2"/>
		
			<label for="bairro_assis<?=$i?>" class="label" style="font-size:12px; margin-left:10px;">Bairro <?=$i?>: </label>
			<input type="text" id="bairro_assis<?=$i?>" style="font-size:12px; width:200px;" name="bairro_assis<?=$i?>" value="<?=utf8_decode($dtA->$strbairro)?>"/>
		</td>
	</tr>
	<? endfor; ?>	
	<tbody id="addend" style="display:none;"></tbody>
	<input type="hidden" id="contaend" name="contaend" value="<?=$xend?>">
	<tr>
		<td align="right"><label for="prof_assis" class="label">Profissão: </label></td>
		<td align="left" colspan="5">
			<select id="prof_assis" name="prof_assis" style="margin-left:10px; font-size:12px; ">				
				<option value="">Selecione</option>
				<?
					$sql = "SELECT * FROM profissoes ";					
					$sql = $sql . " ORDER BY nomeProfissao ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idProfissao?>" <?=$dtA->idProfissao==$dt->idProfissao?"selected":"";?>><?=utf8_decode($dt->nomeProfissao)?></option>	
				<?	endwhile;
				?>
			</select>
	
			<label for="estado_civil" class="label" style="font-size:12px; margin-left:10px;">Estado Civil: </label>
		
			<select id="estado_civil" name="estado_civil" style="font-size:12px;">
				<option value="">Selecione</option>
				<?
					$sql = "SELECT * FROM estadocivil ";					
					$sql = $sql . " ORDER BY nomeEstadoCivil ASC ";
					$dt = $db->Execute($sql);    
					while($dt->MoveNext()):?>
					<option value="<?=$dt->idEstadoCivil?>" <?=$dtA->idEstadoCivil==$dt->idEstadoCivil?"selected":"";?>><?=$dt->nomeEstadoCivil?></option>	
				<?	endwhile;
				?>
			</select>
		</td>		
	</tr>
	<tr>
		<td align="right"><label for="nacionalidade" class="label">Nacionalidade: </label></td>
		<td align="left" colspan="5">
			<input style="font-size:12px; margin-left:10px" type="text" id="nacionalidade" name="nacionalidade" value="<?=$dtA->nacionalidade==""?"brasileiro(a)":$dtA->nacionalidade;?>"/>
			
			<label for="email" class="label" style="font-size:12px; margin-left:10px;">Email: </label>
			<input type="text" style="font-size:12px; margin-left:10px; width:200px;" id="email" name="email" value="<?=$dtA->email?>"/>
		</td>		
	</tr>
	<tr>
		<td colspan="6" style="text-align:center; padding-top:25px;">
			<input type="submit" id="bt_cad_assis" name="bt_cad_assis" value="<?=$bt_form_assis?>"/>
		</td>
	</tr>
	</table>
<form>

<?
	if(isset($_GET['pg']) AND $_GET['pg'] == "c1" AND isset($_POST['bt_cad_assis']) AND $_POST['bt_cad_assis'] == "Cadastrar"){
		echo "<script> document.getElementById('frm_cad_assis').style.display='none'; setTimeout('setadivDesig()',1500); </script>";		
	}
?>