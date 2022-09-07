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
		$descricao_texto = "<br>$regiao_nome2 - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da Quantidade de membros da regiao $regiao_nome do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            QUANTIDADE DE MEMBROS POR DISTRITO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form10"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel10/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
                <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
                <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
                <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>MEMBROS</strong></h2></th> 
            </tr>
        </thead> 
        <tbody>
						<?php 
						
                        //IGREJAS
                        $qr_mat = "SELECT DISTINCT nome,id,regiao
						 from pae_distrito WHERE regiao_id = '$regiao' order by nome asc ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome           = $dados_mat["nome"];
						$distrito_id      = $dados_mat["id"];
						$regiao_nome    = $dados_mat["regiao"];
						
						//REMOVER PALAVRA
						$nome = str_replace("Distrito ", "", $nome);  				
						
							
							//TOTAL
							$qr_idade_t = "SELECT distrito_id,ano_recepcao,ano_exclusao,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE distrito_id='$distrito_id'";
							$todos_idade_t = mysql_query("$qr_idade_t"); 
							while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
							$recebidos  = $dados_idade_t["recebidos"];
							$excluidos   = $dados_idade_t["excluidos"];	
												
							$total = $recebidos-$excluidos;
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$total</td>
                        </tr>";
                        
						
							}
                        }
						
						
							//TOTAL GERAL
							$qr_idade_t = "SELECT distrito_id,ano_recepcao,ano_exclusao,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id='$regiao'";
							$todos_idade_t = mysql_query("$qr_idade_t"); 
							while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
							$recebidos           = $dados_idade_t["recebidos"];
							$excluidos           = $dados_idade_t["excluidos"];	
												
							$total_geral = $recebidos-$excluidos;
							

                       echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$total_geral</b></td>
                        </tr>";
                        
						
							}
							
							
					
						

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




