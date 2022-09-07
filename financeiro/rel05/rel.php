<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda2.php");
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$distrito   = $_POST["id_sub_categoria"];
		$regiao     = $_POST["id_categoria"];
		$ano        = $_POST["ano"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		}
		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}

		//APAGAR A PALAVRA
		$igreja_nome = str_replace("IMW ", "", $igreja_nome); 
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO		
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome    = maiuscula($regiao_nome);
		$igreja_nome2   = maiuscula($igreja_nome);

		//DESCRICAO
		if ($distrito == "0") { $descricao_texto = "- $regiao_nome $ano"; }
		else { $descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome<br> $ano"; }
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
			'Gerar relatorio das igrejas em dia $regiao_nome do ano de $ano','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            IGREJA EM DIA <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form05"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel05/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&ano=$ano";?>" 
            target="_blank" title="Abrir tela de impress&atilde;o">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-print fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            
            </h2>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->


<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="table-responsive">         
                <table class="table table-striped">
                
                <thead>
                    <tr >
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJA</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>JAN</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>FEV</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MAR</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>ABR</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MAI</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>JUN</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>JUL</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>AGO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>SET</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>OUT</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>NOV</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>DEZ</strong></h2></th> 
                   </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						//IGREJA
						
						if ($distrito != "0") {
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito_id
						FROM pae_igreja
						WHERE distrito_id='$distrito'
						ORDER BY nome ASC";
						
						}
						
						else {
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito_id,regiao_id,distrito
						FROM pae_igreja
						WHERE regiao_id='$regiao'
						ORDER BY distrito ASC, nome ASC";
						
						}
						
						$todos_igreja = mysql_query($qr_igreja); 
                        while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
						$igreja_id   = $dados_igreja["id"];
						$igreja_nome = $dados_igreja["nome"];
						
						$igreja_nome = str_replace("IMW ", "", $igreja_nome);
						$igreja_nome2 = maiuscula($igreja_nome);
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$igreja_nome2</td>";
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND igreja_id='$igreja_id'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						$todos_financa = mysql_query("$qr_financa");
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>";
					

						}
						
													if ($mes == "0") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}
						
							if ($mes == "1") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}													
						
							if ($mes == "2") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "3") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}							
						
							if ($mes == "4") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "5") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "6") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}							
						
							if ($mes == "7") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "8") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "9") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "10") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}
							
						
							if ($mes == "11") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}							

						echo"</tr>";			
                    	}
						
						
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><B>TOTAIS<B></td>";
						
						//TOTAL//
						
						if ($distrito == "0") {
							
						$qr_financa = "SELECT regiao,regiao_id, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND regiao_id='$regiao'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						
						}
						
						else {
							
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND distrito_id='$distrito'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						}
						
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'><B>$valortotal2<B></td>";
												
						}
													if ($mes == "0") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}
						
							if ($mes == "1") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}													
						
							if ($mes == "2") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "3") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							
						
							if ($mes == "4") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "5") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "6") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							
						
							if ($mes == "7") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "8") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "9") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "10") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}
							
						
							if ($mes == "11") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							

					
                        echo"</tr>";

					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




