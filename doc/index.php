
<?php
	header('Content-Type: text/html; charset=uft-8'); 
	
	require_once('clsMsDocGenerator.php');
	require_once("../includes/dbcon_obj.php");
	
	$mes = array(1 =>"Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
	$nmes = Date("m");
	$doc = new clsMsDocGenerator();	

	$sql = "SELECT  a.nacionalidade, a.nome, e.nomeEstadoCivil, p.nomeProfissao, a.RG, a.orgaoExpedidor, a.CPF, a.endereco, a.numero,
					a.bairro, a.CEP, c.nomeCidade, u.sigla, u.nomeEstado , a.telefone, a.sexo  ";
	$sql = $sql . " FROM assistidos a ";
	$sql = $sql . " LEFT OUTER JOIN estadocivil e ON a.idEstadoCivil=e.idEstadoCivil ";
	$sql = $sql . " LEFT OUTER JOIN profissoes p ON a.idProfissao=p.idProfissao ";
	$sql = $sql . " LEFT OUTER JOIN cidades c ON a.idCidade=c.idCidade ";
	$sql = $sql . " LEFT OUTER JOIN estados u ON c.idEstado=u.idEstado ";
	$sql = $sql . " WHERE a.idAssistido=".$_GET['id'];	
	
	$dt = $db->Execute($sql); 
	$dt->MoveNext();
	
	$doc->addParagraph($doc->bufferImage('http://'.$url.'/'.$raiz.'/imagens/DPGE.jpg'), array('text-align' => 'center'));

	$doc->addParagraph('DEFENSORIA P�BLICA DE MATO GROSSO DO SUL',array('text-align' => 'center','font-size'=>'14pt'));
	$doc->addParagraph('www.defensoria.ms.gov.br',array('text-align' => 'center','font-size'=>'8pt'));
	
	$negrito = array('text-align' => 'center');
	
	$doc->addParagraph('D E C L A R A � � O', array('text-align' => 'center','text-decoration' => 'underline','font-weight' => 'bold','margin-top' => '40px'));

	$paragraphFormat = array('text-align' => 'justify','text-indent' => '100px','line-height' => '150%','margin-top' => '20px', 'font-size'=>'11pt');
	
	if($dt->sexo=="F"){
		$portador = "portadora";
		$domiciliado = "domiciliada";
		$considerado = "considerada";
	}else{
		$portador = "portador";
		$domiciliado = "domiciliado";
		$considerado = "considerado";
	}
	$rg = $dt->RG==""?"n�o informado":$dt->RG." ".$dt->orgaoExpedidor;
	$CPF = $dt->CPF==""?"n�o informado":$dt->CPF;
	$numerostreet = $dt->numero==""?"n�o informado":$dt->numero;
	$CEP = $dt->CEP==""?"n�o informado":$dt->CEP;
	
	$doc->addParagraph('');
	$doc->addParagraph('Eu, <b>'.strtoupper(utf8_decode($dt->nome)).'</b>, '.$dt->nacionalidade.', '.$dt->nomeEstadoCivil.', '.utf8_decode($dt->nomeProfissao).', '.$portador.' da C�lula de Identidade RG n� '.$rg.', e do CPF/MF n� '.$CPF.', residente e '.$domiciliado.' na cidade de '.utf8_decode($dt->nomeCidade).', Estado '.utf8_decode($dt->nomeEstado).', na '.utf8_decode($dt->endereco).', n.� '.$numerostreet.' bairro '.utf8_decode($dt->bairro).', CEP '.$CEP.', <b><u>DECLARO</u></b>, para receber assist�ncia jur�dica integral e gratuita da <b>DEFENSORIA P�BLICA DO ESTADO DE MATO GROSSO DO SUL</b>, n�o dispor de recursos financeiros que me permitam, na defesa de meus direitos e interesses extra ou judicialmente, suportar as despesas processuais e o pagamento de honor�rios advocat�cios, sem preju�zo do pr�prio sustento ou da fam�lia.',$paragraphFormat);

	$doc->addParagraph('Para an�lise e/ou instru��o processual, autorizo a Defensoria P�blica a requisitar informa��es de quem quer que as detenha, ainda que isso importe em quebra de sigilo profissional, m�dico, fiscal, banc�rio e financeiro.', $paragraphFormat);	
	
	$doc->addParagraph('Comprometo-me a guardar os documentos originais que instru�ram o processo, pelo per�odo de 02 (dois) anos ap�s o tr�nsito em julgado da senten�a/ac�rd�o.', $paragraphFormat);	
	
	$doc->addParagraph('Fa�o esta afirma��o sob pena de pagamento de at� o d�cuplo da custas judiciais e apura��o de responsabilidade criminal.', $paragraphFormat);
		
	$doc->addParagraph('Por ser express�o da verdade, firmo a presente.', array('margin-left' => '100px','margin-top' => '20px'));
	
	$doc->addParagraph('Campo Grande/MS, '.Date("d").' de '.$mes[(int)$nmes].' de '.Date("Y").'.', array('margin-left' => '100px','margin-top' => '20px'));
	
	$doc->addParagraph('');
	$doc->addParagraph('_______________________________________', $negrito);
	/*if($dt->CPF != ""){
		$doc->addParagraph('CPF n.� '.$CPF, array('font-weight' => 'bold','text-align' => 'center','margin-top' => '15px'));
	}*/
	if($dt->telefone != ""){
		$doc->addParagraph('Telefone de Contato: '.$dt->telefone,array('font-weight' => 'bold','margin-top' => '40px'));
	}
	
	$doc->output("declaracao_hip_".$_GET['id'].".doc");
?>