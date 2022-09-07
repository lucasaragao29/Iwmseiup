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
						
						$anterior = $ano-1;
						
						//ROL ANTERIOR 
						
						$qr_rol_anterior = "SELECT departamento,status,ano_recepcao,regiao_id,
						SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo_anterior,
						SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao_anterior,
						SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao_anterior,
						SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia_anterior,
						SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento_anterior,
						COUNT(*) AS Total
						FROM pae_membro 
						WHERE distrito_id = '$distrito'
						AND ano_recepcao = '$anterior'";
						$todos_rol_anterior = mysql_query($qr_rol_anterior); 
						$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
						while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
						$batismo_anterior          = $dados_rol_anterior["batismo_anterior"];
						$adesao_anterior           = $dados_rol_anterior["adesao_anterior"];
						$reconciliacao_anterior    = $dados_rol_anterior["reconciliacao_anterior"];
						$transferencia_anterior    = $dados_rol_anterior["transferencia_anterior"];
						$cadastramento_anterior    = $dados_rol_anterior["cadastramento_anterior"];	
						}
						
						
						//ROL ATUAL
						
						$qr_rol_atual = "SELECT departamento,status,distrito_id,dt_recepcao,igreja,ano_recepcao,regiao_id,
						SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
						SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
						SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
						SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
						SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
						COUNT(*) AS Total
						FROM pae_membro 
						WHERE distrito_id = '$distrito' 
						AND ano_recepcao = '$ano'";
						$todos_rol_atual = mysql_query($qr_rol_atual); 
						$tr_rol_atual = mysql_num_rows($todos_rol_atual);
						while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
						$batismo_atual          = $dados_rol_atual["batismo"];
						$adesao_atual           = $dados_rol_atual["adesao"];
						$reconciliacao_atual    = $dados_rol_atual["reconciliacao"];
						$transferencia_atual    = $dados_rol_atual["transferencia"];
						$cadastramento_atual    = $dados_rol_atual["cadastramento"];	
						}
													
						
                        ?>

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawVisualization);
    
          function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
              ['Anos', 'Adesao', 'Batismo', 'Cadastramento', 'Reconcilizacao', 'Transferencia'],
              ['2018',  <?php echo $adesao_anterior; ?>, <?php echo $batismo_anterior; ?>, <?php echo $cadastramento_anterior; ?>, <?php echo $reconciliacao_anterior; ?>, <?php echo $transferencia_anterior; ?>],
              ['2019',  <?php echo $adesao_atual; ?>, <?php echo $batismo_atual; ?>, <?php echo $cadastramento_atual; ?>, <?php echo $reconciliacao_atual; ?>, <?php echo $transferencia_atual; ?>]
            ]);
    
            var options = {
              title : '',
			  legend: 'bottom',
              vAxis: {title: 'Quantidade'},
              hAxis: {title: 'Anos'},
              seriesType: 'bars',
              series: {5: {type: 'line'}}
            };
    
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>
        
        <div id="chart_div" style="width: 1000px; height: 500px;"></div>                 
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




