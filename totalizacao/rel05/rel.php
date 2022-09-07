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
			'Gerar listagem de totalizacao de membros + clerigos - $regiao_nome','$dados','pae_membro',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            TOTALIZA&Ccedil;&Atilde;O DE MEMBROS + CL&Eacute;RIGOS <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form05"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel05/rel_p.php?regiao=<?php echo"$regiao";?>" 
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
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MEMBROS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>CL&Eacute;RIGOS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>TOTAL</strong></h2></th>
		</tr>
		</thead>"; 
	 }
	 
	 else { 
	 
	 echo"
		<thead>
		<tr>
			<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>MEMBROS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>CL&Eacute;RIGOS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#114a66;'><strong>TOTAL</strong></h2></th>
		</tr>
		</thead>"; 
	 
	 }
	 
	 
?>
    <tbody>

		<?php 
        
		if ($regiao == "0") {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];

            //REGIOES
            $qr_regiao = "SELECT * FROM pae_regiao 
            WHERE id IN (13,17,18,19,22,23,24,25)
			ORDER BY id ASC";
            $resultado_regiao = mysql_query($qr_regiao);
            while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
            $regiao_nome  = $row_regiao["nome"];
            $regiao_id    = $row_regiao["id"];
   
                //MEMBROS
				$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
				SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
				COUNT(*) AS Total
				FROM pae_membro
				WHERE regiao_id = '$regiao_id'";
				$todos_membros = mysql_query("$qr_membros"); 
				while ($dados_membros = mysql_fetch_array($todos_membros)) {
				$recebidos_membros  = $dados_membros["recebidos"];
				$excluidos_membros  = $dados_membros["excluidos"];
				
				$membros_total = $recebidos_membros-$excluidos_membros;
				
				}
				
				//CLERIGOS
				$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
				FROM pae_clerigo
				WHERE status='Ativo'  AND regiao_id ='$regiao_id'";
				$todos_clerigo = mysql_query($qr_clerigo);
				$clerigos_total = mysql_num_rows($todos_clerigo);
				
				$total = $membros_total+$clerigos_total;
				
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$regiao_nome</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$membros_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$clerigos_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//MEMBROS
			$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
			SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
			COUNT(*) AS Total
			FROM pae_membro
			WHERE regiao_id IN (13,17,18,19,22,23,24,25)";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$recebidos_membros  = $dados_membros["recebidos"];
			$excluidos_membros  = $dados_membros["excluidos"];
			
			$membros_total = $recebidos_membros-$excluidos_membros;
			
			}
			
			//CLERIGOS
			$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
			FROM pae_clerigo
			WHERE status='Ativo'  AND regiao_id IN (13,17,18,19,22,23,24,25)";
			$todos_clerigo = mysql_query($qr_clerigo);
			$clerigos_total = mysql_num_rows($todos_clerigo);
			
			$total = $membros_total+$clerigos_total;
			
			echo"
			<tr >
			<td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$membros_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$clerigos_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$total</strong></td>
			</tr>";

			
			
        
		}
		
		else {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];

            //DISTRITOS
            $qr_regiao = "SELECT DISTINCT nome,regiao_id,id FROM pae_distrito 
            WHERE regiao_id = '$regiao'
			ORDER BY nome ASC";
            $resultado_regiao = mysql_query($qr_regiao);
            while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
            $distrito_nome  = $row_regiao["nome"];
            $distrito_id    = $row_regiao["id"];
			
			$distrito_nome = str_replace("Distrito ", "", $distrito_nome);

   
                //MEMBROS
				$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,distrito_id,
				SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
				COUNT(*) AS Total
				FROM pae_membro
				WHERE distrito_id = '$distrito_id'";
				$todos_membros = mysql_query("$qr_membros"); 
				while ($dados_membros = mysql_fetch_array($todos_membros)) {
				$recebidos_membros  = $dados_membros["recebidos"];
				$excluidos_membros  = $dados_membros["excluidos"];
				
				$membros_total = $recebidos_membros-$excluidos_membros;
				
				}
				
				//CLERIGOS
				$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
				FROM pae_clerigo
				WHERE status='Ativo'  AND distrito_id ='$distrito_id'";
				$todos_clerigo = mysql_query($qr_clerigo);
				$clerigos_total = mysql_num_rows($todos_clerigo);
				
				$total = $membros_total+$clerigos_total;
				
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$membros_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$clerigos_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//MEMBROS
			$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
			SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
			COUNT(*) AS Total
			FROM pae_membro
			WHERE regiao_id = '$regiao'";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$recebidos_membros  = $dados_membros["recebidos"];
			$excluidos_membros  = $dados_membros["excluidos"];
			
			$membros_total = $recebidos_membros-$excluidos_membros;
			
			}
			
			//CLERIGOS
			$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
			FROM pae_clerigo
			WHERE status='Ativo'  AND regiao_id = '$regiao_id'";
			$todos_clerigo = mysql_query($qr_clerigo);
			$clerigos_total = mysql_num_rows($todos_clerigo);
			
			$total = $membros_total+$clerigos_total;
			
			echo"
			<tr >
			<td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$membros_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$clerigos_total</strong></td>
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




