<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
        include_once __DIR__ . "/../../config/conexao.php";
        $conn = OpenCon();
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
			$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            MEMBROS POR DEPARTAMENTO <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form16"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel16/rel_p.php?<?php echo"ano=$ano";?>" 
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
                
    <thead>
        <tr>
            <th><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
            <th><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>CRIAN&Ccedil;AS</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>PR&Eacute;</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>ADOLESCENTES</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>JOVENS</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>ADULTOS</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>INDEFINIDOS</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
    <tbody>
						<?php 
						
						
						$anterior = $ano-1;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_anterior = "$anterior-$mes_atual-$dia_atual";
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
						
						//GROUP BY igreja
							//ORDER BY igreja
						
							//ROL ANTEIOR ATIVOS
							$qr_rol_anterior = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as criancas,
							
							(SUM(CASE WHEN (departamento='' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as indefinidos,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							
							";
							$resultado_rol_anterior = mysqli_query($conn,$qr_rol_anterior);		
							while ($row_rol_anterior = mysqli_fetch_assoc($resultado_rol_anterior) ) {
							$adultos_total       = $row_rol_anterior["adultos"];
							$jovens_total        = $row_rol_anterior["jovens"];
							$adolescentes_total  = $row_rol_anterior["adolescentes"];
							$pre_total           = $row_rol_anterior["pre"];
							$criancas_total      = $row_rol_anterior["criancas"];
							$indefinidos_total   = $row_rol_anterior["indefinidos"];
							}

							$tr_anterior_total = $adultos_total+$jovens_total+$adolescentes_total+$pre_total+$criancas_total+$indefinidos_total;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL ANTERIOR [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$criancas_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$pre_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adolescentes_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$jovens_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adultos_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$indefinidos_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_total</b></td>
							</tr>";
																				
						
							//QUANTIDADE DE MEMBROS POR DEPARTAMENTO
							$qr_idade_e = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,distrito_id,
							distrito,regiao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as criancas,
							
							(SUM(CASE WHEN (departamento='' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as indefinidos,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							GROUP BY regiao_id
							ORDER BY regiao ASC";
							$i = "0";
							$resultado_igrejas_e = mysqli_query($conn,$qr_idade_e);		
							while ($row_igrejas_e = mysqli_fetch_assoc($resultado_igrejas_e) ) {
							$i++;
							$adulto_rt       = $row_igrejas_e["adultos"];
							$joven_rt        = $row_igrejas_e["jovens"];
							$adolescente_rt  = $row_igrejas_e["adolescentes"];
							$pre_rt          = $row_igrejas_e["pre"];
							$crianca_rt      = $row_igrejas_e["criancas"];
							$indefinidos_rt  = $row_igrejas_e["indefinidos"];
							$nome            = $row_igrejas_e["regiao"];
							
						
						$tr_rt = $adulto_rt+$joven_rt+$adolescente_rt+$pre_rt+$crianca_rt+$indefinidos_rt;							

                       
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$crianca_rt</td>
                        <td style='font-size:13px;color:#333333;text-align:right'>$pre_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$adolescente_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$joven_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$adulto_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$indefinidos_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$tr_rt</td>
                        </tr>";
                        
                        }
						
						//TOTAIS
						
						$qr_rol_atual = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as criancas,
							
							(SUM(CASE WHEN (departamento='' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as indefinidos,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							";
							
							$resultado_rol_atual = mysqli_query($conn,$qr_rol_atual);		
							while ($row_rol_atual = mysqli_fetch_assoc($resultado_rol_atual) ) {
							$adultos_atual_total       = $row_rol_atual["adultos"];
							$jovens_atual_total        = $row_rol_atual["jovens"];
							$adolescentes_atual_total  = $row_rol_atual["adolescentes"];
							$pre_atual_total           = $row_rol_atual["pre"];
							$criancas_atual_total      = $row_rol_atual["criancas"];
							$indefinidos_atual_total   = $row_rol_atual["indefinidos"];
							}
						
						
							$tr_atual_total = $adultos_atual_total+$jovens_atual_total+$adolescentes_atual_total+$pre_atual_total+$criancas_atual_total+$indefinidos_atual_total;		
						
						echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>ROL ATUAL[$ano]</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$criancas_atual_total</b></td>
                        <td style='font-size:13px;color:#333333;text-align:right'><b>$pre_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$adolescentes_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$jovens_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$adultos_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$indefinidos_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_atual_total</b></td>
                        </tr>";

                        ?>
                    
                    
                    </tbody>
                
                </table>               
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




