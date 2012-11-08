	<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');

	if(isset($_POST['buscar']) AND $_POST['buscar'] == "Buscar"){
		$totalgeral = $_POST['totalgeral'];			

		$vdata ="";
		$vdata2="";
		
		if(isset($_POST['dtassisatend_ini']) AND $_POST['dtassisatend_ini'] !=""){
			$vdata = $_POST['dtassisatend_ini'];
			$vdata = explode("/",$vdata);
			$vdata = $vdata[2]."-".$vdata[1]."-".$vdata[0];
			if(isset($_POST['dtassisatend_fim']) AND $_POST['dtassisatend_fim'] != ""){
				$vdata2 = $_POST['dtassisatend_fim'];
				$vdata2 = explode("/",$vdata2);
				$vdata2 = $vdata2[2]."-".$vdata2[1]."-".$vdata2[0];
				$sqlperiodo = " AND h.dataAtendimento BETWEEN '".$vdata." 00:00:00' AND '".$vdata2." 23:59:59' ";
			}else{
				$sqlperiodo = " AND h.dataAtendimento BETWEEN '".$vdata." 00:00:00' AND DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:%s') ";
			}
		}else{
			$sqlperiodo = " AND DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') ";
		}		
		
	}else{
		$totalgeral = "";
		$sqlperiodo = " AND DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') ";			
	}	
	
	if($totalgeral == "atendente"){		
		$listuser = "";
		if(count($_POST['nomeatend']) > 0 AND $_POST['nomeatend'][0] != "todos"){
			$listuser = " AND (";
			foreach($_POST['nomeatend'] as $value):
				$listuser = $listuser." h.idusercad=".$value." OR";
			endforeach;
			$listuser = substr($listuser,0,-3);
			$listuser = $listuser.") ";					
		}
		$stsatend = "display:block";
		$sql = "select count(h.idHistorico) as total, u.nomeUsuario ";
		$sql = $sql . " from historicoassistencia h ";
		$sql = $sql . " left outer join usuarios u on u.idUsuario=h.idusercad ";
		$sql = $sql . " where 1=1 ".$sqlperiodo.$listuser;
		$sql = $sql . " group by u.nomeUsuario ";
		$sql = $sql . " order By u.idTipoAcesso , u.nomeUsuario ";
		$dt = $db->Execute($sql);
		
		$total = $dt->Count();		
	}else{
		$stsatend = "display:none";
		$sql = "select ";
		$sql = $sql . " (select count(h.idAssistencia) from historicoassistencia h where h.idProvidencia is NULL ".$sqlperiodo.") as espera,  ";
		$sql = $sql . " (select count(h.idAssistencia) from historicoassistencia h where 1=1 ".$sqlperiodo.") as total, ";
		$sql = $sql . " (select count(h.idAssistencia) from historicoassistencia h where h.casonovo = 0 ".$sqlperiodo.") as qtde_retorno  ";
		$sql = $sql . " from usuarios u left outer join dadosusuarios d on (u.idUsuario=d.idUsuario) where u.idTipoAcesso = 4 OR u.idTipoAcesso = 5  ";
		$sql = $sql . " group by espera, total, qtde_retorno ";	
		$dt = $db->Execute($sql);
		$dt->MoveNext();
		$total = $dt->Count();		
	}

