<?php include_once("../config/conexao.php");
  session_start();   
   if (!$_SESSION['id_user']) {
		echo(json_encode(['msg' => 'nao autenticado']));
   } else {

	$conn = mysqli_connect($host, $user, $pass, $db);

	if(empty($_GET['arq'])) {
		echo(json_encode(['msg' => 'erro']));
     } else {
			$id = $_GET['arq'];
			$query = "UPDATE arq_arquivos set status = 1 where id = $id";
			mysqli_query($conn, $query);
			echo(json_encode(['msg' => 'sucesso']));
		}

	}