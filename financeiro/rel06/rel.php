<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda.php");
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		

		//DESCRICAO
		$descricao_texto = "GERAL - $ano";
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
			'Gerar relatorio do tiquete medio geral do ano de $ano','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            T&Iacute;QUETE M&Eacute;DIO <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form06"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel06/rel_p.php?ano=<?php echo"$ano";?>" 
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
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>REGI&Atilde;O</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>ARRECADA&Ccedil;&Atilde;O</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJAS</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>M&Eacute;DIA</strong></h2></th> 
                    </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						//REGIAO
						$qr_regiao = "SELECT DISTINCT id,nome
						FROM pae_regiao
						WHERE id !='962'
						AND id !='2762'
						AND id !='26'
						ORDER BY nome ASC";
						$todos_regiao = mysql_query("$qr_regiao"); 
                        while ($dados_regiao = mysql_fetch_array($todos_regiao)) {
						$regiao_id   = $dados_regiao["id"];
						$regiao_nome = $dados_regiao["nome"];
						
						$regiao_nome2 = maiuscula($regiao_nome);
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito_id,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND regiao_id='$regiao_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						//IGREJA
						$qr_igreja = "SELECT * FROM pae_igreja
						WHERE regiao_id='$regiao_id'";
						$todos_igreja = mysql_query("$qr_igreja"); 
						$tr_igreja = mysql_num_rows($todos_igreja);
						
						if ($valortotal == "") { $media = "0";  } else { $media = $valortotal/$tr_igreja; }
							
						//MOEDA
						$media = number_format( round( $media, 1, PHP_ROUND_HALF_UP ), 2);
						
						$media = moeda($media);
							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$regiao_nome2</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$tr_igreja</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$media</td>
                       </tr>";
						
						}
						
						
			
                    	}
						
						
						//TOTAL//
						$qr_financa = "SELECT regiao_id, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND regiao_id !='962'
						AND regiao_id !='2762'
						AND regiao_id !='26'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal_final   = $dados_financa["SUM(valor)"];
						$numeracao          = $dados_financa["numeracao"];
						$plano_conta        = $dados_financa["plano_conta"];
						
						//IGREJA
						$qr_igreja = "SELECT * FROM pae_igreja
						WHERE regiao_id !='962'
						AND regiao_id !='2762'
						AND regiao_id !='26'";
						$todos_igreja = mysql_query("$qr_igreja"); 
						$tr_igreja = mysql_num_rows($todos_igreja);
						
						$media_total = $valortotal_final/$tr_igreja;
						
						//MOEDA
						$media_total = number_format( round( $media_total, 1, PHP_ROUND_HALF_UP ), 2);
						$valortotal_final = moeda($valortotal_final);
						$media_total = moeda($media_total);
						
												
						}
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal_final</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_igreja</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$media_total</b></td>
                        </tr>";

					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




