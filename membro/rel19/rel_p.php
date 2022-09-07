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
	$descricao_texto = "<br>$regiao_nome2 - $ano";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao da listagem da recepcao de membros da regiao de $regiao_nome do ano $ano','$dados','pae_membro',
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
            ESTAT&Iacute;STICA DE G&Ecirc;NERO<?php echo"$descricao_texto"; ?></strong></p>
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
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>MASCULINO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>FEMININO</strong></h2></th>            
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>INDEFINIDO</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
                    <tbody>
                    
						<?php 
						$anterior = $ano-1;
						
						
						//ROL ANTERIOR 
							
							$qr_rol_anterior = "SELECT regiao_id,status,distrito_id,sexo,igreja,ano_recepcao,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id = '$regiao'
							AND ano_recepcao <= '$anterior'";
							$todos_rol_anterior = mysql_query($qr_rol_anterior); 
							$tr_rol_anterior = mysql_num_rows($todos_rol_anterior);
							while ($dados_rol_anterior = mysql_fetch_array($todos_rol_anterior)) {
							$masculino     = $dados_rol_anterior["masculino"];
							$feminino      = $dados_rol_anterior["feminino"];
							$indefinido    = $dados_rol_anterior["indefinido"];	
							}
							
							$qr_rol_anterior_e = "SELECT distrito_id,sexo,ano_exclusao,status,regiao_id,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id = '$regiao'
							AND ano_exclusao BETWEEN '1' AND '$anterior'";
							$todos_rol_anterior_e = mysql_query($qr_rol_anterior_e); 
							$tr_rol_anterior_e = mysql_num_rows($todos_rol_anterior_e);
							while ($dados_rol_anterior_e = mysql_fetch_array($todos_rol_anterior_e)) {
							$masculino_e     = $dados_rol_anterior_e["masculino"];
							$feminino_e      = $dados_rol_anterior_e["feminino"];
							$indefinido_e    = $dados_rol_anterior_e["indefinido"];	
							}
							
							//TOTAL DO ROL ANTERIOR
							$tr_rol_anterior_total_m = $masculino-$masculino_e;
							$tr_rol_anterior_total_f = $feminino-$feminino_e;
							$tr_rol_anterior_total_n = $indefinido-$indefinido_e;
													
							$tr_rol_anterior_total = $tr_rol_anterior_total_m+$tr_rol_anterior_total_f+$tr_rol_anterior_total_n;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_m</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_f</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total_n</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_anterior_total</b></td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id,regiao_id from pae_distrito
						WHERE regiao_id = '$regiao'
						ORDER BY nome ASC ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome     = $dados_mat["nome"];
						$distrito_id = $dados_mat["id"];  				
	
							//ATIVOS
							$qr_regiao = "SELECT sexo,status,regiao_id,dt_recepcao,igreja,ano_recepcao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE distrito_id='$distrito_id' 
							AND ano_recepcao <= '$ano'";
							$todos_regiao = mysql_query($qr_regiao); 
							$tr_regiao = mysql_num_rows($todos_regiao);
							while ($dados_regiao = mysql_fetch_array($todos_regiao)) {
							$feminino_r      = $dados_regiao["feminino"];
							$masculino_r     = $dados_regiao["masculino"];
							$indefinido_r    = $dados_regiao["indefinido"];	
							}
							
							//INATIVOS
							$qr_regiao_e = "SELECT sexo,status,regiao_id,dt_recepcao,igreja,ano_recepcao,igreja_id,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE distrito_id='$distrito_id' 
							AND ano_exclusao BETWEEN '1' AND '$ano'";
							$todos_regiao_e = mysql_query($qr_regiao_e); 
							$tr_regiao_e = mysql_num_rows($todos_regiao_e);
							while ($dados_regiao_e = mysql_fetch_array($todos_regiao_e)) {
							$feminino_r_e      = $dados_regiao_e["feminino"];
							$masculino_r_e     = $dados_regiao_e["masculino"];
							$indefinido_r_e    = $dados_regiao_e["indefinido"];	
							}
							
							$masculinos  = $masculino_r-$masculino_r_e;
							$femininos   = $feminino_r-$feminino_r_e;
							$indefinidos = $indefinido_r-$indefinido_r_e;
													
							$tr_regiao_total = $femininos+$masculinos+$indefinidos;
							
							echo"<tr>
							<td style='font-size:13px;color:#333333;text-align:center'>$i</td>
							<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$masculinos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$femininos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$indefinidos</td>
							<td style='font-size:13px;color:#333333;text-align:right'>$tr_regiao_total</td>
							</tr>";
                        
                        }
						
						//TOTAIS
						
							$qr_rol_atual = "SELECT regiao_id,status,distrito_id,sexo,igreja,ano_recepcao,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id = '$regiao'
							AND ano_recepcao <= '$ano'";
							$todos_rol_atual = mysql_query($qr_rol_atual); 
							while ($dados_rol_atual = mysql_fetch_array($todos_rol_atual)) {
							$masculino     = $dados_rol_atual["masculino"];
							$feminino      = $dados_rol_atual["feminino"];
							$indefinido    = $dados_rol_atual["indefinido"];	
							}
							
							
							$qr_rol_atual_e = "SELECT distrito_id,sexo,ano_exclusao,status,regiao_id,
							SUM(CASE WHEN sexo='M' then 1 ELSE 0 END) AS masculino,
							SUM(CASE WHEN sexo='F' then 1 ELSE 0 END) AS feminino,
							SUM(CASE WHEN sexo='' then 1 ELSE 0 END) AS indefinido,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id = '$regiao'
							AND ano_exclusao BETWEEN '1' AND '$ano'";
							$todos_rol_atual_e = mysql_query($qr_rol_atual_e); 
							while ($dados_rol_atual_e = mysql_fetch_array($todos_rol_atual_e)) {
							$masculino_e     = $dados_rol_atual_e["masculino"];
							$feminino_e      = $dados_rol_atual_e["feminino"];
							$indefinido_e    = $dados_rol_atual_e["indefinido"];	
							}
							
							$masculino_atual = $masculino-$masculino_e;
							$feminino_atual = $feminino-$feminino_e;
							$indefinido_atual = $indefinido-$indefinido_e;
													
							$tr_rol_atual_total = $masculino_atual+$feminino_atual+$indefinido_atual;
						
							echo"
							<tr style=\"background-color:#fff\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'><strong>ROL [$ano]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$masculino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$feminino_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$indefinido_atual</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_rol_atual_total</b></td>
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
