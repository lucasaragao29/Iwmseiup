<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
                $conn = OpenCon(); 
                mysqli_set_charset($conn,"utf8");
		
		$ano      = $_POST["ano"];
		$distrito = $_POST["id_sub_categoria"];
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysqli_query($conn,$result_distrito);		
		while ($row_distrito = mysqli_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		}

		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysqli_query($conn,$result_regiao);		
		while ($row_regiao = mysqli_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}

		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome - $ano";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Gerar listagem da Quantidade de membros por congregacao do distrito $distrito_nome no ano de $ano','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            QUANTIDADE DE MEMBROS POR CONGREGA&Ccedil;&Atilde;O <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form02"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel02/rel_p.php?regiao=<?php echo"$regiao&distrito=$distrito&ano=$ano";?>" 
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
        <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong></strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>CONGREGA&Ccedil;&Atilde;O</strong></h2></th>
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>IGREJA</strong></h2></th>
        <th style='text-align:right'><h2 style="font-size:15px;color:#114a66;"><strong>TOTAL</strong></h2></th> 
    </tr>
</thead> 
<tbody>
		<?php 

        $hoje = getdate();
        $ano_atual = $hoje["year"];
        $mes_atual = $hoje["mon"];
        $dia_atual = $hoje["mday"];
        
        if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
        if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
        
        $data_atual = "$ano_atual-$mes_atual-$dia_atual";
        
                                                                
        //CONGREGACOES
        $qr_congregacao = "SELECT DISTINCT nome,id,distrito,regiao,igreja
         from pae_congregacao WHERE distrito_id = '$distrito' order by igreja asc, nome asc ";
        $todos_congregacao = mysqli_query($conn,"$qr_congregacao"); 
        $tr_mat = mysqli_num_rows($todos_congregacao);
        $i="0";
        while ($dados_congregacao = mysqli_fetch_array($todos_congregacao)) {
        $i++; 
        $nome           = $dados_congregacao["nome"];
        $congregacao_id = $dados_congregacao["id"];
        $distrito_nome  = $dados_congregacao["distrito"];
        $igreja_nome    = $dados_congregacao["igreja"];
        $regiao_nome    = $dados_congregacao["regiao"];
        
        
        
        //REMOVER PALAVRA
        $nome = str_replace("IMW ", "", $nome);
        $igreja_nome = str_replace("IMW ", "", $igreja_nome);
        $distrito_nome = str_replace("Distrito ", "", $distrito_nome);  				
        
        $nome = minuscula($nome);
        $regiao_nome = minuscula($regiao_nome);
        
            
            //TOTAL DE RECEBIDOS
            $qr_idade_t = "SELECT * FROM pae_membro 
            WHERE distrito_id='$distrito'
			AND congregacao_id='$congregacao_id' 
			AND regiao_id = '$regiao' 
			AND ano_recepcao <= '$ano'";
            $todos_idade_t = mysqli_query($conn,"$qr_idade_t"); 
            $tr_idade_t = mysqli_num_rows($todos_idade_t);
			
			//TOTAL DE EXCLUIDOS
            $qr_idade_t_e = "SELECT * FROM pae_membro 
            WHERE distrito_id='$distrito' 
			AND congregacao_id='$congregacao_id' 
			AND regiao_id = '$regiao'
			AND (ano_exclusao BETWEEN '1' AND '$ano')";
            $todos_idade_t_e = mysqli_query($conn,"$qr_idade_t_e"); 
            $tr_idade_t_e = mysqli_num_rows($todos_idade_t_e);
                                    
            $total = $tr_idade_t-$tr_idade_t_e;

        echo"<tr>
        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
        <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$nome</td>
        <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$igreja_nome</td>
        <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
        </tr>";
        
        }
        
		//TOTAL DE RECEBIDOS
		$qr_total = "SELECT * FROM pae_membro 
		WHERE distrito_id='$distrito'
		AND congregacao_id >'0' 
		AND regiao_id = '$regiao' 
		AND ano_recepcao <= '$ano'";
		$todos_total = mysqli_query($conn,"$qr_total"); 
		$tr_total = mysqli_num_rows($todos_total);
		
		//TOTAL DE EXCLUIDOS
		$qr_total_e = "SELECT * FROM pae_membro 
		WHERE distrito_id='$distrito' 
		AND congregacao_id >'0'  
		AND regiao_id = '$regiao'
		AND (ano_exclusao BETWEEN '1' AND '$ano')";
		$todos_total_e = mysqli_query($conn,"$qr_total_e"); 
		$tr_total_e = mysqli_num_rows($todos_total_e);
        
		$tr_total = $tr_total-$tr_total_e;
		
        echo"<tr>
        <td style='font-size:13px;color:#333333;text-align:center'></td>
        <td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
        <td style='font-size:13px;color:#333333;text-align:center'><b></b></td>
        <td style='font-size:13px;color:#333333;text-align:right'><b>$tr_total</b></td>
        </tr>";
        ?>
                        
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




