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
	$status = $_GET['st'];	
	if($status == "espera"){
		$status = " h.idProvidencia is NULL AND ";
		$titulo = "Assistidos em Espera";
	}else{
		$status = " ";
		$titulo = "Total de Atendimento do Dia";
	}

	$sql = "SELECT h.idAssistencia, a.idAssistido, h.idProvidencia, h.preferencial, h.casonovo, a.senha, ";
	$sql = $sql . " DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome ";
	$sql = $sql . " FROM historicoassistencia h ";
	$sql = $sql . " LEFT OUTER JOIN assistencias a ON h.idAssistencia=a.idAssistencia ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
	$sql = $sql . " WHERE ".$status." h.idUsuario = ".$id." AND h.dataAtendimento BETWEEN TIMESTAMP(CURDATE()) AND TIMESTAMP(CURDATE(),MAKETIME(23,59,59)) ";
	$sql = $sql . " ORDER BY h.dataAtendimento ASC, p.nome ASC ";					
	
	$dt = $db->Execute($sql);
	$dt->MoveNext();
	$n = 1;
	$total = $dt->Count();
?>
<body>
	<p style="text-align:center; font-size:18px;"><?=$titulo?></p>
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px;">
	<tr>
		<th style="padding:8px 0px">ID</th>
		<th>NOME ASSISTIDO</th>
		<th style="padding:0px 5px;">SENHA</th>
		<th style="width:78px; text-align:center;">RETORNO</th>
		<th style="width:100px;">&nbsp;</th>
		<th>DATA DE CADASTRO</th>
	</tr>
	<?
	if($total > 0){

		do{
			$cored = $dt->casonovo==0?"red":"";
	?>		
		<tr id="listassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='corlinha';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" onclick="$('#dialog').remove(); <? if($dt->idProvidencia == ""){?>document.getElementById('div_hist_assis').innerHTML=''; carregaRegistro('<?=$dt->idAssistencia?>');<?}else{?>carregaHistorico('<?=$dt->idAssistencia?>'); carregaRegistro('<?=$dt->idAssistencia?>');<? } ?>">
			<td style="text-align:center;"><?=$n++?></td>
			<td style="text-align:left; padding:4px 10px;">
				<?=strtoupper(utf8_decode($dt->nome))?>
			</td>
			<td style="text-align:center;"><?=$dt->senha?></td>
			<td style="text-align:center;"><font color="<?=$cored?>"><?=$dt->casonovo==0?"SIM":"NÃO"?></font></td>
			<td style="text-align:center; width:100px;"><font color="red"><?=$dt->preferencial=="sim"?"PREFERENCIAL":"&nbsp;"?></font></td>
			<td style="width:160px; margin-left:10px; margin-right:5px; text-align:center;"><?=$dt->dataAtendimento?></td>
		</tr>		
	<?	}while($dt->MoveNext()) ?>
		<tr>
			<td style="padding:4px 2px; text-align:right; padding-right:10px;" colspan="5"><b>Total</b></td>
			<td style="padding:4px 2px; text-align:center;"><?=$total?></td>
		</tr>	
	<? }else {?>
		<tr style="text-align:center;">
			<td style="padding:4px 2px;" colspan="6">Nenhum registro encontrado!</td>
		</tr>
	<? } ?>		
	</table>	
</body>
</html>