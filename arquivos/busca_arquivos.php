<?php include_once("../config/conexao.php");

	$conn = mysqli_connect($host, $user, $pass, $db);


    if((!empty($_POST['id_regiao']))  && (!empty($_POST['id_distrito'])) && (!empty($_POST['id_igreja']))) {
		$query = "pae_regiao_id = $_POST[id_regiao] and pae_distrito_id = $_POST[id_distrito] and pae_igreja_id = $_POST[id_igreja]";
	} else if((!empty($_POST['id_regiao'])) && (!empty($_POST['id_distrito']))) {
		$query = "pae_regiao_id = $_POST[id_regiao] and pae_distrito_id = $_POST[id_distrito]";
	} else if(!empty($_POST['id_regiao'])) {
		$query = "pae_regiao_id = $_POST[id_regiao]";
	}

	//Tratar Categoria e SubCategoria
	if((!empty($_POST['id_categoria'])) &&  (!empty($_POST['id_subcategoria']))){
		$query_two = "and arq_categoria_id = $_POST[id_categoria] and arq_subcategoria_id = $_POST[id_subcategoria]";
	} else if (!empty($_POST['id_categoria'])){
		$query_two = "and arq_categoria_id = $_POST[id_categoria]";
	} 

	$result_sub_cat = "SELECT 
				arq_arquivos.id as id,
				arq_arquivos.nome as nome, 
				arq_arquivos.titulo as titulo,
				arq_arquivos.descricao as descricao,
				pae_distrito.nome as distrito,
				pae_igreja.nome as igreja
			FROM arq_arquivos 
			LEFT JOIN pae_distrito on pae_distrito.id = arq_arquivos.pae_distrito_id
			LEFT JOIN pae_igreja on pae_igreja.id = arq_arquivos.pae_igreja_id 
				WHERE 
					arq_arquivos.status != '1' and
					$query
					$query_two
			ORDER BY nome";
	$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);

	while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
	
		$distrito = str_replace("Distrito ", "", $row_sub_cat['distrito']);
	    $distrito = utf8_encode($distrito);

		$igreja = str_replace("IMW ", "", $row_sub_cat['igreja']);
	    $igreja = utf8_encode($igreja);
	
		$arquivos_res[] = array(
			'id'	 => $row_sub_cat['id'],
			'nome' =>  utf8_encode($row_sub_cat['nome']),
			'titulo' =>  utf8_encode($row_sub_cat['titulo']),
			'distrito' => $distrito,
			'igreja' => $igreja,
			'descricao' =>  utf8_encode($row_sub_cat['descricao'])	
		);
	}
	
	echo(json_encode($arquivos_res));
