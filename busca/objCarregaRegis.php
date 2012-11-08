<? 
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
	
	require_once("../includes/dbcon_obj.php");
	
	session_start();	
	
	$idassis = $_POST['assis'];
	
	$sql = " SELECT a.idProvidencia, a.idAcao, p.nome, h.idHistorico, a.status, a.idAssistido, a.fatonarrado, a.idUsuario, a.senha, h.casonovo ";
	$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido  ";	
	$sql = $sql . " WHERE a.idAssistencia=".$idassis;
	$sql = $sql . " ORDER BY h.idHistorico DESC LIMIT 1";	
	
	$dt = $db->Execute($sql);    
	$dt->MoveNext();
?>

<div class="divBoxTitulo">	
	<p style="text-align:center; color:#0d2d76; font-size:14px; font-weight:bold; _float:left; *float:left; display:inline;">
		<span style="display:block"><?=htmlentities("Registrar Histórico")?></span>
		<a style="text-align:right; display:block; float:right; position:relative; top:-24px; _top:-18px; *top:-18px;">				
			<!--<img style="float:right; display:inline; margin-right:15px; cursor:pointer;" title="Concluir Atendimento" src="imagens/baixa_button.png" onclick="return BaixaAtendimento()" width="24px"/>-->			
			<img id="chamar_aqua" style="float:right; display:inline; margin-right:15px; cursor:pointer;" title="Chamar Assistido" src="imagens/aqua-button.png" onmouseover="document.getElementById('chamar_aqua').src='imagens/aqua-button_over.png';" onmouseout="document.getElementById('chamar_aqua').src='imagens/aqua-button.png'" onclick="return chamarPainel()" width="75px"/>
			<img style="float:right; display:inline; margin-right:25px; cursor:pointer;" title="Editar Assistido" src="imagens/edit-icon.png" onclick="document.getElementById('id_frm_hist').action='principal.php?pg=t2'; document.getElementById('ida').value='<?=$dt->idAssistido?>'; document.id_frm_hist.submit();" width="24px"/>
		</a>
		<a style="text-align:right; display:block; float:left; position:relative; top:-30px; _top:-49px; *top:-49px;">
			<img style="float:left; display:inline; margin-left:30px; cursor:pointer;" title="Gerar Declaração" onclick="location.href='doc/index.php?id=<?=$dt->idAssistido?>'" src="imagens/change_button.png" width="48px"/>	
			<img id="dialogFato" style="float:left; display:inline; margin-left:25px; cursor:pointer;" title="Fato Narrado" src="imagens/fatonarrado.png"/>
		</a>			
	</p>
</div>	

<div id="form_hist" name="form_hist" class="divBodyForm" style="height:345px;">
	<div id="error_hist" style="text-align:left; _text-align:center; *text-align:center; " class="error"></div>		
	<form id="id_frm_hist" name="id_frm_hist" method="post" action="">
	<table width="100%" style="display:block; float:left;">		
	
	<!-- ui-dialog -->
	<div id="dialog" title="Fato Narrado" style="display:none;">
		<textarea id="txtfatonarrado" name="txtfatonarrado" cols="75" rows="14"><?=htmlentities(utf8_decode($dt->fatonarrado))?></textarea>
	</div>	
	
	<input type="hidden" id="idhist" name="idhist" value="<?=($dt->idProvidencia=="" OR $dt->status =="retorno")?$dt->idHistorico:""?>"/>		
	<input type="hidden" id="assispainel" name="assispainel" value="<?=$dt->idAssistido?>"/>
	<input type="hidden" id="ida" name="ida" value="<?=$dt->idAssistido?>"/>
	<input type="hidden" id="defenpainel" name="defenpainel" value="<?=$dt->idUsuario?>"/>	
	<input type="hidden" id="senhapainel" name="senhapainel" value="<?=$dt->senha?>"/>	
	<tbody style="width:100%; float:left;">
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="idassis_aux" class="label"><b>ID:</b> </label></td>
		<td align="left"><input type="text" id="idassis_aux" name="idassis_aux" style="width:50px; margin-left:10px; text-align:center; font-size: 12px;" value="<?=$idassis?>" readonly></td>
	</tr>		
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="nomeassis_hist" class="label"><b>Assistido:</b> </label></td>
		<td align="left"><input type="text" id="nomeassis_hist" name="nomeassis_hist" style="width:375px; margin-left:10px; font-size: 12px;" value="<?=htmlentities(utf8_decode($dt->nome))?>"></td>
	</tr>
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="acao" class="label"><b><?=htmlentities("Ação")?>:</b> </label></td>
		<td align="left">
			<select id="acao" name="acao" style="margin-left:10px; font-size: 12px;">
				<option value="">Selecione</option>
				<?
					$sqlA = "SELECT idAcao, nomeAcao  ";
					$sqlA = $sqlA . " FROM acoes ";
					$sqlA = $sqlA . " WHERE statusAcao = 1 ";
					$sqlA = $sqlA . " ORDER BY nomeAcao ASC ";
					$dtA = $db->Execute($sqlA);   
					while($dtA->MoveNext()):
				?>
					<option value="<?=$dtA->idAcao?>" <?=$dt->idAcao==$dtA->idAcao?"selected":""?>><?=htmlentities(utf8_decode($dtA->nomeAcao))?></option>	
				<?	endwhile; ?>					
			</select>
		</td>
	</tr>	
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="providencia" class="label"><b><?=htmlentities("Providência")?>:</b> </label></td>
		<td align="left">
			<select id="providencia" name="providencia" style="margin-left:10px; font-size: 12px;">
				<option value="">Selecione</option>
				<?
					$sqlP = "SELECT idProvidencia, nomeProvidencia  ";
					$sqlP = $sqlP . " FROM providencias ";
					$sqlP = $sqlP . " WHERE statusProvidencia = 1 ";
					$sqlP = $sqlP . " ORDER BY nomeProvidencia ASC ";
					$dtP = $db->Execute($sqlP);   
					while($dtP->MoveNext()):
				?>
					<option value="<?=$dtP->idProvidencia?>" <?=$dt->idProvidencia==$dtP->idProvidencia?"selected":""?>><?=htmlentities(utf8_decode($dtP->nomeProvidencia))?></option>	
				<?	endwhile; ?>					
			</select>
		</td>
	</tr>	
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="idassis_aux" class="label"><b>SENHA:</b> </label></td>
		<td align="left"><span style="width:50px; margin-left:10px; text-align:center; font-size: 12px;"><?=$dt->senha?></span></td>
	</tr>	
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="idassis_aux" class="label"><b>RETORNO:</b> </label></td>
		<td align="left"><span style="width:50px; margin-left:10px; text-align:center; font-size: 12px;"><?=$dt->casonovo==1?htmlentities("Não"):htmlentities("Sim")?></span></td>
	</tr>		
	
	<!--<tr>
		<td align="right" style="padding:8px 0px; vertical-align:top;"><label style="margin-left:10px;" for="descricao" class="label"><b>Descrição:</b> </label></td>
		<td align="left">
			<textarea id="descricao" name="descricao" cols="53" rows="4" style="margin-left:10px; font-size:12px;"></textarea>
		</td>
	</tr>-->
	<tr style="width:100%">
		<td colspan="2" align="center" style="padding:20px 0px;"><input type="button" id="bt_reg_hist" name="bt_reg_hist" value="Registrar" onclick="return cadHistorico()"></td>
	</tr>
	</tbody>
	</table>
	</form>
</div>