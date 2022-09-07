<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	

                // Estabelece conexao com o banco de dados
                include_once __DIR__ . "/../../config/conexao.php";
		$conn = OpenCon(); 

		include("../config/moeda.php");
		
		$datai     = $_POST["datai"];
		$dataf     = $_POST["dataf"];
		$igreja    = $_POST["id_sub_categoria"];
		$distrito  = $_POST["id_categoria"];
		
		//DATA INICIAL
		$diai = date('d', strtotime($datai));
		$mesi = date('m', strtotime($datai));
		$anoi = date('Y', strtotime($datai));
		$datai_texto = "$mesi/$anoi";
		

		//DATA FINAL
		$diaf = date('d', strtotime($dataf));
		$mesf = date('m', strtotime($dataf));
		$anof = date('Y', strtotime($dataf));
		$dataf_texto = "$mesf/$anof";
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysqli_query($conn,$result_distrito);		
		while ($row_distrito = mysqli_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		$regiao_nome  = $row_distrito["regiao"];
		}
		
		//DESCOBRIR IGREJA
		$result_igreja = "SELECT * FROM pae_igreja WHERE id=$igreja";
		$resultado_igreja = mysqli_query($conn,$result_igreja);		
		while ($row_igreja = mysqli_fetch_assoc($resultado_igreja) ) {
		$igreja_nome  = $row_igreja["nome"];
		}

		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$igreja_nome2 = maiuscula($igreja_nome);
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = " $igreja_nome2<br>DISTRITO DE $distrito_nome2 DA $regiao_nome2<br>PERIODO $datai_texto A $dataf_texto";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar balancete da $igreja_nome do distrito de $distrito_nome da $regiao_nome no periodo de $datai_texto a $dataf_texto','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            BALANCETE DA <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form01"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel01/rel_p.php?igreja=<?php echo"$igreja&distrito=$distrito&datai=$datai&dataf=$dataf";?>" 
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
                    <tr>
                        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>CONTAS</strong></h2></th>
                        <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>ENTRADAS</strong></h2></th>
                        <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>SA&Iacute;DAS</strong></h2></th>
                         <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>%</strong></h2></th>
                   </tr>
                </thead> 
                
                  <tbody>
                        <tr>
                            <td style='text-align:left' colspan='3'><h2 style='font-size:15px;color:#114a66;'><strong>ENTRADAS</strong></h2></td>
                        </tr>
                    </tbody>

					<?php 
						
						echo"<tbody>";
						
						
						
						//ENTRADAS TOTAL
						$qr_entrada_total = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'E' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						ORDER BY numeracao ASC";
						$todos_entrada_total = mysqli_query($conn,$qr_entrada_total); 
                        while ($dados_entrada_total = mysqli_fetch_array($todos_entrada_total)) {
						$entradastotal   = $dados_entrada_total["SUM(valor)"];
						}
						
						//ENTRADAS
						$qr_entrada = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'E' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						GROUP BY plano_conta_id
						ORDER BY numeracao ASC";
						$todos_entrada = mysqli_query($conn,$qr_entrada); 
                        while ($dados_entrada = mysqli_fetch_array($todos_entrada)) {
						$valortotal   = $dados_entrada["SUM(valor)"];
						$numeracao    = $dados_entrada["numeracao"];
						$plano_conta  = $dados_entrada["plano_conta"];
						
						//PERCENTUAL
						$percentual = (100*$valortotal)/$entradastotal;
						$percentual = number_format($percentual,0,'.',''); 
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao - $plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$percentual</td>
                       </tr>";
						}
						
						//MOEDA
						$entradastotal2 = moeda($entradastotal);
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$entradastotal2</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'></td>
                       </tr>";

                    	
						echo"</tbody><tbody>";
						
						?>
 
 					<?php 
						
						echo"<tbody>
                        <tr>
                            <td style='text-align:left' colspan='3'><h2 style='font-size:15px;color:#114a66;'><strong>TRANSFER&Ecirc;NCIAS - ENTRADAS</strong></h2></td>
                        </tr>
                    		</tbody>";
													
						echo"<tbody>";
						
						//TRANSFERENCIA ENTRADAS TOTAL
						$qr_entrada_total_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						ORDER BY numeracao ASC";
						$todos_entrada_total_t = mysqli_query($conn,$qr_entrada_total_t); 
                        while ($dados_entrada_total_t = mysqli_fetch_array($todos_entrada_total_t)) {
						$entradastotal_t   = $dados_entrada_total_t["SUM(valor)"];
						}
						
						//TRANSFERENCIA ENTRADAS
						$qr_entrada_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						GROUP BY plano_conta_id
						ORDER BY numeracao ASC";
						$todos_entrada_t = mysqli_query($conn,$qr_entrada_t); 
                        while ($dados_entrada_t = mysqli_fetch_array($todos_entrada_t)) {
						$valortotal   = $dados_entrada_t["SUM(valor)"];
						$numeracao    = $dados_entrada_t["numeracao"];
						$plano_conta  = $dados_entrada_t["plano_conta"];
						
						//PERCENTUAL
						$percentual = (100*$valortotal)/$entradastotal_t;
						$percentual = number_format($percentual,0,'.',''); 
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao - $plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$percentual</td>
                       </tr>";
						}
						
						//MOEDA
						$entradastotal_t2 = moeda($entradastotal_t);
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$entradastotal_t2</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'></td>
                       </tr>";

                    	
						echo"</tbody><tbody>";
						
						?>
                                               
                        <?php
						
						echo"<tbody>
                        <tr>
                            <td style='text-align:left' colspan='3'><h2 style='font-size:15px;color:#114a66;'><strong>SA&Iacute;DAS</strong></h2></td>
                        </tr>
                    		</tbody>";
						
						//SAIDA TOTAL
						$qr_saida_total = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'S' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						ORDER BY numeracao ASC";
						$todos_saida_total = mysqli_query($conn,$qr_saida_total); 
                        while ($dados_saida_total = mysqli_fetch_array($todos_saida_total)) {
						$saidastotal   = $dados_saida_total["SUM(valor)"];
						}
						
						//SAIDAS
						$qr_saida = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'S' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						GROUP BY plano_conta_id
						ORDER BY numeracao ASC";
						$todos_saida = mysqli_query($conn,$qr_saida); 
                        while ($dados_saida = mysqli_fetch_array($todos_saida)) {
						$valortotal   = $dados_saida["SUM(valor)"];
						$numeracao    = $dados_saida["numeracao"];
						$plano_conta  = $dados_saida["plano_conta"];
						
						//PERCENTUAL
						$percentual = (100*$valortotal)/$saidastotal;
						$percentual = number_format($percentual,0,'.',''); 

						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao - $plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$percentual</td>
                       </tr>";
						}
						
						$saidastotal2 = moeda($saidastotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$saidastotal2</b></td>
 						<td style='font-size:13px;color:#333333;text-align:right'></td>
                       </tr>";
						
						echo"</tbody>";
						?>
                
 					<?php 
						
						echo"<tbody>
                        <tr>
                            <td style='text-align:left' colspan='3'><h2 style='font-size:15px;color:#114a66;'><strong>TRANSFER&Ecirc;NCIAS - SA&Iacute;DAS</strong></h2></td>
                        </tr>
                    		</tbody>";
													
						echo"<tbody>";
						
						//TRANSFERENCIA ENTRADAS TOTAL
						$qr_saida_total_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						ORDER BY numeracao ASC";
						$todos_saida_total_t = mysqli_query($conn,$qr_saida_total_t); 
                        while ($dados_saida_total_t = mysqli_fetch_array($todos_saida_total_t)) {
						$saidastotal_t   = $dados_saida_total_t["SUM(valor)"];
						}
						
						//TRANSFERENCIA saidaS
						$qr_saida_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai-01' AND '$dataf-31'
						GROUP BY plano_conta_id
						ORDER BY numeracao ASC";
						$todos_saida_t = mysqli_query($conn,$qr_saida_t); 
                        while ($dados_saida_t = mysqli_fetch_array($todos_saida_t)) {
						$valortotal   = $dados_saida_t["SUM(valor)"];
						$numeracao    = $dados_saida_t["numeracao"];
						$plano_conta  = $dados_saida_t["plano_conta"];
						
						//PERCENTUAL
						$percentual = (100*$valortotal)/$saidastotal_t;
						$percentual = number_format($percentual,0,'.',''); 
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao - $plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$percentual</td>
                       </tr>";
						}
						
						//MOEDA
						$saidastotal_t2 = moeda($saidastotal_t);
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$saidastotal_t2</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'></td>
                       </tr>";

                    	
						echo"</tbody><tbody>";
						
						?>
                
                 <tbody>
                        <tr>
                            <td style='text-align:left' colspan='3'><h2 style='font-size:15px;color:#114a66;'><strong>RESUMO</strong></h2></td>
                        </tr>
                    </tbody>
                
                
                <?php
                
				
				
				$qr_saldoatual = "SELECT SUM(anterior),instituicao_id,ano,mes
				FROM pae_saldoconsolidado
				WHERE instituicao_id = '$igreja'
				AND mes = '$mesi'
				AND ano = '$anoi'
				";
				$todos_saldoatual = mysqli_query($conn,"$qr_saldoatual"); 
				while ($dados_saldoatual = mysqli_fetch_array($todos_saldoatual)) {
				$saldoanterior  = $dados_saldoatual["SUM(anterior)"];
				}

				$saldoatual = ($entradastotal+$entradastotal_t)-($saidastotal+$saidastotal_t)+$saldoanterior;
//				$saldoatual = $saldoanterior+$entradastotal+$entradastotal_t-$saidastotal-$saidastotal_t;
				if ($saldoatual < "0") { $cor='red'; } else { $cor = 'black'; }
				$saldoatual = moeda($saldoatual);
				$saldoanterior = moeda($saldoanterior);
				$saldoatual = "<font color='$cor'>$saldoatual</font>";
				
				
						
						echo"<tbody>";
					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>SALDO ANTERIOR</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$saldoanterior</b></td>
						</tr>";
					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>ENTRADAS</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$entradastotal2</b></td>
						</tr>";
					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIAS - ENTRADAS</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$entradastotal_t2</b></td>
						</tr>";					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>SA&Iacute;DAS</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$saidastotal2</b></td>
						</tr>";
					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIAS - SA&Iacute;DAS</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$saidastotal_t2</b></td>
						</tr>";						
					
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>SALDO ATUAL</b></td>
						<td colspan='3' style='font-size:13px;color:#333333;text-align:right'><b>$saldoatual</b></td>
						</tr>";						
											
					echo"</tbody>";
				
				?>
                
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




