<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		$igreja    = $_POST["id_sub_categoria"];
		$distrito  = $_POST["id_categoria"];
		
		//DESCRICAO
		$descricao_texto = " DE TODAS AS REGI&Otilde;S";
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem de membros de todas as regioes','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE MEMBROS<?php echo"$descricao_texto"; ?></strong><br>

            
            <a href="rel11/rel_p.php" 
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>NOME</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DATA DE NASCIMENTO</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>IGREJA</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>REGI&Atilde;O</strong></h2></th>
    </tr>
</thead> 
    <tbody>

						<?php 
						
						
							
							//LISTAGEM
							$qr_listagem = "SELECT DISTINCT igreja_id,nome,data_nascimento,distrito,regiao,igreja
							FROM pae_membro
							WHERE status='A'
							ORDER BY nome asc";
							$i="0";
							$resultado_listagem = mysql_query($qr_listagem);		
							while ($row_listagem = mysql_fetch_assoc($resultado_listagem) ) {
							$i++;
							$nome            = $row_listagem["nome"];
							$data_nascimento = $row_listagem["data_nascimento"];
							$distrito        = $row_listagem["distrito"];
							$igreja          = $row_listagem["igreja"];
							$regiao          = $row_listagem["regiao"];
							
							$igreja = str_replace("IMW ", "", $igreja);
							
							$nome = utf8_decode($nome);
							$distrito = utf8_decode($distrito);
							$regiao = utf8_decode($regiao);
							$igreja = utf8_decode($igreja);
							
							//DATA DE NASCIMENTO
							$dia_data = date('d', strtotime($data_nascimento));
							$mes_data = date('m', strtotime($data_nascimento));
							$ano_data = date('Y', strtotime($data_nascimento));
							
							$data_nasc = "$dia_data/$mes_data/$ano_data";

							
							$distrito = str_replace("Distrito ", "", $distrito);
							
							$regiao = minuscula($regiao);
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:right'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$data_nasc</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$igreja</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$regiao</td>
							</tr>";
							
							}
							
																				
                 

                        ?>

                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




