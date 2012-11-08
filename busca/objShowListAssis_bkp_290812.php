<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');

	session_start();
	
	require_once("../includes/dbcon_obj.php");
	
	$sql = "SELECT defensorVinculado FROM usuarios ";
	$sql = $sql . " WHERE idUsuario=".$_SESSION['idUser'];			
	$dtVinc = $db->Execute($sql); 
	$dtVinc->MoveNext();
	
	if($dtVinc->defensorVinculado == 0){
		$idaparece = $_SESSION['idUser'];
	}else{
		$idaparece = $dtVinc->defensorVinculado;
	}	
?>

<table width="100%" cellspacing="0" cellpadding="0">
<?		
/*	if($idaparece==9 OR $idaparece==1){
		$sql = "SELECT DISTINCT a.idAssistencia, a.idAssistido, a.idProvidencia, a.preferencial, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
		$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
		$sql = $sql . " WHERE a.status <> 'concluido' AND a.idUsuario = ".$idaparece." AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y')=DATE_FORMAT('2012-07-10','%d/%m/%Y') ";
		$sql = $sql . " ORDER BY a.dataAtendimento ASC, p.nome ASC ";			
		
	}else{
	*/
		$sql = "SELECT DISTINCT a.idAssistencia, a.idAssistido, a.idProvidencia, a.preferencial, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
		$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
		$sql = $sql . " WHERE a.status <> 'concluido' AND a.idUsuario = ".$idaparece." AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
		$sql = $sql . " ORDER BY a.dataAtendimento ASC, p.nome ASC ";
//	}
			
	$dt = $db->Execute($sql);    
	while($dt->MoveNext()):
?>		
	<tr id="listassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='corlinha';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" style="cursor:pointer;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); <? if($dt->idProvidencia == ""){?>document.getElementById('div_hist_assis').innerHTML=''; carregaRegistro('<?=$dt->idAssistencia?>');<?}else{?>carregaHistorico('<?=$dt->idAssistencia?>'); carregaRegistro('<?=$dt->idAssistencia?>');<? } ?>">
		<td style="text-align:left; padding:4px 10px;">
			<?=strtoupper(utf8_decode($dt->nome))?>
		</td>
		<td style="color:red;"><?=$dt->preferencial=="sim"?"Preferencial":""?></td>
		<td style="width:160px; margin-left:10px; margin-right:5px;"><?=$dt->dataAtendimento?></td>
	</tr>		
<?	endwhile; ?>
</table>