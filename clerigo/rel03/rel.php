<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
        // Estabelece conexao com o banco de dados
        include_once __DIR__ . "/../../config/conexao.php";
        $conn = OpenCon();
		
		$status   = $_POST["status"];
		$distrito = $_POST["id_sub_categoria"];
		$regiao   = $_POST["id_categoria"];
		
			
		if ($status == "Ativo")         { $status2 = "Ativos"; }
		if ($status == "Descontinuado") { $status2 = "Descontinuados"; }
		if ($status == "Desligado")     { $status2 = "Desligados"; }
		if ($status == "Falecido")      { $status2 = "Falecidos"; }
		if ($status == "Jubilado")      { $status2 = "Jubilados"; }
		if ($status == "Licenciado")    { $status2 = "Licenciados"; }
		if ($status == "Transferido")   { $status2 = "Transferidos"; }

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
		
		//MAIUSCULO
		$regiao_nome2   = maiuscula($regiao_nome);
		$distrito_nome2 = maiuscula($distrito_nome);
		$status2        = maiuscula($status2);
		
		//DESCRICAO
		$descricao_texto = "$status2<br>$distrito_nome2 - $regiao_nome2";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
			'Gerar listagem de clerigos $status do $distrito_nome - $regiao_nome','$dados','pae_clerigo',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE CL&Eacute;RIGOS <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form03"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel03/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&status=$status";?>" 
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
							$qr_listagem = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja
							FROM pae_clerigo
							WHERE regiao_id='$regiao'
							and distrito_id='$distrito'
							and status='$status'
							ORDER BY distrito asc, igreja asc, nome asc";
							$i="0";
							$resultado_listagem = mysql_query($qr_listagem);		
							while ($row_listagem = mysql_fetch_assoc($resultado_listagem) ) {
							$i++;
							$nome        = $row_listagem["nome"];
							$funcao    = $row_listagem["funcao"];				
							
							$distrito = str_replace("Distrito ", "", $distrito);
							$igreja = str_replace("IMW ", "", $igreja);
							
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							</tr>";
							
							}
							
																				
                 

                        ?>


                    
					
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




