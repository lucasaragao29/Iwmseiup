<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		$ativo    = $_POST["ativo"];
		$distrito = $_POST["id_sub_categoria"];
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		}
		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}

		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO		
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da Quantidade de membros por igreja do distrito $distrito_nome no ano de $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            QUANTIDADE DE MEMBROS POR IGREJA<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form03"  title="Nova pesquisa">
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
                
 		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);
        
        function drawStuff() {
        var data = new google.visualization.arrayToDataTable([                           
        ['', 'QUANTIDADE DE MEMBROS'],

<?php
               
				
				//TOTAL
				$qr_idade_t = "SELECT distrito_id,ano_recepcao,ano_exclusao,distrito,igreja,
				(SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) -
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS total,
				COUNT(*) AS Total
				FROM pae_membro 
				WHERE distrito_id='$distrito'
				GROUP BY igreja_id
				order by total DESC";
				$todos_idade_t = mysql_query("$qr_idade_t"); 
				while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
				$total   = $dados_idade_t["total"];
				$distrito   = $dados_idade_t["distrito"];
				$igreja   = $dados_idade_t["igreja"];
				
				$igreja = utf8_decode($igreja);
					
				$nome = str_replace("IMW ", "", $igreja); 
					
				echo "['$nome', $total],";
				}
			
			


		
        ?>
        					 
                         ]);
        
        var options = {
        title: '',
        width: 900,
        legend: { position: 'none' },
        chart: { title: '',
           subtitle: '' },
        bars: 'horizontal', // Required for Material Bar Charts.
        axes: {
        x: {
        0: { side: 'top', label: 'Quantidade de membros'} // Top x-axis.
        }
        },
        bar: { groupWidth: "90%" }
        };
        
        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
        };
        </script>
    

		<div id="top_x_div" style="width: 900px; height: 500px;"></div>

                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




