<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$mes      = $_POST["mes"];
		$regiao   = $_POST["id_categoria"];
		
			
		if ($mes == "0")  { $mes2 = "TODO O ANO"; }
		if ($mes == "01") { $mes2 = "JANEIRO"; }
		if ($mes == "02") { $mes2 = "FEVEREIRO"; }
		if ($mes == "03") { $mes2 = "MAR&Ccedil;O"; }
		if ($mes == "04") { $mes2 = "ABRIL"; }
		if ($mes == "05") { $mes2 = "MAIO"; }
		if ($mes == "06") { $mes2 = "JUNHO"; }
		if ($mes == "07") { $mes2 = "JULHO"; }
		if ($mes == "08") { $mes2 = "AGOSTO"; }
		if ($mes == "09") { $mes2 = "SETEMBRO"; }
		if ($mes == "10") { $mes2 = "OUTUBRO"; }
		if ($mes == "11") { $mes2 = "NOVEMBRO"; }
		if ($mes == "12") { $mes2 = "DEZEMBRO"; }

		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}
		
		//MAIUSCULO
		$regiao_nome2   = maiuscula($regiao_nome);
		$distrito_nome2 = maiuscula($distrito_nome);
		
		//DESCRICAO
		$descricao_texto = " DE $mes2<br>$regiao_nome2";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
			'Gerar listagem de clerigos aniversariante do mes - $mes2 da $regiao_nome','$dados','pae_clerigo',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE CL&Eacute;RIGOS ANIVERSARIANTES <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form05"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel05/rel_p.php?regiao=<?php echo"$regiao&mes=$mes";?>" 
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DATA</strong></h2></th>        
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
        
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
						
							//CODIGO DO MES
							
							if ($mes == "0") { $mes_cod = ""; } else { $mes_cod = "AND MONTH(data_nascimento) = '$mes'";  }
							
							//LISTAGEM
							$qr_listagem = "SELECT DISTINCT nome,distrito_id,regiao_id,data_nascimento,distrito,
							MONTH(data_nascimento) as mes,DAY(data_nascimento) as dia
							FROM pae_clerigo
							WHERE regiao_id='$regiao'
							$mes_cod AND status='Ativo' and data_nascimento !='0000-00-00'
							ORDER BY MONTH(data_nascimento) asc, DAY(data_nascimento) asc";
							$i="0";
							$resultado_listagem = mysql_query($qr_listagem);		
							while ($row_listagem = mysql_fetch_assoc($resultado_listagem) ) {
							$i++;
							$nome  = $row_listagem["nome"];
							$distrito   = $row_listagem["distrito"];	
							$dia   = $row_listagem["dia"];	
							$mes   = $row_listagem["mes"];				
							
							$distrito = str_replace("Distrito ", "", $distrito);
							$igreja = str_replace("IMW ", "", $igreja);
							
							if ($dia < "10") { $dia = "0$dia"; }
							if ($mes < "10") { $mes = "0$mes"; }
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>							
							<td style='font-size:13px;color:#333333;text-align:left'>$dia/$mes</td>					
							<td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
							</tr>";
							
							}											
                 

                        ?>
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




