<? 
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
	
	require_once("../includes/dbcon_obj.php");
	
	session_start();	
	
	$idassis = $_POST['assis'];
	
	$sql = " SELECT a.idProvidencia, a.idAcao, p.nome, h.idHistorico, a.status, a.idAssistido, a.fatonarrado, h.idUsuario, h.assessorVinculado, a.senha ";
	$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido  ";	
	$sql = $sql . " WHERE a.idAssistencia=".$idassis;
	$sql = $sql . " ORDER BY h.idHistorico DESC ";	
	
	$dt = $db->Execute($sql);    

	$dt->MoveNext();
	
	/*** PEGANDO 1 REGISTRO **/
	$varidassistido = $dt->idAssistido;
	$varfatonarrado = $dt->fatonarrado;
	$varprovidencia = $dt->idProvidencia;
	$varstatus 		= $dt->status;
	$varidhistorico = $dt->idHistorico;
	$varidusuario 	= $dt->idUsuario;
	$varsenha 		= $dt->senha;
	$varnome		= $dt->nome;
	$varidacao 		= $dt->idAcao;
	
	//criando vetor com id dos usuário(defensores) que registraram algo no atendimento do assistido, pois apenas os mesmos podem visualizar os dados
	$strpermissao 	= array($dt->idUsuario);		
	while($dt->MoveNext()){
		array_push($strpermissao,$dt->idUsuario);
		//array_push($strpermissao,$dt->assessorVinculado);
	}
	
	$strpermissao = array_unique($strpermissao);
	//var_dump($strpermissao);
	
	$sqly = "";
	foreach ($strpermissao as $i => $value) {	
		$sqly = $sqly." defensorVinculado =".$strpermissao[$i]." OR";
		
	}	
	$sqly = substr($sqly, 0, -3);

	$sql = " select idUsuario ";
	$sql = $sql . " from usuarios ";	
	$sql = $sql . " where ".$sqly;

	$dty = $db->Execute($sql);    	
	/* pegando assessores */
	while($dty->MoveNext()){		
		array_push($strpermissao,$dty->idUsuario);
	}	
	//var_dump($strpermissao);
	
	$ver = false;
	foreach ($strpermissao as $i => $value) {		
		if($_SESSION['idUser'] == $strpermissao[$i]){
			$ver = true;
		}			
	}
	if($_SESSION['idnivel'] > 5){
		$ver = true;
	}	
	
?>

<div class="divBoxTitulo">	
	<p style="text-align:center; color:#0d2d76; font-size:14px; font-weight:bold; _float:left; *float:left; display:inline;">
		<span style="display:block"><?=htmlentities("Vizualizar Histórico")?></span>
		<a style="text-align:right; display:block; float:right; position:relative; top:-24px; _top:-18px; *top:-18px;">				
			<!--<img style="float:right; display:inline; margin-right:15px; cursor:pointer;" title="Concluir Atendimento" src="imagens/baixa_button.png" onclick="return BaixaAtendimento()" width="24px"/>-->			
			<img id="chamar_aqua" style="float:right; display:inline; margin-right:15px; cursor:pointer;" src="imagens/aqua-button.png" width="75px"/>
			<img style="float:right; display:inline; margin-right:25px; cursor:pointer;" title="Editar Assistido" src="imagens/edit-icon.png" onclick="document.getElementById('id_frm_hist').action='principal.php?pg=t2'; document.getElementById('ida').value='<?=$varidassistido?>'; document.id_frm_hist.submit();" width="24px"/>
		</a>
		<a style="text-align:right; display:block; float:left; position:relative; top:-30px; _top:-49px; *top:-49px;">
			<img style="float:left; display:inline; margin-left:30px; cursor:pointer;" title="Gerar Declaração" onclick="location.href='doc/index.php?id=<?=$varidassistido?>'" src="imagens/change_button.png" width="48px"/>	
			<? if($ver){?>
			<img id="dialogFato" style="float:left; display:inline; margin-left:25px; cursor:pointer;" title="Fato Narrado" src="imagens/fatonarrado.png"/>
			<? }else{ ?>
			<img id="dialogFatoVisualizar" style="float:left; display:inline; margin-left:25px; cursor:pointer;" title="Fato Narrado" src="imagens/fatonarrado.png"/>
			<? } ?>
		</a>			
	</p>
