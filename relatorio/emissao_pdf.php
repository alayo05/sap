<?php

require_once("../includes/dbcon_obj.php");

//incluindo o arquivo do fpdf
require_once("../includes/fpdf/fpdf.php");
//defininfo a fonte !
//define('FPDF_FONTPATH','fpdf/font/');
//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4

$mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"); 
$nmes = Date("m");

$sql = "SELECT  a.nacionalidade, a.nome, a.filiacao, a.dataNascimento, a.sexo, e.nomeEstadoCivil, p.nomeProfissao, a.RG, a.orgaoExpedidor, a.CPF, a.endereco, a.numero,
				a.bairro, a.CEP, c.nomeCidade, u.sigla, u.nomeEstado , a.telefone, a.telefone2, a.sexo, s.fatonarrado, o.nomeAcao ";
$sql = $sql . " FROM assistidos a ";
$sql = $sql . " LEFT OUTER JOIN assistencias s ON s.idAssistido=a.idAssistido ";
$sql = $sql . " LEFT OUTER JOIN estadocivil e ON a.idEstadoCivil=e.idEstadoCivil ";
$sql = $sql . " LEFT OUTER JOIN profissoes p ON a.idProfissao=p.idProfissao ";
$sql = $sql . " LEFT OUTER JOIN cidades c ON a.idCidade=c.idCidade ";
$sql = $sql . " LEFT OUTER JOIN estados u ON c.idEstado=u.idEstado ";
$sql = $sql . " LEFT OUTER JOIN acoes o ON s.idAcao=o.idAcao ";
//$sql = $sql . " WHERE a.idAssistido=".$ida;
$sql = $sql . " WHERE a.idAssistido=2371";

$dt = $db->Execute($sql); 
$dt->MoveNext();	

$numerostreet = $dt->numero==""?"não informado":$dt->numero;
$telefones = $dt->telefone!=""?$dt->telefone:($dt->telefone2!=""?$dt->telefone." / ".$dt->telefone2:$dt->telefone);

$pdf = new FPDF("P","mm","A4");

$pdf->AddPage();

$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(15);

//define a fonte  a ser usada
$pdf->SetFont('Arial','',10);

// Logo
$pdf->Image('..\imagens\logo_DPGE.jpg',90,6,30);
$pdf->Ln(25);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,8,utf8_decode('DEFENSORIA PÚBLICA DE MATO GROSSO DO SUL'),0,1,'C');

$pdf->SetFont('Arial','',13);
$pdf->Cell(0,8,utf8_decode('COORDENAÇÃO DE 1ª INSTÂNCIA'),0,1,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',11);
$pdf->Cell(30,8,utf8_decode('Oficio/Defensoria'),0,0,'L');
$pdf->Cell(0,8,utf8_decode('Campo Grande, '.Date("d").' de '.$mes[(int)$nmes].' de '.Date("Y")),0,1,'R');

$pdf->Ln(8);
$pdf->Cell(30,8,utf8_decode("A(o) Senhor(a) Celso José de Souza"),0,1,'L');
$pdf->Cell(30,8,utf8_decode("Diretor do Instituto de Identificação do Estado de Mato Grosso do Sul"),0,1,'L');
$pdf->Cell(30,8,utf8_decode("Campo Grande/MS"),0,1,'L');

$pdf->Ln(8);
$pdf->Cell(16,8,utf8_decode("Assunto: "),0,0,'L');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,utf8_decode("Emissão de carteira de identidade"),0,1,'L');

$pdf->SetFont('Arial','',11);
$pdf->Ln(8);
$pdf->Cell(0,8,utf8_decode("Senhor Diretor,"),0,0,'L');

$pdf->Ln(8);
$pdf->MultiCell(40,1,"XXX ",1,'J',0);
$pdf->MultiCell(0,8,"Encaminho a Vossa Senhoria o senhor(a)".strtoupper(utf8_decode($dt->nome)).", ".$dt->nacionalidade.", ".$dt->nomeEstadoCivil.", ".utf8_decode($dt->nomeProfissao).", da comarca de Campo Grande/MS, residente e domiciliado(a) na ".utf8_decode($dt->endereco).utf8_decode(", nº").$numerostreet.", bairro ".utf8_decode($dt->bairro).", na cidade de ".utf8_decode($dt->nomeCidade).", telefone ".$telefones.", a fim de que seja",0,'J',0);




//imprime a saida do arquivo..
$pdf->Output("arquivo","I");

?>