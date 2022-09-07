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
	
		$distrito   = $_GET["distrito"];
		$regiao     = $_GET["regiao"];
		$ano        = $_GET["ano"];
				
		//DESCOBRIR DISTRITO
		$result_distrito = "SELECT * FROM pae_distrito WHERE id=$distrito";
		$resultado_distrito = mysql_query($result_distrito);		
		while ($row_distrito = mysql_fetch_assoc($resultado_distrito) ) {
		$distrito_nome  = $row_distrito["nome"];
		$regiao_nome  = $row_distrito["regiao"];
		}

		//APAGAR A PALAVRA
		$igreja_nome = str_replace("IMW ", "", $igreja_nome); 
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO		
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome    = maiuscula($regiao_nome);

		//DESCRICAO
		$descricao_texto = "<br>DISTRITO $distrito_nome2 - $regiao_nome - $ano";
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao tiquete medio de pastoreio de igrejas do distrito $distrito_nome
			 - $regiao_nome do ano $ano','$dados','pae_membro',
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
            T&Iacute;QUETE M&Eacute;DIO DE PASTOREIO<?php echo"$descricao_texto"; ?></strong></p>
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
                    <th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>IGREJA</strong></h2></th>
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>INVESTIMENTO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>CUSTEIO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>M&Eacute;DIA</strong></h2></th> 
                    </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito
						FROM pae_igreja
						WHERE distrito_id='$distrito'
						ORDER BY nome ASC";
						$todos_igreja = mysql_query("$qr_igreja"); 
                        while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
						$igreja_id   = $dados_igreja["id"];
						$igreja_nome = $dados_igreja["nome"];
						
						$igreja_nome2 = maiuscula($igreja_nome);
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND igreja_id='$igreja_id'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$numeracao    = $dados_financa["numeracao"];
						$plano_conta  = $dados_financa["plano_conta"];
						
						//MOEDA
						$valortotal2 = moeda($valortotal);
						
							//QUANTIDAE DE MEMBROS
							$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE igreja_id='$igreja_id'
							AND	regiao_id = '$regiao'";
							$todos_membros = mysql_query("$qr_membros "); 
							while ($dados_membros  = mysql_fetch_array($todos_membros )) {
							$recebidos = $dados_membros ["recebidos"];
							$excluidos = $dados_membros ["excluidos"];
							
							$membresia = $recebidos-$excluidos;
							}
							
						
						//MES
												
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						
						//echo "ANTES $mes_atual - $ano_atual - $ano<br>";

						if ($mes_atual == "12" and $ano_atual == $ano) { $mes = "11";  }
						if ($mes_atual == "12" and $ano_atual > $ano) { $mes = "12";  }
						if ($mes_atual < "12" and $ano_atual == $ano) { $mes = $mes_atual-1; }
						if ($mes_atual < "12" and $ano_atual > $ano) { $mes = "12"; }
						
						//echo"DEPOIS $mes_atual - $ano_atual - $ano<BR>";
							
						$media = $valortotal/$membresia;
						$custeio = $media/$mes;
							
						//MOEDA
						$media = number_format( round( $media, 1, PHP_ROUND_HALF_UP ), 2);
						$media = moeda($media);
						
						$custeio = number_format( round( $custeio, 1, PHP_ROUND_HALF_UP ), 2);
						$custeio = moeda($custeio);
							
						 echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$igreja_nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$media</td>
 						<td style='font-size:13px;color:#333333;text-align:right'>$custeio</td>
                       </tr>";
						
						}
						
						
						
						
						
						
			
                    	}
						
						
						//TOTAL//
						$qr_financa = "SELECT regiao, distrito,numeracao, igreja,igreja_id, YEAR(data_movimento),
						plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('2.01.15','2.01.16','2.02.01','2.02.02','2.02.03','2.02.04',
						'2.02.05','2.02.06','2.02.07','2.02.08','2.02.09','2.02.99')
						AND distrito_id='$distrito'
						AND YEAR(data_movimento) = '$ano'
						ORDER BY plano_conta_id ASC";
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal_final   = $dados_financa["SUM(valor)"];
						$numeracao          = $dados_financa["numeracao"];
						$plano_conta        = $dados_financa["plano_conta"];
						
						
						
						//QUANTIDAE DE MEMBROS
						$qr_membros_total = "SELECT ano_recepcao,regiao_id,distrito_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE distrito_id='$distrito'";
						$todos_membros_total = mysql_query("$qr_membros_total"); 
						while ($dados_membros_total  = mysql_fetch_array($todos_membros_total )) {
						$recebidos = $dados_membros_total ["recebidos"];
						$excluidos = $dados_membros_total ["excluidos"];
						
						$membresia_total = $recebidos-$excluidos;
						}
						
						//MES
												
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						
						//echo "ANTES $mes_atual - $ano_atual - $ano<br>";

						if ($mes_atual == "12" and $ano_atual == $ano) { $mes = "11";  }
						if ($mes_atual == "12" and $ano_atual > $ano) { $mes = "12";  }
						if ($mes_atual < "12" and $ano_atual == $ano) { $mes = $mes_atual-1; }
						if ($mes_atual < "12" and $ano_atual > $ano) { $mes = "12"; }
						
						//echo"DEPOIS $mes_atual - $ano_atual - $ano<BR>";
							
						$media_total = $valortotal_final/$membresia_total;
						$custeio = $media_total/$mes;
							
						//MOEDA
						$media_total = number_format( round( $media_total, 1, PHP_ROUND_HALF_UP ), 2);
						$media_total = moeda($media_total);
						
						$custeio = number_format( round( $custeio, 1, PHP_ROUND_HALF_UP ), 2);
						$custeio = moeda($custeio);
						
						//MOEDA
						$valortotal_final = moeda($valortotal_final);						
						}
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAIS</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal_final</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$media_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$custeio</b></td>
                        </tr>";

					
						

                        ?>     </tbody>                </table>
                
                
                
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
