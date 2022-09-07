<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        
        <?php	
		
		$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
		mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
		
		$funcao    = $_POST["funcao"];
		
		//FUNCOES
		if ($funcao == "0") { $funcao_nome = "Todos"; }
		if ($funcao == "7") { $funcao_nome = "Co-pastor"; }
		if ($funcao == "8") { $funcao_nome = "Ministro Integral"; }
		if ($funcao == "9") { $funcao_nome = "Pastor Titular Integral"; }
		if ($funcao == "18") { $funcao_nome = "Ministro Parcial"; }
		if ($funcao == "19") { $funcao_nome = "Pastor Titular Parcial"; }
		if ($funcao == "11") { $funcao_nome = "Missionária"; }
		if ($funcao == "20") { $funcao_nome = "Pastor Ajudante Parcial"; }
		if ($funcao == "23") { $funcao_nome = "Pastor Ajudante (sem ônus)"; }
		if ($funcao == "24") { $funcao_nome = "Missionária (sem ônus)"; }
		if ($funcao == "22") { $funcao_nome = "Pastor Titular (sem ônus)"; }
		if ($funcao == "10") { $funcao_nome = "Pastor Ajudante Intergral"; }
		
		$funcao_nome = utf8_decode($funcao_nome);
		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		$funcao_nome2 = maiuscula($funcao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>$funcao_nome2";
		
		include "../config/meuip.php";
	
		//GRAVAR HISTORICO DA ACAO
		$GRAVAR = "INSERT INTO historico_usuario
		(coduser,codregiao,coddistrito, userip,sessao,
		acao,codarquivo,tipo_arquivo,
		data,hora)
		VALUES
		('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Listagem',
		'Gerar listagem da clerigos ($funcao_nome) geral','$dados','pae_nomeacao',
		curdate( ),curtime( ))";
		$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
		
		?>
        
        
            <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> 
            LISTAGEM DE CL&Eacute;RIGOS GERAL<?php echo"$descricao_texto"; ?></strong><br>
            
            <a href="index.php?sessao=form07"  title="Nova pesquisa">
            <span class='fa-stack fa-1x' style="color:#990000;">
            <i class='fa fa-circle fa-stack-2x'></i>
            <i class='fa fa-search fa-stack-1x fa-inverse' style="color:#fff;"></i>
            </span>
            </a>
            
            <a href="rel07/rel_p.php?<?php echo"funcao=$funcao";?>" 
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
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>NOME</strong></h2></th>
                    
                    <?php 
                    if ($funcao == "0") { 
                    echo "<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>FUN&Ccedil;&Atilde;O</strong></h2></th>";
                    }
                    
                    ?>
                    
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>IGREJA</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>DISTRITO</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>REGI&Atilde;O</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>ANIVER.</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>NOMEA&Ccedil;&Atilde;O</strong></h2></th>
                </tr>
            </thead> 
            <tbody>
            
			<?php 
            
			//DATA
            $anterior = $ano-1;
            
            $hoje = getdate();
            $ano_atual = $hoje["year"];
            $mes_atual = $hoje["mon"];
            $dia_atual = $hoje["mday"];
            
            if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
            if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
            
            $data_atual = "$ano_atual-$mes_atual-$dia_atual";
            
			//FUNCAO
            if ($funcao == "0") { $funcao_texto = "AND funcao_ministerial_id  IN (7,8,9,18,19,11,20,23,24,22,10)"; }
			 else { $funcao_texto = "AND funcao_ministerial_id = '$funcao'"; }	
                                                                
            //CLERIGO PESQUISADO
            $qr_clerigo = "SELECT regiao,regiao_id, distrito, instituicao, pessoa, funcao_ministerial,pessoa_id,data_nomeacao
            FROM pae_nomeacao
            WHERE funcao_ministerial_id NOT IN (1,2,3,4,5,6)
            AND data_termino='0000-00-00'
            $funcao_texto
			AND regiao_id IN (13,25,17,18,19,24,23,22)
            ORDER BY regiao, distrito, instituicao";
            $todos_clerigo = mysql_query($qr_clerigo); 
            $tr_mat = mysql_num_rows($todos_clerigo);
            $i="0";
            while ($dados_clerigo = mysql_fetch_array($todos_clerigo)) {
            $i++; 
            $nome               = $dados_clerigo["pessoa"];
            $igreja             = $dados_clerigo["instituicao"];
            $distrito           = $dados_clerigo["distrito"];
            $regiao             = $dados_clerigo["regiao"];
            $data_nomeacao      = $dados_clerigo["data_nomeacao"];
            $pessoa_id          = $dados_clerigo["pessoa_id"];
            $funcao_ministerial = $dados_clerigo["funcao_ministerial"];
			
            //DATA DE NASCIMENTO
            $qr_clerigo2 = "SELECT * FROM pae_clerigo
            WHERE id = '$pessoa_id'";
            $todos_clerigo2 = mysql_query($qr_clerigo2); 
            while ($dados_clerigo2 = mysql_fetch_array($todos_clerigo2)) {
            $niver   = $dados_clerigo2["data_nascimento"];
            }
            
            //DATA DE NASCIMENTO
            $dianasc = date('d', strtotime($niver));
            $mesnasc = date('m', strtotime($niver));
            $anonasc = date('Y', strtotime($data_nomeacao));
            $niver_texto = "$dianasc/$mesnasc";
            
            //NOMEACAO
            $dian = date('d', strtotime($data_nomeacao));
            $mesn = date('m', strtotime($data_nomeacao));
            $anon = date('Y', strtotime($data_nomeacao));
            $nomeacao_texto = "$dian/$mesn/$anon";
            
            if ($distrito == "") { $distrito = "-";  }
            
            //REMOVER PALAVRA
            $distrito = str_replace("Distrito ", "", $distrito);
            $igreja = str_replace("IMW ", "", $igreja);  				

            echo"<tr>
            <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$nome</td>";
            
            if ($funcao == "0") { 
            echo"<td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$funcao_ministerial</td>"; }						
            
            echo"<td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$igreja</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$distrito</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$regiao</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$niver_texto</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$nomeacao_texto</td>
            </tr>";

            }
            ?>
        
        
        </tbody>
    
    </table>
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->




