<?php

	class db {

		//host
		private $host = 'localhost';

		//usuario
		private $usuario = 'root';

		//senha
		private $senha = '';

		//banco de dados
		private $database = 'twitterclone';

		public function conectaMysql(){

			//conecta ao mysql, com as informações registradas anteriormente
			$connect = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

			//seta o charset como padrao de comunicação da aplicação com o banco de dados
			mysqli_set_charset($connect, 'utf8');

			//verifica se houve erro ao conectar com o banco de dados
			if (mysqli_connect_errno()) {
				echo 'Erro ao tentar conectar com o Banco de dados: '.mysqli_connect_error();
			}

			return $connect;

		}

	}

?>