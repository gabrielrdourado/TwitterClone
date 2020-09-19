<?php

	session_start();

	unset($_SESSION['id_usuario']);
	unset($_SESSION['usuario']);
	unset($_SESSION['email']);
	unset($_SESSION['perfil_image']);

	header('Location: index.php');

?>