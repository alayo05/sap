<form id="frm_busca_acao" name="frm_busca_acao" method="post" action="principal.php?pg=ea" style="margin:auto; text-align:center;">
<p class="titulo" style="margin-top:0px; margin-bottom:25px;">Ações</p>
<table cellpadding="3" style="margin:auto;">
	<thead>
	<tr>
		<th width="20px">ID</th>
		<th width="250px">Nome Ação</th>		
		<th>&nbsp;</th>
	</tr>
	</thead>	
	<tbody id="div_show_prov">
<?	
	$recordPerPage = 12;
	
	$sql = "SELECT idAcao ";	
	$sql = $sql . " FROM acoes ";	

	$dt = $db->Execute($sql);    	
	$total = $dt->Count();

	$sql = "SELECT idAcao, nomeAcao, statusAcao ";	
	$sql = $sql . " FROM acoes ";	
	$sql = $sql . " ORDER BY idAcao ASC ";
	
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
			<tr id="cod<?=$dt->idAcao?>" onmouseover="document.getElementById('cod<?=$dt->idAcao?>').className='corlinha';" onmouseout="document.getElementById('cod<?=$dt->idAcao?>').className='';">
				<td onclick="document.getElementById('codacao').value='<?=$dt->idAcao?>'; document.frm_busca_acao.submit();"><?=$dt->idAcao?></td>
				<td align="left" style="padding-left:10px;" onclick="document.getElementById('codacao').value='<?=$dt->idAcao?>'; document.frm_busca_acao.submit();"><?=strtoupper_utf8($dt->nomeAcao)?></td>
				<? if($dt->statusAcao==1):?>
					<td id="codalt<?=$dt->idAcao?>" style="text-align:center;" onclick="if(window.confirm('Cliquem em \'OK\' para confirmar a exclusão!')){delAcao('<?=$dt->idAcao?>');}"><img src="imagens/remove_fav.png"/></td>
				<? else: ?>
					<td style="text-align:center;"><img title="Ação desativada" src="imagens/remove_fav_cinza.png"/></td>
				<? endif;?>
			</tr>
<? 		endwhile; ?>
			<input type="hidden" id="codacao" name="codacao" value=""/>
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
				<a id="idpagant" style="cursor:pointer; color:#91ac41;" onmouseover="document.getElementById('idpagant').style.color='#5b6b28'" onmouseout="document.getElementById('idpagant').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgant?>'; document.getElementById('frm_busca_acao').action='principal.php?pg=ba'; document.frm_busca_acao.submit();">&#171; <?=$antes?></a> <a style="cursor:pointer; color:#91ac41;" id="idpagdep" onmouseover="document.getElementById('idpagdep').style.color='#5b6b28'" onmouseout="document.getElementById('idpagdep').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgdep?>'; document.getElementById('frm_busca_acao').action='principal.php?pg=ba'; document.frm_busca_acao.submit(); "><?=$depois?> &#187;</a>
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
