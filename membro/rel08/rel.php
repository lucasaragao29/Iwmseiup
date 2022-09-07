<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		$distrito = $_POST["id_sub_categoria"];
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		}
		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		
		$distrito_nome2 = maiuscula($distrito_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da recepcao de membros do distrito de $distrito_nome2 do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            RECEP&Ccedil;&Atilde;O DE MEMBROS<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form08"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel08/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&ano=$ano";?>" 
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
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>ADES&Atilde;O</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>BATISMO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>CADASTRAMENTO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>RECONCILIA&Ccedil;&Atilde;O</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TRANSF&Ecirc;RENCIA</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>
                    
                    
						<?php 
						
						$anterior = $ano-1;
						
						//ROL ANTERIOR 
							
							$qr_rol_anterior = "SELECT regiao_id,status,distrito_id,modo_recepcao_id,igreja,ano_recepcao,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE 
							distrito_id='$distrito'
							AND ano_recepcao = '$anterior'";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$batismo          = $dados_rol_anterior["batismo"];
							$adesao           = $dados_rol_anterior["adesao"];
							$reconciliacao    = $dados_rol_anterior["reconciliacao"];
							$transferencia    = $dados_rol_anterior["transferencia"];
							$cadastramento    = $dados_rol_anterior["cadastramento"];	
							}
													
							$tr_rol_anterior_total = $batismo+$adesao+$reconciliacao+$transferencia+$cadastramento;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adesao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$batismo</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$cadastramento</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$reconciliacao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$transferencia</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total</b></td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id 
						FROM pae_igreja 
						WHERE distrito_id='$distrito' 
						order by nome asc ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome    = $dados_mat["nome"];
						$igreja  = $dados_mat["id"];
						$nome = str_replace("IMW ", "", $nome);  				
	
						
							$qr_igreja = "SELECT status,ano_recepcao,igreja_id,modo_recepcao_id,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id='$igreja' 
							AND ano_recepcao = '$ano'";
							$todos_igreja = mysql_query($qr_igreja); 
							while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
							$batismo_r          = $dados_igreja["batismo"];
							$adesao_r           = $dados_igreja["adesao"];
							$reconciliacao_r    = $dados_igreja["reconciliacao"];
							$transferencia_r    = $dados_igreja["transferencia"];
							$cadastramento_r    = $dados_igreja["cadastramento"];	
							}
													
							$tr_regiao_total = $batismo_r+$adesao_r+$reconciliacao_r+$transferencia_r+$cadastramento_r;
							
							if ($adesao_r == "") { $adesao_r = "0"; }
							if ($batismo_r == "") { $batismo_r = "0"; }
							if ($cadastramento_r == "") { $cadastramento_r = "0"; }
							if ($reconciliacao_r == "") { $reconciliacao_r = "0"; }
							if ($transferencia_r == "") { $transferencia_r = "0"; }
							
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:center'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$tr_regiao_total</td>
							</tr>";
                        
                        }
						
						//TOTAIS
						
							$qr_rol_atual = "SELECT departamento,status,distrito_id,dt_recepcao,igreja,ano_recepcao,regiao_id,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE distrito_id='$distrito'
							AND ano_recepcao = '$ano'";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							$tr_rol_atual = mysql_num_rows($todos_rol_atual);
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$batismo          = $dados_rol_atual["batismo"];
							$adesao           = $dados_rol_atual["adesao"];
							$reconciliacao    = $dados_rol_atual["reconciliacao"];
							$transferencia    = $dados_rol_atual["transferencia"];
							$cadastramento    = $dados_rol_atual["cadastramento"];	
							}
													
							$tr_rol_atual_total = $batismo+$adesao+$reconciliacao+$transferencia+$cadastramento;
						
						
							echo"
							<tr style=\"background-color:#fff\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'><strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adesao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$batismo</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$cadastramento</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$reconciliacao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$transferencia</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_atual_total</b></td>
							</tr>";						
						
                        ?>                      
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




