<?php 
	
	//capturando o variavel transmitido por get na url
	$error = isset($_GET['error']) ? $_GET['error'] : 0;
	$rg_success = isset($_GET['rg_success']) ? $_GET['rg_success'] : 0;

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<!-- FavIcon -->
		<link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">
		<link rel="icon" href="imagens/favicon.ico" type="image/x-icon">

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
		<script>
			$(document).ready(function (){

				//alerts
				if (<?= $rg_success ?>==1) {
					alert('Usuário registrado com sucesso!!!');
				}

				$('#btn_login').click(function(){

					var campo_vazio = false;

					if($('#campo_usuario').val() == ''){
						$('#campo_usuario').css({'border-color':'#A94442'});
						campo_vazio = true;
					} else {
						$('#campo_usuario').css({'border-color':'#CCC'});
					}

					if($('#campo_senha').val() == ''){
						$('#campo_senha').css({'border-color':'#A94442'});
						campo_vazio = true;
					} else {
						$('#campo_senha').css({'border-color':'#CCC'});
					}

					if (campo_vazio) return false;

				});

			});						
		</script>
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />By: Gabriel Ribeiro Dourado
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="inscrevase.php">Inscrever-se</a></li>
	            <li class="<?= $error==1 ? 'open' : '' ?>">
	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="<?= $error==1 ? 'true' : 'false' ?>">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Você possui uma conta?</h3>
				    		<br />
							<form method="post" action="validar_acesso.php" id="formLogin">
								<div class="form-group">
									<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
								</div>
								
								<div class="form-group">
									<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
								</div>
								
								<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

								<br />
								
								<?php 
									if($error == 1){
										echo '<font color="#FF0000">Usuário e/ou senha inválido(s)!</font>';
									}
								?>

								<br />

							</form>
						</form>
				  	</ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	      <!-- Main component for a primary marketing message or call to action -->
	      <div class="jumbotron">
	        <h1>Bem vindo ao twitter clone</h1>
	        <p>Veja o que está acontecendo agora...</p>
	      </div>

	      <div class="clearfix"></div>
		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>