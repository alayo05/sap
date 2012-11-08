
<?php
	header('Content-Type: text/html; charset=uft-8'); 
	
	require_once('clsMsDocGenerator.php');
	require_once("../includes/dbcon_obj.php");
	
	$mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
	$nmes = Date("m");
	$doc = new clsMsDocGenerator('PORTRAIT','A4','',1.5,2,2.0,2);

	$sql = "SELECT  a.nacionalidade, a.nome, a.filiacao, a.dataNascimento, a.sexo, e.nomeEstadoCivil, p.nomeProfissao, a.RG, a.orgaoExpedidor, a.CPF, a.endereco, a.numero,
					a.bairro, a.CEP, c.nomeCidade, u.sigla, u.nomeEstado , a.telefone, a.telefone2, a.sexo, s.fatonarrado, o.nomeAcao ";
	$sql = $sql . " FROM assistidos a ";
	$sql = $sql . " LEFT OUTER JOIN assistencias s ON s.idAssistido=a.idAssistido ";
	$sql = $sql . " LEFT OUTER JOIN estadocivil e ON a.idEstadoCivil=e.idEstadoCivil ";
	$sql = $sql . " LEFT OUTER JOIN profissoes p ON a.idProfissao=p.idProfissao ";
	$sql = $sql . " LEFT OUTER JOIN cidades c ON a.idCidade=c.idCidade ";
	$sql = $sql . " LEFT OUTER JOIN estados u ON c.idEstado=u.idEstado ";
	$sql = $sql . " LEFT OUTER JOIN acoes o ON s.idAcao=o.idAcao ";
	$sql = $sql . " WHERE a.idAssistido=".$_GET['id'];
	if($_GET['ida'] != ""){
		$sql = $sql . " AND s.idAssistencia=".$_GET['ida'];
	}
	
	$dt = $db->Execute($sql); 
	$dt->MoveNext();
	
	$doc->addParagraph('DEFENSORIA PÚBLICA DE MATO GROSSO DO SUL',array('text-align' => 'center','font-size'=>'14pt'));
	
	$negrito = array('text-align' => 'center');
	
	$paragraphFormat = array('line-height' => '150%','margin-top' => '20px','font-size'=>'11pt');
	
	$rg = $dt->RG==""?"não informado":$dt->RG." ".$dt->orgaoExpedidor;
	$CPF = $dt->CPF==""?"não informado":$dt->CPF;
	$numerostreet = $dt->numero==""?"não informado":$dt->numero;
	$CEP = $dt->CEP==""?"não informado":$dt->CEP;
	$nomesexo = $dt->sexo=="F"?"Feminino":"Masculino";
	$telefones = $dt->telefone!=""?$dt->telefone:($dt->telefone2!=""?$dt->telefone." / ".$dt->telefone2:$dt->telefone);
	
	$doc->addParagraph('');
	$doc->addParagraph('<b>Nome:</b> '.strtoupper(utf8_decode($dt->nome)).', <b>Filiação: </b>'.strtoupper(utf8_decode($dt->filiacao)).', <b>Data de Nasc.: </b>'.($dt->dataNascimento).', <b>RG nº </b>'.$rg.', e do <b>CPF/MF nº </b>'.$CPF.', <b>Sexo:</b> '.$nomesexo.', <b>Telefone:</b> '.$telefones.', <b>Nacionalidade: </b>'.$dt->nacionalidade.', <b>Estado Civil:</b> '.$dt->nomeEstadoCivil.', <b>Profissão: </b>'.utf8_decode($dt->nomeProfissao).', <b>Cidade:</b> '.utf8_decode($dt->nomeCidade).', <b>Estado </b>'.utf8_decode($dt->nomeEstado).', na '.utf8_decode($dt->endereco).',<b> n.º </b>'.$numerostreet.' <b>bairro </b>'.utf8_decode($dt->bairro).', <b>CEP </b>'.$CEP.'.',$paragraphFormat);

	if($dt->fatonarrado != ""){
		$doc->addParagraph('<b>Fato narrado: </b>'.utf8_decode($dt->fatonarrado),array('text-align' => 'justify','line-height' => '150%','margin-top' => '20px'));
	}	
		$doc->addParagraph('<b>Nº Atendimento: </b>'.$_GET['ida'],array('text-align' => 'justify','line-height' => '150%','margin-top' => '20px'));
		$doc->addParagraph('<b>Ação: </b>'.utf8_decode($dt->nomeAcao),array('text-align' => 'justify','line-height' => '150%','margin-top' => '20px'));

	
	if($_GET['ida'] != ""){
		$sqlA = "SELECT h.idUsuario, h.idProvidencia, h.descricao, h.dataAtendimento, u.nomeUsuario ";
		$sqlA = $sqlA . " FROM historicoassistencia h ";
		$sqlA = $sqlA . " LEFT OUTER JOIN usuarios u ON h.idUsuario=u.idUsuario ";
		$sqlA = $sqlA . " WHERE h.idAssistencia = ".$_GET['ida'];
		$sqlA = $sqlA . " ORDER BY h.dataAtendimento ASC ";
		$dtA = $db->Execute($sqlA);			
		
		$doc->addParagraph('');
		
		$doc->startTable();	
		$doc->addTableRow(array("Providência", "Data Atendimento", "Defensor(a)"),NULL,NULL,array('font-weight'=>'bold','text-align'=>'center'));
		
		while($dtA->MoveNext()):
			$vetarray = array();
			$dt = explode(" ",$dtA->dataAtendimento);
			$dt1 = explode("-",$dt[0]);		
			array_push($vetarray, utf8_decode($dtA->descricao),$dt1[2]."/".$dt1[1]."/".$dt1[0]." ".$dt[1], utf8_decode($dtA->nomeUsuario));
			$doc->addTableRow($vetarray,NULL,NULL,array('text-align'=>'center'));
		endwhile;	

		$doc->endTable();
	}
	
	$doc->addParagraph('');
	$doc->addParagraph('');
	$doc->addParagraph('Campo Grande/MS, '.Date("d").' de '.$mes[(int)$nmes].' de '.Date("Y").'.', array('text-align' => 'center','margin-top' => '20px'));
	
	$doc->addParagraph('');
	$doc->addParagraph('');
	$doc->addParagraph('_______________________________________', $negrito);
	/*if($dt->CPF != ""){
		$doc->addParagraph('CPF n.º '.$CPF, array('font-weight' => 'bold','text-align' => 'center','margin-top' => '15px'));
	}*/
	
	$doc->output("atend_".$_GET['id'].".doc");
?>