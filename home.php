<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//capturando o variavel transmitido por get na url
	$edit_success = isset($_GET['edit_success']) ? $_GET['edit_success'] : 0;
	$erro_usuario = isset($_GET['erro_usuario']) ? $_GET['erro_usuario'] : 0;
	$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

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

		<script type="text/javascript">

			$(document).ready(function(){

				//alerts
				if (<?= $edit_success ?>==1) {
					alert('Perfil atualizado com sucesso!!!');
				}

				if (<?= $erro_usuario ?>==1 && <?= $erro_email ?>==1) {
					alert('Nome de usuário e e-mail indisponível');
				} else {
					if (<?= $erro_usuario ?>==1) {
						alert('Nome de usuário indisponível');
					}
					if (<?= $erro_email ?>==1) {
						alert('E-mail indisponível');
					}
				}

				//associando ao evento de click
				$('#btn_tweet').click(function(){
					if ($('#texto_tweet').val().length > 0) {
						
						$.ajax({
							url: 'inclui_tweet.php',
							method: 'post',
							data: $('#form_tweet').serialize(),
							success: function(data){
								$('#texto_tweet').val('');
								atualizaTweets();
								atualizaQntd();
							}
						});

					}
				});

				function atualizaTweets(){
					$.ajax({
						url: 'get_tweet.php',
						success: function(data){
							$('#tweets').html(data);

							//apagar tweet event
							$('.apaga_tweet').click(function(){
								var id_tweet = $(this).data('id_tweet');
								
								$.ajax({
									url: 'apagar_tweet.php',
									method: 'post',
									data: {apagar_id_tweet: id_tweet},
									success: function(data){
										atualizaTweets();
										atualizaQntd();
									}
								});
							});
						}
					});
				}

				function atualizaQntd(){
					$.ajax({
						url: 'get_qntd.php',
						success: function(data){
							$('#painel_qntd').html(data);
						}
					});
				}

				atualizaTweets();
				atualizaQntd();
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
	            <li><a href="logoff.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<a href="#" id="edit_gear" data-toggle="modal" data-target="#form_editar_perfil"><img src="imagens/gear-icon.png" style="height: 20px; width: 20px; position: absolute;"/></a>
	    				<center><img style="border-radius: 100px; height: 100px; width: 100px;" src="<?= $_SESSION['perfil_image'] ?>"/>
	    				<h4><?= $_SESSION['usuario'] ?></h4></center>
	    				<hr/>
	    					<div id="painel_qntd"></div>
	    			</div>
	    		</div>
	    	</div>

	    	<!-- Janela de editar perfil (modal) -->
	    	<form method="post" action="editar_perfil.php" id="form_editar_perfil" class="modal fade">
	    		<div class="modal-dialog">
	    			<div class="modal-content">
	    				<div class="modal-header">
	    					<button type="button" class="close" data-dismiss="modal">
	    						<span>&times;</span>
	    					</button>
	    					<h4 class="modal-title">Editar Perfil</h4>
	    				</div>

	    				<div class="modal-body">
							<div class="form-group">
								<label for="usuario">Nome</label>
								<input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Nome">
							</div>

							<div class="form-group">
								<label for="imagem_usuario">Imagem de perfil</label>
								<input type="text" class="form-control" id="imagem_usuario" name="imagem_usuario" placeholder="Link da imagem de perfil">
							</div>

							<div class="form-group">
								<label for="email_usuario">E-mail</label>
								<input type="email" class="form-control" id="email_usuario" name="email_usuario" placeholder="E-mail">
							</div>
							
							<div class="form-group">
								<label for="senha_usuario">Senha</label>
								<input type="password" autocomplete="new-password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Senha">
							</div>
	    				</div>

	    				<div class="modal-footer">
	    					<button type="button" class="btn btn-default" data-dismiss="modal">
	    						Cancelar
	    					</button>
	    					<button type="submit" class="btn btn-primary">
	    						Editar
	    					</button>
	    				</div>
	    			</div>
	    		</div>
	    	</form>

	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form_tweet" class="input-group">
		    				<input id="texto_tweet" class="form-control" type="text" placeholder="O que está acontecendo agora?" name="texto_tweet" maxlength="140"/>
		    				<span class="input-group-btn">
		    					<button id="btn_tweet" class="btn btn-default" type="button">Tweet</button>
		    				</span>
	    				</form>
	    			</div>
	    		</div>
	    		<div id="tweets" class="list-group"></div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><a href="procurar_pessoa.php">Procure por pessoas</a></h4>
	    			</div>
	    		</div>
			</div>
		</div>
	

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>