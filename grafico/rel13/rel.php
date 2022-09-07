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
		$descricao_texto = "<br>DA $regiao_nome2 - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem de Membros por departamento da $regiao_nome ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            MEMBROS POR DEPARTAMENTO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form13"  title="Nova pesquisa">
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
        
			$qr_rol = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,
			(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='adultos'AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS adultos,
			(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) -  SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS jovens,
			(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END))AS adolescentes,
			(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS pre,
			(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS criancas,
			COUNT(*) AS Total
			FROM pae_membro 
			WHERE regiao_id = '$regiao'
			";
            $resultado_rol = mysql_query($qr_rol);		
            while ($row_rol = mysql_fetch_assoc($resultado_rol) ) {
            $adultos_atual_total      = $row_rol["adultos"];
            $jovens_atual_total       = $row_rol["jovens"];
            $adolescentes_atual_total = $row_rol["adolescentes"];
            $pre_atual_total          = $row_rol["pre"];
            }
        
            $tr_atual_total = $adultos_atual_total+$jovens_atual_total+$adolescentes_atual_total+$pre_atual_total+$criancas_atual_total;		
        	
			//PORCENTAGENS
			$adulto_porc = ($adultos_atual_total*100)/$tr_atual_total;
			$jovem_porc = ($jovens_atual_total*100)/$tr_atual_total;
			$adolescente_porc = ($adolescentes_atual_total*100)/$tr_atual_total;
			$pre_porc = ($pre_atual_total*100)/$tr_atual_total;
			$crianca_porc = ($criancas_atual_total*100)/$tr_atual_total;

        ?>
                            
    
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Membros', 'Quantidade'],
        ['Adultos', <?php echo $adulto_porc; ?>],
        ['Jovens', <?php echo $jovem_porc; ?>],
        ['Adolescentes', <?php echo $adolescente_porc; ?>],
        ['Pre-adolescentes', <?php echo $pre_porc; ?>],
		['Criancas', <?php echo $crianca_porc; ?>]
        ]);
        
        var options = {
        title: '',
        is3D: true,
		legend: 'bottom',
		pieSliceText: 'label',
		width: '1000',
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
        }
        </script>
        
        
       <div id="piechart_3d" style="width: 1000px; height: 500px;"></div>
    
    
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




