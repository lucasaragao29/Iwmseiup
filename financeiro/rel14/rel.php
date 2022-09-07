<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda.php");
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$distrito   = $_POST["id_sub_categoria"];
		$regiao     = $_POST["id_categoria"];
		$datai      = $_POST["datai"];
		$dataf      = $_POST["dataf"];
		
		//MOSTRA DATA INICIAL		
		$diai = date('d', strtotime($datai));
		$mesi = date('m', strtotime($datai));
		$anoi = date('Y', strtotime($datai));		
		$datai_t = "$mesi/$anoi";
		$datai_m = "$anoi-$mesi-01";
		
		//MOSTRA DATA FINAL
		$diaf = date('d', strtotime($dataf));
		$mesf = date('m', strtotime($dataf));
		$anof = date('Y', strtotime($dataf));		
		$dataf_t = "$mesf/$anof";
		$dataf_m = "$anof-$mesf-31";

				
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		$regiao_nome  = $row_distrito["regiao"];
		}

		//APAGAR A PALAVRA
		$igreja_nome = str_replace("IMW ", "", $igreja_nome); 
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO		
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome    = maiuscula($regiao_nome);
		$igreja_nome2   = maiuscula($igreja_nome);

		//DESCRICAO
		$descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome<br>PERIODO $datai_t a $dataf_t";
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
			'Gerar relatorio de investimento de clerigo do distrito $distrito_nome
			 - $regiao_nome do perido de $datai_t a $dataf_t','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            INVESTIMENTO EM CL&Eacute;RIGO I<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form14"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel14/rel_p.php?distrito=<?php echo"$distrito&igreja=$igreja&datai=$datai&dataf=$dataf";?>" 
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
                
       
						<?php 
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito
						FROM pae_igreja
						WHERE distrito_id='$distrito'
						ORDER BY nome ASC";
						$todos_igreja = mysql_query("$qr_igreja"); 
                        while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
						$igreja_id   = $dados_igreja["id"];
						$igreja_nome = $dados_igreja["nome"];
						
						$igreja_nome2 = maiuscula($igreja_nome);
						
						echo"<thead  >
							<tr bgcolor='#114a66'>
							<th colspan='3' style='text-align:center'><h2 style='font-size:15px;color:#fff;'><strong>$igreja_nome2</strong></h2></th>
							</tr>
							<tr >
							<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>COD</strong></h2></th>
							<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>CONTA</strong></h2></th>
							<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>SUBSIDIO</strong></h2></th> 
							</tr>
						</thead> 
						<tbody>";
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND igreja_id='$igreja_id'
						AND data_movimento BETWEEN '$datai_m' AND '$dataf_m'
						GROUP BY plano_conta_id
						ORDER BY plano_conta_id ASC";
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						//MOEDA
						$valortotal = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal</td>
                        </tr>";
						
						}
						
						
						
						//TOTAL						//
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND igreja_id='$igreja_id'
						AND data_movimento BETWEEN '$datai_m' AND '$dataf_m'";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						
						
						//MOEDA
						$valortotal = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:left'></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal</b></td>
                        </tr>";
						
						}
			
                    	}
						
						
						//TOTAL DO DISTRITOS
						echo"<thead  >
							<tr bgcolor='#000'>
							<th colspan='3' style='text-align:center'><h2 style='font-size:15px;color:#fff;'><strong>DISTRITO $distrito_nome2</strong></h2></th>
							</tr>
							<tr >
							<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>COD</strong></h2></th>
							<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>CONTA</strong></h2></th>
							<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>SUBSIDIO</strong></h2></th> 
							</tr>
						</thead> 
						<tbody>";
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND distrito_id='$distrito'
						AND data_movimento BETWEEN '$datai_m' AND '$dataf_m'
						GROUP BY plano_conta_id
						ORDER BY plano_conta_id ASC";
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						//MOEDA
						$valortotal = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$numeracao</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$plano_conta</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal</td>
                        </tr>";
						
						}
						
						
						
						//TOTAL						//
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, data_movimento,
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND distrito_id='$distrito'
						AND data_movimento BETWEEN '$datai_m' AND '$dataf_m'";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						//MOEDA
						$valortotal = moeda($valortotal);
						
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:left'></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal</b></td>
                        </tr>";
						
						}	
					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




