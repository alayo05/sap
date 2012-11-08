
<div id="busca_assis_def" class="formulario" style="width:100%; display:block; float:left;">	
	<div class="divBox">
		<div class="divBoxTitulo">
			<p style="width:70%; float:left;">Assistidos em Espera</p>
			<p id="timelistassis" style="font-size:11px; text-align:right; float:left; width:90px; color:#888888;"></p>
			</div>
		<div id="showlistassis" class="divBoxBody" style="height:250px;">		
		<table cellspacing="0" cellpadding="0" width="100%">
		<?		
			$sql = "SELECT defensorVinculado FROM usuarios ";
			$sql = $sql . " WHERE idUsuario=".$_SESSION['idUser'];			
			$dtVinc = $db->Execute($sql); 
			$dtVinc->MoveNext();
			
			if($dtVinc->defensorVinculado == 0){
				$idaparece = $_SESSION['idUser'];
			}else{
				$idaparece = $dtVinc->defensorVinculado;
			}			
			
			/*if($idaparece==14 OR $idaparece==13 ){
				$sql = "SELECT DISTINCT a.idAssistencia, a.idAssistido, a.idProvidencia, a.preferencial, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
				$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
				$sql = $sql . " WHERE a.status <> 'concluido' AND a.idUsuario = ".$idaparece." AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y')=DATE_FORMAT('2012-07-30','%d/%m/%Y') ";
				$sql = $sql . " ORDER BY a.dataAtendimento ASC, p.nome ASC ";			
				
			}else{*/
			
				$sql = "SELECT DISTINCT a.idAssistencia, a.idAssistido, a.idProvidencia, a.preferencial, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
				$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
				$sql = $sql . " WHERE a.status <> 'concluido' AND a.idUsuario = ".$idaparece." AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
				$sql = $sql . " ORDER BY a.dataAtendimento ASC, p.nome ASC ";
			//}
			
			$dt = $db->Execute($sql);    
			while($dt->MoveNext()):
		?>		
			<tr id="listassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='corlinha';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" style="cursor:pointer;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); <? if($dt->idProvidencia == ""){?>document.getElementById('div_hist_assis').innerHTML=''; carregaHistorico('<?=$dt->idAssistencia?>','<?=$dt->idAssistido?>'); carregaRegistro('<?=$dt->idAssistencia?>');<?}else{?>carregaHistorico('<?=$dt->idAssistencia?>','<?=$dt->idAssistido?>'); carregaRegistro('<?=$dt->idAssistencia?>');<? } ?>">
				<td style="text-align:left; padding:4px 10px;">
					<?=strtoupper_utf8($dt->nome)?>
				</td>
				<td style="color:red;"><?=$dt->preferencial=="sim"?"Preferencial":""?></td>
				<td style="width:160px; margin-left:10px; margin-right:5px;"><?=$dt->dataAtendimento?></td>
			</tr>		
		<?	endwhile; ?>
		</table>	
		</div>	
	</div>

	<div class="divBox" style="margin-left:15px;">
		<div class="divBoxTitulo"><p style="float:left;">Histórico do Assistído</p><div id="btgerainfassis" style="cursor:pointer; float:right; width:40px; margin:2px 25px 0px 0px; font-size:12px;"></div></div>
		<div id="div_hist_assis" class="divBoxBody" style="height:250px;">			
		</div>	
	</div>

	<div class="divBox" style="margin-top:15px;">
		<div class="divBoxTitulo"><p style="float:left;">Assistidos Atendidos</p><input type="text" id="dtassisatend" maxlength="10" size="10" name="dtassisatend" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data); return verifEnterAtend(event);" onKeyUp="Mascara(this,Data);" style="cursor:pointer; float:right; width:80px; margin:9px 25px 0px 0px; font-size:12px;"/> <label for="dtassisatend" style="float:right; margin:12px 5px 0px 0px;">Data: </label> <input type="text" id="nameassisatend" size="10" name="nameassisatend" onkeypress="return verifEnterAtend(event);" style="cursor:pointer; float:right; width:80px; margin:9px 25px 0px 0px; font-size:12px;"/> <label for="nameassisatend" style="float:right; margin:12px 5px 0px 0px;">Nome: </label> <img title="Buscar Atendimentos" src="imagens/busca_atend.png" style="width:25px; cursor:pointer; position:relative; left:-0px; top:-2px; *top:-2px; _top:-2px; *left:-4px; _left:-4px; margin:12px 5px 0px 0px; display:block;" onclick="NewPage('busca/showinfassistido.php?iddef=<?=$idaparece?>','InfoAssistidos','900','600','yes')" /> </div>
		<div id="listassisatend" class="divBoxBody" style="height:345px;">			
			<table width="100%" cellspacing="0" cellpadding="0">
			<?	
				/*if($idaparece==14 OR $idaparece==13 ){					
					$sql = "SELECT DISTINCT h.idAssistencia, p.idAssistido, x.nomeAcao, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome ";
					$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
					$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
					$sql = $sql . " LEFT OUTER JOIN acoes x ON x.idAcao=a.idAcao ";
					$sql = $sql . " WHERE h.idProvidencia <> 0 AND h.idUsuario = ".$idaparece." AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y')=DATE_FORMAT('2012-07-30','%d/%m/%Y')  ";
					$sql = $sql . " GROUP BY h.idAssistencia, a.dataAtendimento ORDER BY a.dataAtendimento DESC, p.nome ASC ";					
				}else{	*/		
					$sql = "SELECT DISTINCT h.idAssistencia, p.idAssistido, x.nomeAcao, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome ";
					$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
					$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
					$sql = $sql . " LEFT OUTER JOIN acoes x ON x.idAcao=a.idAcao ";
					$sql = $sql . " WHERE h.idProvidencia <> 0 AND h.idUsuario = ".$idaparece." AND DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') ";
					$sql = $sql . " GROUP BY h.idAssistencia, h.dataAtendimento ORDER BY h.dataAtendimento DESC, p.nome ASC ";
				//}
				$dt = $db->Execute($sql);    
				while($dt->MoveNext()):
			?>		
				<tr id="showlistassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('showlistassis<?=$dt->idAssistencia?>').className='corlinhatend';" onmouseout="document.getElementById('showlistassis<?=$dt->idAssistencia?>').className='';" style="cursor:pointer;">
					<td style="text-align:left; padding:4px 4px;" onclick="return novoAtend('<?=$dt->idAssistido?>','<?=$idaparece?>')"><img src="imagens/novo.png" width="16px" title="Novo Atendimento"></td>
					<td style="text-align:left; padding:4px 10px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); carregaHistorico('<?=$dt->idAssistencia?>','<?=$dt->idAssistido?>'); carregaRegAtend('<?=$dt->idAssistencia?>');">
						<?=strtoupper_utf8($dt->nome)?>
					</td>
					<td style="margin-left:10px; margin-right:5px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); carregaHistorico('<?=$dt->idAssistencia?>','<?=$dt->idAssistido?>'); carregaRegAtend('<?=$dt->idAssistencia?>');"><?=utf8_decode($dt->nomeAcao)?></td>
					<td style="width:160px; margin-left:10px; margin-right:5px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); carregaHistorico('<?=$dt->idAssistencia?>','<?=$dt->idAssistido?>'); carregaRegAtend('<?=$dt->idAssistencia?>');"><?=$dt->dataAtendimento?></td>
				</tr>		
			<?	endwhile; ?>
			</table>
		</div>	
	</div>
	
	<div id="div_frm_hist" class="divBox" style="margin-left:15px; margin-top:15px;">
		<div class="divBoxTitulo">	
			<p style="text-align:center; color:#0d2d76; font-size:14px; font-weight:bold; _float:left; *float:left; display:inline;">
				<span style="display:block">Registrar Histórico</span>
				<a style="text-align:right; display:block; float:right; position:relative; top:-24px; _top:-18px; *top:-18px;">									
					<img id="chamar_aqua" style="float:right; display:inline; margin-right:15px; cursor:pointer;" title="Chamar Assistido" src="imagens/aqua-button.png" onmouseover="document.getElementById('chamar_aqua').src='imagens/aqua-button_over.png';" onmouseout="document.getElementById('chamar_aqua').src='imagens/aqua-button.png'" onclick="return chamarPainel()" width="75px"/>
				</a>
				<a style="text-align:right; display:block; float:left; position:relative; top:-30px; _top:-49px; *top:-49px;">
					<img style="float:left; display:inline; margin-left:30px; cursor:pointer;" title="Gerar Declaração" onclick="" src="imagens/change_button.png" width="48px"/>	
					<img id="dialogFato2" style="float:left; display:inline; margin-left:25px; cursor:pointer;" title="Fato Narrado" src="imagens/fatonarrado.png"/>
				</a>			
			</p>
		</div>	
		<div name="form_hist" class="divBodyForm" style="height:345px;">
			<div id="error_hist" class="error" style="text-align:left; _text-align:center; *text-align:center;"></div>		
			<form id="id_frm_hist" name="id_frm_hist" method="post">						
			<table width="100%" style="display:block; float:left;">						
			<input type="hidden" id="idhist" name="idhist" value=""/>		
			<tr>
				<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="idassis_aux" class="label"><b>ID:</b> </label></td>
				<td align="left"><input type="text" id="idassis_aux" name="idassis_aux" style="width:50px; margin-left:10px; text-align:center; font-size: 12px;" value="" readonly></td>
			</tr>		
			<tr>
				<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="nomeassis_hist" class="label"><b>Assistido:</b> </label></td>
				<td align="left"><input type="text" id="nomeassis_hist" name="nomeassis_hist" style="width:375px; margin-left:10px; font-size: 12px;" value=""></td>
			</tr>
			<tr>
				<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="acao" class="label"><b>Ação:</b> </label></td>
				<td align="left">
					<select id="acao" name="acao" style="margin-left:10px; font-size: 12px;">
						<option value="">Selecione</option>
						<?
							$sqlA = "SELECT idAcao, nomeAcao  ";
							$sqlA = $sqlA . " FROM acoes ";
							$sqlA = $sqlA . " WHERE statusAcao = 1 ";
							$sqlA = $sqlA . " ORDER BY nomeAcao ASC ";
							$dt = $db->Execute($sqlA);   
							while($dt->MoveNext()):
						?>
							<option value="<?=$dt->idAcao?>"><?=utf8_decode($dt->nomeAcao)?></option>	
						<?	endwhile; ?>					
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" style="padding:8px 0px"><label style="margin-left:10px;"for="providencia" class="label"><b>Providência:</b> </label></td>
				<td align="left">
					<select id="providencia" name="providencia" style="margin-left:10px; font-size: 12px;">
						<option value="">Selecione</option>
						<?
							$sqlP = "SELECT idProvidencia, nomeProvidencia  ";
							$sqlP = $sqlP . " FROM providencias ";
							$sqlP = $sqlP . " WHERE statusProvidencia = 1 ";
							$sqlP = $sqlP . " ORDER BY nomeProvidencia ASC ";
							$dt = $db->Execute($sqlP);   
							while($dt->MoveNext()):
						?>
							<option value="<?=$dt->idProvidencia?>"><?=utf8_decode($dt->nomeProvidencia)?></option>	
						<?	endwhile; ?>					
					</select>
				</td>
			</tr>			
			<tr style="width:100%">
				<td colspan="2" align="center" style="padding:20px 0px;"><input type="button" id="bt_reg_hist" name="bt_reg_hist" value="Registrar" onclick="return cadHistorico()"></td>
			</tr>
			</table>
			</form>
		</div>	
	</div>
</div>