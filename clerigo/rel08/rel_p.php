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
	
		$regiao   = $_GET["regiao"];
		

		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}
		
		//MAIUSCULO
		$regiao_nome2   = maiuscula($regiao_nome);
		$distrito_nome2 = maiuscula($distrito_nome);
		$status2        = maiuscula($status2);
		
		//DESCRICAO
		$descricao_texto = "$regiao_nome2";
		
				
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Clerigo',
	'Tela de impressao da estatistica de clerigos da $regiao_nome','$dados','pae_clerigo',
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
            ESTAT&Iacute;STICA CL&Eacute;RIGOS DA <?php echo"$descricao_texto"; ?></strong></p>
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
        <th style='text-align:left'><h2 style="font-size:15px;color:#114a66;"><strong>FUN&Ccedil;&Atilde;O</strong></h2></th>
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
						
							//CLERIGO PESQUISADO
							//$qr_bispos = "SELECT regiao, distrito, instituicao, pessoa, funcao_ministerial,
							//SUM(CASE WHEN funcao_ministerial_id='3' then 1 ELSE 0 END) AS Bispo,
							//COUNT(*) AS Total															  
							//FROM pae_nomeacao
							///WHERE data_termino='0000-00-00' and instituicao_id='$regiao'";
							//$todos_bispos = mysql_query("$qr_bispos"); 
							//while ($dados_bispos = mysql_fetch_array($todos_bispos)) {
							//$Bispo = $dados_bispos["Bispo"];
							//}

							//CLERIGO PESQUISADO
							$qr_clerigos = "SELECT regiao, distrito, instituicao, pessoa, funcao_ministerial,
							SUM(CASE WHEN funcao_ministerial_id='3' then 1 ELSE 0 END) AS Bispo,
							SUM(CASE WHEN funcao_ministerial_id='7' then 1 ELSE 0 END) AS Copastor,
							SUM(CASE WHEN funcao_ministerial_id='8' then 1 ELSE 0 END) AS Ministro_integral,
							SUM(CASE WHEN funcao_ministerial_id='9' then 1 ELSE 0 END) AS Pastor_titular_integral,
							SUM(CASE WHEN funcao_ministerial_id='18' then 1 ELSE 0 END) AS Ministro_parcial,
							SUM(CASE WHEN funcao_ministerial_id='19' then 1 ELSE 0 END) AS Pastor_titular_parcial,
							SUM(CASE WHEN funcao_ministerial_id='11' then 1 ELSE 0 END) AS missionaria,
							SUM(CASE WHEN funcao_ministerial_id='20' then 1 ELSE 0 END) AS Pastor_ajudante_parcial,
							SUM(CASE WHEN funcao_ministerial_id='23' then 1 ELSE 0 END) AS Pastor_ajudante_onus,
							SUM(CASE WHEN funcao_ministerial_id='24' then 1 ELSE 0 END) AS missionaria_onus,
							SUM(CASE WHEN funcao_ministerial_id='22' then 1 ELSE 0 END) AS Pastor_titular_onus,
							SUM(CASE WHEN funcao_ministerial_id='10' then 1 ELSE 0 END) AS Pastor_ajudante_integral,
							COUNT(*) AS Total															  
							FROM pae_nomeacao
							WHERE data_termino='0000-00-00' and regiao_id='$regiao'";
							$todos_clerigos = mysql_query("$qr_clerigos"); 
							while ($dados_clerigos = mysql_fetch_array($todos_clerigos)) {
							$Bispo                    = $dados_clerigos["Bispo"];
							$Copastor                 = $dados_clerigos["Copastor"];
							$Ministro_integral        = $dados_clerigos["Ministro_integral"];
							$Pastor_titular_integral  = $dados_clerigos["Pastor_titular_integral"];
							$Ministro_parcial         = $dados_clerigos["Ministro_parcial"];
							$Pastor_titular_parcial   = $dados_clerigos["Pastor_titular_parcial"];
							$missionaria              = $dados_clerigos["missionaria"];
							$Pastor_ajudante_parcial  = $dados_clerigos["Pastor_ajudante_parcial"];
							$Pastor_ajudante_onus     = $dados_clerigos["Pastor_ajudante_onus"];
							$missionaria_onus         = $dados_clerigos["missionaria_onus"];
							$Pastor_titular_onus      = $dados_clerigos["Pastor_titular_onus"];
							$Pastor_ajudante_integral = $dados_clerigos["Pastor_ajudante_integral"];
							
							$pastor = $Copastor+$Pastor_titular_integral+$Pastor_titular_parcial+
							$Pastor_ajudante_parcial+$Pastor_ajudante_onus+$Pastor_titular_onus+$Pastor_ajudante_integral;
							
							$ministro = $Ministro_integral+$Ministro_parcial+$missionaria_onus;
							
							$missionaria = $missionaria+$missionaria_onus;
							
							$clerigos_total = $pastor+$bispo+$ministro+$missionaria;
							
		
							//PORCENTAGEM
							$tr_porc_bispo       = (100*$Bispo)/$clerigos_total;
							$tr_porc_pastor      = (100*$pastor)/$clerigos_total;
							$tr_porc_ministro    = (100*$ministro)/$clerigos_total;
							$tr_porc_missionaria = (100*$missionaria)/$clerigos_total;
							$tr_porc  = "100";
							
							$tr_porc_bispo = number_format($tr_porc_bispo,0,'.',''); 
							$tr_porc_pastor = number_format($tr_porc_pastor,0,'.',''); 
							$tr_porc_ministro = number_format($tr_porc_ministro,0,'.',''); 
							$tr_porc_missionaria = number_format($tr_porc_missionaria,0,'.','');
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>Bispos</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$Bispo</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc_bispo</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>Ministros</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$ministro</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc_ministro</td>
							</tr>";	
														
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>Pastores</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$pastor</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc_pastor</td>
							</tr>";	
							
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>Mission&aacute;rias</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$missionaria</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc_missionaria</td>
							</tr>";	

														
							//TOTAIS
							echo"<tr style=\"background-color:#\">
							<td style='font-size:13px;color:#333333;text-align:left'>TOTAL</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$clerigos_total</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_porc</td>
							</tr>";	
							
							
							}
							
                        ?>                          </tbody>
                
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
