<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos/selecoes.css" rel="stylesheet" type="text/css" />
<link href="css/cadastro.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../includes/MascaraValidacao.js"></script>
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
<script type="text/javascript">
</script>

</head>
<? 
	require_once("../includes/dbcon_obj.php");

	
	if(isset($_POST['buscar']) AND $_POST['buscar'] == "Buscar"){
		$fatonarrado = $_POST['fatonarrado']=="on"?"true":"";			
		$id = $_POST['iddef'];	
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
		$fatonarrado = "";
		$sqlperiodo = " AND DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') ";
		$id = $_GET['iddef'];	
	}
	
	$sql = "SELECT DISTINCT h.idAssistencia, p.idAssistido, a.fatonarrado, x.nomeAcao, u.nomeUsuario, po.nomeProvidencia, DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento, p.nome ";
	$sql = $sql . " FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON a.idassistido=p.idassistido ";
	$sql = $sql . " LEFT OUTER JOIN acoes x ON x.idAcao=a.idAcao ";
	$sql = $sql . " LEFT OUTER JOIN providencias po ON po.idProvidencia=h.idProvidencia ";	
	$sql = $sql . " LEFT OUTER JOIN usuarios u ON u.idUsuario=h.idUsuario ";
	$sql = $sql . " WHERE h.idProvidencia <> 0 AND h.idUsuario = ".$id.$sqlperiodo;	
	$sql = $sql . " GROUP BY h.idAssistencia, h.dataAtendimento ORDER BY h.dataAtendimento ASC, p.nome ASC ";					

	$dt = $db->Execute($sql);
	$dt->MoveNext();
	$total = $dt->Count();
?>
<body>

	<form id="frm_busca_infassis" name="frm_busca_infassis" method="post" style="text-align:center; margin-top:30px;">
	<table width="70%" cellspacing="0" cellpadding="0" style="padding:10px 0px; text-align:center; border: 1px solid #CFCFCF; margin:auto;">
		<tr>
			<td>

				
				<input type="hidden" id="iddef" name="iddef" value="<?=$id?>">
				
				<label for="dtassisatend_ini" style="margin:12px 5px 0px 0px;">Data Início: </label>
				<input type="text" id="dtassisatend_ini" maxlength="10" size="10" name="dtassisatend_ini" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" style="cursor:pointer; width:80px; margin:9px 25px 0px 0px; font-size:12px;" value="<?=(isset($_POST['dtassisatend_ini']))?$_POST['dtassisatend_ini']:""?>"/>
				<label for="dtassisatend_fim" style="margin:12px 5px 0px 0px;">Data Fim: </label>
				<input type="text" id="dtassisatend_fim" maxlength="10" size="10" name="dtassisatend_fim" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);" style="cursor:pointer; width:80px; margin:9px 25px 0px 0px; font-size:12px;" value="<?=(isset($_POST['dtassisatend_fim']))?$_POST['dtassisatend_fim']:""?>"/>
				
				<label for="fatonarrado" style="margin-left:0px;">Fato Narrado </label>
				<input type="checkbox" id="fatonarrado" name="fatonarrado" <?=($fatonarrado!="" AND $fatonarrado == "true")?"checked":""?>/>
			
				
				<input type="submit" id="buscar" name="buscar" value="Buscar" style="margin-left:20px;">				
			</td>
		</tr>
	</table>
	</form>
	
	<p style="text-align:center; font-size:18px;">Histórico de Atendimentos <? if($total > 0){echo "- ".strtoupper(utf8_decode($dt->nomeUsuario));}?> <img style="cursor:pointer; float:right; width:22px; margin:9px 20px 6px;" onclick="window.open('rel_assist_def.php?fato=<?=$fatonarrado?>&iddef=<?=$id?>&dti=<?=$vdata?>&dtf=<?=$vdata2?>','ImprimirAssistidos')" title="Exibe Histórico de Atendimento" src="../imagens/print-button.png"></p>
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px;">
	<tr>
		<th style="padding:8px 0px">ID</th>
		<th>ASSISTIDO</th>
		<th>PROVIDÊNCIA</th>
		<th>AÇÃO</th>		
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
			<td style="padding:4px 2px;"><?=utf8_decode($dt->nome)?></td>
			<td style="padding:4px 2px;"><?=utf8_decode($dt->nomeProvidencia)?></td>
			<td style="padding:4px 2px;"><?=utf8_decode($dt->nomeAcao)?></td>										
			<td style="width:130px;"><?=$dt->dataAtendimento?></td>
		</tr>
		<? if($fatonarrado == "true" AND $dt->fatonarrado != ""){ ?>
		<tr>			
			<td style="padding:4px 3px;" colspan="5"><b>Fato Narrado:</b> <?=utf8_decode($dt->fatonarrado)?></td>
		</tr>		
		<? } ?>
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