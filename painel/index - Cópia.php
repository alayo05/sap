<?	ini_set('date.timezone','America/Campo_Grande'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="SHORTCUT ICON" HREF="../imagens/pena_mini.ico"> 
	<title>Painel de Atendimento - SAP</title>
	<link rel="stylesheet" type="text/css" href="jqdialog.css"/>
	<link href="../includes/padrao_index.css" rel="stylesheet" type="text/css">
	<link href="../jquery/css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" type="text/css" />

	<meta name="description" content="Painel de Atendimento - Assistidos" />
	<meta name="keywords" content="painel, atendimento, assistidos" />
	
	<script src="../jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="../jquery/jquery-ui-1.8.20.custom.min.js" type="text/javascript"></script>		
	<script type="text/javascript" src="jqdialog.min.js"></script>
	<script language="javascript" type="text/javascript" src="../includes/MascaraValidacao.js"></script>
	<script language="javascript" src="../includes/ajax.js"></script>
	<script language="javascript" src="../includes/functions.js"></script>	
</head>

<?php 		

	require_once("../includes/funcoes.php");	
	require_once("../includes/dbcon_obj.php");	
 ?>

<style>
.demo {float: left; margin: auto; width: 100%;}
.column { width: 100%; float: left; padding-bottom: 100px; }
.portlet { margin: 0 1em 1em 0; }
.portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; cursor:move;}
.portlet-header .ui-icon { float: right; cursor:pointer;}
.portlet-content { padding: 0.4em; }
.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
.ui-sortable-placeholder * { visibility: hidden; }
</style>
<script>
$(function() {
	$( ".column" ).sortable({
		connectWith: ".column"
	});

	$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
		.find( ".portlet-header" )
			.addClass( "ui-widget-header ui-corner-all" )
			.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
			.end()
		.find( ".portlet-content" );

	$( ".portlet-header .ui-icon" ).click(function() {
		$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
		$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
	});

	$( ".column" ).disableSelection();
});
</script>

<body>

<div class="demo">

	<div class="column">

		<?
			$sqlP = "SELECT p.idPainel, p.idAssistido, p.idUsuario, p.idAssistencia, a.nome, a2.preferencial, d.nomeCompleto, d.sala  ";
			$sqlP = $sqlP . " FROM painelatendimento p ";
			$sqlP = $sqlP . " LEFT OUTER JOIN assistidos a ON p.idAssistido=a.idAssistido ";
			$sqlP = $sqlP . " LEFT OUTER JOIN dadosusuarios d ON p.idUsuario=d.idUsuario ";
			$sqlP = $sqlP . " LEFT OUTER JOIN assistencias a2 ON a2.idAssistencia=p.idAssistencia ";
			$sqlP = $sqlP . " WHERE p.status='chamar' AND DATE_FORMAT(p.dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
			$sqlP = $sqlP . " ORDER BY p.dataRegistro ASC LIMIT 1 ";

			$dtP = $db->Execute($sqlP);   
			$dtP->MoveNext();						
		?>		
		<div class="portlet">
			<div class="portlet-header">Central de Atendimento</div>
			<div class="portlet-content">
				<div id="painel_chamado">				
					<br>
					<? if($dtP->Count() == 0){ ?>
						<p class="boasvindas">SEJAM BEM VINDOS(AS)</p>
						<p class="boasvindas" style="padding-top:10px"><img src="../imagens/logo_dpge_azul.png" width="250px"/></p>
						<p class="boasvindas" style="padding-top:10px">DEFENSORIA PÚBLICA</p>
						<input type="hidden" id="assispainel" name="assispainel" value="">
						<input type="hidden" id="defenpainel" name="defenpainel" value="">
						<input type="hidden" id="idassis_aux" name="idassis_aux" value="">
						<input type="hidden" id="idpainel" name="idpainel" value="">
						<input type="hidden" id="timereload" name="timereload" value="10000">
					<? }else{ ?>
						<p class="nome"><?=strtoupper(utf8_decode($dtP->nome))?></p>					
						<input type="hidden" id="assispainel" name="assispainel" value="<?=$dtP->idAssistido?>">
						<p class="label_nome">ASSISTIDO(A) <font style="color:red"><?=$dtP->preferencial=="sim"?"PREFERENCIAL":""?></font></p>
						<br>
						<p class="defensor"><?=strtoupper(utf8_decode($dtP->nomeCompleto))." - <blink>".strtoupper(utf8_decode($dtP->sala))."</blink>"?></p>
						<input type="hidden" id="defenpainel" name="defenpainel" value="<?=$dtP->idUsuario?>">
						<input type="hidden" id="idassis_aux" name="idassis_aux" value="<?=$dtP->idAssistencia?>">
						<input type="hidden" id="idpainel" name="idpainel" value="<?=$dtP->idPainel?>">
						<p class="label_defensor">DEFENSOR(A)</p>				
						<embed src="../campainha.wav" loop="0" autostart="true" volume="300" hidden="true">		
						<input type="hidden" id="timereload" name="timereload" value="10000">
					<? } ?>
					<p class="rodape"><?=date("d/m/Y H:i:s")?></p>			
				</div>		
			</div>
		</div>
		
		<?
			$sqlH = "SELECT a.nome, d.sala  ";
			$sqlH = $sqlH . " FROM painelatendimento p ";
			$sqlH = $sqlH . " LEFT OUTER JOIN assistidos a ON p.idAssistido=a.idAssistido ";
			$sqlH = $sqlH . " LEFT OUTER JOIN dadosusuarios d ON p.idUsuario=d.idUsuario ";
			$sqlH = $sqlH . " WHERE p.status='historico' AND DATE_FORMAT(p.dataRegistro,'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') ";
			$sqlH = $sqlH . " ORDER BY p.dataRegistro DESC LIMIT 5 ";
			$dtH = $db->Execute($sqlH);   
						
		?>	
		<!--<div class="portlet">
			<div class="portlet-header">Últimos</div>
			<div class="portlet-content">
				<div id="painel_historico">
					<? if($dtH->Count() == 0){ ?>
							<p class="boasvindas">SEJA BEM VINDO(A)!</p>
					<? }else{ ?>
						<table width="100%">						
					<? 		while($dtH->MoveNext()): ?>
							<tr>
								<td style="width:90%; text-align:left; font-size:18px;" class="historico"><?=strtoupper_utf8($dtH->nome)?></td> 
								<td style="text-align:center; font-size:18px;" class="historico"><?=strtoupper_utf8($dtH->sala)?></td>
							</tr>
					<? 		endwhile; ?>
						</table>
					<? } ?>
				</div>
			</div>
		</div>-->
	</div>
