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
	
	$idassis = $_GET['id'];		
	
	$sql = "SELECT h.idHistorico, h.descricao, h.idUsuario, p.nome as nome_assistido, u.nomeUsuario, DATE_FORMAT(h.dataCadastro,'%d/%m/%Y %H:%i:%s') as dataCadastro, c.nomeAcao ";
	$sql = $sql . " FROM assistencias a ";
	$sql = $sql . " LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia  ";	
	$sql = $sql . " LEFT OUTER JOIN acoes c ON a.idAcao=c.idAcao  ";
	$sql = $sql . " LEFT OUTER JOIN usuarios u ON h.idUsuario=u.idUsuario ";
	$sql = $sql . " LEFT OUTER JOIN assistidos p ON p.idAssistido=a.idAssistido ";
	$sql = $sql . " WHERE h.idAssistencia=".$idassis;	
	$sql = $sql . " ORDER BY h.dataCadastro ASC ";	

	$dt = $db->Execute($sql);  	
?>
<body>
<center style="font-size:18px; font-weight:bold;">Histórico do Assistido</center>
<br>
<table class="classtable" border="1" cellspacing="0" cellpadding="0" style="font-size:14px;">
<tr>
	<th style="padding:2px;">ID</th>
	<th style="padding:10px;">Assistido</th>
	<th style="padding:10px;">Descrição</th>
	<th style="width:155px;" >Defensor(a)</th>
	<th style="width:200px;" >Ação</th>	
	<th style="width:160px;">Data de Cadastro</th>
<? while($dt->MoveNext()): ?>
<tr>
	<td style="text-align:center;"><?=$dt->idHistorico?></td>
	<td align="left" style="padding:8px; font-size:14px; width:200px;"><?=strtoupper(utf8_decode($dt->nome_assistido))?></td>
	<td align="center" style="padding:8px; text-align: justify; padding-left:5px; width:190px; font-size:14px;"><?=$dt->descricao==""?"&nbsp;":utf8_decode($dt->descricao)?></td>
	<td align="center" style="padding: 8px; font-size:14px;"><?=strtoupper(utf8_decode($dt->nomeUsuario))?></td>
	<td align="center" style="padding: 8px; font-size:14px;"><?=$dt->nomeAcao==""?"&nbsp;":ucwords(utf8_decode($dt->nomeAcao))?></td>	
	<td align="center" style="font-size:14px;"><?=$dt->dataCadastro==""?"&nbsp;":$dt->dataCadastro?></td>
</tr>		
<? endwhile; ?>
</table>
</body>
</html>