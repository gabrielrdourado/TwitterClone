<?php 

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$texto_tweet = $_POST['texto_tweet'];
	$id_usuario = $_SESSION['id_usuario'];

	if ($texto_tweet == '' || $id_usuario == '') {
		die();
	}

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "INSERT INTO tweet(id_usuario, tweet) values ('$id_usuario', '$texto_tweet')";

	mysqli_query($linkDB, $sql)

?>