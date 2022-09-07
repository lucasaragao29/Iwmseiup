<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		
		
		//DESCRICAO
		$descricao_texto = " - GERAL";
		
		 
		
			include "../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Listagem',
			'Gerar listagem fiscal geral','$dados','pae_nomeacao',
			curdate( ),curtime( ))";
			$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM FISCAL <?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form13"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel13/rel_p.php?" 
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
	   
		//CLERIGO PESQUISADO
		$qr_clerigo = "SELECT regiao,regiao_id, distrito, instituicao, pessoa,
		funcao_ministerial,pessoa_id,data_nomeacao,pessoa_id
		FROM pae_nomeacao
		WHERE data_termino='0000-00-00'
		AND funcao_ministerial_id  IN (7,8,9,18,19,20,23,22,10)
		AND regiao_id NOT IN (5)
		ORDER BY pessoa ASC";
		$todos_clerigo = mysql_query($qr_clerigo); 
		$tr_mat = mysql_num_rows($todos_clerigo);
		$i="0";
		while ($dados_clerigo = mysql_fetch_array($todos_clerigo)) {
		$i++; 
		$id_clerigo         = $dados_clerigo["pessoa_id"];
		$nome               = $dados_clerigo["pessoa"];
		$igreja             = $dados_clerigo["instituicao"];
		$distrito           = $dados_clerigo["distrito"];
		$regiao             = $dados_clerigo["regiao"];
		$data_nomeacao      = $dados_clerigo["data_nomeacao"];
		$pessoa_id          = $dados_clerigo["pessoa_id"];
		$funcao_ministerial = $dados_clerigo["funcao_ministerial"];
		
		$nome = maiuscula($nome);
		$igreja = maiuscula($igreja);
		$distrito = maiuscula($distrito);
		$regiao = maiuscula($regiao);
		
		//PARENTES
		$qr_familia_q = "SELECT * FROM pae_clerigo_dependente
		WHERE pessoa_id = '$id_clerigo' 
		ORDER BY parentesco ASC, nascimento ASC";
		$todos_familia_q = mysql_query($qr_familia_q); 
		$tr_familia_q = mysql_num_rows($todos_familia_q);
						
		echo"<thead >
		<tr bgcolor='#114a66'>
		<th colspan='4' style='text-align:center'><h2 style='font-size:15px;color:#fff;'><strong>$nome - $igreja - $distrito - $regiao</strong></h2></th>
		</tr>";
		
		if ($tr_familia_q > "0" or $tr_familia_q != "") {
		echo"<tr >
		<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>PARENTESCO</strong></h2></th>
		<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>NOME</strong></h2></th>
		<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>CPF</strong></h2></th> 
		<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DATA DE NASCIMENTO</strong></h2></th>
		</tr>";
		}
		
		if ($tr_familia_q == "0") {  
		
		echo"<tr >
		<th colspan='5' style='text-align:center'><h2 style='font-size:15px;color:#114a66;'><strong>N&Atilde;O H&Aacute; PARENTES INFORMADOS</strong></h2></th>
		</tr>";
		
		
		}
		
		echo"</thead> 
		<tbody>";          
                 
			
			//DESCRITIVO
			$qr_familia = "SELECT * FROM pae_clerigo_dependente
			WHERE pessoa_id = '$id_clerigo' 
			ORDER BY parentesco ASC, nascimento ASC";
			
			$todos_familia = mysql_query("$qr_familia"); 
			while ($dados_familia = mysql_fetch_array($todos_familia)) {
			$nome       =  $dados_familia["nome"];
			$cpf        = $dados_familia["cpf"];
			$nascimento = $dados_familia["nascimento"];
			$parentesco = $dados_familia["parentesco"];
			
			$nome = ucwords(strtolower($nome));
			
			//CPF
			if ($cpf == '\N' or $cpf == '') { $monta_cpf = "***"; }
			else {
			$parte_um     = substr($cpf, 0, 3);
			$parte_dois   = substr($cpf, 3, 3);
			$parte_tres   = substr($cpf, 6, 3);
			$parte_quatro = substr($cpf, 9, 2);
			
			$monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
			}
			
			//ANIVERSÁRIO
			$dia_nasc  = date('d', strtotime($nascimento));
			$mes_nasc  = date('m', strtotime($nascimento));
			$ano_nasc  = date('Y', strtotime($nascimento));
			$aniversario = "$dia_nasc/$mes_nasc/$ano_nasc";

			
			//PARENTESCO
			if ($parentesco == "C") { $parentesco_texto = "C&ocirc;njuge";}
			if ($parentesco == "F") { $parentesco_texto = "Filho";}
			
			 echo"<tr>
			<td style='font-size:13px;color:#333333;text-align:left'>$parentesco_texto</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$monta_cpf</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$aniversario</td>
			</tr>";
			
			}
		
		}
		
		
		
           ?>      
                 
                 
                 
                 
                 
                 
                 
         
                    
                    
                    </tbody>
                
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




