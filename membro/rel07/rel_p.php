<?php

	
	session_start(); 	
	$id_user =  $_SESSION['id_user'];
	
	include("../../config/conexao.php");
	include("../../config/config.php");
	include("../../config/maiuscula.php");
	include("../../config/minuscula.php");
	
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
	
	$ano      = $_GET["ano"];
	$ativo    = $_GET["ativo"];
	$regiao   = $_GET["regiao"];
	
	//DESCOBRIR REGIAO
	$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
	$resultado_regiao = mysql_query($result_regiao);		
	while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
	$regiao_nome  = $row_regiao["nome"];
	}
	

	//MAIUSCULO
	
	$regiao_nome2 = maiuscula($regiao_nome);
	
	//DESCRICAO
	$descricao_texto = "<br> $regiao_nome2 - $ano";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao da listagem da recepcao de membros da $regiao_nome por distrito do ano $ano','$dados','pae_membro',
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
            RECEP&Ccedil;&Atilde;O DE MEMBROS<?php echo"$descricao_texto"; ?></strong></p>
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
            <th><h2 style="font-size:13px;color:#000;"><strong></strong></h2></th>
            <th><h2 style="font-size:13px;color:#000;"><strong></strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>ADES&Atilde;O</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>BATISMO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>CADASTRAMENTO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>RECONCILIA&Ccedil;&Atilde;O</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>TRANSF&Ecirc;RENCIA</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
                    <tbody>
                    
						<?php 
						
						
						
						if ($regiao == "0") {  }
						
						else { 
						
						$anterior = $ano-1;
						$anterior2 = $ano-2;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						//$data_anterior = "$anterior-$mes_atual-$dia_atual";
						//$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
							
							$qr_rol_anterior = "SELECT regiao_id,status,distrito_id,modo_recepcao_id,igreja,ano_recepcao,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE STATUS='A'
							AND regiao_id='$regiao'
							AND (ano_recepcao = '$anterior')";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$batismo          = $dados_rol_anterior["batismo"];
							$adesao           = $dados_rol_anterior["adesao"];
							$reconciliacao    = $dados_rol_anterior["reconciliacao"];
							$transferencia    = $dados_rol_anterior["transferencia"];
							$cadastramento    = $dados_rol_anterior["cadastramento"];	
							}
													
							$tr_rol_anterior_total = $batismo+$adesao+$reconciliacao+$transferencia+$cadastramento;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adesao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$batismo</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$cadastramento</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$reconciliacao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$transferencia</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total</b></td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id from pae_distrito WHERE regiao_id='$regiao' order by nome asc ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome    = $dados_mat["nome"];
						$distrito    = $dados_mat["id"];
						$nome = str_replace("Distrito ", "", $nome);  				
	
						
							$qr_regiao = "SELECT departamento,status,distrito_id,dt_recepcao,igreja,ano_recepcao,regiao_id,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE STATUS='A'
							AND distrito_id='$distrito' 
							AND (ano_recepcao = '$ano')";
							$todos_regiao = mysql_query($qr_regiao); 
							$tr_regiao = mysql_num_rows($todos_regiao);
							while ($dados_regiao = mysql_fetch_array($todos_regiao)) {
							$batismo_r          = $dados_regiao["batismo"];
							$adesao_r           = $dados_regiao["adesao"];
							$reconciliacao_r    = $dados_regiao["reconciliacao"];
							$transferencia_r    = $dados_regiao["transferencia"];
							$cadastramento_r    = $dados_regiao["cadastramento"];	
							}
													
							$tr_regiao_total = $batismo_r+$adesao_r+$reconciliacao_r+$transferencia_r+$cadastramento_r;
							
							if ($adesao_r == "") { $adesao_r = "0"; }
							if ($batismo_r == "") { $batismo_r = "0"; }
							if ($cadastramento_r == "") { $cadastramento_r = "0"; }
							if ($reconciliacao_r == "") { $reconciliacao_r = "0"; }
							if ($transferencia_r == "") { $transferencia_r = "0"; }
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:center'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$adesao_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$batismo_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$cadastramento_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$reconciliacao_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$transferencia_r</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$tr_regiao_total</td>
							</tr>";
                        
                        }
						
						//TOTAIS
						
							$qr_rol_atual = "SELECT departamento,status,distrito_id,dt_recepcao,igreja,ano_recepcao,regiao_id,
							SUM(CASE WHEN modo_recepcao_id='1' then 1 ELSE 0 END) AS batismo,
							SUM(CASE WHEN modo_recepcao_id='2' then 1 ELSE 0 END) AS adesao,
							SUM(CASE WHEN modo_recepcao_id='3' then 1 ELSE 0 END) AS reconciliacao,
							SUM(CASE WHEN modo_recepcao_id='4' then 1 ELSE 0 END) AS transferencia,
							SUM(CASE WHEN modo_recepcao_id='5' then 1 ELSE 0 END) AS cadastramento,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE STATUS='A'
							AND regiao_id='$regiao'
							AND (ano_recepcao = '$ano')";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							$tr_rol_atual = mysql_num_rows($todos_rol_atual);
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$batismo          = $dados_rol_atual["batismo"];
							$adesao           = $dados_rol_atual["adesao"];
							$reconciliacao    = $dados_rol_atual["reconciliacao"];
							$transferencia    = $dados_rol_atual["transferencia"];
							$cadastramento    = $dados_rol_atual["cadastramento"];	
							}
													
							$tr_rol_atual_total = $batismo+$adesao+$reconciliacao+$transferencia+$cadastramento;
						
						
							echo"
							<tr style=\"background-color:#fff\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'><strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adesao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adesao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$cadastramento</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$reconciliacao</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$transferencia</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_atual_total</b></td>
							</tr>";						
						

						}
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
