<?php
	session_start();
	//echo '<script>alert("'.$_SESSION["status"].'");</script>';
	
	require_once("config.php");
	
?>
	
<script type="text/javascript">	
	var MENU_ITEMS = [				
	
<? if($_SESSION['idnivel'] >= 1){ ?>	
		['Cadastrar', null, {'tw':'_self'},			
	<? if($_SESSION['idnivel'] >= 3  AND $_SESSION['idnivel'] != 6){ ?>		
			['Assistido', '/<?=$raiz?>/principal.php?pg=c1', {'tw':'_self'}],
<?		if($_SESSION['idnivel'] > 6){ ?>	
			['Usu�rio', '/<?=$raiz?>/principal.php?pg=dp2', {'tw':'_self'}],
<? 		} ?>				
			['Provid�ncia', '/<?=$raiz?>/principal.php?pg=cp', {'tw':'_self'}],
				
			['A��o', '/<?=$raiz?>/principal.php?pg=ca', {'tw':'_self'}],
			//['N�cleos', '/<?=$raiz?>/cadastra/nucleo.php', {'tw':'_self'}],
<? } ?>	
			['Profiss�o', '/<?=$raiz?>/principal.php?pg=cf', {'tw':'_self'}],
		],	
<? if($_SESSION['idnivel'] >= 3){ ?>			
<?		if($_SESSION['idnivel'] > 6){ ?>			
		['Editar', null, {'tw':'_self'},			
			['Usu�rios', '/<?=$raiz?>/principal.php?pg=dp3', {'tw':'_self'}],
			['Provid�ncias', '/<?=$raiz?>/principal.php?pg=bp', {'tw':'_self'}],

			['A��es', '/<?=$raiz?>/principal.php?pg=ba', {'tw':'_self'}],

			//['N�cleos', '/<?=$raiz?>/edita/nucleo.php', {'tw':'_self'}]
		],
		<? } 
		if($_SESSION['idnivel'] >= 6){ ?>		
		['Relat�rios', null, {'tw':'_self'},
			['Qtd de Atend.', '/<?=$raiz?>/principal.php?pg=rel', {'tw':'_self'}],				
		],		
<? 		} ?>			
		['Buscar Assistido', '/<?=$raiz?>/principal.php?pg=t2', {'tw':'_self'}],		
	<? } ?>			
<? } ?>		
<?		if($_SESSION['idnivel'] < 6 ){ ?>		
		['Dados Pessoais', '/<?=$raiz?>/principal.php?pg=dp1', {'tw':'_self'}],
<? } ?>
		
		['In�cio', '/<?=$raiz?>/principal.php', {'tw':'_self'}],
		
		['Sair', '/<?=$raiz?>/logout.php', {'tw':'_self'}],
		
		['Painel', '/<?=$raiz?>/painel/index.php', {'tw':'wndNew'}],		
		
	];
</script>