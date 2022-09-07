<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
                // Estabelece conexao com o banco de dados
                include_once __DIR__ . "/../../config/conexao.php";
                $conn = OpenCon();
		
		$ano      = $_POST["ano"];
		$igreja    = $_POST["id_sub_categoria"];
		$distrito  = $_POST["id_categoria"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysqli_query($conn,$result_distrito);		
		while ($row_distrito = mysqli_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		$regiao_nome  = $row_distrito["regiao"];
		}
		
		//DESCOBRIR IGREJA
		$result_igreja = "SELECT * FROM pae_igreja WHERE id=$igreja";
		$resultado_igreja = mysqli_query($conn,$result_igreja);		
		while ($row_igreja = mysqli_fetch_assoc($resultado_igreja) ) {
		$igreja_nome  = $row_igreja["nome"];
		}

		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$igreja_nome2 = maiuscula($igreja_nome);
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = " DA $igreja_nome2<br>DISTRITO DE $distrito_nome2 DA $regiao_nome2";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem de membros da $igreja_nome do distrito de $distrito_nome da $regiao_nome','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE MEMBROS<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form10"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel10/rel_p.php?igreja=<?php echo"$igreja&distrito=$distrito";?>" 
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DATA DE NASCIMENTO</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>REGI&Atilde;O</strong></h2></th>
    </tr>
</thead> 
    <tbody>

						<?php 
						
						
							
							//LISTAGEM
							$qr_listagem = "SELECT DISTINCT igreja_id,nome,data_nascimento,distrito,regiao
							FROM pae_membro
							WHERE igreja_id='$igreja'
							AND status='A'
							ORDER BY nome asc";
							$i="0";
							$resultado_listagem = mysqli_query($conn,$qr_listagem);		
							while ($row_listagem = mysqli_fetch_assoc($resultado_listagem) ) {
							$i++;
							$nome            = $row_listagem["nome"];
							$data_nascimento = $row_listagem["data_nascimento"];
							$distrito        = $row_listagem["distrito"];
							$regiao          = $row_listagem["regiao"];
							
							//DATA DE NASCIMENTO
							$dia_data = date('d', strtotime($data_nascimento));
							$mes_data = date('m', strtotime($data_nascimento));
							$ano_data = date('Y', strtotime($data_nascimento));
							
							$data_nasc = "$dia_data/$mes_data/$ano_data";

							
							$distrito = str_replace("Distrito ", "", $distrito);
							
							$regiao = minuscula($regiao);
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:right'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$data_nasc</td>
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




