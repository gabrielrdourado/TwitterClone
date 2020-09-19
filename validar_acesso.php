<?php

	//iniciando sessão
	session_start();
	
	//importando o dbclass
	require_once('db.class.php');

	//resgatando as informações do form q foi passado
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	//variavel com a linha em SQL de verificação de usuário registrado no BD
	$sql = "SELECT id, usuario, email, perfil_image FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";

	//resgatando informações que o select retorna
	$resourceLogin = mysqli_query($linkDB, $sql);

	if($resourceLogin){

		//transformando as informações em array
		$dadosUsuario = mysqli_fetch_array($resourceLogin, MYSQLI_ASSOC);

		if (is_null($dadosUsuario['usuario'])){
			header('Location: index.php?error=1');
		} else {
			
			$_SESSION['id_usuario'] = $dadosUsuario['id'];
			$_SESSION['usuario'] = $dadosUsuario['usuario'];
			$_SESSION['email'] = $dadosUsuario['email'];
			$_SESSION['perfil_image'] = $dadosUsuario['perfil_image'];

			header('Location: home.php');

		}

	} else {

		echo 'Erro na execução da consulta de usuário no banco de dados!';

	}

?>