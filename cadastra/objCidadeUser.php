<? 
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
	
	require_once("../includes/dbcon_obj.php");
	
	$iduf = $_POST['iduf'];		

	$sql = "SELECT * FROM cidades ";
	$sql = $sql . " WHERE idEstado =".$iduf;
	$sql = $sql . " ORDER BY nomeCidade ASC ";
	$dt = $db->Execute($sql);    
?>	

<select id="cid_usuario" name="cid_usuario">
<?	while($dt->MoveNext()): ?>
		<option value="<?=$dt->idCidade?>"><?=utf8_decode($dt->nomeCidade)?></option>	
<?	endwhile; ?>
</select>
