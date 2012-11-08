<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos/selecoes.css" rel="stylesheet" type="text/css" />
<link href="css/cadastro.css" rel="stylesheet" type="text/css" />
<style>
	<!--[if !lt IE 6]>
	.classtable{
		width:100%;		
	}
	<![endif]-->
	.classtable{
		width:100%;		
	}
</style>
</head>
<? 
	require_once("../includes/dbcon_obj.php");
	
	$id = $_GET['id'];		
	$fatonarrado = $_GET['fn'];
	
	$sql = "SELECT DISTINCT a.idAssistencia, a.fatonarrado, s.nome, p.nomeProvidencia, a.idProvidencia, c.nomeAcao, u.nomeUsuario, DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento ";
	$sql = $sql . " FROM assistencias a LEFT OUTER JOIN providencias p ON a.idProvidencia=p.idProvidencia ";
	$sql = $sql . " 					LEFT OUTER JOIN acoes c ON a.idAcao=c.idAcao ";
	$sql = $sql . " 					LEFT OUTER JOIN usuarios u ON u.idUsuario=a.idUsuario ";
	$sql = $sql . " 					LEFT OUTER JOIN assistidos s ON a.idAssistido=s.idAssistido ";
	$sql = $sql . " WHERE a.idAssistido = ".$id." AND a.status = 'concluido' ";
	$sql = $sql . " ORDER BY a.dataAtendimento DESC ";						
	
	$dt = $db->Execute($sql);
	$dt->MoveNext();
	$total = $dt->Count();
?>
<body>
	<p style="text-align:center; font-size:18px;">Histórico de Atendimentos <? if($total > 0){echo "- ".$dt->nome;}?> <img style="cursor:pointer; float:right; width:22px; margin:9px 20px 6px;" onclick="window.print()" title="Exibe Histórico de Atendimento" src="../imagens/print-button.png"></p>
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px;">
	<tr>
		<th style="padding:8px 0px">ID</th>
		<th>PROVIDÊNCIA</th>
		<th>AÇÃO</th>
		<th>DEFENSOR</th>
		<th>DATA CADASTRO</th>
	</tr>
	<?
	if($total > 0){

		do{			
			$corlinhacao = "corlinha";			
			$cortitle = "";
			
			$rown = '';
			if($fatonarrado == "true" AND $dt->fatonarrado != ""){
				$rown = 'rowspan="2"';
		}
	?>		
		<tr <?=$rown?> id="listassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='<?=$corlinhacao?>';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" style="text-align:center;">
			<td style="padding:4px 3px;" <?=$rown?> ><?=$dt->idAssistencia?></td>
			<td style="padding:4px 2px;"><?=utf8_decode($dt->nomeProvidencia)?></td>
			<td style="padding:4px 2px;"><?=utf8_decode($dt->nomeAcao)?></td>							
			<td><?=strtoupper(utf8_decode($dt->nomeUsuario))?></td>
			<td style="width:130px;"><?=$dt->dataAtendimento?></td>
		</tr>
		<? if($fatonarrado == "true" AND $dt->fatonarrado != ""):?>
		<tr>			
			<td style="padding:4px 3px;" colspan="5"><b>Fato Narrado:</b> <?=utf8_decode($dt->fatonarrado)?></td>
		</tr>		
		<? endif; ?>
	<? }while($dt->MoveNext()); ?>
		<tr>
			<td style="padding:4px 2px; text-align:right; padding-right:10px;" colspan="4"><b>Total</b></td>
			<td style="padding:4px 2px; text-align:center; width:130px;"><?=$total?></td>
		</tr>
	<? }else {?>
		<tr style="text-align:center;">
			<td style="padding:4px 2px;" colspan="5">Nenhum registro encontrado!</td>
		</tr>
	<? } ?>
	
		<input type="hidden" id="idasRet2" name="idasRet2" value="<?=$id?>"/>
		<input type="hidden" id="idasRetorno" name="idasRetorno" value=""/>
	</table>

</body>
</html>