</div>	

<div id="form_hist" name="form_hist" class="divBodyForm" style="height:345px;">
	<div id="error_hist" style="text-align:left; _text-align:center; *text-align:center; " class="error"></div>		
	<form id="id_frm_hist" name="id_frm_hist" method="post" action="">
	<table width="100%" style="display:block; float:left;">		
	
	<!-- ui-dialog -->
	<div id="dialog" title="Fato Narrado" style="display:none;">
		<textarea id="txtfatonarrado" name="txtfatonarrado" cols="75" rows="14"><?=htmlentities(utf8_decode($varfatonarrado))?></textarea>
	</div>
	<div id="dialogVisualizar" title="Fato Narrado" style="display:none;">
		<textarea id="txtfatonarrado" name="txtfatonarrado" cols="75" rows="14"><?=htmlentities(utf8_decode($varfatonarrado))?></textarea>
	</div>		
	
	<input type="hidden" id="idhist" name="idhist" value="<?=$varidhistorico?>"/>		
	<input type="hidden" id="assispainel" name="assispainel" value="<?=$varidassistido?>"/>
	<input type="hidden" id="ida" name="ida" value="<?=$varidassistido?>"/>
	<input type="hidden" id="defenpainel" name="defenpainel" value="<?=$varidusuario?>"/>	
	<input type="hidden" id="senhapainel" name="senhapainel" value="<?=$varsenha?>"/>	
	<tbody style="width:100%; float:left;">
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="idassis_aux" class="label"><b>ID:</b> </label></td>
		<td align="left"><span style="width:50px; margin-left:10px; text-align:center; font-size: 12px;"><?=$idassis?></span></td>
		<input type="hidden" id="idassis_aux" name="idassis_aux" value="<?=$idassis?>">
	</tr>		
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="nomeassis_hist" class="label"><b>Assistido:</b> </label></td>
		<td align="left"><span style="width:375px; margin-left:10px; font-size: 12px;"><?=htmlentities(utf8_decode($varnome))?></span></td>
	</tr>
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="acao" class="label"><b><?=htmlentities("Ação")?>:</b> </label></td>
		<td align="left">
			<select id="acao" name="acao" style="margin-left:10px; font-size: 12px;" <?=$ver?"":"disabled"?>>
				<option value="">Selecione</option>
				<?
					$sqlA = "SELECT idAcao, nomeAcao  ";
					$sqlA = $sqlA . " FROM acoes ";
					$sqlA = $sqlA . " WHERE statusAcao = 1 ";
					$sqlA = $sqlA . " ORDER BY nomeAcao ASC ";
					$dtA = $db->Execute($sqlA);   
					while($dtA->MoveNext()):
				?>
					<option value="<?=$dtA->idAcao?>" <?=$varidacao==$dtA->idAcao?"selected":""?>><?=htmlentities(utf8_decode($dtA->nomeAcao))?></option>	
				<?	endwhile; ?>					
			</select>
		</td>
	</tr>	
	<tr>
		<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="providencia" class="label"><b><?=htmlentities("Providência")?>:</b> </label></td>
		<td align="left">
			<select id="providencia" name="providencia" style="margin-left:10px; font-size: 12px;" <?=$ver?"":"disabled"?>>
				<option value="">Selecione</option>
				<?
					$sqlP = "SELECT idProvidencia, nomeProvidencia  ";
					$sqlP = $sqlP . " FROM providencias ";
					$sqlP = $sqlP . " WHERE statusProvidencia = 1 ";
					$sqlP = $sqlP . " ORDER BY nomeProvidencia ASC ";
					$dtP = $db->Execute($sqlP);   
					while($dtP->MoveNext()):
				?>
					<option value="<?=$dtP->idProvidencia?>" <?=$varprovidencia==$dtP->idProvidencia?"selected":""?>><?=htmlentities(utf8_decode($dtP->nomeProvidencia))?></option>	
				<?	endwhile; ?>					
			</select>
		</td>
	</tr>	
	<? if($ver):?>
	<tr style="width:100%">
		<td colspan="2" align="center" style="padding:20px 0px;"><input type="button" id="bt_alt_hist" name="bt_alt_hist" value="Alterar" onclick="return alterarHistorico()"></td>
	</tr>	
	<? endif; ?>
	</tbody>
	</table>
	</form>
</div>