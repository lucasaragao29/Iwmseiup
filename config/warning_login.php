<?php

if (empty($_SESSION["id_user"])){

		echo '<script>window.location="/sei/index.php?mensagem=Você deve efetuar login para acessar o sistema.";</script>';

	}

?>

