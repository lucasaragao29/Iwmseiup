<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda.php");
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$regiao     = $_POST["id_categoria"];
		$ano      = $_POST["ano"];
				
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome    = $row_regiao["nome"];
		}

		//MAIUSCULO		
		$regiao_nome2 = maiuscula($regiao_nome);

		//DESCRICAO
		$descricao_texto = "$regiao_nome - $ano";
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
			'Gerar relatorio investimento de clerigo III da $regiao_nome do ano $ano','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            INVESTIMENTO EM CL&Eacute;RIGO III<br><?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form03"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel03/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>ARRECADA&Ccedil;&Atilde;O</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>INVESTIMENTO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>%</strong></h2></th> 
                    </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						//DISTRITO
						$qr_distrito = "SELECT DISTINCT id,nome,regiao_id
						FROM pae_distrito
						WHERE regiao_id='$regiao'
						ORDER BY nome ASC";
						$todos_distrito = mysql_query("$qr_distrito"); 
                        while ($dados_distrito = mysql_fetch_array($todos_distrito)) {
						$distrito_id   = $dados_distrito["id"];
						$distrito_nome = $dados_distrito["nome"];
						
						$distrito_nome = str_replace("Distrito ", "", $distrito_nome);
						
						$distrito_nome = maiuscula($distrito_nome);
						
						//ARRECADAÇÃO
						$qr_arrecadacao = "SELECT regiao,distrito_id, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND distrito_id='$distrito_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_arrecadacao = mysql_query("$qr_arrecadacao"); 
                        while ($dados_arrecadacao = mysql_fetch_array($todos_arrecadacao)) {
						$arrecadacao_total   = $dados_arrecadacao["SUM(valor)"];
						
						}
						
						//INVESTIMENTO
						$qr_investimento = "SELECT regiao,distrito_id, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND distrito_id='$distrito_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_investimento = mysql_query("$qr_investimento"); 
                        while ($dados_investimento = mysql_fetch_array($todos_investimento)) {
						$investimento_total   = $dados_investimento["SUM(valor)"];
						}
						
						//MES
												
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						
						if ($mes_atual == "12" and $ano_atual == $ano) { $mes = "11";  }
						if ($mes_atual == "12" and $ano_atual > $ano) { $mes = "12";  }
						if ($mes_atual < "12" and $ano_atual == $ano) { $mes = $mes_atual-1; }
						if ($mes_atual < "12" and $ano_atual > $ano) { $mes = "12"; }
						
						//PORCENTAGEM
						if ($arrecadacao_total < "1" or $investimento_total < "1") { $porcentagem = "0"; }
						else { $porcentagem = ($investimento_total*100)/$arrecadacao_total; }
							
						//MOEDA
						$porcentagem = number_format( round( $porcentagem, 1, PHP_ROUND_HALF_UP ), 2);
						$media = moeda($media);
						
						//MOEDA
						$investimento_total = moeda($investimento_total);
						$arrecadacao_total = moeda($arrecadacao_total);

							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$arrecadacao_total</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$investimento_total</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$porcentagem</td>
                       </tr>";
						
						
						
			
                    	}
						
						//ARRECADAÇÃO
						$qr_arrecadacao = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND regiao_id='$regiao'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_arrecadacao = mysql_query("$qr_arrecadacao"); 
                        while ($dados_arrecadacao = mysql_fetch_array($todos_arrecadacao)) {
						$arrecadacao_total   = $dados_arrecadacao["SUM(valor)"];
						
						}
						
						//INVESTIMENTO
						$qr_investimento = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND regiao_id='$regiao'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_investimento = mysql_query("$qr_investimento"); 
                        while ($dados_investimento = mysql_fetch_array($todos_investimento)) {
						$investimento_total   = $dados_investimento["SUM(valor)"];
						}

						
						//MES
												
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						
						//echo "ANTES $mes_atual - $ano_atual - $ano<br>";

						if ($mes_atual == "12" and $ano_atual == $ano) { $mes = "11";  }
						if ($mes_atual == "12" and $ano_atual > $ano) { $mes = "12";  }
						if ($mes_atual < "12" and $ano_atual == $ano) { $mes = $mes_atual-1; }
						if ($mes_atual < "12" and $ano_atual > $ano) { $mes = "12"; }
						
						//echo"DEPOIS $mes_atual - $ano_atual - $ano<BR>";
							
						//PORCENTAGEM
						if ($arrecadacao_total < "1" or $investimento_total < "1") { $porcentagem = "0,00"; }
						else { $porcentagem = ($investimento_total*100)/$arrecadacao_total; }
							
						//MOEDA
						$porcentagem = number_format( round( $porcentagem, 1, PHP_ROUND_HALF_UP ), 2);
						$media = moeda($media);
						
						//MOEDA
						$investimento_total = moeda($investimento_total);
						$arrecadacao_total = moeda($arrecadacao_total);

							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS<b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$arrecadacao_total</b></td>
 						<td style='font-size:13px;color:#333333;text-align:right'><b>$investimento_total</b></td>
 						<td style='font-size:13px;color:#333333;text-align:right'><b>$porcentagem</b></td>
                       </tr>";

					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




