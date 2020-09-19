<?php 

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$apagar_id_tweet = $_POST['apagar_id_tweet'];

	if ($id_usuario == '' || $apagar_id_tweet == '') {
		die();
	}

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "DELETE FROM tweet WHERE id_tweet=$apagar_id_tweet AND id_usuario=$id_usuario";

	mysqli_query($linkDB, $sql);

?>