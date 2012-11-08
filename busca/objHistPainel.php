<? 	
	require_once("../includes/dbcon_obj.php");
	
	function strtoupper_utf8($string){
		$string=utf8_decode($string);
		$string=strtoupper($string);
		//$string=utf8_encode($string);
		return $string;
	}		
	
	$sqlH = "SELECT a.nome, d.sala  ";
	$sqlH = $sqlH . " FROM painelatendimento p ";
	$sqlH = $sqlH . " LEFT OUTER JOIN assistidos a ON p.idAssistido=a.idAssistido ";
	$sqlH = $sqlH . " LEFT OUTER JOIN dadosusuarios d ON p.idUsuario=d.idUsuario ";
	$sqlH = $sqlH . " WHERE p.status='historico' AND DATE_FORMAT(p.dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
	$sqlH = $sqlH . " ORDER BY p.dataRegistro DESC LIMIT 5 ";
	$dtH = $db->Execute($sqlH);   		
?>

<? if($dtH->Count() == 0){ ?>
		<p class="boasvindas">SEJA BEM VINDO(A)!</p>
<? }else{ ?>
	<table width="100%">						
<? 		while($dtH->MoveNext()): ?>
		<tr>
			<td style="width:90%; text-align:left;" class="historico"><?=strtoupper_utf8($dtH->nome)?></td> 
			<td style="text-align:center;" class="historico"><?=strtoupper_utf8($dtH->sala)?></td>
		</tr>
<? 		endwhile; ?>
	</table>
<? } ?>