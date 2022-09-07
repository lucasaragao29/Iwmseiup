




<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$ano      = $_POST["ano"];
		
		//MAIUSCULO
		
		
		//DESCRICAO
		$descricao_texto = "GERAL - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem de Membros por departamento geral do ano $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            MEMBROS POR DEPARTAMENTO<br><?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form16"  title="Nova pesquisa">
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
        
        $qr_rol_atual = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,
        SUM(CASE WHEN departamento='adultos' then 1 ELSE 0 END) AS adultos,
        SUM(CASE WHEN departamento='jovens' then 1 ELSE 0 END) AS jovens,
        SUM(CASE WHEN departamento='adolescentes' then 1 ELSE 0 END) AS adolescentes,
        SUM(CASE WHEN departamento='pre-adolescentes' then 1 ELSE 0 END) AS pre,
        SUM(CASE WHEN departamento='criancas' then 1 ELSE 0 END) AS criancas,
        COUNT(*) AS Total
        FROM pae_membro 
        WHERE regiao_id IN (13,17,18,19,22,23,24,25)
        AND ano_recepcao <= '$ano'
        ";
            $resultado_rol_atual = mysql_query($qr_rol_atual);		
            while ($row_rol_atual = mysql_fetch_assoc($resultado_rol_atual) ) {
            $adultos_atual       = $row_rol_atual["adultos"];
            $jovens_atual        = $row_rol_atual["jovens"];
            $adolescentes_atual  = $row_rol_atual["adolescentes"];
            $pre_atual           = $row_rol_atual["pre"];
            $criancas_atual      = $row_rol_atual["criancas"];
            }

        //EXCLUIDO DO ANO ATUAL
            $qr_atual_e = "SELECT departamento,status,distrito_id,ano_recepcao,igreja,regiao_id,ano_exclusao,
            SUM(CASE WHEN departamento='adultos' then 1 ELSE 0 END) AS adultos,
            SUM(CASE WHEN departamento='jovens' then 1 ELSE 0 END) AS jovens,
            SUM(CASE WHEN departamento='adolescentes' then 1 ELSE 0 END) AS adolescentes,
            SUM(CASE WHEN departamento='pre-adolescentes' then 1 ELSE 0 END) AS pre,
            SUM(CASE WHEN departamento='criancas' then 1 ELSE 0 END) AS criancas,
            COUNT(*) AS Total
            FROM pae_membro 
            WHERE regiao_id IN (13,17,18,19,22,23,24,25)
            AND ano_exclusao BETWEEN '1' AND '$ano'";
            $resultado_atual_e = mysql_query($qr_atual_e);		
            while ($row_atual_e = mysql_fetch_assoc($resultado_atual_e) ) {
            $adultos_atual_e       = $row_atual_e["adultos"];
            $jovens_atual_e        = $row_atual_e["jovens"];
            $adolescentes_atual_e  = $row_atual_e["adolescentes"];
            $pre_atual_e           = $row_atual_e["pre"];
            $criancas_atual_e      = $row_atual_e["criancas"];
            }
                    
        
            $adultos_atual_total       = $adultos_atual-$adultos_atual_e;
            $jovens_atual_total        = $jovens_atual-$jovens_atual_e;
            $adolescentes_atual_total  = $adolescentes_atual-$adolescentes_atual_e;
            $pre_atual_total           = $pre_atual-$pre_atual_e;
            $criancas_atual_total      = $criancas_atual-$criancas_atual_e;
        
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




