<div id="conteudo">
<?php
	if(isset($_SESSION['idnivel'])){
	
		/********* NÍVEL DE ACESSO - SERVIDOR ********/
		if($_SESSION['idnivel'] >= 1 AND $_SESSION['idnivel'] <= 2){
		
			switch($_GET['pg']){
				case("dp1"):
					$_SESSION['valdp'] = "dp1";
					include('busca/dadospessoaisserv.php');
					break;
				case("rel"):
					$_SESSION['valdp'] = "rel";
					include('relatorio/rel_total_atend.php');
					break;	
				case("cf"):
					include('cadastra/profissao.php');
					break;							
				default:
					include('busca/assistido.php');
					break;						
			}
		}elseif($_SESSION['idnivel'] >= 3){
		
			switch($_GET['pg']){
				case("t2"):
					include('busca/assistido.php');
					break;
					
				case("dp1"):
					$_SESSION['valdp'] = "dp1";
					include('busca/dadospessoais.php');
					break;
					
				case("c1"):
					include('includes/form_assistido.php');
					break;
					
				case("dp2"):
					$_SESSION['valdp'] = "dp2";
					include('busca/dadospessoais.php');
					break;					
					
				case("dp3"):
					$_SESSION['valdp'] = "dp3";
					include('busca/dadospessoais.php');
					break;					
					
				case("cp"):
					include('cadastra/providencia.php');
					break;					
					
				case("bp"):
					include('busca/providencia.php');
					break;					
					
				case("ep"):
					include('altera/providencia.php');
					break;					
				
				case("ca"):
					include('cadastra/acao.php');
					break;					

				case("ba"):
					include('busca/acao.php');
					break;									

				case("ea"):
					include('altera/acao.php');
					break;	
					
				case("cf"):
					include('cadastra/profissao.php');
					break;						
					
				case("rel"):
					$_SESSION['valdp'] = "rel";					
					include('relatorio/rel_total_atend.php');
					break;	
					
				default:
					include('busca/defensor.php'); ?>
					<script style="text/javascript">		
						t=setInterval('showlistassis()',10000);
					</script>
<?					break;				
			}
		}
	}
?>
</div>
