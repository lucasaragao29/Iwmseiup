<?php
error_reporting(0);
?>

<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$anoi     = $_POST["anoi"];
		$anof     = $_POST["anof"];
		$ativo    = $_POST["ativo"];
		$distrito = $_POST["id_sub_categoria"];
		$regiao   = $_POST["id_categoria"];
		
		//ANOS
		if ($anoi == $anof) { $ano_texto = "$anoi"; } else { $ano_texto = " PER&Iacute;ODO $anoi A $anof";  }
		
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
		$descricao_texto = "<br> DE $distrito_nome2 - $ano_texto";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da Evolucao de Crescimento do
			 distrito de $distrito_nome no periodo de $anoi a $anof','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            EVOLU&Ccedil;&Atilde;O DE CRESCIMENTO DO DISTRITO <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form04"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel04/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&anoi=$anoi&anof=$anof";?>" 
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
                        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
                        
						<?php 
						
                        //ANOS
                        $qr_anos = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
                        $todos_anos = mysql_query("$qr_anos");
                        while ($dados_anos = mysql_fetch_array($todos_anos)) {
						$ano  = $dados_anos["ano"];
						echo"<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>$ano</strong></h2></th> ";
						
						}
						
						?>
                        
                        
                        
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
																				
                        //DISTRITOS
                        $qr_distrito = "SELECT DISTINCT nome,id from pae_distrito WHERE id = '$distrito' order by nome asc ";
                        $todos_distrito = mysql_query("$qr_distrito"); 
                        while ($dados_distrito = mysql_fetch_array($todos_distrito)) {
						$nome   = $dados_distrito["nome"];
						
						//REMOVER PALAVRA
						$nome = str_replace("Distrito ", "", $nome); 
                       
                        echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>";
						
						//MEMBRESIA DATAS
                        $qr_periodo = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
                        $todos_periodo = mysql_query("$qr_periodo");
                        while ($dados_periodo = mysql_fetch_array($todos_periodo)) {
						$ano_periodo  = $dados_periodo["ano"];
						
							//TOTAL DE MEMBROS POR ANO
							$qr_data_t = "SELECT ano_recepcao,regiao_id,distrito_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano_periodo') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_periodo') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE regiao_id = '$regiao'
							AND distrito_id='$distrito'";
							$todos_data_t = mysql_query("$qr_data_t"); 
							while ($dados_data_t = mysql_fetch_array($todos_data_t)) {
							$recebidos  = $dados_data_t["recebidos"];
							$excluidos  = $dados_data_t["excluidos"];
							
							$rol_final_t = $recebidos-$excluidos;
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>$rol_final_t</td>";
							
							
							}							
						
						}
						
						
							//PORCENTAGEM
							$qr_data_porc_t = "SELECT ano_recepcao,regiao_id,distrito_id,
							SUM(CASE WHEN (ano_recepcao <= '$anoi') then 1 ELSE 0 END) AS recebidos_inicial,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anoi') then 1 ELSE 0 END) AS excluidos_inicial,
							SUM(CASE WHEN (ano_recepcao <= '$anof') then 1 ELSE 0 END) AS recebidos_final,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anof') then 1 ELSE 0 END) AS excluidos_final,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE regiao_id = '$regiao'";
							$todos_data_porc_t  = mysql_query("$qr_data_porc_t"); 
							while ($dados_data_porc_t  = mysql_fetch_array($todos_data_porc_t)) {
							$recebidos_inicial = $dados_data_porc_t["recebidos_inicial"];
							$excluidos_inicial = $dados_data_porc_t["excluidos_inicial"];
							$recebidos_final   = $dados_data_porc_t["recebidos_final"];
							$excluidos_final   = $dados_data_porc_t["excluidos_final"];
							
							$rol_ano_inicial_t = $recebidos_inicial-$excluidos_inicial;
							$rol_ano_final_t = $recebidos_final-$excluidos_final;
							
								//PORCENTAGEM
								if ($rol_ano_inicial_t == $rol_ano_final_t) { $porcentagem = "0"; }
								else { $porcentagem = (($rol_ano_final_t-$rol_ano_inicial_t)/$rol_ano_inicial_t)*100;
								$porcentagem = number_format($porcentagem,2,'.','');  
								}
							
							echo"<td style='font-size:13px;color:#333333;text-align:center'>$porcentagem</td></tr>";
						
							}	
						
                        }
						

                        ?>
                    
                    </tbody>
                </table>
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->