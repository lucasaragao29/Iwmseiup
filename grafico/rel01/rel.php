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
			'Gerar listagem de Membros por departamento do distrito de $distrito_nome2 do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            MEMBROS POR DEPARTAMENTO<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form01"  title="Nova pesquisa">
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
			
        
			$qr_rol = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,distrito_id,
			(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='adultos'AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS adultos,
			(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) -  SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS jovens,
			(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END))AS adolescentes,
			(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS pre,
			(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) - SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END)) AS criancas,
			COUNT(*) AS Total
			FROM pae_membro 
			WHERE regiao_id = '$regiao'
			AND distrito_id ='$distrito'
			";
            $resultado_rol = mysql_query($qr_rol);		
            while ($row_rol = mysql_fetch_assoc($resultado_rol) ) {
            $adultos      = $row_rol["adultos"];
            $jovens       = $row_rol["jovens"];
            $adolescentes = $row_rol["adolescentes"];
            $pre_atual    = $row_rol["pre"];
			$criancas     = $row_rol["criancas"];
			
			echo"$adultos+$jovens+$adolescentes+$pre_atual+$criancas;	";
           
            $tr_total = $adultos+$jovens+$adolescentes+$pre_atual+$criancas;		
        	
			//PORCENTAGENS
			$adulto_porc = ($adultos*100)/$tr_total;
			$jovem_porc = ($jovens*100)/$tr_total;
			$adolescente_porc = ($adolescentes*100)/$tr_total;
			$pre_porc = ($pre_atual*100)/$tr_total;
			$crianca_porc = ($criancas*100)/$tr_total;

				   
			 }
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




