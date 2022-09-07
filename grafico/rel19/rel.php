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
			'Gerar listagem da estatistica de genero da $regiao_nome do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            ESTAT&Iacute;STICA DE G&Ecirc;NERO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form19"  title="Nova pesquisa">
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
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],            
		<?php 
		
		$qr_rol_atual = "SELECT regiao_id,status,distrito_id,sexo,igreja,ano_recepcao,
		(SUM(CASE WHEN (sexo='M' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (sexo='M' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS masculino,
		(SUM(CASE WHEN (sexo='F' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (sexo='F' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS feminino,
		(SUM(CASE WHEN (sexo='' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (sexo='' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS indefinido,
		COUNT(*) AS Total
		FROM pae_membro 
		WHERE regiao_id = '$regiao'";
		$todos_rol_atual = mysql_query($qr_rol_atual); 
		while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
		$masculino     = $dados_rol_atual["masculino"];
		$feminino      = $dados_rol_atual["feminino"];
		$indefinido    = $dados_rol_atual["indefinido"];	
		}
		
		//$tr_rol_atual_total = $masculino_atual+$feminino_atual+$indefinido_atual;
			
		echo "['MASCULINO', $masculino],";						
		echo "['FEMININO', $feminino],";
		echo "['NAO INFORMADO', $indefinido],";
		
		?>
                        
          ]);

        var options = {
          title: '',
          pieHole: 0.4,
		  legend: 'bottom',
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="donutchart" style="width: 100%; height: 500px;"></div>                  

                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




