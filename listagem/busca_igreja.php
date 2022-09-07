<?php include_once("../config/conexao.php");

	$conn = mysqli_connect($host, $user, $pass, $db);

	$id_categoria = $_REQUEST['id_categoria'];
	
	$result_sub_cat = "SELECT DISTINCT nome,distrito_id,id FROM pae_igreja WHERE distrito_id=$id_categoria ORDER BY nome";
	$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);
	
	while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	$igreja  = $row_sub_cat["nome"];
		
	//APAGAR A PALAVRA
	$igreja = str_replace("IMW ", "", $igreja);
	$igreja = utf8_encode($igreja);
	 
		
		$sub_categorias_post[] = array(
			'id'	=> $row_sub_cat['id'],
			'nome' => $igreja,
		);
	}
	
	echo(json_encode($sub_categorias_post));
