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
			['Usuário', '/<?=$raiz?>/principal.php?pg=dp2', {'tw':'_self'}],
<? 		} ?>				
			['Providência', '/<?=$raiz?>/principal.php?pg=cp', {'tw':'_self'}],
				
			['Ação', '/<?=$raiz?>/principal.php?pg=ca', {'tw':'_self'}],
			//['Núcleos', '/<?=$raiz?>/cadastra/nucleo.php', {'tw':'_self'}],
<? } ?>	
			['Profissão', '/<?=$raiz?>/principal.php?pg=cf', {'tw':'_self'}],
		],	
<? if($_SESSION['idnivel'] >= 3){ ?>			
<?		if($_SESSION['idnivel'] > 6){ ?>			
		['Editar', null, {'tw':'_self'},			
			['Usuários', '/<?=$raiz?>/principal.php?pg=dp3', {'tw':'_self'}],
			['Providências', '/<?=$raiz?>/principal.php?pg=bp', {'tw':'_self'}],

			['Ações', '/<?=$raiz?>/principal.php?pg=ba', {'tw':'_self'}],

			//['Núcleos', '/<?=$raiz?>/edita/nucleo.php', {'tw':'_self'}]
		],
		<? } 
		if($_SESSION['idnivel'] >= 6){ ?>		
		['Relatórios', null, {'tw':'_self'},
			['Qtd de Atend.', '/<?=$raiz?>/principal.php?pg=rel', {'tw':'_self'}],				
		],		
<? 		} ?>			
		['Buscar Assistido', '/<?=$raiz?>/principal.php?pg=t2', {'tw':'_self'}],		
	<? } ?>			
<? } ?>		
<?		if($_SESSION['idnivel'] < 6 ){ ?>		
		['Dados Pessoais', '/<?=$raiz?>/principal.php?pg=dp1', {'tw':'_self'}],
<? } ?>
		
		['Início', '/<?=$raiz?>/principal.php', {'tw':'_self'}],
		
		['Sair', '/<?=$raiz?>/logout.php', {'tw':'_self'}],
		
		['Painel', '/<?=$raiz?>/painel/index.php', {'tw':'wndNew'}],		
		
	];
</script>