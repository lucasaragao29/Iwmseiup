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
		$regiao_nome  = $row_regiao["nome"];
		}

		
		//MAIUSCULO		
		$regiao_nome    = maiuscula($regiao_nome);

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
			'Gerar relatorio do tiquete medio de investimenro em clerigo da $regiao_nome do ano de $ano','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            T&Iacute;QUETE M&Eacute;DIO DE INVESTIMENTO POR CL&Eacute;RIGO DA <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form11"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel11/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>INVESTIMENTO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>M&Eacute;DIA</strong></h2></th> 
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
						
						$distrito_nome2 = maiuscula($distrito_nome);
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito_id,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND distrito_id='$distrito_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						//CLERIGOS
						$qr_clerigos = "SELECT regiao, distrito, instituicao, pessoa, funcao_ministerial,
						SUM(CASE WHEN distrito_id='$distrito_id' then 1 ELSE 0 END) AS clerigos,
						COUNT(*) AS Total															  
						FROM pae_nomeacao
						WHERE data_termino='0000-00-00'";
						$todos_clerigos = mysql_query("$qr_clerigos"); 
						while ($dados_clerigos = mysql_fetch_array($todos_clerigos)) {
						$clerigos                    = $dados_clerigos["clerigos"];
						}
						if ($valortotal == "") { $media = "0";  } else { $media = $valortotal/$clerigos; }
							
						//MOEDA
						$media = number_format( round( $media, 1, PHP_ROUND_HALF_UP ), 2);
						
						$media = moeda($media);
							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome2</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$media</td>
                       </tr>";
						
						}
						
						
			
                    	}
						
						
						//TOTAL//
						$qr_financa = "SELECT regiao_id, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND regiao_id='$regiao'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal_final   = $dados_financa["SUM(valor)"];
						$numeracao          = $dados_financa["numeracao"];
						$plano_conta        = $dados_financa["plano_conta"];
						
						//CLERIGOS
						$qr_clerigos = "SELECT regiao, distrito, instituicao, pessoa, funcao_ministerial,
						SUM(CASE WHEN regiao_id='$regiao' then 1 ELSE 0 END) AS clerigos,
						COUNT(*) AS Total															  
						FROM pae_nomeacao
						WHERE data_termino='0000-00-00'";
						$todos_clerigos = mysql_query("$qr_clerigos"); 
						while ($dados_clerigos = mysql_fetch_array($todos_clerigos)) {
						$clerigos_total                    = $dados_clerigos["clerigos"];
						}
						
						$media_total = $valortotal_final/$clerigos_total;
						
						//MOEDA
						$media_total = number_format( round( $media_total, 1, PHP_ROUND_HALF_UP ), 2);
						$valortotal_final = moeda($valortotal_final);
						$media_total = moeda($media_total);
						
												
						}
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal_final</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$media_total</b></td>
                        </tr>";

					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




