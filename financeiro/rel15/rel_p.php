<?php

	
	session_start(); 	
	$id_user =  $_SESSION['id_user'];
	
	include("../../config/conexao.php");
	include("../../config/config.php");
	include("../../config/maiuscula.php");
	include("../../config/minuscula.php");
	include("../../config/moeda.php");
	
	$link = mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
	mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");
	
	$busca_usuario = "SELECT * from user WHERE id = '$id_user'";
	$todos_usuario = mysql_query("$busca_usuario"); 
	while ($dados_usuario = mysql_fetch_array($todos_usuario)) { 
	$id_user    = $dados_usuario["id"];
	$log_user   = $dados_usuario["login_user"];
	$senha_user = $dados_usuario["senha_user"];
	$nivel_user = $dados_usuario["codnivel"];
	$regiao_user   = $dados_usuario["codregiao"];
	$regiao_user   = $dados_usuario["coddistrito"];	
	}
	
	$ano        = $_GET["ano"];
			
	//DESCRICAO
	$descricao_texto = "GERAL - $ano";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao do relatorio do tiquete medio de investimenro em clerigo geral do ano de $ano','$dados','pae_membro',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execução da consultas");	
	
?>
<HTML>
<HEAD>
<title><?php include ("../../config/codigos.php"); echo"$titulos_novo";?></title></HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
    <link href="../../config/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="../../config/css/animate.min.css" rel="stylesheet">
    <link href="../../config/css/prettyPhoto.css" rel="stylesheet">
    <link href="../../config/css/main.css" rel="stylesheet">
    <link href="../../config/css/responsive.css" rel="stylesheet">
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
	}
	
	.panel.panel-custom {
	background:#fff;
	color:red;
	border:3px solid #000;
	border-radius:20px;
	}
	
	.panel.panel-custom2 {
	background:#000;
	color:red;
	border:3px solid #000;
	border-radius:20px;
	}
	.panel.panel-custom3 {
	background:transparent;
	color:#666;
	border:3px solid transparent;
	border-radius:20px;
	}
	
	
	.px {
	padding-top : 0px;
	padding-bottom : 0px;
	padding-left : 0px;
	padding-right : 0px;
	margin-top : 2px;
	margin-bottom : 0px;
	margin-left : 0px;
	margin-right : 0px;
	}
	.texto {
	color : black;
	margin-top : 1px;
	padding-bottom : 1px;
	margin-bottom : 1px;
	margin-left : 1px;
	margin-right : 1px;
	font-size : 12px;
	font-family : Tahoma,Verdana,Arial;
	}
	
	.texto_requerimento {
	color : black;
	line-height: 200%;
	margin-top : 1px;
	padding-bottom : 1px;
	margin-bottom : 1px;
	margin-left : 1px;
	margin-right : 1px;
	font-size : 16px;
	font-family : Tahoma,Verdana,Arial;
	}
	
	.texto_titulo {
	color : black;
	margin-top : 1px;
	padding-bottom : 1px;
	margin-bottom : 1px;
	margin-left : 1px;
	margin-right : 1px;
	font-size : 22px;
	font-style:italic;
	font-family : Tahoma,Verdana,Arial;
	}


    </style>
    

</HEAD>

<BODY BGCOLOR="#FFFFFF" LINK="#333333" VLINK="#000000" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0">
<div align="center">
<TABLE WIDTH="850" BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR>
    <TD height="20"><table width="850" height="190" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_">
      <tr>
        <td><img src="../../imagens/relatorio_topo_01.gif" width="850" height="150" alt=""></td>
      </tr>
      
      
    </table>
      <br></TD>
  </TR>
  <TR>
    <TD height="20" align="center" valign="middle">
    
 
<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">

        
        
            <p style="font-size:15px;color:#000"><strong><i class="fa fa-file-text"></i> 
            T&Iacute;QUETE M&Eacute;DIO DE INVESTIMENTO POR CL&Eacute;RIGO <?php echo"$descricao_texto"; ?></strong></p>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->
    
    
    
<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="table-responsive">         
                <table class="table table-striped">
                
                
                <thead>
                    <tr >
                    <th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>REGI&Atilde;O</strong></h2></th>
                    <th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>INVESTIMENTO</strong></h2></th> 
                    <th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>M&Eacute;DIA</strong></h2></th> 
                    </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						//REGIAO
						$qr_regiao = "SELECT DISTINCT id,nome
						FROM pae_regiao
						WHERE id !='962'
						AND id !='2762'
						AND id !='26'
 						ORDER BY nome ASC";
						$todos_regiao = mysql_query("$qr_regiao"); 
                        while ($dados_regiao = mysql_fetch_array($todos_regiao)) {
						$regiao_id   = $dados_regiao["id"];
						$regiao_nome = $dados_regiao["nome"];
						
						$regiao_nome2 = maiuscula($regiao_nome);
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, regiao_id,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND regiao_id='$regiao_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
						//CLERIGOS
						$qr_clerigos = "SELECT regiao,regiao_id, distrito, instituicao, pessoa, funcao_ministerial,
						SUM(CASE WHEN regiao_id='$regiao_id' then 1 ELSE 0 END) AS clerigos,
						COUNT(*) AS Total															  
						FROM pae_nomeacao
						WHERE data_termino='0000-00-00'";
						$todos_clerigos = mysql_query("$qr_clerigos"); 
						while ($dados_clerigos = mysql_fetch_array($todos_clerigos)) {
						$clerigos                    = $dados_clerigos["clerigos"];
						}
						if ($valortotal == "") { $media = "0";  } else { $media = $valortotal/$clerigos; }
							
						//MOEDA
						$media = number_format( round( $media, 1, PHP_ROUND_HALF_UP ), 2);
						
						$media = moeda($media);
							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$regiao_nome2</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$valortotal2</td>
 						<td style='font-size:13px;color:#333333;text-align:left'>$media</td>
                       </tr>";
						
						}
						
						
			
                    	}
						
						
						//TOTAL//
						$qr_financa = "SELECT regiao_id, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal_final   = $dados_financa["SUM(valor)"];
						$numeracao          = $dados_financa["numeracao"];
						$plano_conta        = $dados_financa["plano_conta"];
						
						//CLERIGOS
						$qr_clerigos = "SELECT regiao, distrito, instituicao, pessoa, funcao_ministerial,
						SUM(CASE WHEN (id !='962' AND id !='2762' AND id !='26') then 1 ELSE 0 END) AS clerigos,
						COUNT(*) AS Total															  
						FROM pae_nomeacao
						WHERE data_termino='0000-00-00'";
						$todos_clerigos = mysql_query("$qr_clerigos"); 
						while ($dados_clerigos = mysql_fetch_array($todos_clerigos)) {
						$clerigos_total                    = $dados_clerigos["clerigos"];
						}
						
						$media_total = $valortotal_final/$clerigos_total;
						
						//MOEDA
						$media_total = number_format( round( $media_total, 1, PHP_ROUND_HALF_UP ), 2);
						$valortotal_final = moeda($valortotal_final);
						$media_total = moeda($media_total);
						
												
						}
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>$valortotal_final</b></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>$media_total</b></td>
                        </tr>";

					
						

                        ?>                      
                    </tbody>
                </table>
                
                
                
            </div> <!-- table-responsive -->
        </div>  <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->    
    
 <div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">

        
        
            <p style="font-size:15px;color:#000"><strong><i class="fa fa-file-text"></i> 
            <?php echo"$titulos_novo"; ?></strong></p>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->   
</TD>
  </TR>
  
</TABLE>
</div>
</BODY>
</HTML>