</div><!-- End demo -->

<script type="text/javascript">
<!--
	// jqDialog examples
	
	// notify dialog
	$('#bt-notify').click( function() { $.jqDialog.notify("This dialog will disappear in 3 seconds", 3); } );
	
	// alert dialog
	$('#bt-alert').click(function() {
		$.jqDialog.alert("This is a non intrusive alert", function() {	// callback function for 'OK' button
			$('#message').html('OK');
		});
	} );

	// prompt
	$('#bt-prompt').click( function() {
		$.jqDialog.prompt("Please enter your name",
			'Sam',
			function(data) { $('#message').html(data); },		// callback function for 'OK' button
			function() { $('#message').html('Cancel'); }		// callback function for 'Cancel' button
		);
	} );

	// confirm dialog
	$('#bt-confirm').click( function() {
		$.jqDialog.confirm("Are you sure want to click either of these buttons?",
			function() { $('#message').html('YES'); },		// callback function for 'YES' button
			function() { $('#message').html('NO'); }		// callback function for 'NO' button
		);
	} );
	
	// custom cotent dialog
	$('#bt-content').click( function() {
		$.jqDialog.content('No dialog controls, just custom content<br /><input type="text" name="test" />');
	} );

	// vertical scrollbar
	//for(var i=0; i<50; i++) {
	//	$("#main").append("<p>").append("Scroll to see dialog persistence");
	//}
//-->

	function historicoPainel(){
		var combopainelh = createXMLHTTP();
		combopainelh.open("post","../busca/objHistPainel.php",true);
		combopainelh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combopainelh.onreadystatechange= function()
		{
			if(combopainelh.readyState == 4){				
				document.getElementById("painel_historico").innerHTML = combopainelh.responseText;				
			}
		}	
		combopainelh.send();
	}
	
	
	function atualizaPainel(){
		var combopainel = createXMLHTTP();
		combopainel.open("post","../busca/objRegPainel.php",true);
		combopainel.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		combopainel.onreadystatechange= function()
		{
			if(combopainel.readyState == 4){				
				document.getElementById("painel_chamado").innerHTML = combopainel.responseText;				
				//historicoPainel();
			}
		}	
		var assis = document.getElementById('assispainel').value;
		var defen = document.getElementById('defenpainel').value;				
		var idatend = document.getElementById('idassis_aux').value;
		var idpainel = document.getElementById('idpainel').value;
		combopainel.send("assis="+assis+"&defen="+defen+"&idate="+idatend+"&acao="+idpainel);
	}

	/** ATUALIZA **/
	setInterval("atualizaPainel()",document.getElementById('timereload').value);
</script>	

</body>
</html>