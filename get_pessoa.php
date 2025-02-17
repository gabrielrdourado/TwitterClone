<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php');
	}

	//importando o dbclass
	require_once('db.class.php');

	$nome_pessoa = $_POST['nome_pessoa'];
	$id_usuario = $_SESSION['id_usuario'];

	//definindo um objeto da classe db
	$objDB = new db();

	//criando o link de conexão com o banco de dados
	$linkDB = $objDB->conectaMysql();

	$sql = "SELECT u.*, us.* ";
	$sql.= "FROM usuarios AS u ";
	$sql.= "LEFT JOIN usuarios_seguidores AS us ";
	$sql.= "ON (us.id_usuario = $id_usuario AND u.id = us.seguindo_id_usuario) ";
	$sql.= "WHERE u.usuario like '%$nome_pessoa%' AND u.id <> '$id_usuario'";

	$resultado_id = mysqli_query($linkDB, $sql);

	if($resultado_id){
		
		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			echo '<a href="#" class="list-group-item" style="margin: 15px 0px;">';
				echo '<img src="'.$registro['perfil_image'].'" style="position: absolute; height:40px; width:40px; border-radius: 40px;"/>';
				echo '<strong style="margin-left:50px;">'.$registro['usuario'].'</strong><small> - '.$registro['email'].'</small>';
				echo '<p class="list-group-item-text pull-right">';

				$esta_seguindo_sn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';

				$btn_seguir_display = 'block';
				$btn_deixar_seguir_display = 'block';

				if ($esta_seguindo_sn=='N') {
					$btn_deixar_seguir_display='none';
				} else {
					$btn_seguir_display='none';
				}

					echo '<button type="button" style="display:'.$btn_seguir_display.';" id="btn_seguir_'.$registro['id'].'" class="btn btn-default btn_seguir" data-id_usuario="'.$registro['id'].'">Seguir</button>';
					echo '<button type="button" style="display:'.$btn_deixar_seguir_display.';" id="btn_deixar_seguir_'.$registro['id'].'" class="btn btn-primary btn_deixar_seguir" data-id_usuario="'.$registro['id'].'">Deixar de seguir</button>';

				echo '</p>';
				echo '<div class="clearfix"></div>';
			echo '</a>';
		}

	} else {
		echo('Erro na requisição de tweets!!!');
	}

?>