<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		include("../config/moeda.php");
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$distrito   = $_POST["id_sub_categoria"];
		$regiao     = $_POST["id_categoria"];
		$ano      = $_POST["ano"];
				
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

		//DESCRICAO
		$descricao_texto = "<br>DISTRITO $distrito_nome2 - $regiao_nome - $ano";
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
			'Gerar relatorio tiquete medio per capta de igrejas do distrito $distrito_nome
			 - $regiao_nome do ano $ano','$dados','pae_financeiro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            T&Iacute;QUETE M&Eacute;DIO PER CAPTA<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form12"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel12/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&ano=$ano";?>" 
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
                    <tr >
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJA</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>ARRECADA&Ccedil;&Atilde;O</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>M&Eacute;DIA</strong></h2></th> 
                    </tr>
                </thead> 
                
                <tbody>
                        
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
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND igreja_id='$igreja_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						//QUANTIDAE DE MEMBROS
						$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
						SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
						SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
						COUNT(*) AS Total
						FROM pae_membro
						WHERE igreja_id='$igreja_id'
						AND	regiao_id = '$regiao'";
						$todos_membros = mysql_query("$qr_membros "); 
						while ($dados_membros  = mysql_fetch_array($todos_membros )) {
						$recebidos = $dados_membros ["recebidos"];
						$excluidos = $dados_membros ["excluidos"];
						
						$membresia = $recebidos-$excluidos;
						}
						
						$media = $valortotal/$membresia;
							
						//MOEDA
						$media = number_format( round( $media, 1, PHP_ROUND_HALF_UP ), 2);
						$media = moeda($media);
							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$igreja_nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$media</td>
                       </tr>";
						
						}
						
                    	}
						
						
						//TOTAL//
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND distrito_id='$distrito'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal_final   = $dados_financa["SUM(valor)"];
						$numeracao          = $dados_financa["numeracao"];
						$plano_conta        = $dados_financa["plano_conta"];
						
						
						//QUANTIDAE DE MEMBROS
						$qr_membros_total = "SELECT ano_recepcao,regiao_id,distrito_id,
						SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
						SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
						COUNT(*) AS Total
						FROM pae_membro
						WHERE distrito_id='$distrito'";
						$todos_membros_total = mysql_query("$qr_membros_total"); 
						while ($dados_membros_total  = mysql_fetch_array($todos_membros_total )) {
						$recebidos = $dados_membros_total ["recebidos"];
						$excluidos = $dados_membros_total ["excluidos"];
						
						$membresia_total = $recebidos-$excluidos;
						}
						
						$media_total = $valortotal_final/$membresia_total;
						
						//MOEDA
						$media_total = number_format( round( $media_total, 1, PHP_ROUND_HALF_UP ), 2);
						$valortotal_final = moeda($valortotal_final);
						$media_total = moeda($media_total);
						
						}
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal_final</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$media_total</b></td>
                        </tr>";

                        ?>                      
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




