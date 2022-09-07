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
		$descricao_texto = "<br> $regiao_nome2 - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Totalizacao',
			'Gerar listagem das 10 igrejas que mais receberam na $regiao_nome em $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            10 IGREJAS QUE MAIS RECEBERAM<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form07"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel07/rel_p.php?regiao=<?php echo"$regiao&ano=$ano";?>" 
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
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJA</strong></h2></th>
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>REGI&Atilde;O</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MEMBROS</strong></h2></th>
		</tr>
		</thead>"; 
	 
?>
    <tbody>

		<?php 
        
		if ($regiao == "0") {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];
			
						$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];
			
			//MEMBROS
			$qr_membros = "SELECT regiao_id,ano_recepcao,distrito,distrito_id,igreja,regiao,
			SUM(CASE WHEN modo_recepcao_id > '0' AND modo_recepcao_id !='4' then 1 ELSE 0 END) AS recebidos,
			COUNT(*) AS Total	
			FROM pae_membro
//			WHERE regiao_id IN (13,25,17,18,19,24,23,22)
			WHERE regiao_id = $regiao
			AND (ano_recepcao = '$ano')
			GROUP BY igreja
			ORDER BY recebidos DESC
			LIMIT 0,10
			";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$igreja    = $dados_membros["igreja"];
			$membro    = $dados_membros["membro"];
			$distrito  = $dados_membros["distrito"];
			$regiao    = $dados_membros["regiao"];
			$recebidos    = $dados_membros["recebidos"];
			
			$igreja = utf8_decode($igreja);
			$distrito = utf8_decode($distrito);
			$regiao   = utf8_decode($regiao);
			
			$igreja = str_replace("IMW ", "", $igreja);  				
			$distrito = str_replace("Distrito ", "", $distrito);  				

            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$igreja</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$regiao</td>
			 <td style='font-size:13px;color:#333333;text-align:right'>$recebidos</td>
            </tr>";
			
			}	


       
		}
		
		else {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];
			
			//MEMBROS
			$qr_membros = "SELECT regiao_id,ano_recepcao,distrito,distrito_id,igreja,regiao,
			SUM(CASE WHEN modo_recepcao_id > '0' AND modo_recepcao_id !='4' then 1 ELSE 0 END) AS recebidos,
			COUNT(*) AS Total	
			FROM pae_membro
			WHERE regiao_id = '$regiao'
			AND (ano_recepcao = '$ano')
			GROUP BY igreja
			ORDER BY recebidos DESC
			LIMIT 0,10
			";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$igreja    = $dados_membros["igreja"];
			$membro    = $dados_membros["membro"];
			$distrito  = $dados_membros["distrito"];
			$regiao    = $dados_membros["regiao"];
			$recebidos    = $dados_membros["recebidos"];
			
			$igreja = $igreja;
			$distrito = $distrito;
			$regiao   = $regiao;
			
			$igreja = str_replace("IMW ", "", $igreja);  				
			$distrito = str_replace("Distrito ", "", $distrito);  				

            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$igreja</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
            <td style='font-size:13px;color:#333333;text-align:left'>$regiao</td>
			 <td style='font-size:13px;color:#333333;text-align:right'>$recebidos</td>
            </tr>";
			
			}	
			
			
		}
        
        ?>
                        
                    </tbody>
                
                </table>

                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




