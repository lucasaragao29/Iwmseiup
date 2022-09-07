<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		
		//DESCRICAO
		$descricao_texto = "POR FAIXA ET&Aacute;RIA - GERAL";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
			'Gerar listagem de clerigos por faixa etaria geral','$dados','pae_clerigo',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE CL&Eacute;RIGOS <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form13"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel13/rel_p.php" 
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>FAIXA ET&Aacute;RIA</strong></h2></th>
        <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>QUANTIDADE</strong></h2></th>
        <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>%</strong></h2></th>
        
    </tr>
</thead> 
    <tbody>
						<?php 
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
							
							//FAIXA 1 - 25 A 40
							$qr_faixa1 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 25 and 40)  
							and status='Ativo'";
							$resultado_faixa1 = mysql_query($qr_faixa1);
							$tr_faixa1 = mysql_num_rows($resultado_faixa1);
							
							//FAIXA 2 - 41 A 50
							$qr_faixa2 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 41 and 50)  
							and data_nascimento !='0000-00-00' and status='Ativo' ";
							$resultado_faixa2 = mysql_query($qr_faixa2);
							$tr_faixa2 = mysql_num_rows($resultado_faixa2);
							
							//FAIXA 3 - 51 A 60
							$qr_faixa3 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 51 and 60)  
							and data_nascimento !='0000-00-00'  and status='Ativo'";
							$resultado_faixa3 = mysql_query($qr_faixa3);
							$tr_faixa3 = mysql_num_rows($resultado_faixa3);
							
							//FAIXA 4 - 61 A 200
							$qr_faixa4 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 61 and 200)  
							and data_nascimento !='0000-00-00'  and status='Ativo'";
							$resultado_faixa4 = mysql_query($qr_faixa4);
							$tr_faixa4 = mysql_num_rows($resultado_faixa4);
							
							//FAIXA 5 - INDEFINIDO
							$qr_faixa5 = "SELECT * FROM pae_clerigo 
							WHERE data_nascimento ='0000-00-00' and status='Ativo' ";
							$resultado_faixa5 = mysql_query($qr_faixa5);
							$tr_faixa5 = mysql_num_rows($resultado_faixa5);							
							//TOTAL
							$tr_faixa = $tr_faixa1+$tr_faixa2+$tr_faixa3+$tr_faixa4+$tr_faixa5;
							
							//PORCENTAGEM
							$tr_porc1 = (100*$tr_faixa1)/$tr_faixa;
							$tr_porc2 = (100*$tr_faixa2)/$tr_faixa;
							$tr_porc3 = (100*$tr_faixa3)/$tr_faixa;
							$tr_porc4 = (100*$tr_faixa4)/$tr_faixa;
							$tr_porc5 = (100*$tr_faixa5)/$tr_faixa;
							$tr_porc  = "100";
							
							$tr_porc1 = number_format($tr_porc1,0,'.',''); 
							$tr_porc2 = number_format($tr_porc2,0,'.',''); 
							$tr_porc3 = number_format($tr_porc3,0,'.',''); 
							$tr_porc4 = number_format($tr_porc4,0,'.','');
							$tr_porc5 = number_format($tr_porc5,0,'.','');  
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>25 &agrave; 40</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa1</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc1</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>41 &agrave; 50</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa2</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc2</td>
							</tr>";	
														
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>51 &agrave; 60</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa3</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc3</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>61 ></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa4</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc4</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>N&atilde;o informado</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa5</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc5</td>
							</tr>";
														
							//TOTAIS
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>TOTAL</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc</td>
							</tr>";	
							
							
							
							
                        ?>


                    
					
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




