<?	
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	ini_set('date.timezone','America/Campo_Grande');
	
	require_once("../includes/dbcon_obj.php");

	if(isset($_POST['btSalvar']) AND $_POST['btSalvar'] == "Salvar"){
		$sqlU = "UPDATE assistencias ";
		$sqlU = $sqlU . " SET idUsuario =".$_POST['namedef2'].",";
		if($_POST['pref2'] == "on"){					
			$sqlU = $sqlU . "		preferencial='sim', ";
		}else{
			$sqlU = $sqlU . "		preferencial='nao', ";
		}			
		$sqlU = $sqlU . " 	  senha ='".$_POST['senha2']."' ";
		$sqlU = $sqlU . " WHERE idAssistencia =".$_POST['numassist'];
		$db->Execute($sqlU);				
		$db->Commit();	
		
		$sqlH = "UPDATE historicoassistencia ";
		$sqlH = $sqlH . " SET idUsuario =".$_POST['namedef2'].",";
		if($_POST['pref2'] == "on"){					
			$sqlH = $sqlH . "		preferencial='sim', ";
		}else{
			$sqlH = $sqlH . "		preferencial='nao', ";
		}						
		if($_POST['casonovo2'] == "on"){
			$sqlH = $sqlH ."casonovo=0 ";
		}else{
			$sqlH = $sqlH ."casonovo=1 ";
		}						
		$sqlH = $sqlH . " WHERE idHistorico =".$_POST['idhistred'];
		$db->Execute($sqlH);				
		$db->Commit();			
	}	
?>
<script language="javascript" src="../includes/ajax.js"></script>
<script type="text/javascript">
function validaNumDef(){	
	if(document.getElementById('resultnumatend').value >= 15){
		if(window.confirm('Já foram designados '+document.getElementById('resultnumatend').value+' assistidos para esse defensor! \n\n Clique em \'OK\' para confirmar a designação. \n')){
			return true;
		}else{
			return false;
		}
	}
}
function confirmAtend(idef){
	
	var comboassis = createXMLHTTP();
	comboassis.open("post","objNumAtend.php",true);
	comboassis.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	comboassis.onreadystatechange= function()
	{
		if(comboassis.readyState == 4){	
			document.getElementById('resultnumatend').value = comboassis.responseText;
		}		
	}	
	comboassis.send("ndef="+idef);	
}
</script>

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
	$sql = "SELECT s.nome, a.idAssistencia, u.nomeUsuario, a.idUsuario, h.casonovo, h.preferencial, h.idHistorico, a.senha, ";
	$sql = $sql . " DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y %H:%i:%s') as dataAtendimento ";
	$sql = $sql . " FROM assistencias a ";
	$sql = $sql . " LEFT OUTER JOIN usuarios u ON u.idUsuario=a.idUsuario ";
	$sql = $sql . " LEFT OUTER JOIN assistidos s ON a.idAssistido=s.idAssistido ";
	$sql = $sql . " LEFT OUTER JOIN historicoassistencia h ON a.idAssistencia=h.idAssistencia AND DATE_FORMAT(h.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') ";
	$sql = $sql . " WHERE a.status <> 'concluido' AND DATE_FORMAT(a.dataAtendimento,'%d/%m/%Y') = DATE_FORMAT(NOW(),'%d/%m/%Y') AND h.idProvidencia is NULL ";
	if(isset($_POST['nameass']) AND $_POST['nameass'] != ""):
		$sql = $sql . " AND s.nome like '%".$_POST['nameass']."%' ";
	endif;
	if(isset($_POST['namedef']) AND $_POST['namedef'] != ""):
		$sql = $sql . " AND a.idUsuario =".$_POST['namedef'];
	endif;	
	$sql = $sql . " ORDER BY a.dataAtendimento ASC ";						
	
	$dt = $db->Execute($sql);
	$dt->MoveNext();
	$total = $dt->Count();
?>

<script>
	/****** Função captura a tecla ENTER *****/
	function OnEnter(evt)
	{	
		var key_code = evt.keyCode  ? evt.keyCode  :
						   evt.charCode ? evt.charCode :
						   evt.which    ? evt.which    : void 0;

		if (key_code == 13)
		{	
			return true;
		}
	}
	
	function verifEnterEspera(e){
		if(OnEnter(e)){		
			document.getElementById('frm_esp').submit();
		}
	}
