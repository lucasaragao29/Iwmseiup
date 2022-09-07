<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id='$regiao'";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}
		
		//MAIUSCULO
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>$regiao_nome2 - $ano";
		
		include "../config/meuip.php";
	
		//GRAVAR HISTORICO DA ACAO
		$GRAVAR = "INSERT INTO historico_usuario
		(coduser,codregiao,coddistrito, userip,sessao,
		acao,codarquivo,tipo_arquivo,
		data,hora)
		VALUES
		('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
		'Gerar listagem da estatistica de recepcao, desligamento e transferencia de membros da regiao da $regiao_nome do ano $ano','$dados','pae_membro',
		curdate( ),curtime( ))";
		$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            ESTAT&Iacute;STICAS DE RECEP&Ccedil;&Atilde;O, DESLIGAMENTO E TRANSFER&Ecirc;NCIA<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form18"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel18/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
            <th><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>MASCULINO</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>FEMININO</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>N&Atilde;O INFORMADO</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>

						<?php 
						
						$anterior = $ano-1;
						$anterior2 = $ano-2;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_anterior = "$anterior-$mes_atual-$dia_atual";
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
						
							$qr_rol_anterior = "SELECT regiao_id,sexo,status,dt_recepcao,igreja,
							  SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							  SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							  SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							  COUNT(*) AS Total
							  FROM pae_membro 
							  WHERE status='A'
							  	AND regiao_id='$regiao'
								AND (dt_recepcao <= '$anterior-11-01')";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$feminino    = $dados_rol_anterior["feminino"];
							$masculino   = $dados_rol_anterior["masculino"];
							$indefinido  = $dados_rol_anterior["indefinido"];	
							}
												
							
					 //DESLIGAMENTOS
						
						$qr_rol_anterior_d = "SELECT sexo,status,regiao_id,modo_exclusao_id,dt_exclusao,
							  SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							  SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							  SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							  COUNT(*) AS Total
							  FROM pae_membro 
							  WHERE regiao_id='$regiao' and modo_exclusao_id > '5' and status='I' 
							 and (dt_exclusao between '$anterior-11-01' and '$ano-11-01')";
							$todos_rol_anterior_d = mysql_query($qr_rol_anterior_d); 
							$tr_rol_anterior_d = mysql_num_rows($todos_rol_anterior_d);
							while ($dados_rol_anterior_d = mysql_fetch_array($todos_rol_anterior_d)) {
							$feminino_d    = $dados_rol_anterior_d["feminino"];
							$masculino_d   = $dados_rol_anterior_d["masculino"];
							$indefinido_d  = $dados_rol_anterior_d["indefinido"];	
							}
					
					//VALORES
		
					$tr_anterior_m = $masculino+$masculino_d;
					$tr_anterior_f = $feminino+$feminino_d;
					$tr_anterior_n = $indefinido+$indefinido_d;
					$tr_anterior_total = $tr_anterior_m+$tr_anterior_f+$tr_anterior_n;
		
							
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_anterior_m</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_anterior_f</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_anterior_n</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_anterior_total</td>
							</tr>";
							
							//RECEBIMENTOS >>
						
							$qr_recepcao = "SELECT distrito_id,sexo,status,dt_recepcao,igreja,modo_recepcao_id,dt_recepcao,
							  SUM(CASE WHEN modo_recepcao_id='1' and sexo='F' then 1 ELSE 0 END) AS batismo_f,
							  SUM(CASE WHEN modo_recepcao_id='2' and sexo='F' then 1 ELSE 0 END) AS adesao_f,
							  SUM(CASE WHEN modo_recepcao_id='3' and sexo='F' then 1 ELSE 0 END) AS reconciliacao_f,
							  SUM(CASE WHEN modo_recepcao_id='4' and sexo='F' then 1 ELSE 0 END) AS transferencia_f,
							  SUM(CASE WHEN modo_recepcao_id='5' and sexo='F' then 1 ELSE 0 END) AS cadastramento_f,
							  
							  SUM(CASE WHEN modo_recepcao_id='1' and sexo='M' then 1 ELSE 0 END) AS batismo_m,
							  SUM(CASE WHEN modo_recepcao_id='2' and sexo='M' then 1 ELSE 0 END) AS adesao_m,
							  SUM(CASE WHEN modo_recepcao_id='3' and sexo='M' then 1 ELSE 0 END) AS reconciliacao_m,
							  SUM(CASE WHEN modo_recepcao_id='4' and sexo='M' then 1 ELSE 0 END) AS transferencia_m,
							  SUM(CASE WHEN modo_recepcao_id='5' and sexo='M' then 1 ELSE 0 END) AS cadastramento_m,
							  
							  SUM(CASE WHEN modo_recepcao_id='1' and sexo='' then 1 ELSE 0 END) AS batismo_n,
							  SUM(CASE WHEN modo_recepcao_id='2' and sexo='' then 1 ELSE 0 END) AS adesao_n,
							  SUM(CASE WHEN modo_recepcao_id='3' and sexo='' then 1 ELSE 0 END) AS reconciliacao_n,
							  SUM(CASE WHEN modo_recepcao_id='4' and sexo='' then 1 ELSE 0 END) AS transferencia_n,
							  SUM(CASE WHEN modo_recepcao_id='5' and sexo='' then 1 ELSE 0 END) AS cadastramento_n,
							  
							  COUNT(*) AS Total
							  FROM pae_membro 
							  WHERE status='A'
							  	AND regiao_id='$regiao' 
								AND (dt_recepcao between '$anterior-11-01' AND '$ano-11-01')";
							$todos_recepcao = mysql_query($qr_recepcao); 
							$tr_recepcao = mysql_num_rows($todos_recepcao);
							while ($dados_recepcao = mysql_fetch_array($todos_recepcao)) {
							$batismo_f        = $dados_recepcao["batismo_f"];
							$adesao_f         = $dados_recepcao["adesao_f"];
							$reconciliacao_f  = $dados_recepcao["reconciliacao_f"];
							$transferencia_f  = $dados_recepcao["transferencia_f"];
							$cadastramento_f  = $dados_recepcao["cadastramento_f"];
							
							$batismo_m        = $dados_recepcao["batismo_m"];
							$adesao_m         = $dados_recepcao["adesao_m"];
							$reconciliacao_m  = $dados_recepcao["reconciliacao_m"];
							$transferencia_m  = $dados_recepcao["transferencia_m"];
							$cadastramento_m  = $dados_recepcao["cadastramento_m"];
							
							$batismo_n        = $dados_recepcao["batismo_n"];
							$adesao_n         = $dados_recepcao["adesao_n"];
							$reconciliacao_n  = $dados_recepcao["reconciliacao_n"];
							$transferencia_n  = $dados_recepcao["transferencia_n"];
							$cadastramento_n  = $dados_recepcao["cadastramento_n"];
								
							}
						
						//RECEBIDOS
						
						 echo"<tr>
                        <td colspan='5' style='font-size:15px;color:#fff;text-align:center;background:#114a66;'><b>RECEBIDOS
						</b></td>
                        </tr>";
							
						//TOTAIS
						$adesao_total        = $adesao_m+$adesao_f+$adesao_n;
						$batismo_total       = $batismo_m+$batismo_f+$batismo_n;
						$reconciliacao_total = $reconciliacao_m+$reconciliacao_f+$reconciliacao_n;
						$transferencia_total = $transferencia_m+$transferencia_f+$transferencia_n;
						$cadastramento_total = $cadastramento_m+$cadastramento_f+$cadastramento_n;
                       	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>ADES&Atilde;O</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$adesao_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$adesao_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$adesao_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$adesao_total</td>
                        </tr>";
 
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>BATISMO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$batismo_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$batismo_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$batismo_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$batismo_total</td>
                        </tr>";

                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>CADASTRAMENTO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$cadastramento_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$cadastramento_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$cadastramento_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$cadastramento_total</td>
                        </tr>";
							
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>RECONCILIA&Ccedil;&Atilde;O</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$reconciliacao_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$reconciliacao_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$reconciliacao_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$reconciliacao_total</td>
                        </tr>";	
                       	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIA</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$transferencia_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_total</td>
                        </tr>";
 
						//TOTAL MASCULINO
						$tr_sexo_t_masculino = $adesao_m+$batismo_m+$cadastramento_m
						+$reconciliacao_m+$transferencia_m;
						
						//TOTAL FEMININO
						$tr_sexo_t_feminino = $adesao_f+$batismo_f+$cadastramento_f
						+$reconciliacao_f+$transferencia_f;

						//TOTAL NAO INFORMADO
						$tr_sexo_t_naoinformado = $adesao_n+$batismo_n+$cadastramento_n
						+$reconciliacao_n+$transferencia_n;

						//TOTAL TOTAL
						$tr_sexo_t_total = $adesao_total+$batismo_total+$cadastramento_total
						+$reconciliacao_total+$transferencia_total;
							
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_masculino</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_feminino</b></td>
                        <td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_naoinformado</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_total</b></td>
                        </tr>";	
						
						
						//EXCLUSOES >>
						
							$qr_exclusao = "SELECT modo_exclusao_id,status,regiao_id,dt_exclusao,sexo,
							  SUM(CASE WHEN modo_exclusao_id='6' and sexo='F' then 1 ELSE 0 END) AS pedido_f,
							  SUM(CASE WHEN modo_exclusao_id='7' and sexo='F' then 1 ELSE 0 END) AS abandono_f,
							  SUM(CASE WHEN modo_exclusao_id='8' and sexo='F' then 1 ELSE 0 END) AS falecimento_f,
							  SUM(CASE WHEN modo_exclusao_id='9' and sexo='F' then 1 ELSE 0 END) AS desligamento_f,
							  SUM(CASE WHEN modo_exclusao_id='10' and sexo='F' then 1 ELSE 0 END) AS transferencia_f,
							  SUM(CASE WHEN modo_exclusao_id='11' and sexo='F' then 1 ELSE 0 END) AS duplicidade_f,
							  
							  SUM(CASE WHEN modo_exclusao_id='6' and sexo='M' then 1 ELSE 0 END) AS pedido_m,
							  SUM(CASE WHEN modo_exclusao_id='7' and sexo='M' then 1 ELSE 0 END) AS abandono_m,
							  SUM(CASE WHEN modo_exclusao_id='8' and sexo='M' then 1 ELSE 0 END) AS falecimento_m,
							  SUM(CASE WHEN modo_exclusao_id='9' and sexo='M' then 1 ELSE 0 END) AS desligamento_m,
							  SUM(CASE WHEN modo_exclusao_id='10' and sexo='M' then 1 ELSE 0 END) AS transferencia_m,
							  SUM(CASE WHEN modo_exclusao_id='11' and sexo='M' then 1 ELSE 0 END) AS duplicidade_m,
							  
							  SUM(CASE WHEN modo_exclusao_id='6' and sexo='' then 1 ELSE 0 END) AS pedido_n,
							  SUM(CASE WHEN modo_exclusao_id='7' and sexo='' then 1 ELSE 0 END) AS abandono_n,
							  SUM(CASE WHEN modo_exclusao_id='8' and sexo='' then 1 ELSE 0 END) AS falecimento_n,
							  SUM(CASE WHEN modo_exclusao_id='9' and sexo='' then 1 ELSE 0 END) AS desligamento_n,
							  SUM(CASE WHEN modo_exclusao_id='10' and sexo='' then 1 ELSE 0 END) AS transferencia_n,
							  SUM(CASE WHEN modo_exclusao_id='11' and sexo='' then 1 ELSE 0 END) AS duplicidade_n,
							  
							  COUNT(*) AS Total
							  FROM pae_membro 
							  WHERE status='I'
							  	AND regiao_id='$regiao' 
								AND (dt_exclusao between '$anterior-11-01' AND '$ano-11-01')";
							$todos_exclusao = mysql_query($qr_exclusao); 
							$tr_exclusao = mysql_num_rows($todos_exclusao);
							while ($dados_exclusao = mysql_fetch_array($todos_exclusao)) {
							$pedido_f        = $dados_exclusao["pedido_f"];
							$abandono_f      = $dados_exclusao["abandono_f"];
							$falecimento_f   = $dados_exclusao["falecimento_f"];
							$desligamento_f  = $dados_exclusao["desligamento_f"];
							$transferencia_f = $dados_exclusao["transferencia_f"];
							$duplicidade_f   = $dados_exclusao["duplicidade_f"];
							
							$pedido_m        = $dados_exclusao["pedido_m"];
							$abandono_m      = $dados_exclusao["abandono_m"];
							$falecimento_m   = $dados_exclusao["falecimento_m"];
							$desligamento_m  = $dados_exclusao["desligamento_m"];
							$transferencia_m = $dados_exclusao["transferencia_m"];
							$duplicidade_m   = $dados_exclusao["duplicidade_m"];
							
							$pedido_n        = $dados_exclusao["pedido_n"];
							$abandono_n      = $dados_exclusao["abandono_n"];
							$falecimento_n   = $dados_exclusao["falecimento_n"];
							$desligamento_n  = $dados_exclusao["desligamento_n"];
							$transferencia_n = $dados_exclusao["transferencia_n"];
							$duplicidade_n   = $dados_exclusao["duplicidade_n"];
								
							}
						
						//RECEBIDOS
						
						 echo"<tr>
                        <td colspan='5' style='font-size:15px;color:#fff;text-align:center;background:#114a66;'><b>DESLIGAMENTOS
						</b></td>
                        </tr>";
							
						//TOTAIS
						$pedido_total        = $pedido_m+$pedido_f+$pedido_n;
						$abandono_total      = $abandono_m+$abandono_f+$abandono_n;
						$falecimento_total   = $falecimento_m+$falecimento_f+$falecimento_n;
						$desligamento_total  = $desligamento_m+$desligamento_f+$desligamento_n;
						$cadastramento_total = $transferencia_m+$transferencia_f+$transferencia_n;
						$duplicidade_total   = $duplicidade_m+$duplicidade_f+$duplicidade_n;
                       	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>PEDIDO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$pedido_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$pedido_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$pedido_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$pedido_total</td>
                        </tr>";
 
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>ABANDONO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$abandono_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$abandono_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$abandono_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$abandono_total</td>
                        </tr>";

                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIA</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$transferencia_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$transferencia_total</td>
                        </tr>";
							
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>FALECIMENTO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$falecimento_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$falecimento_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$falecimento_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$falecimento_total</td>
                        </tr>";	
                       	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>DESLIGAMENTO</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$desligamento_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$desligamento_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$desligamento_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$desligamento_total</td>
                        </tr>";
                       	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>DUPLICIDADE</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'>$duplicidade_m</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$duplicidade_f</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$duplicidade_n</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$duplicidade_total</td>
                        </tr>";
						 
						//TOTAL MASCULINO
						$tr_sexo_t_masculino = $pedido_m+$abandono_m+$transferencia_m
						+$falecimento_m+$desligamento_m+$duplicidade_m;
						
						//TOTAL FEMININO
						$tr_sexo_t_feminino = $pedido_f+$abandono_f+$transferencia_f
						+$falecimento_f+$desligamento_f+$duplicidade_f;

						//TOTAL NAO INFORMADO
						$tr_sexo_t_naoinformado = $pedido_n+$abandono_n+$transferencia_n
						+$falecimento_n+$desligamento_n+$duplicidade_n;

						//TOTAL TOTAL
						$tr_sexo_t_total = $pedido_total+$abandono_total+$transferencia_total
						+$falecimento_total+$desligamento_total+$duplicidade_total;
							
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_masculino</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_feminino</b></td>
                        <td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_naoinformado</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_sexo_t_total</b></td>
                        </tr>";		
						
											

	
						
						//ROL ATUAL 
						
							$qr_rol_atual = "SELECT regiao_id,sexo,status,dt_recepcao,igreja,
							  SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							  SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							  SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							  COUNT(*) AS Total
							  FROM pae_membro 
							  WHERE status='A'
							  	AND regiao_id='$regiao'
								AND (dt_recepcao <= '$ano-11-01')";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							$tr_rol_atual = mysql_num_rows($todos_rol_atual);
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$feminino    = $dados_rol_atual["feminino"];
							$masculino   = $dados_rol_atual["masculino"];
							$indefinido  = $dados_rol_atual["indefinido"];	
							}
							
							$tr_total_atual = $feminino+$masculino+$indefinido;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$masculino</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$feminino</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$indefinido</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_total_atual</td>
							</tr>";
						
						
						
						
												
																	
                        ?>
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




