<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$regiao   = $_POST["id_categoria"];
		
		//DESCOBRIR REGIAO
		if ($regiao == "0") { $regiao_nome = "Geral"; }
		else {
			$result_regiao = "SELECT * FROM pae_regiao WHERE id='$regiao'";
			$resultado_regiao = mysql_query($result_regiao);		
			while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
			$regiao_nome  = $row_regiao["nome"];
			}
		}
		
		//MAIUSCULO
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "$regiao_nome2";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Totalizacao',
			'Gerar listagem de totalizacao de igrejas - $regiao_nome','$dados','pae_igreja',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            TOTALIZA&Ccedil;&Atilde;O DE IGREJAS <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form01"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel01/rel_p.php?regiao=<?php echo"$regiao";?>" 
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
 
 
 <?php 
 
	 if ($regiao == "0") {               
		echo"
		<thead>
		<tr>
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>REGI&Atilde;O</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJAS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>CONGREGA&Ccedil;&Otilde;ES</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>TOTAL</strong></h2></th> 
		</tr>
		</thead>"; 
	 }
	 
	 else { 
	 
	 echo"
		<thead>
		<tr>
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>IGREJAS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>CONGREGA&Ccedil;&Otilde;ES</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>TOTAL</strong></h2></th> 
		</tr>
		</thead>"; 
	 
	 }
	 
	 
?>
    <tbody>

		<?php 
        
		if ($regiao == "0") {
			
            //REGIOES
            $qr_regiao = "SELECT * FROM pae_regiao 
            WHERE id IN (13,17,18,19,22,23,24,25)
			ORDER BY id ASC";
            $resultado_regiao = mysql_query($qr_regiao);
            while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
            $regiao_nome  = $row_regiao["nome"];
            $regiao_id    = $row_regiao["id"];
                //IGREJAS
                $qr_igrejas = "SELECT * FROM pae_igreja 
                WHERE regiao_id = '$regiao_id'";
                $resultado_igrejas = mysql_query($qr_igrejas);
                $tr_igrejas = mysql_num_rows($resultado_igrejas);	
   
                //CONGREGAÇÕES
                $qr_congregacao = "SELECT * FROM pae_congregacao 
                WHERE regiao_id = '$regiao_id'";
                $resultado_congregacao = mysql_query($qr_congregacao);
                $tr_congregacao = mysql_num_rows($resultado_congregacao);		
        
            $total = $tr_igrejas+$tr_congregacao;
            
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'><strong>$regiao_nome</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'>$tr_igrejas</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$tr_congregacao</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//REGIOES
                //IGREJAS
                $qr_igrejas = "SELECT * FROM pae_igreja 
                WHERE regiao_id IN (13,17,18,19,22,23,24,25)";
                $resultado_igrejas = mysql_query($qr_igrejas);
                $tr_igrejas = mysql_num_rows($resultado_igrejas);	
   
                //CONGREGAÇÕES
                $qr_congregacao = "SELECT * FROM pae_congregacao 
                WHERE regiao_id IN (13,17,18,19,22,23,24,25)";
                $resultado_congregacao = mysql_query($qr_congregacao);
                $tr_congregacao = mysql_num_rows($resultado_congregacao);		
        
            $total = $tr_igrejas+$tr_congregacao;
            
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$tr_igrejas</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$tr_congregacao</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$total</strong></td>
            </tr>";
			
			
        
		}
		
		else {
			
		    //DISTRITOS
            $qr_distrito = "SELECT DISTINCT id,regiao_id, nome FROM pae_distrito
            WHERE regiao_id ='$regiao'
			ORDER BY nome ASC";
            $resultado_distrito = mysql_query($qr_distrito);
            while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
            $distrito_nome  = $row_distrito["nome"];
            $distrito_id    = $row_distrito["id"];
			
				$distrito_nome = str_replace("Distrito ", "", $distrito_nome);  				
			
                //IGREJAS
                $qr_igrejas = "SELECT * FROM pae_igreja 
                WHERE distrito_id = '$distrito_id'";
                $resultado_igrejas = mysql_query($qr_igrejas);
                $tr_igrejas = mysql_num_rows($resultado_igrejas);	
   
                //CONGREGAÇÕES
                $qr_congregacao = "SELECT * FROM pae_congregacao 
                WHERE distrito_id = '$distrito_id'";
                $resultado_congregacao = mysql_query($qr_congregacao);
                $tr_congregacao = mysql_num_rows($resultado_congregacao);		
        
            $total = $tr_igrejas+$tr_congregacao;
            
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'><strong>$distrito_nome</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'>$tr_igrejas</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$tr_congregacao</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//REGIOES
                //IGREJAS
                $qr_igrejas = "SELECT * FROM pae_igreja 
                WHERE regiao_id ='$regiao'";
                $resultado_igrejas = mysql_query($qr_igrejas);
                $tr_igrejas = mysql_num_rows($resultado_igrejas);	
   
                //CONGREGAÇÕES
                $qr_congregacao = "SELECT * FROM pae_congregacao 
                WHERE regiao_id ='$regiao'";
                $resultado_congregacao = mysql_query($qr_congregacao);
                $tr_congregacao = mysql_num_rows($resultado_congregacao);		
        
            $total = $tr_igrejas+$tr_congregacao;
            
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$tr_igrejas</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$tr_congregacao</strong></td>
            <td style='font-size:13px;color:#333333;text-align:right'><strong>$total</strong></td>
            </tr>";
	
			
		}
        
        ?>
                        
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




