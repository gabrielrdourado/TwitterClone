<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}
	
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

				//associando ao evento de click
				$('#btn_procurar_pessoa').click(function(){
					if ($('#nome_pessoa').val().length > 0) {
						
						$.ajax({
							url: 'get_pessoa.php',
							method: 'post',
							data: $('#form_procurar_pessoa').serialize(),
							success: function(data){
								$('#pessoas').html(data);

								$('.btn_seguir').click(function(){
									var id_usuario = $(this).data('id_usuario');

									$.ajax({
										url: 'seguir.php',
										method: 'post',
										data: { seguir_id_usuario: id_usuario },
										success: function(data){

											$('#btn_seguir_'+id_usuario).hide();
											$('#btn_deixar_seguir_'+id_usuario).show();

											atualizaQntd();
										}

									});
								});

								$('.btn_deixar_seguir').click(function(){
									var id_usuario = $(this).data('id_usuario');

									$.ajax({
										url: 'deixar_seguir.php',
										method: 'post',
										data: { deixar_seguir_id_usuario: id_usuario },
										success: function(data){

											$('#btn_seguir_'+id_usuario).show();
											$('#btn_deixar_seguir_'+id_usuario).hide();

											atualizaQntd();
										}

									});
								});

							}

						});

					}
				});

				function atualizaQntd(){
					$.ajax({
						url: 'get_qntd.php',
						success: function(data){
							$('#painel_qntd').html(data);
						}
					});
				}

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
	          	<li><a href="home.php">Home</a></li>
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
	    				<form id="form_procurar_pessoa" class="input-group">
		    				<input id="nome_pessoa" class="form-control" type="text" placeholder="Quem você está procurando?" name="nome_pessoa" maxlength="140"/>
		    				<span class="input-group-btn">
		    					<button id="btn_procurar_pessoa" class="btn btn-default" type="button">Procurar</button>
		    				</span>
	    				</form>
	    			</div>
	    		</div>
	    		<div id="pessoas" class="list-group"></div>
			</div>
			<div class="col-md-3">
				
			</div>
		</div>
	

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>