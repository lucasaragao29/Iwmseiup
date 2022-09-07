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
	$descricao_texto = " DA $regiao_nome2 - $ano";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao da listagem de Membros por departamento da $regiao_nome do ano $ano','$dados','pae_membro',
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
            MEMBROS POR DEPARTAMENTO<?php echo"$descricao_texto"; ?></strong></p>
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
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>DISTRITO</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>CRIAN&Ccedil;AS</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>PR&Eacute;</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>ADOLESCENTES</strong></h2></th>
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>JOVENS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>ADULTOS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>INDEFINIDOS</strong></h2></th> 
            <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong>TOTAL</strong></h2></th> 
        </tr>
    </thead> 
                    <tbody>
                    
						<?php 
						
						
						$anterior = $ano-1;
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];
						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_anterior = "$anterior-$mes_atual-$dia_atual";
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ROL ANTERIOR 
						
							//CRIANÇAS
							$qr_idade_c_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 0 and 9)  
							 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_c_r = mysql_query("$qr_idade_c_r"); 
							$tr_idade_c_r = mysql_num_rows($todos_idade_c_r);
							
							//EXCLUSÕES 2019
							$qr_idade_c_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 0 and 9) and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
							$todos_idade_c_r_ex = mysql_query("$qr_idade_c_r_ex"); 
							$tr_idade_c_r_ex = mysql_num_rows($todos_idade_c_r_ex);
	
							//PRE ADOWES
							$qr_idade_p_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 10 and 13)  
							 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_p_r = mysql_query("$qr_idade_p_r"); 
							$tr_idade_p_r = mysql_num_rows($todos_idade_p_r);	
							
							$qr_idade_p_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 10 and 13) and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
							$todos_idade_p_r_ex = mysql_query("$qr_idade_p_r_ex"); 
							$tr_idade_p_r_ex = mysql_num_rows($todos_idade_p_r_ex);					
	
							//ADOWES
							$qr_idade_a_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 14 and 17)  
							 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_a_r = mysql_query("$qr_idade_a_r"); 
							$tr_idade_a_r = mysql_num_rows($todos_idade_a_r);						
							
							$qr_idade_a_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 14 and 17)  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
							$todos_idade_a_r_ex = mysql_query("$qr_idade_a_r_ex"); 
							$tr_idade_a_r_ex = mysql_num_rows($todos_idade_a_r_ex);
								
							//JOVENS
							$qr_idade_j_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 18 and 30)  
							 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_j_r = mysql_query("$qr_idade_j_r"); 
							$tr_idade_j_r = mysql_num_rows($todos_idade_j_r);

							$qr_idade_j_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 18 and 30)  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
							$todos_idade_j_r_ex = mysql_query("$qr_idade_j_r_ex"); 
							$tr_idade_j_r_ex = mysql_num_rows($todos_idade_j_r_ex);
								
							//ADULTOS
							$qr_idade_ad_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 31 and 120)  and 
							regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
							$todos_idade_ad_r = mysql_query("$qr_idade_ad_r"); 
							$tr_idade_ad_r = mysql_num_rows($todos_idade_ad_r);
							
							$qr_idade_ad_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) 
							- (RIGHT('$data_anterior',5) <RIGHT(data_nascimento,5)) AS 
							idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao	 FROM pae_membro 
							WHERE ((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 31 and 120)  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'";
							$todos_idade_ad_r_ex = mysql_query("$qr_idade_ad_r_ex"); 
							$tr_idade_ad_r_ex = mysql_num_rows($todos_idade_ad_r_ex);
	
							//INDEFINIDO
							$qr_idade_i_r = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE (((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and 
							regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01' 
							and data_nascimento = '0000-00-00') or
							(((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and 
							regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'
							 and data_nascimento != '0000-00-00') ";
							$todos_idade_i_r = mysql_query("$qr_idade_i_r"); 
							$tr_idade_i_r = mysql_num_rows($todos_idade_i_r);
							
							$qr_idade_i_r_ex = "SELECT (YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
							 FROM pae_membro 
							WHERE (((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'
							and data_nascimento = '0000-00-00') or
							(((YEAR('$data_anterior')-YEAR(data_nascimento)) - (RIGHT('$data_anterior',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and regiao_id = '$regiao' and status='I' and ano_exclusao = '$ano'
							 and data_nascimento != '0000-00-00') ";
							$todos_idade_i_r_ex = mysql_query("$qr_idade_i_r_ex"); 
							$tr_idade_i_r_ex = mysql_num_rows($todos_idade_i_r_ex);	
							
							$tr_idade_c_r  = $tr_idade_c_r+$tr_idade_c_r_ex;
							$tr_idade_p_r  = $tr_idade_p_r+$tr_idade_p_r_ex;
							$tr_idade_a_r  = $tr_idade_a_r+$tr_idade_a_r_ex;
							$tr_idade_j_r  = $tr_idade_j_r+$tr_idade_j_r_ex;
							$tr_idade_ad_r = $tr_idade_ad_r+$tr_idade_ad_r_ex;
							$tr_idade_i_r  = $tr_idade_i_r+$tr_idade_i_r_ex;
							$tr_idade_t_r  = $tr_idade_t_r+$tr_idade_t_r_ex;
							
							$tr_idade_t_r = $tr_idade_c_r+$tr_idade_p_r+$tr_idade_a_r+$tr_idade_j_r+$tr_idade_ad_r+$tr_idade_i_r;
							
							echo"
							<tr style=\"background-color:#114a66\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL ANTERIOR [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:center'></td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_c_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_p_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_a_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_j_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_ad_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_i_r</td>
							<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_t_r</td>
							</tr>";
																				
                        //REGIAO
                        $qr_mat = "SELECT DISTINCT nome,id,distrito from pae_igreja WHERE regiao_id = '$regiao' 
						order by distrito asc, nome asc ";
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome       = $dados_mat["nome"];
						$igreja_id  = $dados_mat["id"];
						$distrito   = $dados_mat["distrito"];	
						
						$nome = str_replace("IMW ", "", $nome);
						$distrito = str_replace("Distrito ", "", $distrito);  				
						
							//CRIANÇAS
							$qr_idade_c = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao 
							FROM pae_membro 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 0 and 9)  and igreja_id='$igreja_id' and status='A'  and dt_recepcao <= '$ano-11-01'";
							$todos_idade_c = mysql_query("$qr_idade_c"); 
							$tr_idade_c = mysql_num_rows($todos_idade_c);
							
							//PRE ADOWES
							$qr_idade_p = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 10 and 13)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_p = mysql_query("$qr_idade_p"); 
							$tr_idade_p = mysql_num_rows($todos_idade_p);						
							
							//ADOWES
							$qr_idade_a = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 14 and 17)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_a = mysql_query("$qr_idade_a"); 
							$tr_idade_a = mysql_num_rows($todos_idade_a);						
							
							//JOVENS
							$qr_idade_j = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 18 and 30)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_j = mysql_query("$qr_idade_j"); 
							$tr_idade_j = mysql_num_rows($todos_idade_j);
							
							//ADULTOS
							$qr_idade_ad = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao
							 FROM pae_membro 
							WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 31 and 120)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'";
							$todos_idade_ad = mysql_query("$qr_idade_ad"); 
							$tr_idade_ad = mysql_num_rows($todos_idade_ad);
							
							//INDEFINIDO
							$qr_idade_i = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,igreja_id,
							dt_recepcao
							 FROM pae_membro 
							WHERE (((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01' 
							and data_nascimento = '0000-00-00') or
							(((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
							<RIGHT(data_nascimento,5))
							BETWEEN 121 and 7000)  and igreja_id='$igreja_id' and status='A' and dt_recepcao <= '$ano-11-01'
							 and data_nascimento != '0000-00-00')";
							$todos_idade_i = mysql_query("$qr_idade_i"); 
							$tr_idade_i = mysql_num_rows($todos_idade_i);
													
							$tr_idade_t = $tr_idade_c+$tr_idade_p+$tr_idade_a+$tr_idade_j+$tr_idade_ad+$tr_idade_i;
							

                       
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_c</td>
                        <td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_p</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_a</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_j</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_ad</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_i</td>
						<td style='font-size:13px;color:#333333;text-align:center'>$tr_idade_t</td>
                        </tr>";
                        
                        }
						
						//TOTAIS
						
						//CRIANÇAS
						$qr_idade_c_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
						 FROM pae_membro 
						WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 0 and 9)  
						 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_c_t = mysql_query("$qr_idade_c_t"); 
						$tr_idade_c_t = mysql_num_rows($todos_idade_c_t);

						//PRE ADOWES
						$qr_idade_p_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
						 FROM pae_membro 
						WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 10 and 13)  
						 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_p_t = mysql_query("$qr_idade_p_t"); 
						$tr_idade_p_t = mysql_num_rows($todos_idade_p_t);						

						//ADOWES
						$qr_idade_a_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id FROM pae_membro 
						WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 14 and 17)  
						 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_a_t = mysql_query("$qr_idade_a_t"); 
						$tr_idade_a_t = mysql_num_rows($todos_idade_a_t);						

						//JOVENS
						$qr_idade_j_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
						 FROM pae_membro 
						WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 18 and 30)  
						 and regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_j_t = mysql_query("$qr_idade_j_t"); 
						$tr_idade_j_t = mysql_num_rows($todos_idade_j_t);

						//ADULTOS
						$qr_idade_ad_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
						 FROM pae_membro 
						WHERE ((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 31 and 120)  and 
						regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'";
						$todos_idade_ad_t = mysql_query("$qr_idade_ad_t"); 
						$tr_idade_ad_t = mysql_num_rows($todos_idade_ad_t);
						
						//INDEFINIDO
						$qr_idade_i_t = "SELECT (YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5)) AS idade,nome,regiao_id,data_nascimento,status,distrito_id,dt_recepcao
						 FROM pae_membro 
						WHERE (((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 121 and 7000)  and 
						regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'
						 and data_nascimento = '0000-00-00') or
						(((YEAR('$data_atual')-YEAR(data_nascimento)) - (RIGHT('$data_atual',5)
						<RIGHT(data_nascimento,5))
						BETWEEN 121 and 7000)  and 
						regiao_id = '$regiao' and status='A' and dt_recepcao <= '$anterior-11-01'
						 and data_nascimento != '0000-00-00')";
						$todos_idade_i_t = mysql_query("$qr_idade_i_t"); 
						$tr_idade_i_t = mysql_num_rows($todos_idade_i_t);	
						
												
						$tr_idade_t_t = $tr_idade_c_t+$tr_idade_p_t+$tr_idade_a_t+$tr_idade_j_t+$tr_idade_ad_t+$tr_idade_i_t;
						
						
						echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>ROL ATUAL[$ano]</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b></b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_c_t</b></td>
                        <td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_p_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_a_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_j_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_ad_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_i_t</b></td>
						<td style='font-size:13px;color:#333333;text-align:center'><b>$tr_idade_t_t</b></td>
                        </tr>";

                        ?>                    </tbody>
                
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
