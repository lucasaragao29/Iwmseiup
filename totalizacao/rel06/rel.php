<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR REGIAO
		if ($regiao == "0") { $regiao_nome = "Geral"; }
		else {
			$result_regiao = "SELECT * FROM pae_regiao WHERE id='$regiao'";
			$resultado_regiao = mysql_query($result_regiao);		
			while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
			$regiao_nome  = $row_regiao["nome"];
			}
		}
		
		//MAIUSCULO
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "$regiao_nome2";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Totalizacao',
			'Gerar listagem de totalizacao das 10 maiores igrejas - $regiao_nome','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            10 MAIORES IGREJAS - <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form06"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel06/rel_p.php?regiao=<?php echo"$regiao";?>" 
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
 
 
		<?php 
         
                echo"
                <thead>
                <tr>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong></strong></h2></th>
					<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJA</strong></h2></th>
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>
                    <th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>REGI&Atilde;O</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MEMBROS</strong></h2></th>
                </tr>
                </thead>"; 
             
             
             
        ?>
    <tbody>

		<?php 
        
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];
			
			if ($regiao == "0") { $regiao_codigo = ""; } else { $regiao_codigo = "WHERE regiao_id='$regiao'"; }
			
			//MEMBROS
			$qr_membros = "SELECT regiao_id, igreja_id, ano_recepcao,ano_exclusao,distrito,regiao,igreja,
			SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) - 
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS membresia,
			COUNT(*) AS Total															  
			FROM pae_membro
			$regiao_codigo
			GROUP BY igreja_id
			ORDER BY membresia DESC
			LIMIT 0,10";
			$i="0";
			$todos_membros = mysql_query($qr_membros); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$i++;
			$distrito    = $dados_membros["distrito"];
			$regiao      = $dados_membros["regiao"];
			$igreja      = $dados_membros["igreja"];
			$membresia   = $dados_membros["membresia"];
			
			$distrito = str_replace("Distrito ", "", $distrito);  	
			$igreja = str_replace("IMW ", "", $igreja);  	
			
			$distrito = utf8_decode($distrito);
			$regiao = utf8_decode($regiao);
			$igreja = utf8_decode($igreja);
		
            echo"
            <tr >
			<td style='font-size:13px;color:#333333;text-align:right'>$i</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$igreja</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$regiao</td>
			 <td style='font-size:13px;color:#333333;text-align:right'>$membresia</td>
            </tr>";
			
			}
			
       
	
        
        ?>
                        
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




