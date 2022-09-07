<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda.php");

                $conn = OpenCon();
		
		$datai     = $_POST["datai"];
		$dataf     = $_POST["dataf"];
		$igreja    = $_POST["id_sub_categoria"];
		$distrito  = $_POST["id_categoria"];
		
		//DATA INICIAL
		$diai = date('d', strtotime($datai));
		$mesi = date('m', strtotime($datai));
		$anoi = date('Y', strtotime($datai));
		$datai_texto = "$diai/$mesi/$anoi";

		//DATA FINAL
		$diaf = date('d', strtotime($dataf));
		$mesf = date('m', strtotime($dataf));
		$anof = date('Y', strtotime($dataf));
		$dataf_texto = "$diaf/$mesf/$anof";
		
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
            LIVRO RAZ&Atilde;O DA <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form02"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel02/rel_p.php?igreja=<?php echo"$igreja&distrito=$distrito&datai=$datai&dataf=$dataf";?>" 
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
                         <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAIS</strong></h2></th>
                  </tr>
                </thead> 
                
					<?php 
						
						echo"<tbody>";
						
						//ENTRADAS TOTAL
						$qr_entrada_total = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'E' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						<td style='font-size:13px;color:#333333;text-align:left'><b>$numeracao - $plano_conta</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>
                       </tr>";
			
							//ENTRADAS INDIVIDUAIS
							$qr_entrada_i = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
							plano_conta_id,plano_conta, valor
							FROM pae_financeiro
							WHERE tipo = 'E' 
							AND igreja_id='$igreja'
							AND data_movimento BETWEEN '$datai' AND '$dataf'
							AND numeracao='$numeracao'
							ORDER BY data_movimento ASC";
							$todos_entrada_i = mysqli_query($conn,$qr_entrada_i); 
							while ($dados_entrada_i = mysqli_fetch_array($todos_entrada_i)) {
							$valortotal_i   = $dados_entrada_i["valor"];
							$numeracao_i    = $dados_entrada_i["numeracao"];
							$plano_conta_i  = $dados_entrada_i["plano_conta"];
							$data_movimento  = $dados_entrada_i["data_movimento"];
						   
							   	//DATA DO MOVIMENTO
								$dia_mov = date('d', strtotime($data_movimento));
								$mes_mov = date('m', strtotime($data_movimento));
								$ano_mov = date('Y', strtotime($data_movimento));
						   		$data_mov = "$dia_mov/$mes_mov/$ano_mov";
								
							//MOEDA
							$valortotal_i = moeda($valortotal_i);
							
							 echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left;padding-left:62px'>$data_mov</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$valortotal_i</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
						   </tr>";
						   
							}
						
						}
						
						//MOEDA
						$entradastotal2 = moeda($entradastotal);
                    	
						echo"</tbody><tbody>";
						
						?>
 
 					<?php 
						
													
						echo"<tbody>";
						
						//TRANSFERENCIA ENTRADAS TOTAL
						$qr_entrada_total_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						<td style='font-size:13px;color:#333333;text-align:left'><b>$numeracao - $plano_conta</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>
                       </tr>";
					   
							//ENTRADAS INDIVIDUAIS
							$qr_entrada_ti = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
							plano_conta_id,plano_conta, valor
							FROM pae_financeiro
							WHERE tipo = 'T'
							AND tipo_lancamento = 'E' 
							AND igreja_id='$igreja'
							AND data_movimento BETWEEN '$datai' AND '$dataf'
							AND numeracao='$numeracao'
							ORDER BY data_movimento ASC";
							$todos_entrada_ti = mysqli_query($conn,$qr_entrada_ti); 
							while ($dados_entrada_ti = mysqli_fetch_array($todos_entrada_ti)) {
							$valortotal_ti   = $dados_entrada_ti["valor"];
							$numeracao_ti    = $dados_entrada_ti["numeracao"];
							$plano_conta_ti  = $dados_entrada_ti["plano_conta"];
							$data_movimento  = $dados_entrada_ti["data_movimento"];
						   
							   	//DATA DO MOVIMENTO
								$dia_mov = date('d', strtotime($data_movimento));
								$mes_mov = date('m', strtotime($data_movimento));
								$ano_mov = date('Y', strtotime($data_movimento));
						   		$data_mov = "$dia_mov/$mes_mov/$ano_mov";
								
							//MOEDA
							$valortotal_ti = moeda($valortotal_ti);
							
							 echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left;padding-left:62px'>$data_mov</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$valortotal_ti</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
						   </tr>";
						   
							}
					   
						}
						
						//MOEDA
						$entradastotal_t2 = moeda($entradastotal_t);
						
                    	
						echo"</tbody><tbody>";
						
						?>
                                               
                        <?php
						
						
						//SAIDA TOTAL
						$qr_saida_total = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'S' 
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						<td style='font-size:13px;color:#333333;text-align:left'><b>$numeracao - $plano_conta</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>
                       </tr>";
					   
							//SAIDAS INDIVIDUAIS
							$qr_saida_ti = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
							plano_conta_id,plano_conta, valor
							FROM pae_financeiro
							WHERE tipo_lancamento = 'S' 
							AND igreja_id='$igreja'
							AND data_movimento BETWEEN '$datai' AND '$dataf'
							AND numeracao='$numeracao'
							ORDER BY data_movimento ASC";
							$todos_saida_ti = mysqli_query($conn,$qr_saida_ti); 
							while ($dados_saida_ti = mysqli_fetch_array($todos_saida_ti)) {
							$valortotal_saida     = $dados_saida_ti["valor"];
							$numeracao_saida      = $dados_saida_ti["numeracao"];
							$plano_conta_saida    = $dados_saida_ti["plano_conta"];
							$data_movimento_saida = $dados_saida_ti["data_movimento"];
						   
							   	//DATA DO MOVIMENTO
								$dia_mov_saida  = date('d', strtotime($data_movimento_saida));
								$mes_mov_saida  = date('m', strtotime($data_movimento_saida));
								$ano_mov_saida  = date('Y', strtotime($data_movimento_saida));
						   		$data_mo_saidav = "$dia_mov/$mes_mov/$ano_mov";
								
							//MOEDA
							$valortotal_saida = moeda($valortotal_saida);
							
							 echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left;padding-left:62px'>$data_mo_saidav</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$valortotal_saida</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
						   </tr>";
						   
							}					   
						}
						
						$saidastotal2 = moeda($saidastotal);

						echo"</tbody>";
						?>
                
 					<?php 
													
						echo"<tbody>";
						
						//TRANSFERENCIA ENTRADAS TOTAL
						$qr_saida_total_t = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE tipo = 'T'
						AND tipo_lancamento = 'E'
						AND igreja_id='$igreja'
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						AND data_movimento BETWEEN '$datai' AND '$dataf'
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
						<td style='font-size:13px;color:#333333;text-align:left'><b>$numeracao - $plano_conta</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
						<td style='font-size:13px;color:#333333;text-align:right'></td>
 						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>
                       </tr>";
					   
					   
							//SAIDAS INDIVIDUAIS
							$qr_saida_ti = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,tipo,
							plano_conta_id,plano_conta, valor
							FROM pae_financeiro
							WHERE tipo = 'T'
							AND tipo_lancamento = 'S'
							AND igreja_id='$igreja'
							AND data_movimento BETWEEN '$datai' AND '$dataf'
							AND numeracao='$numeracao'
							ORDER BY data_movimento ASC";
							$todos_saida_ti = mysqli_query($conn,$qr_saida_ti); 
							while ($dados_saida_ti = mysqli_fetch_array($todos_saida_ti)) {
							$valortotal_saida     = $dados_saida_ti["valor"];
							$numeracao_saida      = $dados_saida_ti["numeracao"];
							$plano_conta_saida    = $dados_saida_ti["plano_conta"];
							$data_movimento_saida = $dados_saida_ti["data_movimento"];
						   
							   	//DATA DO MOVIMENTO
								$dia_mov_saida  = date('d', strtotime($data_movimento_saida));
								$mes_mov_saida  = date('m', strtotime($data_movimento_saida));
								$ano_mov_saida  = date('Y', strtotime($data_movimento_saida));
						   		$data_mo_saidav = "$dia_mov/$mes_mov/$ano_mov";
								
							//MOEDA
							$valortotal_saida = moeda($valortotal_saida);
							
							 echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left;padding-left:62px'>$data_mo_saidav</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$valortotal_saida</td>
							<td style='font-size:13px;color:#333333;text-align:right'></td>
						   </tr>";
						   
							}					   
						}
						
						//MOEDA
						$saidastotal_t2 = moeda($saidastotal_t);
						
						echo"</tbody><tbody>";
						
						?>
                
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




