<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');

	require_once("../includes/dbcon_obj.php");

	$nomeassis = $_POST['nome'];			
?>

<form id="frm_assis_op" name="frm_assis_op" method="post">
<table cellpadding="3">
	<thead>
	<tr>
		<th width="410px">Nome</th>
		<th width="410px"><?=htmlentities("Filiação")?></th>
		<th width="80px">Data Nasc.</th>
		<th width="110px">CPF</th>
		<th>Sexo</th>
		<th width="105px">Telefone</th>
		<th width="40px"></th>
	</tr>
	</thead>	
	<tbody>
<?	
	$recordPerPage = 10;		
	
	$sql = "SELECT *, DATE_FORMAT(dataNascimento,'%d/%m/%Y') as dataNascimento FROM assistidos ";
	$sql = $sql . " WHERE nome LIKE '%".$nomeassis."%' ";
	$sql = $sql . " ORDER BY nome ASC ";

	$dt = $db->Execute($sql);    	
	$total = $dt->Count();
	
	$sql = "SELECT *, DATE_FORMAT(dataNascimento,'%d/%m/%Y') as dataNascimento FROM assistidos ";
	$sql = $sql . " WHERE nome LIKE '%".$nomeassis."%' ";
	$sql = $sql . " ORDER BY nome ASC ";
	
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
			<tr id="linha<?=$dt->idAssistido?>" onmouseover="document.getElementById('linha<?=$dt->idAssistido?>').className='corlinha';" onmouseout="document.getElementById('linha<?=$dt->idAssistido?>').className='';">
				<td align="left" onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=htmlentities(strtoupper(utf8_decode($dt->nome)))?></td>
				<td align="left" onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=htmlentities(strtoupper(utf8_decode($dt->filiacao)))?></td>
				<td onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=$dt->dataNascimento?></td>		
				<td onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=$dt->cpf?></td>
				<td onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=$dt->sexo?></td>
				<td onclick="document.getElementById('idas').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"><?=$dt->telefone?></td>
				<td><img src="imagens/edit-icon.png" style="cursor:pointer;" onclick="document.getElementById('ida').value='<?=$dt->idAssistido?>'; document.frm_assis_op.submit();"/></td>				
			</tr>
<? 		endwhile; ?>
			<input type="hidden" id="idas" name="idas" value=""/>
			<input type="hidden" id="ida" name="ida" value=""/>
		</tbody>
		<tfoot>
		<tr>			
			<td colspan="7" align="right" style="padding-top:15px;"><b><?=htmlentities("Página")?> <?=$pg?> de <?=$maxpage==0?1:$maxpage?></b></td>			
		</tr>
		<tr>
			<td colspan="7">
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
				<a id="idpagant" style="cursor:pointer; color:#91ac41;" onmouseover="document.getElementById('idpagant').style.color='#5b6b28'" onmouseout="document.getElementById('idpagant').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgant?>'; BuscaAssistido();">&#171; <?=$antes?></a> <a style="cursor:pointer; color:#91ac41;" id="idpagdep" onmouseover="document.getElementById('idpagdep').style.color='#5b6b28'" onmouseout="document.getElementById('idpagdep').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgdep?>'; BuscaAssistido();"><?=$depois?> &#187;</a>
			</td>			
		</tr>
		</tfoot>
<?	}else{ ?>
		<tr>
			<td colspan="6" align="center">Nenhum registro encontrado!</td>			
		</tr>	
	</tbody>		
<?	} ?>
<input type="hidden" id="page" name="page" value=""/>
</table>
</form>