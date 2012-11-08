
<?php
	header('Content-Type: text/html; charset=uft-8'); 
	
	require_once('clsMsDocGenerator.php');
	require_once("../includes/dbcon_obj.php");
	
	$mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
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

	$doc->addParagraph('DEFENSORIA PÚBLICA DE MATO GROSSO DO SUL',array('text-align' => 'center','font-size'=>'14pt'));
	$doc->addParagraph('www.defensoria.ms.gov.br',array('text-align' => 'center','font-size'=>'8pt'));
	
	$negrito = array('text-align' => 'center');
	
	$doc->addParagraph('D E C L A R A Ç Ã O', array('text-align' => 'center','text-decoration' => 'underline','font-weight' => 'bold','margin-top' => '40px'));

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
	$rg = $dt->RG==""?"não informado":$dt->RG." ".$dt->orgaoExpedidor;
	$CPF = $dt->CPF==""?"não informado":$dt->CPF;
	$numerostreet = $dt->numero==""?"não informado":$dt->numero;
	$CEP = $dt->CEP==""?"não informado":$dt->CEP;
	
	$doc->addParagraph('');
	$doc->addParagraph('Eu, <b>'.strtoupper(utf8_decode($dt->nome)).'</b>, '.$dt->nacionalidade.', '.$dt->nomeEstadoCivil.', '.utf8_decode($dt->nomeProfissao).', '.$portador.' da Célula de Identidade RG nº '.$rg.', e do CPF/MF nº '.$CPF.', residente e '.$domiciliado.' na cidade de '.utf8_decode($dt->nomeCidade).', Estado '.utf8_decode($dt->nomeEstado).', na '.utf8_decode($dt->endereco).', n.º '.$numerostreet.' bairro '.utf8_decode($dt->bairro).', CEP '.$CEP.', <b><u>DECLARO</u></b>, para receber assistência jurídica integral e gratuita da <b>DEFENSORIA PÚBLICA DO ESTADO DE MATO GROSSO DO SUL</b>, não dispor de recursos financeiros que me permitam, na defesa de meus direitos e interesses extra ou judicialmente, suportar as despesas processuais e o pagamento de honorários advocatícios, sem prejuízo do próprio sustento ou da família.',$paragraphFormat);

	$doc->addParagraph('Para análise e/ou instrução processual, autorizo a Defensoria Pública a requisitar informações de quem quer que as detenha, ainda que isso importe em quebra de sigilo profissional, médico, fiscal, bancário e financeiro.', $paragraphFormat);	
	
	$doc->addParagraph('Comprometo-me a guardar os documentos originais que instruíram o processo, pelo período de 02 (dois) anos após o trânsito em julgado da sentença/acórdão.', $paragraphFormat);	
	
	$doc->addParagraph('Faço esta afirmação sob pena de pagamento de até o décuplo da custas judiciais e apuração de responsabilidade criminal.', $paragraphFormat);
		
	$doc->addParagraph('Por ser expressão da verdade, firmo a presente.', array('margin-left' => '100px','margin-top' => '20px'));
	
	$doc->addParagraph('Campo Grande/MS, '.Date("d").' de '.$mes[(int)$nmes].' de '.Date("Y").'.', array('margin-left' => '100px','margin-top' => '20px'));
	
	$doc->addParagraph('');
	$doc->addParagraph('_______________________________________', $negrito);
	/*if($dt->CPF != ""){
		$doc->addParagraph('CPF n.º '.$CPF, array('font-weight' => 'bold','text-align' => 'center','margin-top' => '15px'));
	}*/
	if($dt->telefone != ""){
		$doc->addParagraph('Telefone de Contato: '.$dt->telefone,array('font-weight' => 'bold','margin-top' => '40px'));
	}
	
	$doc->output("declaracao_hip_".$_GET['id'].".doc");
?>