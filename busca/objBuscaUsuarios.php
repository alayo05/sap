<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');

	require_once("../includes/dbcon_obj.php");		
?>

<form id="frm_usuarios" name="frm_usuarios" method="post" action="">
<table cellpadding="3">
	<thead>
	<tr>
		<th width="150px">Nome Usuário</th>
		<th width="150px">Login</th>
		<th width="80px">Tipo de Acesso</th>
		<th width="40px"></th>
	</tr>
	</thead>	
	<tbody>
<?	
	$recordPerPage = 10;
	
	$sql = "SELECT u.idUsuario ";	
	$sql = $sql . " FROM usuarios u ";
	$sql = $sql . " LEFT OUTER JOIN tipoacesso t ON t.idTipoAcesso=u.idTipoAcesso ";
	$sql = $sql . " ORDER BY nomeUsuario ASC ";

	$dt = $db->Execute($sql);    	
	$total = $dt->Count();
	
	$sql = "SELECT u.idUsuario, u.nomeUsuario, u.login, t.nome as tpacesso ";	
	$sql = $sql . " FROM usuarios u ";
	$sql = $sql . " LEFT OUTER JOIN tipoacesso t ON t.idTipoAcesso=u.idTipoAcesso ";
	$sql = $sql . " ORDER BY nomeUsuario ASC ";
	
	/** Paginação **/
	$npage = intval($_POST['page']);
	$maxpage = ceil($total/$recordPerPage);
	$maxlimit = $recordPerPage*$npage;
	if(isset($npage) AND $npage > 1){	
		$sql = $sql . " LIMIT ".$maxlimit.", ".intval($maxlimit-$recordPerPage);
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
				<td align="left" onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=utf8_decode($dt->nomeUsuario)?></td>				
				<td align="left" onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=utf8_decode($dt->login)?></td>				
				<td align="left" onclick="document.getElementById('codusuario').value='<?=$dt->idUsuario?>'; document.frm_usuarios.submit();"><?=utf8_decode($dt->tpacesso)?></td>				
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
						$depois = "Próximo";
						$pgant = $pg;
						$pgdep = $pg+1;											
					elseif($pg == 1 AND $maxpage == $pg):					
						$antes = "Primeiro";
						$depois = "Último";
						$pgant = $pg;
						$pgdep = $pg;						
					elseif($pg > 1 AND $pg < $maxpage):
						$antes = "Anterior";
						$depois = "Próximo";
						$pgant = $pg-1;
						$pgdep = $pg+1;						
					elseif($pg == $maxpage):
						$antes = "Anterior";
						$depois = "Último";
						$pgant = $pg-1;
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