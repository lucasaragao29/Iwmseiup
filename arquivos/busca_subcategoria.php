<?php include_once("../config/conexao.php");

	$conn = mysqli_connect($host, $user, $pass, $db);

	$id_subcategoria = $_REQUEST['id_subcategoria'];
	
	$result_sub_cat = "SELECT id, nome FROM arq_subcategoria WHERE arq_categoria_id = $id_subcategoria  ORDER BY nome";
	$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);
	
	while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$subcategoria  = $row_sub_cat["nome"];
		
	//APAGAR A PALAVRA
	$subcategoria = utf8_encode($subcategoria);
	 
		
		$sub_categorias_post[] = [
			'id' => $row_sub_cat['id'],
			'nome' => $subcategoria,
		];
	}
	
	echo(json_encode($sub_categorias_post));
