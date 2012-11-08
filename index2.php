<?php 	
	session_start();	
	if($_SESSION['status'] == "logado"){		
		echo "<script>location.href='principal.php';</script>"; 
	}
	ini_set('date.timezone','America/Campo_Grande');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos/selecoes.css" rel="stylesheet" type="text/css" />
<link href="css/cadastro.css" rel="stylesheet" type="text/css" />
<link rel="SHORTCUT ICON" HREF="imagens/pena_mini.ico"> 
<style type="text/css">
<!--
	.style2 {
		font-size: 12pt;
		font-weight: bold;
	}
	.style22 {
		font-size: 14pt;
		font-weight: bold;
		color: #00642F;
	}
	.style3 {color: #00642D}
	.style4 {
		font-size: 18px
	}
	.style5 {font-size: 10pt}
-->
</style>

<!--[if !lt IE 6]><!-->
<style type="text/css">
	.texto {width:145px;}	
</style>
<!--<![endif]-->

</head>
<script language="javascript" type="text/javascript">
function verifica()
{
	var erro = "";
	if (document.login.usuario.value == "")
	{
		erro = erro + "Campo USUARIO não pode ser vazio! \n";
		document.getElementById("error").innerHTML = erro;
		document.login.usuario.focus();
		return false;
	}
	else
	{
		if (document.login.senha.value == "")
		{
			erro = erro + "Campo SENHA não pode ser vazio! \n";
			document.getElementById("error").innerHTML = erro;
			document.login.senha.focus();
			return false;
		}
		else
		{
			if (document.login.newsenha.value == "trocasenha" && document.login.novasenha.value == "" && !valida_senha(document.login.novasenha))
			{
				erro = erro + "Campo NOVA SENHA não pode ser vazio! \n";
				document.getElementById("error").innerHTML = erro;
				document.login.novasenha.focus();				
				return false;
			}
		}
	}
	return true;
}

function valida_senha(campo)
{	

	if (document.login.novasenha.value.length < "6")
	{
		alert("Nova senha não pode ser menor que 6 digitos!");
		document.login.novasenha.focus();
		return false;
	}
	
	valor = campo.value;  
	contemNumeros = /[0-9]/;  
	contemLetras = /[a-z]/i;  
	contemEspecial = /[@#$%&amp;amp;*]/;  
	contagem = 0;  
	mensagem = "";  
	  
	if ( valor.length > 0 ) 
	{  
		 if ( contemNumeros.test( valor ) ) contagem++;  
		 if ( contemLetras.test( valor ) ) contagem++;  
		 if ( contemEspecial.test( valor ) ) contagem++;  
	   
		 switch ( contagem ) 
		{  
			 case 1: mensagem = "Senha Fraca!";  
				break;  
			 case 2: mensagem = "Senha Boa!";  
				break;  
			 case 3: mensagem = "Senha Excelente!";  
				break;  
			 default: mensagem = "ops! o que aconteceu?";  
		}  
	  
		document.getElementById('div_forca_senha').innerHTML = mensagem;  
	}  
	return true;
}

</script>

<?php 
	
	if(isset($_POST['entrar']) && $_POST['entrar'] == "Entrar"){		
		
		require_once("config.php");
		include("includes/funcoes.php");
		include("includes/conexao.con");
		
		$login = escapestrings($_POST["usuario"]);
		$senha = escapestrings($_POST["senha"]);

				
		$sqlC = "select u.*, tp.nome as nivelacesso from usuarios u ";
		$sqlC = $sqlC . " left outer join tipoacesso tp on u.idTipoAcesso=tp.idTipoAcesso ";
		$sqlC = $sqlC . " where login = '".$login."' and senha = '".md5($senha)."' ";			
		
		$resConfirma = mysql_db_query("sap", "$sqlC", $con);
		$contagem = mysql_num_rows($resConfirma);
		$linha = mysql_fetch_array($resConfirma);
		
		if ($contagem == 1)
		{		   	
			if($linha['status'] == 1){
			   $_SESSION['login'] = $linha['nomeUsuario']; //grava o nome do usuario na sessao 		   
			   $_SESSION['nivelacesso'] = $linha['nivelacesso'];
			   $_SESSION['idnivel'] = $linha['idTipoAcesso'];
			   $_SESSION['idUser'] = $linha['idUsuario'];
			   
				if ($senha == $login)
				{
					if($_SESSION['status'] == "logon"){
						$showerror = '<div id="error" class="error">É necessário a troca da senha!</div>';
						$_SESSION['status']	= "trocasenha";						
					}elseif($_SESSION['status'] == "trocasenha"){
						$novasenha = escapestrings($_POST["novasenha"]);
						if($senha == $novasenha){
							$showerror = '<div id="error" class="error">Nova senha não pode ser igual!</div>';
						}else{
							$sqlSenha = "UPDATE usuarios ";
							$sqlSenha = $sqlSenha." SET senha = '".md5($novasenha)."'";
							$sqlSenha = $sqlSenha."	WHERE login = '".$login."'";		
							//echo $sqlSenha;
							$rsNovaSenha = mysql_db_query("sap", "$sqlSenha", $con);												
							
							echo "<script language='javascript'> alert('Senha alterada com sucesso!'); window.location.href='index.html';</script>";
						}
					}				
					$nomefieldset = "Nova Senha";				
				}	
				else{	
					$_SESSION['status'] = "logado";
					echo "<script language='javascript' type='text/javascript'>window.location='redirect_logon.php';</script>";		  
				}
			}else{
				$nomefieldset = "Acesso";
				$showerror = '<div id="error" class="error">Usuário Desativado!</div>';						
			}
		}else{
			if($_SESSION['status'] == "trocasenha"){
				$nomefieldset = "Nova Senha";
				$showerror = '<div id="error" class="error">Senha Atual inválida!</div>';								
			}else{		
				$nomefieldset = "Acesso";
				$showerror = '<div id="error" class="error">LOGIN ou SENHA inválidos!</div>';					
				unset($_SESSION['login']);
				unset($_SESSION['senha']);	
				unset($_SESSION['nivelacesso']);
				unset($_SESSION['idnivel']);
				unset($_SESSION['idUser']);
			}
		}		
	}else{		
			$nomefieldset = "Acesso";
			//$_SESSION['status'] = "logon";			
			$showerror = '<div id="error" class="error"></div>';
	}	
?>

<body onLoad="document.getElementById('usuario').focus();">

<form name="login" method="post" onsubmit="return verifica()">

<table width="900" border="0" align="center">
  <tr>
    <td width="900"><div align="center"><img src="imagens/logo.jpg" alt="" width="170" height="116" /></div></td>
  </tr>
</table>
<table width="900" border="0" align="center">

<td width="900"><p align="center" class="style3 style4"><strong>Defensoria Pública Geral do Estado de Mato Grosso do Sul</strong></p>
    <p align="center" class="style22">DEFENSORIA</p>
    <p align="center" class="style22">SAP - Sistema de Automação de Petições</p>
    <p align="center" class="style2">&nbsp;</p></td>
</table>  

<fieldset>
    <legend><?php echo $nomefieldset;?></legend>
		
	<?php echo $showerror; ?>
	
	<p>&nbsp;</p>
	<table border="0" align="center">
	  <tr>
		<td width="400"><div align="right" class="style2 style5">Usuário:&nbsp;</div></td>
		<td width="490"><input name="usuario" type="text" id="usuario" class="texto" value="<?php echo $_SESSION['login'];?>" /></td>
	  </tr>
	  <tr>
		<td><div align="right" class="opcoes">Senha <?php echo $_SESSION['status'] == "trocasenha"?"Atual":"";?>:&nbsp;</div></td>
		<td><input name="senha" type="password" id="senha" class="texto"/></td>
	  </tr>
<?php if($_SESSION['status'] == "trocasenha"): ?>
	  <tr>
		<td><div align="right" class="opcoes">Nova Senha:&nbsp;</div></td>
		<td><input name="novasenha" type="password" id="novasenha" class="texto" onblur="return valida_senha(this)"/>&nbsp;
			<div class="senha" id="div_forca_senha" style="display:inline; width:100px;"></div>
		</td>
	  </tr>
<?php endif; ?>	 
		<input type="hidden" id="newsenha" name="newsenha" value="<?php echo $_SESSION['status'];?>">
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<table border="0" align="center">
	  <tr>
		<td><div align="center">
		  <input name="entrar" type="submit" id="entrar" value="Entrar" class="botao"/>
		</div></td>
	  </tr>
	</table>
  </fieldset>
</form>
</body>
</html>
