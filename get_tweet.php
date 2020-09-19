<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS data_inclusao, t.tweet, u.usuario, u.perfil_image, t.id_usuario, t.id_tweet";
	$sql.= " FROM tweet AS t JOIN usuarios AS u ON (t.id_usuario = u.id)";
	$sql.= " WHERE id_usuario = $id_usuario OR id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE id_usuario=$id_usuario) ORDER BY data_inclusao DESC";

	$resultado_id = mysqli_query($linkDB, $sql);

	if($resultado_id){
		
		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			echo '<a href="#" class="list-group-item" style="cursor: default; margin: 15px 0px;">';
				echo '<img src="'.$registro['perfil_image'].'" style="position: absolute; margin-top: 11px; height:40px; width:40px; border-radius: 40px;"/>';
				echo '<h4 class="list-item-group-heading" style="margin-left:50px;">'.$registro['usuario'].' <small> - '.$registro['data_inclusao'].'</small>';

				if($id_usuario == $registro['id_usuario']){

					echo '<button class="apaga_tweet btn btn-link" style="display:float; float: right; color:black;" data-id_tweet="'.$registro['id_tweet'].'"><span style="font-size: 11px;" class="glyphicon glyphicon-trash"></span></button>';

				}

				echo '</h4>';

				echo '<p class="list-group-item-text" style="margin-left:50px;">'.$registro['tweet'].'</p>';
			echo '</a>';
		}

	} else {
		echo('Erro na requisição de tweets!!!');
	}

?>