</script>

<body>

<? if(isset($_POST['idredesig']) AND $_POST['idredesig'] != ""):?>
	<p style="text-align:center; font-size:18px;">Redesignar Assistido ao Defensor</p>
	<hr style="width:50%;"/>
	<form id="frm_esp" name="frm_esp" method="post" style="text-align:center;" onSubmit="return validaNumDef()">
	<div style="padding-top:30px;">		
		<label for="nameass2" style="margin-left:15px;"><b>Nome Assistido: </b></label> <input type="text" id="nameass2" name="nameass2" value="<?=(isset($_POST['nomeredesig']) AND $_POST['nomeredesig'] != "")?$_POST['nomeredesig']:""?>" size="25" style="width:300px;"><br><br>
		<label for="namedef2" style="margin-left:15px;"><b>Defensores: </b></label> 
		<select id="namedef2" name="namedef2" onchange="confirmAtend(this.value)">
			<option value="">selecione</option>
			<?	$sqlD = "SELECT idUsuario, nomeUsuario FROM usuarios ";
				$sqlD = $sqlD . " WHERE idTipoAcesso = 4 OR idTipoAcesso = 5 ";
				$sqlD = $sqlD . " ORDER BY nomeUsuario ASC ";
				$dtD = $db->Execute($sqlD);
				
				while($dtD->MoveNext()){									
			?>
					<option value="<?=$dtD->idUsuario?>" <?=(isset($_POST['defredesig']) AND $_POST['defredesig']==$dtD->idUsuario)?"selected":""?>><?=ucwords(strtolower(utf8_decode($dtD->nomeUsuario)))?></option>
			<? } ?>
		</select><br><br>
		<label for="senha2" style="margin-left:15px;"><b>Senha: </b></label> <input type="text" id="senha2" name="senha2" value="<?=(isset($_POST['senha']) AND $_POST['senha'] != "")?$_POST['senha']:""?>" size="25" style="width:80px;"><br><br>
		
		<label for="pref2" style="margin-left:15px;"><b>Preferencial: </b></label> <input type="checkbox" id="pref2" name="pref2" <?=($_POST['pref']=="sim")?"checked=checked":""?>><br><br>
		<label for="casonovo2" style="margin-left:15px;"><b>Retorno: </b></label> <input type="checkbox" id="casonovo2" name="casonovo2" <?=($_POST['casonovo']=="0")?"checked=checked":""?>><br><br>				
		
		<br>
		<br><br>
		<input type="hidden" id="numassist" name="numassist" value="<?=(isset($_POST['idredesig']) AND $_POST['idredesig'] != "")?$_POST['idredesig']:""?>">
		<input type="hidden" id="idhistred" name="idhistred" value="<?=(isset($_POST['idhistred']) AND $_POST['idhistred'] != "")?$_POST['idhistred']:""?>"/>
		<input type="hidden" id="resultnumatend" name="resultnumatend" value="">
		<input type="submit" id="btSalvar" name="btSalvar" value="Salvar">
		<input type="button" id="voltar" name="voltar" value="Voltar" onclick="javascript: history.go(-1);">
	</div>
	</form>
