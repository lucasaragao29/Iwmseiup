<?php 


		include_once("../config/conexao.php");

		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$hoje = getdate();
		$ano_atual = $hoje["year"];

		////IGREJAS
		$qr_igreja = "SELECT id,regiao_id FROM pae_igreja";
		$todos_igreja = mysql_query("$qr_igreja"); 
		while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
		$igreja_id  = $dados_igreja["id"];	
		
		//MEMBROS
		$qr_membros = "SELECT igreja_id,ano_recepcao,ano_exclusao,
		SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
		SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
		COUNT(*) AS Total
		FROM pae_membro 
		WHERE igreja_id='$igreja_id'";
		$todos_membros = mysql_query("$qr_membros"); 
		while ($dados_membros = mysql_fetch_array($todos_membros)) {
		$recebidos  = $dados_membros["recebidos"];
		$excluidos   = $dados_membros["excluidos"];	
			
		$rol = $recebidos-$excluidos;
		
				echo"$igreja_id - $rol<br>";

		
		}
			
			//ATUALIZAR
			mysql_query("UPDATE pae_igreja SET membro='$rol' WHERE id='$igreja_id' ")
			or die ("Erro ao adicionar Registro!!!" . mysql_error());
		
		}
		
		
		
		

?>