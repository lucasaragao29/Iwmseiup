<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		
		
		//DESCRICAO
		$descricao_texto = "<br>GERAL - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da estatistica de genero geral do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            ESTAT&Iacute;STICA DE G&Ecirc;NERO<?php echo"$descricao_texto"; ?></strong><br>
            
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
        <tr>
            <th><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
            <th><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>MASCULINO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>FEMININO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>INDEFINIDO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>
                    
						<?php 
						
						if ($regiao == "0") {  }
						
						else { 
						
						$anterior = $ano-1;
						$anterior2 = $ano-2;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						//$data_anterior = "$anterior-$mes_atual-$dia_atual";
						//$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
							
							$qr_rol_anterior = "SELECT regiao_id,status,distrito_id,sexo,igreja,ano_recepcao,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,25,17,18,19,24,23,22)
							AND ano_recepcao <= '$anterior'";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$masculino     = $dados_rol_anterior["masculino"];
							$feminino      = $dados_rol_anterior["feminino"];
							$indefinido    = $dados_rol_anterior["indefinido"];	
							}
							
							$qr_rol_anterior_e = "SELECT distrito_id,sexo,ano_exclusao,status,regiao_id,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,25,17,18,19,24,23,22)
							AND ano_exclusao BETWEEN '1' AND '$anterior'";
							$todos_rol_anterior_e = mysql_query($qr_rol_anterior_e); 
							$tr_rol_anterior_e = mysql_num_rows($todos_rol_anterior_e);
							while ($dados_rol_anterior_e = mysql_fetch_array($todos_rol_anterior_e)) {
							$masculino_e     = $dados_rol_anterior_e["masculino"];
							$feminino_e      = $dados_rol_anterior_e["feminino"];
							$indefinido_e    = $dados_rol_anterior_e["indefinido"];	
							}
							
							//TOTAL DO ROL ANTERIOR
							$tr_rol_anterior_total_m = $masculino-$masculino_e;
							$tr_rol_anterior_total_f = $feminino-$feminino_e;
							$tr_rol_anterior_total_n = $indefinido-$indefinido_e;
													
							$tr_rol_anterior_total = $tr_rol_anterior_total_m+$tr_rol_anterior_total_f+$tr_rol_anterior_total_n;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_m</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_f</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_n</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total</b></td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id from pae_regiao
						WHERE id != '962' AND id !='2762' AND id !='26'
						ORDER BY nome ASC ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome     = $dados_mat["nome"];
						$regiao = $dados_mat["id"];  				
	
							//ATIVOS
							$qr_regiao = "SELECT sexo,status,regiao_id,dt_recepcao,igreja,ano_recepcao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id='$regiao' 
							AND ano_recepcao <= '$ano'";
							$todos_regiao = mysql_query($qr_regiao); 
							$tr_regiao = mysql_num_rows($todos_regiao);
							while ($dados_regiao = mysql_fetch_array($todos_regiao)) {
							$feminino_r      = $dados_regiao["feminino"];
							$masculino_r     = $dados_regiao["masculino"];
							$indefinido_r    = $dados_regiao["indefinido"];	
							}
							
							//INATIVOS
							$qr_regiao_e = "SELECT sexo,status,regiao_id,dt_recepcao,igreja,ano_recepcao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id='$regiao' 
							AND ano_exclusao BETWEEN '1' AND '$ano'";
							$todos_regiao_e = mysql_query($qr_regiao_e); 
							$tr_regiao_e = mysql_num_rows($todos_regiao_e);
							while ($dados_regiao_e = mysql_fetch_array($todos_regiao_e)) {
							$feminino_r_e      = $dados_regiao_e["feminino"];
							$masculino_r_e     = $dados_regiao_e["masculino"];
							$indefinido_r_e    = $dados_regiao_e["indefinido"];	
							}
							
							$masculinos  = $masculino_r-$masculino_r_e;
							$femininos   = $feminino_r-$feminino_r_e;
							$indefinidos = $indefinido_r-$indefinido_r_e;
													
							$tr_regiao_total = $femininos+$masculinos+$indefinidos;
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:center'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$masculinos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$femininos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$indefinidos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$tr_regiao_total</td>
							</tr>";
                        
                        }
						
						//TOTAIS
						
							$qr_rol_atual = "SELECT regiao_id,status,distrito_id,sexo,igreja,ano_recepcao,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,25,17,18,19,24,23,22)
							AND ano_recepcao <= '$ano'";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$masculino     = $dados_rol_atual["masculino"];
							$feminino      = $dados_rol_atual["feminino"];
							$indefinido    = $dados_rol_atual["indefinido"];	
							}
							
							
							$qr_rol_atual_e = "SELECT distrito_id,sexo,ano_exclusao,status,regiao_id,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,25,17,18,19,24,23,22)
							AND ano_exclusao BETWEEN '1' AND '$ano'";
							$todos_rol_atual_e = mysql_query($qr_rol_atual_e); 
							while ($dados_rol_atual_e = mysql_fetch_array($todos_rol_atual_e)) {
							$masculino_e     = $dados_rol_atual_e["masculino"];
							$feminino_e      = $dados_rol_atual_e["feminino"];
							$indefinido_e    = $dados_rol_atual_e["indefinido"];	
							}
							
							$masculino_atual = $masculino-$masculino_e;
							$feminino_atual = $feminino-$feminino_e;
							$indefinido_atual = $indefinido-$indefinido_e;
													
							$tr_rol_atual_total = $masculino_atual+$feminino_atual+$indefinido_atual;
						
						
							echo"
							<tr style=\"background-color:#fff\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'><strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$masculino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$feminino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$indefinido_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_atual_total</b></td>
							</tr>";						
						

						}
                        ?>                      
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




