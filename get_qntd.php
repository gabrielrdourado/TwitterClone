<?php
	
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$qnt_tweets = 0;
	$qnt_seguidores = 0;
	$qnt_seguindo = 0;

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	//Recuperando a quantidade de seguidores
	$sql_qnt_seguidores= "SELECT COUNT(*) AS qnt_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario=$id_usuario";

	$resultado_id_qnt_seguidores = mysqli_query($linkDB, $sql_qnt_seguidores);

	if($resultado_id_qnt_seguidores){
		
		$registro_qnt_seguidores = mysqli_fetch_array($resultado_id_qnt_seguidores, MYSQLI_ASSOC);

		$qnt_seguidores = $registro_qnt_seguidores['qnt_seguidores'];

	} else {
		echo('Erro na requisição da quantidade de seguidores!!!');
	}

	//Recuperando a quantidade que está seguindo
	$sql_qnt_seguindo= "SELECT COUNT(*) AS qnt_seguindo FROM usuarios_seguidores WHERE id_usuario=$id_usuario";

	$resultado_id_qnt_seguindo = mysqli_query($linkDB, $sql_qnt_seguindo);

	if($resultado_id_qnt_seguindo){
		
		$registro_qnt_seguindo = mysqli_fetch_array($resultado_id_qnt_seguindo, MYSQLI_ASSOC);

		$qnt_seguindo = $registro_qnt_seguindo['qnt_seguindo'];

	} else {
		echo('Erro na requisição da quantidade que está seguindo!!!');
	}

	//Recuperando a quantidade de tweets
	$sql_qnt_tweets= "SELECT COUNT(*) AS qnt_tweet FROM tweet WHERE id_usuario=$id_usuario";

	$resultado_id_qnt_tweets = mysqli_query($linkDB, $sql_qnt_tweets);

	if($resultado_id_qnt_tweets){

		$registro_qnt_tweets = mysqli_fetch_array($resultado_id_qnt_tweets, MYSQLI_ASSOC);

		$qnt_tweets = $registro_qnt_tweets['qnt_tweet'];

	} else {
		echo('Erro na requisição da quantidade de tweets!!!');
	}

	echo '<div class="col-md-6"><center><h4>Seguidores<br/>'.$qnt_seguidores.'</h4></center></div>';
	echo '<div class="col-md-6"><center><h4>Seguindo<br/>'.$qnt_seguindo.'</h4></center></div>';
	echo '<div class="col-md-12"><center><h4>Tweets<br/>'.$qnt_tweets.'</h4></center></div>';

?>