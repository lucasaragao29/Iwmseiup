<?php

	
	session_start(); 	
	$id_user =  $_SESSION['id_user'];
	
	include("../../config/conexao.php");
	include("../../config/config.php");
	include("../../config/maiuscula.php");
	include("../../config/minuscula.php");
	
	$link = mysql_connect($host,$user,$pass)  or die("N?o foi poss?vel conectar");
	mysql_select_db($db)  or die("N?o foi poss?vel selecionar o banco de dados");
	
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
	
		//DESCRICAO
		$descricao_texto = " POR FAIXA ET&Aacute;RIA GERAL";
		
		
				
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
	'Tela de impressao da listagem de clerigos por faixa etaria geral','$dados','pae_clerigo',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execu??o da consultas");	
	
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
            LISTAGEM DE CL&Eacute;RIGOS <?php echo"$descricao_texto"; ?></strong></p>
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>FAIXA ET&Aacute;RIA</strong></h2></th>
        <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>QUANTIDADE</strong></h2></th>
        <th style='text-align:center'><h2 style="font-size:15px;color:#114a66;"><strong>%</strong></h2></th>
        
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
							
							//FAIXA 1 - 25 A 40
							$qr_faixa1 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 25 and 40)  
							 and status='Ativo'";
							$resultado_faixa1 = mysql_query($qr_faixa1);
							$tr_faixa1 = mysql_num_rows($resultado_faixa1);
							
							//FAIXA 2 - 41 A 50
							$qr_faixa2 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 41 and 50)  
							 and data_nascimento !='0000-00-00' and status='Ativo' ";
							$resultado_faixa2 = mysql_query($qr_faixa2);
							$tr_faixa2 = mysql_num_rows($resultado_faixa2);
							
							//FAIXA 3 - 51 A 60
							$qr_faixa3 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 51 and 60)  
							 and data_nascimento !='0000-00-00'  and status='Ativo'";
							$resultado_faixa3 = mysql_query($qr_faixa3);
							$tr_faixa3 = mysql_num_rows($resultado_faixa3);
							
							//FAIXA 4 - 61 A 200
							$qr_faixa4 = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,regiao_id,data_nascimento
							FROM pae_clerigo 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 61 and 200)  
							 and data_nascimento !='0000-00-00'  and status='Ativo'";
							$resultado_faixa4 = mysql_query($qr_faixa4);
							$tr_faixa4 = mysql_num_rows($resultado_faixa4);
							
							//FAIXA 5 - INDEFINIDO
							$qr_faixa5 = "SELECT * FROM pae_clerigo 
							WHERE data_nascimento ='0000-00-00' and status='Ativo' ";
							$resultado_faixa5 = mysql_query($qr_faixa5);
							$tr_faixa5 = mysql_num_rows($resultado_faixa5);							
							//TOTAL
							$tr_faixa = $tr_faixa1+$tr_faixa2+$tr_faixa3+$tr_faixa4+$tr_faixa5;
							
							//PORCENTAGEM
							$tr_porc1 = (100*$tr_faixa1)/$tr_faixa;
							$tr_porc2 = (100*$tr_faixa2)/$tr_faixa;
							$tr_porc3 = (100*$tr_faixa3)/$tr_faixa;
							$tr_porc4 = (100*$tr_faixa4)/$tr_faixa;
							$tr_porc5 = (100*$tr_faixa5)/$tr_faixa;
							$tr_porc  = "100";
							
							$tr_porc1 = number_format($tr_porc1,0,'.',''); 
							$tr_porc2 = number_format($tr_porc2,0,'.',''); 
							$tr_porc3 = number_format($tr_porc3,0,'.',''); 
							$tr_porc4 = number_format($tr_porc4,0,'.','');
							$tr_porc5 = number_format($tr_porc5,0,'.','');  
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>25 &agrave; 40</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa1</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc1</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>41 &agrave; 50</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa2</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc2</td>
							</tr>";	
														
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>51 &agrave; 60</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa3</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc3</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>61 ></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa4</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc4</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>N&atilde;o informado</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa5</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc5</td>
							</tr>";
														
							//TOTAIS
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>TOTAL</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_faixa</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc</td>
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
