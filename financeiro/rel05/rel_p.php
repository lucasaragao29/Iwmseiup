<?php

	
	session_start(); 	
	$id_user =  $_SESSION['id_user'];
	
	include("../../config/conexao.php");
	include("../../config/config.php");
	include("../../config/maiuscula.php");
	include("../../config/minuscula.php");
	include("../../config/moeda2.php");
	
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
	$distrito_user   = $dados_usuario["coddistrito"];	}
	
	$distrito   = $_GET["distrito"];
	$regiao     = $_GET["regiao"];
	$ano        = $_GET["ano"];
			
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

	//APAGAR A PALAVRA
	$igreja_nome = str_replace("IMW ", "", $igreja_nome); 
	$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
	
	//MAIUSCULO		
	$distrito_nome2 = maiuscula($distrito_nome);
	$regiao_nome    = maiuscula($regiao_nome);
	$igreja_nome2   = maiuscula($igreja_nome);

	//DESCRICAO
	if ($distrito == "0") { $descricao_texto = "- $regiao_nome $ano"; }
	else { $descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome<br> $ano"; }
	
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Financeiro',
	'Tela de impressao do relatorio das igrejas em dia $regiao_nome do ano de $ano','$dados','pae_financeiro',
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
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR>
    <TD height="20"><table width="100%" height="190" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_">
      <tr>
        <td align="center"><img src="../../imagens/relatorio_topo_01.gif" width="850" height="150" alt=""></td>
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
            IGREJAS EM DIA <?php echo"$descricao_texto"; ?></strong></p>
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
<?php if($distrito == "0") { echo"<th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>DISTRITO</strong></h2></th>"; } ?>  
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>JAN</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>FEV</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>MAR</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>ABR</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>MAI</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>JUN</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>JUL</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>AGO</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>SET</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>OUT</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>NOV</strong></h2></th> 
                    <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>DEZ</strong></h2></th> 
                     <th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>TOTAL</strong></h2></th> 
                  </tr>
                </thead> 
                
                <tbody>
                        
						<?php 
						
						if ($distrito != "0") {
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito_id
						FROM pae_igreja
						WHERE distrito_id='$distrito'
						ORDER BY nome ASC";
						
						}
						
						else {
						
						$qr_igreja = "SELECT DISTINCT id,nome,distrito_id,regiao_id,distrito
						FROM pae_igreja
						WHERE regiao_id='$regiao'
						ORDER BY distrito ASC, nome ASC";
						
						}
						$todos_igreja = mysql_query($qr_igreja); 
                        while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
						$igreja_id   = $dados_igreja["id"];
						$igreja_nome = $dados_igreja["nome"];
						$distrito_nome = $dados_igreja["distrito"];
						
						$igreja_nome = str_replace("IMW ", "", $igreja_nome);
						$distrito_nome = str_replace("Distrito ", "", $distrito_nome);
						$igreja_nome2 = maiuscula($igreja_nome);
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'>$igreja_nome2</td>";
						
						if ($distrito == "0") { echo"<td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>"; }
						
						//DESCRITIVO
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND igreja_id='$igreja_id'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						$todos_financa = mysql_query("$qr_financa");
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'>$valortotal2</td>";
					

						}
						
													if ($mes == "0") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}
						
							if ($mes == "1") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}													
						
							if ($mes == "2") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "3") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}							
						
							if ($mes == "4") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "5") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "6") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}							
						
							if ($mes == "7") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "8") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "9") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}						
						
							if ($mes == "10") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}
							
						
							if ($mes == "11") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>***</td>";
							
							}	
							
							
						//TOTAL DA IGREJA
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND igreja_id='$igreja_id'
						AND YEAR(data_movimento) = '$ano'";
						$todos_financa = mysql_query("$qr_financa");
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>";
					

						}							

						echo"</tr>";			
                    	}
						
						
						
						echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:left'><B>TOTAIS<B></td>";
						
						//TOTAL//
						if ($distrito == "0") {
							
						$qr_financa = "SELECT regiao,regiao_id, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND regiao_id='$regiao'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						
						}
						
						else {
							
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND distrito_id='$distrito'
						AND YEAR(data_movimento) = '$ano'
						AND MONTH(data_movimento) IN ('1','2','3','4','5','6','7','8','9','10','11','12')
						GROUP BY MONTH(data_movimento)
						ORDER BY MONTH(data_movimento) ASC";
						}
						
						
						$todos_financa = mysql_query("$qr_financa"); 
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'><B>$valortotal2<B></td>";
												
						}
													if ($mes == "0") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}
						
							if ($mes == "1") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}													
						
							if ($mes == "2") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "3") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							
						
							if ($mes == "4") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "5") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "6") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							
						
							if ($mes == "7") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "8") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "9") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}						
						
							if ($mes == "10") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}
							
						
							if ($mes == "11") { 
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>***</b></td>";
							
							}							

						//TOTAL DO DISTRITO
						$qr_financa = "SELECT regiao, distrito_id,numeracao,igreja,igreja_id, YEAR(data_movimento),
						MONTH(data_movimento),plano_conta_id,plano_conta, SUM(valor)
					    FROM pae_financeiro
					    WHERE numeracao IN ('1.01.01','1.01.02','1.02.01')
						AND distrito_id='$distrito'
						AND YEAR(data_movimento) = '$ano'";
						$todos_financa = mysql_query("$qr_financa");
                        while ($dados_financa = mysql_fetch_array($todos_financa)) {
						$valortotal   = $dados_financa["SUM(valor)"];
						$mes          = $dados_financa["MONTH(data_movimento)"];
						
						//MOEDA
						$valortotal2 = moeda2($valortotal);
						
						echo"<td style='font-size:13px;color:#333333;text-align:right'><b>$valortotal2</b></td>";
					

						}							
                        echo"</tr>";

					
						

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
