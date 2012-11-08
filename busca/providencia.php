<form id="frm_busca_prov" name="frm_busca_prov" method="post" action="principal.php?pg=ep" style="margin:auto; text-align:center;">
<p class="titulo" style="margin-top:0px; margin-bottom:25px;">Providências</p>
<table cellpadding="3" style="margin:auto;">
	<thead>
	<tr>
		<th width="20px">ID</th>
		<th width="250px">Nome Providência</th>		
		<th>&nbsp;</th>
	</tr>
	</thead>	
	<tbody id="div_show_prov">
<?	
	$recordPerPage = 12;
	
	$sql = "SELECT idProvidencia ";	
	$sql = $sql . " FROM providencias ";
	//$sql = $sql . " WHERE statusProvidencia = 1 ";	

	$dt = $db->Execute($sql);    	
	$total = $dt->Count();

	$sql = "SELECT idProvidencia, nomeProvidencia, statusProvidencia ";	
	$sql = $sql . " FROM providencias ";
	//$sql = $sql . " WHERE statusProvidencia = 1 ";
	$sql = $sql . " ORDER BY idProvidencia ASC ";
	
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
			<tr id="cod<?=$dt->idProvidencia?>" onmouseover="document.getElementById('cod<?=$dt->idProvidencia?>').className='corlinha';" onmouseout="document.getElementById('cod<?=$dt->idProvidencia?>').className='';">
				<td onclick="document.getElementById('codprovidencia').value='<?=$dt->idProvidencia?>'; document.frm_busca_prov.submit();"><?=$dt->idProvidencia?></td>
				<td align="left" style="padding-left:10px;" onclick="document.getElementById('codprovidencia').value='<?=$dt->idProvidencia?>'; document.frm_busca_prov.submit();"><?=strtoupper_utf8($dt->nomeProvidencia)?></td>
				<? if($dt->statusProvidencia==1):?>
					<td id="codalt<?=$dt->idProvidencia?>" style="text-align:center;" onclick="if(window.confirm('Cliquem em \'OK\' para confirmar a exclusão!')){delProvidencia('<?=$dt->idProvidencia?>');}"><img src="imagens/remove_fav.png"/></td>
				<? else: ?>
					<td style="text-align:center;"><img title="Providência desativada" src="imagens/remove_fav_cinza.png"/></td>
				<? endif;?>
			</tr>
<? 		endwhile; ?>
			<input type="hidden" id="codprovidencia" name="codprovidencia" value=""/>
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
				<a id="idpagant" style="cursor:pointer; color:#91ac41;" onmouseover="document.getElementById('idpagant').style.color='#5b6b28'" onmouseout="document.getElementById('idpagant').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgant?>'; document.getElementById('frm_busca_prov').action='principal.php?pg=bp'; document.frm_busca_prov.submit();">&#171; <?=$antes?></a> <a style="cursor:pointer; color:#91ac41;" id="idpagdep" onmouseover="document.getElementById('idpagdep').style.color='#5b6b28'" onmouseout="document.getElementById('idpagdep').style.color='#91ac41'" onclick="document.getElementById('page').value='<?=$pgdep?>'; document.getElementById('frm_busca_prov').action='principal.php?pg=bp'; document.frm_busca_prov.submit(); "><?=$depois?> &#187;</a>
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
