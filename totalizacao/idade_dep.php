<?php 


		include_once("../config/conexao.php");

		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");

		// Descobre que dia é hoje e retorna a unix timestamp
		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));


		$result_membro = "SELECT 
		DATE_FORMAT(data_nascimento, '%d de %M de %Y') AS Nascimento,
    	TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) AS idade, id
    	FROM pae_membro2
    	WHERE regiao_id='13'";
		
		//DESCOBRIR IDADE E DEPARTAMENTO
		//$result_membro = "SELECT id,data_nascimento,nome FROM pae_membro2 where regiao_id='13' ";
		$resultado_membro = mysql_query($result_membro);		
		while ($row_membro = mysql_fetch_assoc($resultado_membro) ) {
		$id               = $row_membro["id"];
		$idade2               = $row_membro["idade"];
		//$data_nascimento  = $row_membro["data_nascimento"];
		//$nome             = $row_membro["nome"];
		
		//$dia_nasc = date('d', strtotime($data_nascimento));
		//$mes_nasc = date('m', strtotime($data_nascimento));
		//$ano_nasc = date('Y', strtotime($data_nascimento));
	   
		// Descobre a unix timestamp da data de nascimento do fulano
		//$nascimento = mktime( 0, 0, 0, $mes_nasc, $dia_nasc, $ano_nasc);
	   
		// Depois apenas fazemos o cálculo já citado :)
		//$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
	   
	   	//$idade2 = $idade;
		
		//DEPARTAMENTO
		if ($idade2 < "10") { $departamento = "1";   } //CRIANÇAS
		if ($idade2 > "9" and $idade2 < "14") { $departamento = "2";   } //PRE
		if ($idade2 > "13" and $idade2 < "18") { $departamento = "3";   } //ADOLESCENTES
		if ($idade2 > "17" and $idade2 < "31") { $departamento = "4";   } //JOVENS
		if ($idade2 > "29") { $departamento = "5";   } //ADULTOS
		if ($idade2 > "120" and $idade2 < "8000") { $departamento = "6";   } //INDETERMINADO
		
		echo"$nome - idade $idade2 anos ($data) - Departamento - $departamento<br>";
		
		mysql_query("UPDATE pae_membro2 SET 
		idade='$idade2',departamento='$departamento' WHERE id='$id' ") or die (mysql_error());

		
		
		
		
		
		}
		
		mysql_close($link); 
		
		

?>