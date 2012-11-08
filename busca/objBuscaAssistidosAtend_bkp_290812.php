<?	session_start();

	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');


	require_once("../includes/dbcon_obj.php");

	$nomeassis = $_POST['nome'];			
	$dtnomeassis = $_POST['dta'];
	
	function strtoupper_utf8($string){
		$string=utf8_decode($string);
		$string=strtoupper($string);
		//$string=utf8_encode($string);
		return $string;
	}		
?>

<table width="100%" cellspacing="0" cellpadding="0">
<?		
	$sql = "SELECT DISTINCT h.idAssistencia, p.idAssistido, x.nomeAcao, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome ";
	$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
	$sql = $sql . " LEFT OUTER JOIN acoes x ON x.idAcao=a.idAcao ";
	$sql = $sql . " WHERE h.idProvidencia <> 0 AND p.nome like '%".$nomeassis."%' ";
	if($dtnomeassis != ""){
		$sql = $sql . " AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y') = '".$dtnomeassis."' ";
	}
	$sql = $sql . " GROUP BY h.idAssistencia, a.dataAtendimento ORDER BY a.dataAtendimento DESC, p.nome ASC ";
	
	$dt = $db->Execute($sql);    
	while($dt->MoveNext()):
?>		
	<tr id="showlistassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('showlistassis<?=$dt->idAssistencia?>').className='corlinhatend';" onmouseout="document.getElementById('showlistassis<?=$dt->idAssistencia?>').className='';" style="cursor:pointer;">
		<td style="text-align:left; padding:4px 4px;" onclick="novoAtend('<?=$dt->idAssistido?>','<?=$_SESSION['idUser']?>')"><img src="imagens/novo.png" width="16px" title="Novo Atendimento"/></td>
		<td style="text-align:left; padding:4px 10px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove();  carregaHistorico('<?=$dt->idAssistencia?>'); carregaRegAtend('<?=$dt->idAssistencia?>');">
			<?=strtoupper(utf8_decode($dt->nome))?>
		</td>
		<td style="margin-left:10px; margin-right:5px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); carregaHistorico('<?=$dt->idAssistencia?>'); carregaRegAtend('<?=$dt->idAssistencia?>');"><?=utf8_decode($dt->nomeAcao)?></td>
		<td style="width:160px; margin-left:10px; margin-right:5px;" onclick="$('#dialog').remove(); $('#dialogVisualizar').remove(); carregaHistorico('<?=$dt->idAssistencia?>'); carregaRegAtend('<?=$dt->idAssistencia?>');"><?=$dt->dataAtendimento?></td>
	</tr>		
<?	endwhile; ?>
</table>