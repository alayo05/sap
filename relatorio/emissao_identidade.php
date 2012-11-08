<?php

require_once("../includes/fpdf_OLD/html2pdf.php");

require_once("../includes/dbcon_obj.php");

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


$text  = '<BR><BR><BR><BR>';
$text .= '<P ALIGN="center"><font size="14" face="Arial"><strong>DEFENSORIA PÚBLICA DE MATO GROSSO DO SUL</strong></font></P>';
$text .= '<p ALIGN="center"><font size="13" face="Arial">COORDENAÇÃO DE 1ª INSTÂNCIA</font></p>';
$text .= '<BR><BR><font size="12" face="Arial">';
$text .= '<P ALIGN="leftoficio">Ofício/Defensoria</P>';
$text .= '<P ALIGN="right">Campo Grande, '.Date("d").' de '.$mes[(int)$nmes].' de '.Date("Y").'</P><br>';

$text .= '<P ALIGN="left">A(o) Senhor(a) Celso José de Souza</p>';
$text .= '<P ALIGN="left">Diretor do Instituto de Identificação do Estado de Mato Grosso do Sul</p>';
$text .= '<P ALIGN="left">Campo Grande/MS</p>';
$text .= '<BR>';

$text .= '<P ALIGN="leftassunto">Assunto:  </p>';
$text .= '<P ALIGN="left"><strong>Emissão de carteira de identidade</strong></p><br>';

$text .= '<p style="text-align:justify; text-indent:100px; line-height:150%;">Senhor Diretor,</p>';

$text .= '<p style="text-align:justify; text-indent:100px; line-height:150%;">Encaminho a Vossa Senhoria o senhor(a) <b>strtoupper(utf8_decode($dt->nome))</b>, $dt->nacionalidade, $dt->nomeEstadoCivil, utf8_decode($dt->nomeProfissao), da comarca de Campo Grande/MS, residente e domiciliado(a) na utf8_decode($dt->endereco), nº $numerostreet, bairro utf8_decode($dt->bairro), na cidade de utf8_decode($dt->nomeCidade), telefone $telefones, a fim de que seja <font style="font-weight:bold; text-decoration:underline;">EMITIDA GRATUITAMENTA</font> a sua primeira <font style="font-weight:bold; text-decoration:underline;">CARTEIRA DE IDENTIDADE</font>, nos termos do parágrafo 3º do artigo 2º da Lei nº 7.116, de 29 de agosto de 1983.</p>';

$text .= '<p style="text-align:justify; text-indent:100px; line-height:150%;">Atenciosamente,</p>';

$text .= '<div style="background:url(\'imagens/assinatura_renato.png\') no-repeat center;">';
$text .= '	<p style="margin-bottom:5px; padding-top:70px;">___________________________________</p>';
$text .= '	<p style="margin-top:0px; margin-top:0px;">RENATO RODRIGUES DOS SANTOS</p>';
$text .= '	<p style="font-size:10pt; margin-top:0px;">Defensor Público</p>';
$text .= '</div>';
$text .= '<br>';
$text .= '<p style="font-size:8pt; margin-bottom:5px;">Rua Antônio Maria Coelho, 1.668</p>';
$text .= '<p style="font-size:8pt; margin-top:0px; margin-bottom:5px;">Centro - Campo Grande/MS</p>';
$text .= '<p style="font-size:8pt; margin-top:0px;">Fone: (67) 3317-4300</p>';
$text .= '</font>';

$pdf=new PDF_HTML();
$pdf->AddPage();

if(ini_get('magic_quotes_gpc')=='1')
	$text=stripslashes($text);
$pdf->Image('..\imagens\logo_DPGE.jpg',90,6,30);
$pdf->WriteHTML($text);
$pdf->Output();
?>