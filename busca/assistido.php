<script>
//	$(document).ready(function () {
//		document.getElementById("nome_assis").focus();
//	});

</script>
<?

	/*** CADASTRA ASSISTIDO NO BANCO ***/	

	if((isset($_POST['bt_cad_assis']) AND $_POST['bt_cad_assis'] == "Cadastrar") OR (isset($_POST['idas']) AND $_POST['idas'] != "") OR (isset($_POST['idasRet2']) AND $_POST['idasRet2'] != "")){
		
		if(!isset($_POST['idas']) AND !isset($_POST['idasRet2'])){					
		
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
				if($_POST['email'] != ""){
					$sql = $sql . " email, ";
				}
				
				$sql = $sql . " bairro, ";				
				
				if(isset($_POST['contaend']) AND $_POST['contaend'] > 1 AND $_POST['contaend'] < 4)  {
					if($_POST['contaend'] > 1){
						$sql = $sql . " endereco2, ";
						if($_POST['num_assis2'] != ""){
							$sql = $sql . " numero2, ";
						}
						$sql = $sql . " bairro2, ";
					}
					if($_POST['contaend'] > 2){
						$sql = $sql . " endereco3, ";
						if($_POST['num_assis3'] != ""){
							$sql = $sql . " numero3, ";
						}
						$sql = $sql . " bairro3, ";					
					}
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
				
				if(isset($_POST['contaend']) AND $_POST['contaend'] > 1 AND $_POST['contaend'] < 4)  {
					if($_POST['contaend'] > 1){
						$sql = $sql ."'".utf8_encode($_POST['end_assis2'])."',";
						if($_POST['num_assis2'] != ""){
							$sql = $sql . $_POST['num_assis2'].",";
						}
						$sql = $sql ."'".utf8_encode($_POST['bairro_assis2'])."',";
					}
					if($_POST['contaend'] > 2){
						$sql = $sql ."'".utf8_encode($_POST['end_assis3'])."',";
						if($_POST['num_assis3'] != ""){
							$sql = $sql . $_POST['num_assis3'].",";
						}
						$sql = $sql ."'".utf8_encode($_POST['bairro_assis3'])."',";
					}					
				}
				$sql = $sql ."'".$_POST['cep_assis']."'";		
				$sql = $sql . " ) ";
		
				$db->Execute($sql);    		
				$id = $db->GetLastInsertID();
				$db->Commit();
				$nameassiscad = $_POST['nome_assis_cad'];
?>
				<div id="div_msg_confirm" class="msg_confirm" style="display:block;">Cadastro efetuado com sucesso!</div>
<?
				$retorno = '';
				$titleDesig = "Designar Assistido ao Defensor";
				$botaohist = '<img src="imagens/lista_espera.png" title="Exibe lista de assistidos em espera" onclick="window.open(\'busca/showlistaespera.php\',\'Assistidos\',\'toolbar=0,titlebar=0,status=yes,scrollbars=yes,resizable=yes,width=710,height=440\');" style="cursor:pointer; float:right; width:22px; margin:7px 25px 6px;">';
				$nomebtDesig = "Designar";				
				$valpref = "";				
				$valret = "";				
			//}
		}else{		
			
			/************* RETORNO DO ASSISTIDO - CASOS: Aguard. Doc., Orientação e etc ************/
			$retorno = '';
			$titleDesig = "Designar Assistido ao Defensor";
			$botaohist = '<img src="imagens/lista_espera.png" title="Exibe lista de assistidos em espera" onclick="window.open(\'busca/showlistaespera.php\',\'Assistidos\',\'toolbar=0,titlebar=0,status=yes,scrollbars=yes,resizable=yes,width=710,height=440\');" style="cursor:pointer; float:right; width:22px; margin:7px 25px 6px;">';
			$nomebtDesig = "Designar";
			$varidas = $_POST['idas'];

			if(isset($_POST['idasRetorno']) AND $_POST['idasRetorno'] != ""){				
				$valpref = $_POST['pref_assist'];
				$valret = $_POST['ret_assist'];
				$titleDesig = "Retorno do Assistido";
				$botaohist = '<img src="imagens/lista_espera.png" title="Exibe lista de assistidos em espera" onclick="window.open(\'busca/showlistaespera.php\',\'Assistidos\',\'toolbar=0,titlebar=0,status=yes,scrollbars=yes,resizable=yes,width=710,height=440\');" style="cursor:pointer; float:right; width:22px; margin:7px 25px 6px;"> <img src="imagens/button_historico.png" id="bthis" onmouseover="document.getElementById(\'bthis\').src=\'imagens/button_historico_over.png\';" onmouseout="document.getElementById(\'bthis\').src=\'imagens/button_historico.png\'" onclick="NewPage(\'busca/showhist.php?id='.$_POST['idasRetorno'].'\',\'Historico\',\'650\',\'400\',\'yes\')" style="cursor:pointer; float:right; width:85px; margin:7px 5px 6px;">';
				$retorno = '<label for="numassisret" class="label" style="float:left; vertical-align:top; margin-left:10px;">Nº da Assistência: </label>
							<input type="text" class="text" id="numassisret" name="numassisret" style="float:left; margin-left: 33px; width:50px; font-size:12px;" value="'.$_POST['idasRetorno'].'" readonly> <br><br>
							<input type="hidden" id="numAssisRetorno" name="numAssisRetorno" value="'.$_POST['idasRetorno'].'"/>';
				$nomebtDesig = "Designar Retorno";
				$varidas = $_POST['idasRet2'];			
			}
			
			$sqlU = "select nome from assistidos ";				
			$sqlU = $sqlU . " where idAssistido = ".$varidas;		
			$dt = $db->Execute($sqlU);   		
			$dt->MoveNext();	
			
			$id = $varidas;
			$nameassiscad = utf8_decode($dt->nome);		

?>
			<div id="div_msg_confirm" class="msg_confirm" style="display:none;">Cadastro efetuado com sucesso!</div>
<?
		}
?>		
		
		<div class="divBox" style="width:540px; *width:535px; _width:535px;">		
			<div class="divBoxTitulo" style="width:540px; *width:535px; _width:535px;"><p style="float:left;"><?=$titleDesig?></p><?=$botaohist?></div>		
			<div id="designacao" class="divBoxBody">
			<form id="frm_desig_assis" name="frm_desig_assis" method="post" style="text-align:center;" onSubmit="return Verif_Desig();">								
				<div id="error_desig" class="error"></div>				
				<br>
				<?=$retorno?>				
				<label width="150px" for="nome_assis_desig" class="label" style="vertical-align:top; margin-left:10px; float:left;">Nome do Assistido: </label>
				<input type="hidden" id="idassistido" name="idassistido" value="<?=$id?>">
				<input type="text" class="text" id="nome_assis_desig" name="nome_assis_desig" style="margin-left: 27px; width:367px; float:left; font-size:12px; display:inline;" value="<?=$nameassiscad?>" readonly><br><br>
				<div style="width:94%; *width:93%; _width:93%; float:left; clear:both; color:#0d2d76; text-align:right; display:inline;">
					<span style="text-align:center; float:right; width:45px;">total</span>
					<span style="text-align:center; float:right; width:45px;">espera</span>					
				</div>
				<label for="defensor_assis" class="label" style="vertical-align:top; margin-left:10px; float:left;">Selecione o Defensor: </label>								
				<div id="listadef" style="width:370px; height:150px; font-size:12px; text-align:left; margin-left:10px; float:left; display:inline; border-color:#D2D2D2; border-style:solid; border-width:1px; overflow:auto;">
				<?
					$sqlC = "select u.idUsuario, ";
					$sqlC = $sqlC . " d.nomeCompleto, ";
					$sqlC = $sqlC . " (select count(h.idAssistencia) from historicoassistencia h where h.idUsuario=u.idUsuario AND h.idProvidencia is NULL AND h.dataAtendimento BETWEEN TIMESTAMP(CURDATE())  AND TIMESTAMP(CURDATE(),MAKETIME(23,59,59))) as espera, ";
					$sqlC = $sqlC . " (select count(h.idAssistencia) from historicoassistencia h where h.idUsuario=u.idUsuario AND h.dataAtendimento BETWEEN TIMESTAMP(CURDATE()) AND TIMESTAMP(CURDATE(),MAKETIME(23,59,59))) as total, ";
					$sqlC = $sqlC . " (select count(h.idAssistencia) from historicoassistencia h where h.idUsuario=u.idUsuario AND h.casonovo = 0 AND h.dataAtendimento BETWEEN TIMESTAMP(CURDATE()) AND TIMESTAMP(CURDATE(),MAKETIME(23,59,59))) as qtde_retorno ";
					$sqlC = $sqlC . " from usuarios u left outer join dadosusuarios d on (u.idUsuario=d.idUsuario) ";					
					$sqlC = $sqlC . " where u.idTipoAcesso = 4 OR u.idTipoAcesso = 5 ";
					$sqlC = $sqlC . " group by u.idUsuario, d.nomeCompleto ";
					$sqlC = $sqlC . " order by d.nomeCompleto ASC ";   
					
					$dt = $db->Execute($sqlC);   
					
					while($dt->MoveNext()):
						$cored = $dt->qtde_retorno==0?"":"red";
				?>
						<p id="listdefassis<?=$dt->idUsuario?>" style="float:left; width:98%; *width:92%; _width:92%; margin:0px; padding:3px;" onmouseover="mudarLinha('#listdefassis<?=$dt->idUsuario?>');" onmouseout="mudarLinha('#listdefassis<?=$dt->idUsuario?>');" onclick="confirmAtend('<?=$dt->idUsuario?>'); document.getElementById('defensor_assis').value='<?=$dt->idUsuario?>'; mudarLinha('#listdefassis<?=$dt->idUsuario?>');">
							<span style="float:left;"><?=utf8_decode($dt->nomeCompleto)?></span>							
							<span id="espera<?=$dt->idUsuario?>" title="Clique para visualizar!" style="text-align:center; float:right; width:48px;" onmouseover="mudarCorTexto('#espera<?=$dt->idUsuario?>');" onmouseout="mudarCorTexto('#espera<?=$dt->idUsuario?>');" onclick="NewPage('busca/showassistidos.php?id=<?=$dt->idUsuario?>&st=total','nomeJanela','650','400','yes')"><?=$dt->total?> <font color="<?=$cored?>" title="<?=$dt->qtde_retorno?> caso(s) de retorno">(<?=$dt->qtde_retorno?>R)</font></span>
							<span id="total<?=$dt->idUsuario?>" title="Clique para visualizar!" style="text-align:center; float:right; width:48px;" onmouseover="mudarCorTexto('#total<?=$dt->idUsuario?>');" onmouseout="mudarCorTexto('#total<?=$dt->idUsuario?>');" onclick="NewPage('busca/showassistidos.php?id=<?=$dt->idUsuario?>&st=espera','nomeJanela','650','400','yes')"><?=$dt->espera?></span>
						</p>										
				<?	endwhile; ?>
				</div>	
				<label for="preferencial" class="label" style="vertical-align:top; margin-left:10px; float:left; text-align:left; width:120px; margin-top:15px;">Preferencial </label>				
				<div style="margin-left: 27px; float:left; tex-align:left; font-size:12px; display:inline; margin-top:15px; width:370px; text-align:left;"><input type="checkbox" id="preferencial" name="preferencial" <?=($valpref=="sim")?"checked=checked":""?>></div>

				<label for="retornochk" class="label" style="vertical-align:top; margin-left:10px; float:left; text-align:left; width:120px; margin-top:15px;">Retorno </label>				
				<div style="margin-left: 27px; float:left; tex-align:left; font-size:12px; display:inline; margin-top:15px; width:370px; text-align:left;"><input type="checkbox" id="retornochk" name="retornochk" <?=($valret=="sim")?"checked=checked":""?> onclick="alert('SE É RETORNO E O ATENDIMENTO INICIAL ESTÁ NO LADO DIREITO(\'em Atendimentos Realizados\'),\n ENTÃO CLIQUE NELE PARA REABRIR O ATENDIMENTO! \n OBRIGADO!')"></div>				
				
				<label for="senha" class="label" style="vertical-align:top; margin-left:10px; float:left; text-align:left; width:120px; margin-top:15px;">Senha </label>
				<div style="margin-left: 27px; float:left; tex-align:left; font-size:12px; display:inline; margin-top:15px; width:370px; text-align:left;"><input type="input" id="senha" name="senha" value="" style="width:80px;"></div>
				
				<input type="hidden" id="defensor_assis" name="defensor_assis" value="">
				<input type="hidden" id="resultnumatend" name="resultnumatend" value="">
				<input type="submit" style="display:inline; margin-top:20px; margin-bottom:20px; font-size:12px;" id="bt_desig_assis" name="bt_desig_assis" value="<?=$nomebtDesig?>">			
				
			</form>	
			
			</div>
		</div>

		<div class="divBox" style="float:right; margin-right:30px; margin-left:0px;">
			<script type="text/javascript">
				function chamaPopup(id){
					var btfato = document.getElementById('btfato').checked;
					NewPage('busca/showatendassis.php?id='+id+'&fn='+btfato,'Historicos','750','400','yes');
				}
			</script>
			<div class="divBoxTitulo"><p style="float:left;">Atendimentos Realizados</p> <input type="checkbox" id="btfato" value="fato" style="float:right; cursor:pointer; margin:15px 15px 0 0px;"/><label for="btfato" style="float:right; margin:15px 8px 0 0;">fato narrado</label> <img src="imagens/print-button.png" title="Exibe Histórico de Atendimento" onclick="chamaPopup('<?=$id?>')" style="cursor:pointer; float:right; width:22px; margin:9px 20px 6px;"></div>
			
			<div id="designa_assis" class="divBoxBody">				
			<form id="frm_desig_retorno" name="frm_desig_retorno" method="post">
					<table width="100%" cellspacing="0" cellpadding="0" style="font-size:10px; padding:10px 0px;">
					<tr>
						<th style="padding:8px 0px">ID</th>
						<th>PROVIDÊNCIA</th>
						<th>AÇÃO</th>
						<th>DEFENSOR</th>
						<th>DATA CADASTRO</th>
					</tr>
					<?		
						$sql = "SELECT DISTINCT a.idAssistencia, a.preferencial, p.nomeProvidencia, a.idProvidencia, c.nomeAcao, u.nomeUsuario, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento ";
						$sql = $sql . " FROM assistencias a LEFT OUTER JOIN providencias p ON a.idProvidencia=p.idProvidencia ";
						$sql = $sql . " 					LEFT OUTER JOIN acoes c ON a.idAcao=c.idAcao ";
						$sql = $sql . " 					LEFT OUTER JOIN usuarios u ON u.idUsuario=a.idUsuario ";
						$sql = $sql . " WHERE a.idAssistido = ".$id." AND a.status = 'concluido' ";
						$sql = $sql . " ORDER BY a.dataAtendimento DESC ";						
						
						$dt = $db->Execute($sql);    
						while($dt->MoveNext()):
							//if($dt->idProvidencia == 1 OR $dt->idProvidencia == 2 OR $dt->idProvidencia == 6){
								$acaoclick ="document.getElementById('idasRetorno').value='$dt->idAssistencia'; document.getElementById('pref_assist').value='$dt->preferencial'; document.getElementById('ret_assist').value='sim'; document.frm_desig_retorno.submit();";
								$corlinhacao = "corlinha";
								$titleacao = "Clique para REABRIR atendimento!";
								$cortitle = "";
							/*}else{
								$acaoclick ="NewPage('busca/showhist.php?id=$dt->idAssistencia','nomeJanela','650','400','yes')";
								$corlinhacao = "corlinhatend";
								$titleacao = "Clique para VISUALIZAR histórico!";
								$cortitle = 'style="background:#FFFFFF;"';
							}*/
					?>		
						<tr id="listassis<?=$dt->idAssistencia?>" title="<?=$titleacao?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='<?=$corlinhacao?>';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" onclick="<?=$acaoclick?>" style="cursor:pointer; text-align:center;">
							<td style="padding:4px 3px;"><?=$dt->idAssistencia?></td>
							<td style="padding:4px 2px;"><?=strtoupper_utf8($dt->nomeProvidencia)?></td>
							<td style="padding:4px 2px;"><?=strtoupper_utf8($dt->nomeAcao)?></td>							
							<td><?=strtoupper_utf8($dt->nomeUsuario)?></td>
							<td style="width:130px;"><?=$dt->dataAtendimento?></td>
						</tr>		
					<?	endwhile; ?>
						<input type="hidden" id="idasRet2" name="idasRet2" value="<?=$id?>"/>
						<input type="hidden" id="idasRetorno" name="idasRetorno" value=""/>
						<input type="hidden" id="pref_assist" name="pref_assist" value=""/>
						<input type="hidden" id="ret_assist" name="ret_assist" value=""/>
					</table>					
				</div>
			</form>			
		</div>		
		
		<?	
			echo "<script>
					function setadiv(){
						document.getElementById('div_msg_confirm').style.display='none';
						document.getElementById('designa_assis').style.display='block';						
					}
					setTimeout('setadiv()',0);					
				  </script>";			

	}else{ 		
		
		if(isset($_POST['bt_cad_assis']) AND $_POST['bt_cad_assis'] == "Salvar"){
		
			/** BUSCA SE ASSISTIDO JÁ EXISTE NO SISTEMA **/
			$sqlN = "select nome from assistidos ";				
			$sqlN = $sqlN . " where nome = '".$_POST['nome_assis_cad']."' and idAssistido <> ".$_POST['idassisedit'];		
			$dt = $db->Execute($sqlN);
			$tot = $dt->Count();
			
			/*if($tot > 0){
				echo "<script> alert('Assistido já existente!'); setadivDesig(); </script>";
			}else{*/
			
				/**** Registra Assistência ****/
				$sql = "UPDATE assistidos ";
				$sql = $sql . " SET idUsuario=".$_SESSION['idUser'].", ";
				$sql = $sql . " 	idCidade=".$_POST['cid_assis'].", ";
				$sql = $sql . " 	idProfissao=".$_POST['prof_assis'].", ";
				$sql = $sql . " 	idEstadoCivil=".$_POST['estado_civil'].", ";
				$sql = $sql . " 	nome='".utf8_encode($_POST['nome_assis_cad'])."', ";
				$sql = $sql . " 	filiacao='".utf8_encode($_POST['filiacao_assis'])."', ";
				$dtx = explode("/",$_POST['dtnasc_assis']);
				$sql = $sql . " 	dataNascimento='".date("Y-m-d", mktime(0, 0, 0, $dtx[1], $dtx[0], $dtx[2]))."', ";
				$sql = $sql . " 	rg='".$_POST['rg_assis']."', ";
				$sql = $sql . " 	cpf='".$_POST['cpf_assis']."', ";
				$sql = $sql . " 	sexo='".$_POST['sexo_assis']."', ";
				$sql = $sql . " 	nacionalidade='".$_POST['nacionalidade']."', ";
				$sql = $sql . " 	orgaoExpedidor='".$_POST['orgao_exp']."/".$_POST['uf_orgao_exp']."', ";
				$sql = $sql . " 	telefone='".$_POST['tel_assis']."', ";
				$sql = $sql . " 	telefone2='".$_POST['tel_assis2']."', ";
				$sql = $sql . " 	endereco='".utf8_encode($_POST['end_assis'])."', ";
				if($_POST['num_assis'] != ""){
					$sql = $sql . " 	numero=".$_POST['num_assis'].", ";
				}else{
					$sql = $sql . " 	numero=NULL, ";
				}
				$sql = $sql . " 	bairro='".utf8_encode($_POST['bairro_assis'])."', ";
				if($_POST['email'] != ""){
					$sql = $sql . " 	email='".$_POST['email']."', ";
				}else{
					$sql = $sql . " 	email=NULL, ";
				}

				if(isset($_POST['contaend']) AND $_POST['contaend'] > 1 AND $_POST['contaend'] < 4)  {
					if($_POST['contaend'] > 1){
						$sql = $sql . " endereco2='".utf8_encode($_POST['end_assis2'])."', ";
						if($_POST['num_assis2'] != ""){
							$sql = $sql . " numero2=".$_POST['num_assis2'].", ";
						}else{
							$sql = $sql . " numero2=NULL, ";
						}
						$sql = $sql . " bairro2='".utf8_encode($_POST['bairro_assis2'])."', ";
					}
					if($_POST['contaend'] > 2){
						$sql = $sql . " endereco3='".utf8_encode($_POST['end_assis3'])."', ";
						if($_POST['num_assis3'] != ""){
							$sql = $sql . " numero3=".$_POST['num_assis3'].", ";
						}else{
							$sql = $sql . " numero3=NULL, ";
						}
						$sql = $sql . " bairro3='".utf8_encode($_POST['bairro_assis3'])."', ";					
					}
				}
				
				$sql = $sql . " 	cep='".$_POST['cep_assis']."'";
				$sql = $sql . " WHERE idAssistido =".$_POST['idassisedit'];
				
				$db->Execute($sql);			
				$db->Commit();
?>
				<div id="div_msg_desig" class="msg_confirm" style="display:block;">Alteração efetuada com sucesso!</div>	
<?		
				echo "<script> setTimeout('setadivDesig()',750); </script>";
			//}
		}else{	
			if(isset($_POST['bt_desig_assis']) AND $_POST['bt_desig_assis'] == "Designar"){
				
				$dataagora = date('Y-m-d H:i:s');
				/**** Registra Assistência ****/
				$sql = "INSERT INTO assistencias( ";
				$sql = $sql . " idAssistido, ";
				$sql = $sql . " idUsuario, ";
				$sql = $sql . " dataInicio, ";
				$sql = $sql . " dataAtendimento, ";
				$sql = $sql . " preferencial, ";
				$sql = $sql . " senha, ";
				$sql = $sql . " status ";
				$sql = $sql . " )VALUES( ";			
				$sql = $sql . $_POST['idassistido'].",";
				$sql = $sql . $_POST['defensor_assis'].",";
				$sql = $sql ."'".$dataagora."',";
				$sql = $sql ."'".$dataagora."',";
				if($_POST['preferencial'] == "on"){
					$sql = $sql ."'sim',";
				}else{
					$sql = $sql ."'nao',";
				}
				$sql = $sql ."'".$_POST['senha']."',";
				$sql = $sql ."'aberto'";
				$sql = $sql . " ) ";
				
				$db->Execute($sql);
				$idAssistencia = $db->GetLastInsertID();
				$db->Commit();
				
				/**** Registra Histórico da Assistência ****/
				$sql = "INSERT INTO HistoricoAssistencia( ";
				$sql = $sql . " idAssistencia, ";
				$sql = $sql . " idUsuario, ";
				$sql = $sql . " dataAtendimento, ";
				$sql = $sql . " idusercad, ";	
				$sql = $sql . " preferencial, ";							
				$sql = $sql . " casonovo ";
				$sql = $sql . " )VALUES( ";			
				$sql = $sql . $idAssistencia.",";
				$sql = $sql . $_POST['defensor_assis'].",";
				$sql = $sql ."'".$dataagora."', ";
				$sql = $sql . $_SESSION['idUser'].",";
				if($_POST['preferencial'] == "on"){
					$sql = $sql ."'sim', ";
				}else{
					$sql = $sql ."'nao', ";
				}
				if($_POST['retornochk'] == "on"){
					$sql = $sql ."0 ";
				}else{
					$sql = $sql ."1 ";
				}								
				$sql = $sql . " ) ";
				
				$db->Execute($sql);			
				$db->Commit();
	?>
				<div id="div_msg_desig2" class="msg_confirm" style="display:block;">Assistido designado com sucesso!</div>	
	<?		
				echo "<script> setTimeout('setadivDesig()',750); </script>";
			}elseif(isset($_POST['bt_desig_assis']) AND $_POST['bt_desig_assis'] == "Designar Retorno"){
				$dataagora = date('Y-m-d H:i:s');
				/**** Registra Assistência ****/
				$sql = "UPDATE assistencias ";
				$sql = $sql . " SET idUsuario =".$_POST['defensor_assis'].", ";
				$sql = $sql . " 	dataAtendimento='".$dataagora."',";
				$sql = $sql . " 	dataFim=NULL,";
				if($_POST['preferencial'] == "on"){					
					$sql = $sql . "		preferencial='sim', ";
				}else{
					$sql = $sql . "		preferencial='nao', ";
				}			
				$sql = $sql . " 	senha='".$_POST['senha']."', ";
				$sql = $sql . " 	status='retorno' ";				
				$sql = $sql . " WHERE idAssistencia =".$_POST['numAssisRetorno'];
				
				$db->Execute($sql);				
				$db->Commit();
				
				/**** Registra Histórico da Assistência ****/
				$sql = "INSERT INTO HistoricoAssistencia( ";
				$sql = $sql . " idAssistencia, ";
				$sql = $sql . " idUsuario, ";
				$sql = $sql . " dataAtendimento, ";
				$sql = $sql . " idusercad, ";	
				$sql = $sql . " preferencial, ";
				$sql = $sql . " casonovo ";
				$sql = $sql . " )VALUES( ";			
				$sql = $sql . $_POST['numAssisRetorno'].",";
				$sql = $sql . $_POST['defensor_assis'].",";
				$sql = $sql ."'".$dataagora."', ";
				$sql = $sql . $_SESSION['idUser'].",";
				if($_POST['preferencial'] == "on"){
					$sql = $sql ."'sim', ";
				}else{
					$sql = $sql ."'nao', ";
				}					
				if($_POST['retornochk'] == "on"){
					$sql = $sql ."0 ";
				}else{
					$sql = $sql ."1 ";
				}				
				$sql = $sql . " ) ";				
				
				$db->Execute($sql);			
				$db->Commit();
	?>
				<div id="div_msg_desig2" class="msg_confirm" style="display:block;">Assistido designado com sucesso!</div>	
	<?		
				echo "<script> setTimeout('setadivDesig()',750); </script>";
			}else{ ?>		
		
					<div id="busca_assistido" class="formulario">
						<p class="titulo">Buscar Assistido</p>			
						<label for="nome_assis" class="label">Nome: </label>
						<input type="text" class="text" id="nome_assis" name="nome_assis" value="" onkeypress="return verifEnter(event);">
						<input type="button" id="bt_busca" name="bt_busca" value="Buscar" onclick="BuscaAssistido()" style="margin-left:15px;">
						<input type="button" id="bt_cadastra" name="bt_cadastra" value="Cadastrar" onclick="document.getElementById('nome_assis_cad').value = document.getElementById('nome_assis').value; document.getElementById('cadastra_assis').style.display='block'; document.getElementById('busca_assistido').style.display='none'; document.getElementById('show_assis').style.display='none';" style="margin-left:15px;">
					</div>

					<div id="show_assis">
					<table cellpadding="3">
						<thead>
						<tr>
							<th width="400px">Nome</th>
							<th width="400px">Filiação</th>
							<th width="120px">Data Nasc.</th>
							<th width="120px">CPF</th>
							<th>Sexo</th>
							<th width="120px">Telefone</th>
						</tr>
						</thead>	
						<tbody>	
							<tr>
								<td colspan="6" align="center">Nenhum registro encontrado!</td>
							</tr>	
						</tbody>
						<input type="hidden" id="page" name="page" value=""/>
					</table>
					</div>

					<div id="cadastra_assis" name="cadastra_assis" class="formulario" style="display:none;">
						<? include('includes/form_assistido.php'); ?>
					</div>
<? 			}
		}
	} ?>

