<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
    <?php 
        $conn = OpenCon();

		
		$status   = $_POST["status"];
		
		
		if ($status == "Ativo")         { $status2 = "Ativos"; }
		if ($status == "Descontinuado") { $status2 = "Descontinuados"; }
		if ($status == "Desligado")     { $status2 = "Desligados"; }
		if ($status == "Falecido")      { $status2 = "Falecidos"; }
		if ($status == "Jubilado")      { $status2 = "Jubilados"; }
		if ($status == "Licenciado")    { $status2 = "Licenciados"; }
		if ($status == "Transferido")   { $status2 = "Transferidos"; }
		
		//MAIUSCULO
		$status2        = maiuscula($status2);
		
		//DESCRICAO
		$descricao_texto = "$status2 - GERAL";
		
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
			'Gerar listagem de clerigos $status geral','$dados','pae_clerigo',
			curdate( ),curtime( ))";
			$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE CL&Eacute;RIGOS <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form01"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel01/rel_p.php?<?php echo"status=$status";?>" 
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>NOME</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>REGI&Atilde;O</strong></h2></th>
        
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
						
							echo"";
							//LISTAGEM
							$qr_listagem = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
							FROM pae_clerigo
							WHERE  status='$status'  AND regiao_id NOT IN ('962','12','26','2762') 
							ORDER BY distrito asc, igreja asc, nome asc";
							$i="0";
							$resultado_listagem = mysqli_query($conn,$qr_listagem);		
							while ($row_listagem = mysqli_fetch_assoc($resultado_listagem) ) {
							$i++;
							$nome        = $row_listagem["nome"];
							$distrito    = $row_listagem["distrito"];	
							$regiao      = $row_listagem["regiao"];			
							
							$distrito = str_replace("Distrito ", "", $distrito);
							$igreja = str_replace("IMW ", "", $igreja);
							
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$regiao</td>
							</tr>";
							
							}
							
																				
                 

                        ?>


                    
					
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