<? else: ?>
	<p style="text-align:center; font-size:18px;">Lista de Espera</p>
	
	<form id="frm_esp" name="frm_esp" method="post">
	<div style="padding-top:15px;">
		<label for="nameass" style="margin-left:15px;"><b>Nome Assistido: </b></label> <input type="text" id="nameass" name="nameass" value="<?=(isset($_POST['nameass']) AND $_POST['nameass'] != "")?$_POST['nameass']:""?>" size="25" style="width:200px;" onkeypress="return verifEnterEspera(event);">
		<label for="namedef" style="margin-left:15px;"><b>Defensores: </b></label> 
		<select id="namedef" name="namedef" onchange="document.getElementById('frm_esp').submit();">
			<option value="">selecione</option>
			<?	$sqlD = "SELECT idUsuario, nomeUsuario FROM usuarios ";
				$sqlD = $sqlD . " WHERE idTipoAcesso = 4 OR idTipoAcesso = 5 ";
				$sqlD = $sqlD . " ORDER BY nomeUsuario ASC ";
				$dtD = $db->Execute($sqlD);
				echo $sqlD;
				while($dtD->MoveNext()){									
			?>
					<option value="<?=$dtD->idUsuario?>" <?=(isset($_POST['namedef']) AND $_POST['namedef']==$dtD->idUsuario)?"selected":""?>><?=ucwords(strtolower(utf8_decode($dtD->nomeUsuario)))?></option>
			<? } ?>
		</select>
	</div>
	</form>
	<br>
	<form id="frm_redesig" name="frm_redesig" method="post">
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px;">
	<tr>
		<th style="padding:8px 0px">ID</th>
		<th>NOME DO ASSISTIDO</th>
		<th style="padding:0px 5px;">SENHA</th>
		<th style="width:78px; text-align:center;">RETORNO</th>		
		<th style="width:50px;">PREF.</th>
		<th>DEFENSOR</th>
		<th>DATA CADASTRO</th>
		<th>&nbsp;</th>
	</tr>
	<?
	if($total > 0){

		do{		
				$cored = $dt->casonovo==0?"red":"";		
				$corlinhacao = "corlinha";				
				$cortitle = "";
				
				$rown = '';
				if($fatonarrado == "true" AND $dt->fatonarrado != ""){
					$rown = 'rowspan="2"';
				}
	?>		
		<tr <?=$rown?> id="listassis<?=$dt->idAssistencia?>" onmouseover="document.getElementById('listassis<?=$dt->idAssistencia?>').className='<?=$corlinhacao?>';" onmouseout="document.getElementById('listassis<?=$dt->idAssistencia?>').className='';" style="text-align:center;">
			<td style="padding:4px 3px;" <?=$rown?> ><?=$dt->idAssistencia?></td>
			<td style="padding:4px 2px; text-align:left; padding-left:10px;"><?=strtoupper(utf8_decode($dt->nome))?></td>
			<td style="padding:4px 3px;"><?=$dt->senha?></td>			
			<td style="text-align:center;"><font color="<?=$cored?>"><?=$dt->casonovo==0?"SIM":"NÃO"?></font></td>
			<td style="text-align:center; width:50px;"><font color="red"><?=$dt->preferencial=="sim"?"SIM":"NÃO"?></font></td>
			<td><?=strtoupper(utf8_decode($dt->nomeUsuario))?></td>
			<td style="width:130px;"><?=$dt->dataAtendimento?></td>
			<td style="width:40px; text-align:center;"><img style="cursor:pointer;" title="Redesignar Defensor" width="20" src="../imagens/redesignar.png" onclick="document.getElementById('idredesig').value='<?=$dt->idAssistencia?>'; document.getElementById('nomeredesig').value='<?=strtoupper(utf8_decode($dt->nome))?>'; document.getElementById('defredesig').value='<?=$dt->idUsuario?>'; document.getElementById('casonovo').value='<?=$dt->casonovo?>'; document.getElementById('senha').value='<?=$dt->senha?>'; document.getElementById('pref').value='<?=$dt->preferencial?>'; document.getElementById('idhistred').value='<?=$dt->idHistorico?>'; document.frm_redesig.submit();" onmouseover="this.src='../imagens/redesignar_verde.png'" onmouseout="this.src='../imagens/redesignar.png'"/></td>
		</tr>			
		
	<? }while($dt->MoveNext()); ?>
		<tr>
			<td style="padding:4px 2px; text-align:right; padding-right:10px;" colspan="7"><b>Total</b></td>
			<td style="padding:4px 2px; text-align:center;"><?=$total?></td>
		</tr>
	<? }else {?>
		<tr>
			<td style="padding:4px 2px; text-align:center;" colspan="7">Nenhum registro encontrado!</td>
		</tr>
	<? } ?>
		<input type="hidden" id="idredesig" name="idredesig" value="">
		<input type="hidden" id="nomeredesig" name="nomeredesig" value="">
		<input type="hidden" id="defredesig" name="defredesig" value="">
		<input type="hidden" id="idhistred" name="idhistred" value=""/>
		<input type="hidden" id="casonovo" name="casonovo" value=""/>
		<input type="hidden" id="senha" name="senha" value=""/>
		<input type="hidden" id="pref" name="pref" value=""/>
	</table>
	</form>
<? endif; ?>
</body>
</html>