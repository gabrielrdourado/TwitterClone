<?php 

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$seguir_id_usuario = $_POST['seguir_id_usuario'];

	if ($id_usuario == '' || $seguir_id_usuario == '') {
		die();
	}

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario) values ($id_usuario, $seguir_id_usuario)";

	mysqli_query($linkDB, $sql);
?>