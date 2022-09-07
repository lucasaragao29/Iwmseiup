<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$anoi     = $_POST["anoi"];
		$anof     = $_POST["anof"];
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
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Anos', 'Membros'],
                    
		<?php 
		
		//MEMBRESIA DATAS
		$qr_periodo = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
		$todos_periodo = mysql_query("$qr_periodo");
		while ($dados_periodo = mysql_fetch_array($todos_periodo)) {
		$ano_periodo  = $dados_periodo["ano"];
		
			//TOTAL DE MEMBROS POR ANO
			$qr_data_t = "SELECT ano_recepcao,regiao_id,distrito_id,
			(SUM(CASE WHEN (ano_recepcao <= '$ano_periodo') then 1 ELSE 0 END) -
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_periodo') then 1 ELSE 0 END)) AS rol,
			COUNT(*) AS Total
			FROM pae_membro
			WHERE regiao_id = '$regiao'
			AND distrito_id='$distrito'";
			$todos_data_t = mysql_query("$qr_data_t"); 
			while ($dados_data_t = mysql_fetch_array($todos_data_t)) {
			$rol  = $dados_data_t["rol"];
			
			
			
			}	
			
		echo "['$ano_periodo', $rol],";						
		
		
		}
		
		
		?>
                        
          ]);

        var options = {
          title: '',
          hAxis: {title: 'Anos',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    <div id="chart_div" style="width: 100%; height: 500px;"></div>                  
                        
                </table>
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->