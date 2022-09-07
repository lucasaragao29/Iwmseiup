<?php include_once("../config/conexao.php");

	$conn = mysqli_connect($host, $user, $pass, $db);

	$result_sub_cat = "SELECT id, nome FROM arq_categoria ORDER BY nome";
	$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);
	
	while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$categoria  = $row_sub_cat["nome"];
		
	//APAGAR A PALAVRA
	$categoria = utf8_encode($categoria);
	 
		
		$categorias_post[] = [
			'id' => $row_sub_cat['id'],
			'nome' => $categoria,
		];
	}
	
	echo(json_encode($categorias_post));
