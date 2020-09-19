<?php 

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];

	//resgatando as informações do form q foi passado
	$nome_usuario = $_POST['nome_usuario'];
	$imagem_usuario = $_POST['imagem_usuario'];
	$email_usuario = $_POST['email_usuario'];
	$senha_usuario = md5($_POST['senha_usuario']);

	$usuario_existe = false;
	$email_existe = false;

	if ($id_usuario == '') {
		die();
	}

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	//-----------------------------------VERIFICANDO-----------------------------------//
	//verificando usuario
	if($nome_usuario!=''){
		$sql = "SELECT * FROM usuarios WHERE usuario = '$nome_usuario'";

		if($retornoSql = mysqli_query($linkDB, $sql)){
			$dadosUsuario = mysqli_fetch_array($retornoSql);

			if (isset($dadosUsuario['usuario'])) {
				$usuario_existe = true;
			}

		} else {
			echo 'Erro ao verificar dados';
		}
	}

	//verificando email
	if($email_usuario!=''){
		$sql = "SELECT * FROM usuarios WHERE email = '$email_usuario'";

		if($retornoSql = mysqli_query($linkDB, $sql)){
			$dadosUsuario = mysqli_fetch_array($retornoSql);

			if (isset($dadosUsuario['email'])) {
				$email_existe = true;
			}

		} else {
			echo 'Erro ao verificar dados';
		}
	}

	if ($usuario_existe || $email_existe) {

		$retorno_get = '';

		if ($usuario_existe) {
			$retorno_get.='erro_usuario=1&';
		}

		if ($email_existe) {
			$retorno_get.='erro_email=1&';
		}

		header('Location: home.php?'.$retorno_get);
		die();
	}
	//-----------------------------------FIM VERIFICAÇÃO-----------------------------------//

	//-----------------------------------ATUALIZANDO DADOS-----------------------------------//

	//Nome
	if($nome_usuario!=''){
		$sql = "UPDATE usuarios SET usuario='$nome_usuario' WHERE id=$id_usuario";
		if(mysqli_query($linkDB, $sql)){
			$_SESSION['usuario'] = $nome_usuario;
		}
	}

	//Imagem de perfil
	if($imagem_usuario!=''){
		$sql = "UPDATE usuarios SET perfil_image='$imagem_usuario' WHERE id=$id_usuario";
		if(mysqli_query($linkDB, $sql)){
			$_SESSION['perfil_image'] = $imagem_usuario;
		}
	}

	//Email
	if($email_usuario!=''){
		$sql = "UPDATE usuarios SET email='$email_usuario' WHERE id=$id_usuario";
		if(mysqli_query($linkDB, $sql)){
			$_SESSION['email'] = $email_usuario;
		}
	}

	//Senha
	if($senha_usuario!='d41d8cd98f00b204e9800998ecf8427e'){
		$sql = "UPDATE usuarios SET senha='$senha_usuario' WHERE id=$id_usuario";
		mysqli_query($linkDB, $sql);
	}

	header('Location: home.php?edit_success=1');
	die();
?>