?>

	<form id="frm_busca_infassis" name="frm_busca_infassis" method="post" style="text-align:center; margin-top:10px;">

	<table width="60%" cellspacing="0" cellpadding="0" style="padding:10px 0px; text-align:center; border: 1px solid #CFCFCF; margin:auto;">
			<tr style="vertical-align:top;">
				<td>
					<table>
					<tr>
						<input type="hidden" id="iddef" name="iddef" value="">
						<td style="text-align:right;"><label for="dtassisatend_ini">Data Início: </label></td>
						<td><input type="text" id="dtassisatend_ini" maxlength="10" size="10" name="dtassisatend_ini" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" style="cursor:pointer; width:80px; vertical-align:top; padding-left:5px; margin:0px 25px 0px 0px; font-size:12px;" value="<?=(isset($_POST['dtassisatend_ini']))?$_POST['dtassisatend_ini']:DATE("d/m/Y")?>"/></td>
						<td style="text-align:right;"><label for="dtassisatend_fim">Data Fim: </label></td>
						<td><input type="text" id="dtassisatend_fim" maxlength="10" size="10" name="dtassisatend_fim" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" style="cursor:pointer; width:80px; vertical-align:top; padding-left:5px; font-size:12px;" value="<?=(isset($_POST['dtassisatend_fim']))?$_POST['dtassisatend_fim']:DATE("d/m/Y")?>"/></td>
					</tr>
					<tr>
						<td style="text-align:right; padding-left:10px;"><label>Relatório Geral: </label></td>
						<td style="text-align:left; padding-left:5px;"><input type="radio" id="totalgeral" name="totalgeral" value="geral" onclick="document.getElementById('idnomeatend').style.display='none'" style="vertical-align:top;" <?=($totalgeral=="")?"checked":($totalgeral=="geral"?"checked":"")?>/></td>
						<td style="text-align:right;"><label>Por Atendente: </label></td>
						<td style="text-align:left; padding-left:5px;"><input type="radio" id="totalgeral" name="totalgeral" value="atendente" onclick="document.getElementById('idnomeatend').style.display='block'" style="text-align:left;" <?=($totalgeral!="" AND $totalgeral=="atendente")?"checked":""?> /></td>
					</tr>
					</table>
				</td>
				<td id="idnomeatend" style="<?=$stsatend?>">
					<label for="nomeatend" style="margin-left:15px; vertical-align:top;"><b>Atendentes: </b></label> 
					<select id="nomeatend" name="nomeatend[]" multiple style="height:100px;">
						<option value="todos" <?=(isset($_POST['nomeatend']) AND in_array("todos", $_POST['nomeatend']))?"selected":(!isset($_POST['nomeatend'])?"selected":"")?>>Todos</option>
						<?	$sqlD = "SELECT idUsuario, nomeUsuario FROM usuarios ";
							$sqlD = $sqlD . " WHERE idTipoAcesso = 2 ";
							$sqlD = $sqlD . " ORDER BY nomeUsuario ASC ";
							$dtD = $db->Execute($sqlD);
							echo $sqlD;
							
							while($dtD->MoveNext()){									
						?>
								<option value="<?=$dtD->idUsuario?>" <?=(isset($_POST['nomeatend']) AND in_array($dtD->idUsuario, $_POST['nomeatend']))?"selected":""?>><?=ucwords(strtolower(utf8_decode($dtD->nomeUsuario)))?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center; padding-top:10px;"><input type="submit" id="buscar" name="buscar" value="Buscar" style="margin-left:20px; vertical-align:top;"></td>
			</tr>
		</table>
		
	<? if($totalgeral == "atendente"){	?>

		<p style="text-align:center; font-size:18px; margin-top:35px; ">Total de Atendimentos por Atendente</p>		
		
		<table width="50%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; margin:auto;">
		<tr>
			<th style="padding:8px 0px">NOME</th>			
			<th style="padding:0px 5px;">TOTAL DE ATENDIMENTO</th>
		</tr>
		<? if($total > 0){
			$somatotal = 0;
			  while($dt->MoveNext()){
		?>
		
			  <tr style="text-align:center;">
				<td style="padding:4px 3px;"><?=ucwords(strtolower(utf8_decode($dt->nomeUsuario)))?></td>			
				<td style="padding:4px 3px;"><?=$dt->total?></td>			
			  </tr>
		<? 	  $somatotal=$somatotal+$dt->total;
			  }?>
			  <tr style="text-align:center;">
				<td style="padding:4px 3px;"><b>Total</b></td>			
				<td style="padding:4px 3px;"><?=$somatotal?></td>			
			  </tr>			  
		<?	}else{ ?>
			<tr>
				<td style="padding:4px 2px; text-align:center;" colspan="2">Nenhum registro encontrado!</td>
			</tr>
		<? } ?>
		
		</table>	
	
	<? }else{ ?>			
		
		<p style="text-align:center; font-size:18px; margin-top:35px; ">Relatório Geral</p>		
		
		<table width="50%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; margin:auto;">
		<tr>
			<th style="padding:8px 0px">TOTAL</th>
			<th>CASO NOVO</th>
			<th style="padding:0px 5px;">RETORNO</th>
		</tr>
		<? if($total > 0){
		?>
		
		<tr style="text-align:center;">
			<td style="padding:4px 3px;"><?=$dt->total?></td>
			<td style="padding:4px 2px; padding-left:10px;"><?=($dt->total-$dt->qtde_retorno)?></td>
			<td style="padding:4px 3px;"><?=$dt->qtde_retorno?></td>			
		</tr>
		<? }else{ ?>
			<tr>
				<td style="padding:4px 2px; text-align:center;" colspan="6">Nenhum registro encontrado!</td>
			</tr>
		<? } ?>
		
		</table>
	<? } ?>
	</form>