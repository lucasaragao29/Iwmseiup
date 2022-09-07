<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		
		
		//DESCRICAO
		$descricao_texto = "<br>GERAL - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da Quantidade de membros geral ano de $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            QUANTIDADE DE MEMBROS POR REGI&Atilde;O<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form17"  title="Nova pesquisa">
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
               
				
				
			//IGREJAS
			$dataPoints = array();
			$qr_mat = "SELECT DISTINCT nome,id
			 from pae_regiao WHERE id != '26' AND id != '962' AND id != '0' AND id != '2762' order by nome asc ";
			$todos_mat = mysql_query("$qr_mat"); 
			$tr_mat = mysql_num_rows($todos_mat);
			while ($dados_mat = mysql_fetch_array($todos_mat)) {
			$nome           = $dados_mat["nome"];
			$regiao_id      = $dados_mat["id"];
			
			//$nome = utf8_encode($nome);
				
				//TOTAL
				$qr_idade_t = "SELECT regiao_id,ano_recepcao,ano_exclusao,
				SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
				COUNT(*) AS Total
				FROM pae_membro 
				WHERE regiao_id='$regiao_id'";
				$todos_idade_t = mysql_query("$qr_idade_t"); 
				while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
				$recebidos  = $dados_idade_t["recebidos"];
				$excluidos   = $dados_idade_t["excluidos"];	
									
				$total = $recebidos-$excluidos;
				
				}
			
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




