<?php 

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$deixar_seguir_id_usuario = $_POST['deixar_seguir_id_usuario'];

	if ($id_usuario == '' || $deixar_seguir_id_usuario == '') {
		die();
	}

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "DELETE FROM usuarios_seguidores WHERE id_usuario=$id_usuario AND seguindo_id_usuario=$deixar_seguir_id_usuario";

	mysqli_query($linkDB, $sql);
?>