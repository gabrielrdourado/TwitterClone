<?php 
	
	//importando o dbclass
	require_once('db.class.php');

	//resgatando as informações do form q foi passado
	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = md5($_POST['senha']);

	$usuario_existe = false;
	$email_existe = false;

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	//-----------------------------------VERIFICANDO-----------------------------------//
	//verificando usuario
	$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

	if($retornoSql = mysqli_query($linkDB, $sql)){
		$dadosUsuario = mysqli_fetch_array($retornoSql);

		if (isset($dadosUsuario['usuario'])) {
			$usuario_existe = true;
		}

	} else {
		echo 'Erro ao verificar dados';
	}

	//verificando email
	$sql = "SELECT * FROM usuarios WHERE email = '$email'";

	if($retornoSql = mysqli_query($linkDB, $sql)){
		$dadosUsuario = mysqli_fetch_array($retornoSql);

		if (isset($dadosUsuario['email'])) {
			$email_existe = true;
		}

	} else {
		echo 'Erro ao verificar dados';
	}

	if ($usuario_existe || $email_existe) {

		$retorno_get = '';

		if ($usuario_existe) {
			$retorno_get.='erro_usuario=1&';
		}

		if ($email_existe) {
			$retorno_get.='erro_email=1&';
		}

		header('Location: inscrevase.php?'.$retorno_get);
		die();
	}
	//-----------------------------------FIM VERIFICAÇÃO-----------------------------------//


	//variavel com a linha em SQL de inserção dos dados no BD
	$sql = "insert into usuarios(usuario, email, senha) values ('$usuario', '$email', '$senha')";

	if(mysqli_query($linkDB, $sql)){
		header('Location: index.php?rg_success=1');
	} else {
		echo 'Erro ao registrar o usuário!';
	}

?>