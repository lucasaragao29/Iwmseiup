<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano        = $_POST["ano"];
		$igreja     = $_POST["id_sub_categoria"];
		$distrito   = $_POST["id_categoria"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		}
		
		//DESCOBRIR IGREJA
		$result_igreja = "SELECT * FROM pae_igreja WHERE id=$igreja";
		$resultado_igreja = mysql_query($result_igreja);		
		while ($row_igreja = mysql_fetch_assoc($resultado_igreja) ) {
		$igreja_nome  = $row_igreja["nome"];
		}
				
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		$igreja_nome = str_replace("IMW ", "", $igreja_nome); 
		
		//MAIUSCULO
		
		$distrito_nome2 = maiuscula($distrito_nome);
		$igreja_nome2 = maiuscula($igreja_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>IMW $igreja_nome2 - DISTRITO $distrito_nome2 - $ano";
		
		include "../config/meuip.php";
	
		//GRAVAR HISTORICO DA ACAO
		$GRAVAR = "INSERT INTO historico_usuario
		(coduser,codregiao,coddistrito, userip,sessao,
		acao,codarquivo,tipo_arquivo,
		data,hora)
		VALUES
		('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
		'Gerar listagem da estatistica de recepcao e desligamento da IMW $igreja_nome do distrito de $distrito_nome2 do 
		ano $ano','$dados','pae_membro',
		curdate( ),curtime( ))";
		$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            ESTAT&Iacute;STICAS DE RECEP&Ccedil;&Atilde;O E DESLIGAMENTO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form18"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel18/rel_p.php?distrito=<?php echo"$distrito&igreja=$igreja&ano=$ano";?>" 
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
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>MASCULINO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>FEMININO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>N&Atilde;O INFORMADO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>
                    
						<?php 
						
						$anterior = $ano-1;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						
						//ROL ANTERIOR
						
							//RECEBIMENTOS
							$qr_rol_anterior = "SELECT igreja_id,sexo,ano_recepcao,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino_a,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino_a,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido_a,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id = '$igreja'
							AND ano_recepcao <= '$anterior'";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$feminino    = $dados_rol_anterior["feminino_a"];
							$masculino   = $dados_rol_anterior["masculino_a"];
							$indefinido  = $dados_rol_anterior["indefinido_a"];	
							}
											
							
							//DESLIGAMENTOS
							$qr_rol_anterior_d = "SELECT sexo,distrito_id,ano_exclusao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino_ae,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino_ae,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido_ae,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id = '$igreja'
							AND ano_exclusao BETWEEN '1' AND '$anterior'";
							$todos_rol_anterior_d = mysql_query($qr_rol_anterior_d); 
							$tr_rol_anterior_d = mysql_num_rows($todos_rol_anterior_d);
							while ($dados_rol_anterior_d = mysql_fetch_array($todos_rol_anterior_d)) {
							$feminino_d    = $dados_rol_anterior_d["feminino_ae"];
							$masculino_d   = $dados_rol_anterior_d["masculino_ae"];
							$indefinido_d  = $dados_rol_anterior_d["indefinido_ae"];	
							}
						
							//VALORES
							$tr_anterior_m = $masculino-$masculino_d;
							$tr_anterior_f = $feminino-$feminino_d;
							$tr_anterior_n = $indefinido-$indefinido_d;
							$tr_anterior_total = $tr_anterior_m+$tr_anterior_f+$tr_anterior_n;
						
							echo"
							<tr style=\"background-color:#3d3d3d\">
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_m</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_f</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_n</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_total</b></td>
							</tr>";
							
						//RECEBIMENTOS
						
							$qr_recepcao = "SELECT sexo,modo_recepcao_id,ano_recepcao,distrito_id,
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
							WHERE igreja_id = '$igreja'
							AND ano_recepcao = '$ano'";
							$todos_recepcao = mysql_query($qr_recepcao); 
							$tr_recepcao = mysql_num_rows($todos_recepcao);
							while ($dados_recepcao = mysql_fetch_array($todos_recepcao)) {
							$batismo_f        = $dados_recepcao["batismo_f"];
							$adesao_f         = $dados_recepcao["adesao_f"];
							$reconciliacao_f  = $dados_recepcao["reconciliacao_f"];
							$cadastramento_f  = $dados_recepcao["cadastramento_f"];
							$transferencia_f  = $dados_recepcao["transferencia_f"];
							
							$batismo_m        = $dados_recepcao["batismo_m"];
							$adesao_m         = $dados_recepcao["adesao_m"];
							$reconciliacao_m  = $dados_recepcao["reconciliacao_m"];
							$cadastramento_m  = $dados_recepcao["cadastramento_m"];
							$transferencia_m  = $dados_recepcao["transferencia_m"];
							
							$batismo_n        = $dados_recepcao["batismo_n"];
							$adesao_n         = $dados_recepcao["adesao_n"];
							$reconciliacao_n  = $dados_recepcao["reconciliacao_n"];
							$cadastramento_n  = $dados_recepcao["cadastramento_n"];
							$transferencia_n  = $dados_recepcao["transferencia_n"];
								
							}
							
							//TOTAIS
							$adesao_total        = $adesao_m+$adesao_f+$adesao_n;
							$batismo_total       = $batismo_m+$batismo_f+$batismo_n;
							$reconciliacao_total = $reconciliacao_m+$reconciliacao_f+$reconciliacao_n;
							$transferencia_total = $transferencia_m+$transferencia_f+$transferencia_n;
							$cadastramento_total = $cadastramento_m+$cadastramento_f+$cadastramento_n;
			
							//TOTAL MASCULINO
							$tr_sexo_t_masculino = $adesao_m+$batismo_m+$cadastramento_m+$reconciliacao_m+$transferencia_m;
							
							//TOTAL FEMININO
							$tr_sexo_t_feminino = $adesao_f+$batismo_f+$cadastramento_f+$reconciliacao_f+$transferencia_f;
	
							//TOTAL NAO INFORMADO
							$tr_sexo_t_naoinformado = $adesao_n+$batismo_n+$cadastramento_n+$reconciliacao_n+$transferencia_n;
	
							//TOTAL TOTAL
							$tr_sexo_t_total = $adesao_total+$batismo_total+$cadastramento_total+$reconciliacao_total+$transferencia_total;
								
							echo"<tr>
							<td colspan='5' style='font-size:15px;color:#fff;text-align:center;background:#114a66;'><b>RECEBIDOS
							</b></td>
							</tr>";
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>ADES&Atilde;O</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_total</td>
							</tr>";
	 
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>BATISMO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_total</td>
							</tr>";
	
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>CADASTRAMENTO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_total</td>
							</tr>";
								
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>RECONCILIA&Ccedil;&Atilde;O</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_total</td>
							</tr>";	
								
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIA</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_total</td>
							</tr>";	
								 
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_masculino</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_feminino</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_naoinformado</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_total</b></td>
							</tr>";	
						
						//DESLIGAMENTOS >>
						
							$qr_exclusao = "SELECT regiao_id,ano_exclusao,sexo,status,modo_exclusao_id,
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
							WHERE igreja_id = '$igreja'
							AND ano_exclusao = '$ano'";
							$todos_exclusao = mysql_query($qr_exclusao); 
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
								
							//TOTAIS
							$pedido_total        = $pedido_m+$pedido_f+$pedido_n;
							$abandono_total      = $abandono_m+$abandono_f+$abandono_n;
							$transferencia_total = $transferencia_m+$transferencia_f+$transferencia_n;
							$falecimento_total   = $falecimento_m+$falecimento_f+$falecimento_n;
							$desligamento_total  = $desligamento_m+$desligamento_f+$desligamento_n;
							$duplicidade_total   = $duplicidade_m+$duplicidade_f+$duplicidade_n;

							//TOTAL MASCULINO
							$tr_sexo_t_masculino = $pedido_m+$abandono_m+$falecimento_m+$desligamento_m+$duplicidade_m+$transferencia_m;
							
							//TOTAL FEMININO
							$tr_sexo_t_feminino = $pedido_f+$abandono_f+$falecimento_f+$desligamento_f+$duplicidade_f+$transferencia_f;
	
							//TOTAL NAO INFORMADO
							$tr_sexo_t_naoinformado = $pedido_n+$abandono_n+$falecimento_n+$desligamento_n+$duplicidade_n+$transferencia_n;
	
							//TOTAL TOTAL
							$tr_sexo_t_total = $pedido_total+$abandono_total+$falecimento_total+$desligamento_total+$duplicidade_total+$transferencia_total;
								
						
						//DESLIGAMENTOS
						
							echo"<tr>
							<td colspan='5' style='font-size:15px;color:#fff;text-align:center;background:#114a66;'><b>DESLIGAMENTOS
							</b></td></tr>";
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>PEDIDO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$pedido_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$pedido_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$pedido_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$pedido_total</td>
							</tr>";
	 
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>ABANDONO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$abandono_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$abandono_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$abandono_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$abandono_total</td>
							</tr>";
								
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>FALECIMENTO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$falecimento_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$falecimento_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$falecimento_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$falecimento_total</td>
							</tr>";	
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>DESLIGAMENTO</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$desligamento_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$desligamento_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$desligamento_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$desligamento_total</td>
							</tr>";
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>DUPLICIDADE</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$duplicidade_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$duplicidade_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$duplicidade_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$duplicidade_total</td>
							</tr>";

							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>TRANSFER&Ecirc;NCIA</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_m</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_f</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_n</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_total</td>
							</tr>";
														 
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_masculino</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_feminino</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_naoinformado</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_sexo_t_total</b></td>
							</tr>";		
						
						//ROL ATUAL 
						
							$qr_rol_atual = "SELECT regiao_id,sexo,ano_recepcao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id = '$igreja'
							AND ano_recepcao <= '$ano'";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							$tr_rol_atual = mysql_num_rows($todos_rol_atual);
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$feminino_atual    = $dados_rol_atual["feminino"];
							$masculino_atual   = $dados_rol_atual["masculino"];
							$indefinido_atual  = $dados_rol_atual["indefinido"];	
							}

							$qr_rol_atual_e = "SELECT regiao_id,sexo,ano_exclusao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id = '$igreja'
							AND ano_exclusao BETWEEN '1' AND '$ano'";
							$todos_rol_atual_e = mysql_query($qr_rol_atual_e); 
							$tr_rol_atual_e = mysql_num_rows($todos_rol_atual_e);
							while ($dados_rol_atual_e = mysql_fetch_array($todos_rol_atual_e)) {
							$feminino_atual_e    = $dados_rol_atual_e["feminino"];
							$masculino_atual_e   = $dados_rol_atual_e["masculino"];
							$indefinido_atual_e  = $dados_rol_atual_e["indefinido"];	
							}
							
							$feminino_atual   = $feminino_atual-$feminino_atual_e;
							$masculino_atual  = $masculino_atual-$masculino_atual_e;
							$indefinido_atual = $indefinido_atual-$indefinido_atual_e;
							$tr_total_atual = $feminino_atual+$masculino_atual+$indefinido_atual;
							
							echo"
							<tr style=\"background-color:#3d3d3d\">
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$masculino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$feminino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$indefinido_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_total_atual</b></td>
							</tr>";
						
                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




