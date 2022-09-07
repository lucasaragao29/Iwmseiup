<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}
		

		//MAIUSCULO
		
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>DA $regiao_nome2 - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem de Membros por departamento da $regiao_nome ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            MEMBROS POR DEPARTAMENTO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form13"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel13/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>CRIAN&Ccedil;AS</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>PR&Eacute;</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>ADOLESCENTES</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>JOVENS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>ADULTOS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>INDEFINIDOS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>
						<?php 
						
						
						$anterior = $ano-1;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_anterior = "$anterior-$mes_atual-$dia_atual";
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
						
							//CRIANÇAS
							$qr_idade_c_r = "SELECT * FROM pae_membro2
							WHERE departamento = '1'  and regiao_id = '$regiao' and status='A' 
							and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_c_r = mysql_query("$qr_idade_c_r"); 
							$tr_idade_c_r = mysql_num_rows($todos_idade_c_r);
							
								//EXCLUSÕES ATUAL
								$qr_idade_c_r_ex = "SELECT * FROM pae_membro2 
								WHERE departamento = '1' and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_c_r_ex = mysql_query("$qr_idade_c_r_ex"); 
								$tr_idade_c_r_ex = mysql_num_rows($todos_idade_c_r_ex);
	
							//PRE ADOWES
							$qr_idade_p_r = "SELECT *  FROM pae_membro2
							WHERE departamento = '2' and regiao_id = '$regiao' and status='A' and 
							dt_recepcao <= '$anterior-11-01'";
							$todos_idade_p_r = mysql_query("$qr_idade_p_r"); 
							$tr_idade_p_r = mysql_num_rows($todos_idade_p_r);	
							
								//EXCLUSOES ATUAL
								$qr_idade_p_r_ex = "SELECT * FROM pae_membro2 
								WHERE departamento = '2' and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_p_r_ex = mysql_query("$qr_idade_p_r_ex"); 
								$tr_idade_p_r_ex = mysql_num_rows($todos_idade_p_r_ex);					
	
							//ADOWES
							$qr_idade_a_r = "SELECT * FROM pae_membro2 
							WHERE departamento = '3' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_a_r = mysql_query("$qr_idade_a_r"); 
							$tr_idade_a_r = mysql_num_rows($todos_idade_a_r);						
							
								//EXCLUSOES ATUAL
								$qr_idade_a_r_ex = "SELECT * FROM pae_membro2 
								WHERE departamento = '3'  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_a_r_ex = mysql_query("$qr_idade_a_r_ex"); 
								$tr_idade_a_r_ex = mysql_num_rows($todos_idade_a_r_ex);
								
							//JOVENS
							$qr_idade_j_r = "SELECT * FROM pae_membro2 
							WHERE departamento = '4' and 
							regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_j_r = mysql_query("$qr_idade_j_r"); 
							$tr_idade_j_r = mysql_num_rows($todos_idade_j_r);

								//EXCLUSOES ATUAL
								$qr_idade_j_r_ex = "SELECT * FROM pae_membro2 
								WHERE departamento='4' and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_j_r_ex = mysql_query("$qr_idade_j_r_ex"); 
								$tr_idade_j_r_ex = mysql_num_rows($todos_idade_j_r_ex);
								
							//ADULTOS
							$qr_idade_ad_r = "SELECT * FROM pae_membro2 
							WHERE departamento ='5' and regiao_id = '$regiao' and status='A' 
							and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_ad_r = mysql_query("$qr_idade_ad_r"); 
							$tr_idade_ad_r = mysql_num_rows($todos_idade_ad_r);
								
								//EXCLUSÕES ATUAL
								$qr_idade_ad_r_ex = "SELECT * FROM pae_membro2  
								WHERE departamento = '5'  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_ad_r_ex = mysql_query("$qr_idade_ad_r_ex"); 
								$tr_idade_ad_r_ex = mysql_num_rows($todos_idade_ad_r_ex);
	
							//INDEFINIDO
							$qr_idade_i_r = "SELECT * FROM pae_membro2 
							WHERE departamento = '6'  and regiao_id = '$regiao' and status='A' and 
							dt_recepcao <= '$anterior-11-01'";
							$todos_idade_i_r = mysql_query("$qr_idade_i_r"); 
							$tr_idade_i_r = mysql_num_rows($todos_idade_i_r);
								
								//EXCLUSÕES ATUAL
								$qr_idade_i_r_ex = "SELECT * FROM pae_membro2 
								WHERE departamento = '6' and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
								$todos_idade_i_r_ex = mysql_query("$qr_idade_i_r_ex"); 
								$tr_idade_i_r_ex = mysql_num_rows($todos_idade_i_r_ex);	
							
							$tr_idade_c_r  = $tr_idade_c_r+$tr_idade_c_r_ex;
							$tr_idade_p_r  = $tr_idade_p_r+$tr_idade_p_r_ex;
							$tr_idade_a_r  = $tr_idade_a_r+$tr_idade_a_r_ex;
							$tr_idade_j_r  = $tr_idade_j_r+$tr_idade_j_r_ex;
							$tr_idade_ad_r = $tr_idade_ad_r+$tr_idade_ad_r_ex;
							$tr_idade_i_r  = $tr_idade_i_r+$tr_idade_i_r_ex;
							$tr_idade_t_r  = $tr_idade_t_r+$tr_idade_t_r_ex;
							
							$tr_idade_t_r = $tr_idade_c_r+$tr_idade_p_r+$tr_idade_a_r+$tr_idade_j_r+$tr_idade_ad_r+$tr_idade_i_r;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL ANTERIOR [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:center'></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_c_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_p_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_a_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_j_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_ad_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_i_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_t_r</td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id,distrito from pae_igreja WHERE regiao_id = '$regiao' 
						order by distrito asc, nome asc ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome       = $dados_mat["nome"];
						$igreja_id  = $dados_mat["id"];
						$distrito   = $dados_mat["distrito"];	
						
						$nome = str_replace("IMW ", "", $nome);
						$distrito = str_replace("Distrito ", "", $distrito);  				
						
							//CRIANÇAS
							$qr_idade_c = "SELECT * FROM pae_membro2 
							WHERE departamento='1'  and igreja_id='$igreja_id' and status='A'  and dt_recepcao <= '$ano-11-01'";
							$todos_idade_c = mysql_query("$qr_idade_c"); 
							$tr_idade_c = mysql_num_rows($todos_idade_c);
							
							//PRE ADOWES
							$qr_idade_p = "SELECT * FROM pae_membro2
							WHERE departamento='2'  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_p = mysql_query("$qr_idade_p"); 
							$tr_idade_p = mysql_num_rows($todos_idade_p);						
							
							//ADOWES
							$qr_idade_a = "SELECT * FROM pae_membro2
							WHERE departamento='3'  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_a = mysql_query("$qr_idade_a"); 
							$tr_idade_a = mysql_num_rows($todos_idade_a);						
							
							//JOVENS
							$qr_idade_j = "SELECT * FROM pae_membro2
							WHERE departamento='4' and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_j = mysql_query("$qr_idade_j"); 
							$tr_idade_j = mysql_num_rows($todos_idade_j);
							
							//ADULTOS
							$qr_idade_ad = "SELECT * FROM pae_membro2
							WHERE departamento='5'  and  igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_ad = mysql_query("$qr_idade_ad"); 
							$tr_idade_ad = mysql_num_rows($todos_idade_ad);
							
							//INDEFINIDO
							$qr_idade_i = "SELECT * FROM pae_membro2
							WHERE departamento='6'  and  igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_i = mysql_query("$qr_idade_i"); 
							$tr_idade_i = mysql_num_rows($todos_idade_i);
													
							$tr_idade_t = $tr_idade_c+$tr_idade_p+$tr_idade_a+$tr_idade_j+$tr_idade_ad+$tr_idade_i;
							

                       
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_c</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_p</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_a</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_j</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_ad</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_i</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_t</td>
                        </tr>";
                        
                        }
						
						//TOTAIS
						
						//CRIANÇAS
						$qr_idade_c_t = "SELECT * FROM pae_membro2 
						WHERE departamento='1' and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_c_t = mysql_query("$qr_idade_c_t"); 
						$tr_idade_c_t = mysql_num_rows($todos_idade_c_t);

						//PRE ADOWES
						$qr_idade_p_t = "SELECT * FROM pae_membro2 
						WHERE departamento='2' and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_p_t = mysql_query("$qr_idade_p_t"); 
						$tr_idade_p_t = mysql_num_rows($todos_idade_p_t);						

						//ADOWES
						$qr_idade_a_t = "SELECT * FROM pae_membro2 
						WHERE departamento = '3' and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_a_t = mysql_query("$qr_idade_a_t"); 
						$tr_idade_a_t = mysql_num_rows($todos_idade_a_t);						

						//JOVENS
						$qr_idade_j_t = "SELECT * FROM pae_membro2 
						WHERE departamento = '4' and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_j_t = mysql_query("$qr_idade_j_t"); 
						$tr_idade_j_t = mysql_num_rows($todos_idade_j_t);

						//ADULTOS
						$qr_idade_ad_t = "SELECT * FROM pae_membro2 
						WHERE departamento = '5'   and 
						regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_ad_t = mysql_query("$qr_idade_ad_t"); 
						$tr_idade_ad_t = mysql_num_rows($todos_idade_ad_t);
						
						//INDEFINIDO
						$qr_idade_i_t = "SELECT * FROM pae_membro2 
						WHERE departamento = '6'   and 
						regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_i_t = mysql_query("$qr_idade_i_t"); 
						$tr_idade_i_t = mysql_num_rows($todos_idade_i_t);	
						
												
						$tr_idade_t_t = $tr_idade_c_t+$tr_idade_p_t+$tr_idade_a_t+$tr_idade_j_t+$tr_idade_ad_t+$tr_idade_i_t;
						
						
						echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>ROL ATUAL[$ano]</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b></b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_c_t</b></td>
                        <td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_p_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_a_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_j_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_ad_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_i_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_t_t</b></td>
                        </tr>";

                        ?>
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




