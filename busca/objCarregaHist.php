<style>
	<!--[if !lt IE 6]>
	.classtable{
		width:97%;
	}
	<![endif]-->
	.classtable{
		width:100%;
	}
</style>
<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');

	require_once("../includes/dbcon_obj.php");

	function html_strtoupper_utf8($string){
		$string=utf8_decode($string);
		$string=strtoupper($string);		
		$string=htmlentities($string);	
		
		//$string=utf8_encode($string);
		return $string;
	}

	function html_utf8($string){
		$string=utf8_decode($string);		
		$string=htmlentities($string);	
		
		//$string=utf8_encode($string);
		return $string;
	}	
	
	$idassis = $_POST['assis'];		

	$sql = "SELECT h.descricao, h.idUsuario, u.nomeUsuario, DATE_FORMAT(h.dataCadastro,'%d/%m/%Y %H:%i:%s') as dataCadastro FROM assistencias a LEFT OUTER JOIN historicoassistencia h ON a.idassistencia=h.idAssistencia  ";
	$sql = $sql . " LEFT OUTER JOIN usuarios u ON h.idUsuario=u.idUsuario ";
	$sql = $sql . " WHERE h.idAssistencia=".$idassis." AND h.descricao <> '' ";	
	$sql = $sql . " ORDER BY h.dataCadastro DESC ";	
	
	$dt = $db->Execute($sql);  	
?>

<table class="classtable">
<? while($dt->MoveNext()): ?>
<tr>
	<td align="left" style="padding:8px 0px; text-align: justify; padding-left:5px; width:280px;"><?=html_utf8($dt->descricao)?></td>
	<td align="center" style="width:57px; padding: 8px;"><?=html_utf8($dt->nomeUsuario)?></td>
	<td align="left" style="width:147px;"><?=$dt->dataCadastro?></td>
</tr>		
<? endwhile; ?>
</table>