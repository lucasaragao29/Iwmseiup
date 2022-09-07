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
	
	//DESCRICAO
	$descricao_texto = " GERAL - $ano";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao da listagem de Membros por departamento geral do ano $ano','$dados','pae_membro',
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
            <th><h2 style="font-size:15px;color:#000000;"><strong></strong></h2></th>
            <th><h2 style="font-size:15px;color:#000000;"><strong></strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>CRIAN&Ccedil;AS</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>PR&Eacute;</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>ADOLESCENTES</strong></h2></th>
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>JOVENS</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>ADULTOS</strong></h2></th> 
            <th style='text-align:right'><h2 style="font-size:15px;color:#000000;"><strong>TOTAL</strong></h2></th> 
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
						
						//GROUP BY igreja
							//ORDER BY igreja
						
							//ROL ANTEIOR ATIVOS
							$qr_rol_anterior = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$anterior') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$anterior') 
							then 1 ELSE 0 END)) as criancas,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							
							";
							$resultado_rol_anterior = mysql_query($qr_rol_anterior);		
							while ($row_rol_anterior = mysql_fetch_assoc($resultado_rol_anterior) ) {
							$adultos_total       = $row_rol_anterior["adultos"];
							$jovens_total        = $row_rol_anterior["jovens"];
							$adolescentes_total  = $row_rol_anterior["adolescentes"];
							$pre_total           = $row_rol_anterior["pre"];
							$criancas_total      = $row_rol_anterior["criancas"];
							}

							$tr_anterior_total = $adultos_total+$jovens_total+$adolescentes_total+$pre_total+$criancas_total;
							
							echo"
							<tr style=\"background-color:#000000\">
							<td style='font-size:13px;color:#333333;'></td>
							<td style='font-size:13px;color:#333333;text-align:left'>
							<strong>ROL ANTERIOR [$anterior]</strong></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$criancas_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$pre_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adolescentes_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$jovens_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$adultos_total</b></td>
							<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_anterior_total</b></td>
							</tr>";
																				
						
							//QUANTIDADE DE MEMBROS POR DEPARTAMENTO
							$qr_idade_e = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,distrito_id,
							distrito,regiao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as criancas,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							GROUP BY regiao_id
							ORDER BY regiao ASC";
							$i = "0";
							$resultado_igrejas_e = mysql_query($qr_idade_e);		
							while ($row_igrejas_e = mysql_fetch_assoc($resultado_igrejas_e) ) {
							$i++;
							$adulto_rt       = $row_igrejas_e["adultos"];
							$joven_rt        = $row_igrejas_e["jovens"];
							$adolescente_rt  = $row_igrejas_e["adolescentes"];
							$pre_rt          = $row_igrejas_e["pre"];
							$crianca_rt      = $row_igrejas_e["criancas"];
							$nome            = $row_igrejas_e["regiao"];
							
						
						$tr_rt = $adulto_rt+$joven_rt+$adolescente_rt+$pre_rt+$crianca_rt;							

                       
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$crianca_rt</td>
                        <td style='font-size:13px;color:#333333;text-align:right'>$pre_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$adolescente_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$joven_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$adulto_rt</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$tr_rt</td>
                        </tr>";
                        
                        }
						
						//TOTAIS
						
						$qr_rol_atual = "SELECT departamento,status,regiao_id,ano_recepcao,igreja,dt_exclusao,
							(SUM(CASE WHEN (departamento='adultos' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adultos' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adultos,
							
							(SUM(CASE WHEN (departamento='jovens' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='jovens' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as jovens,
							
							(SUM(CASE WHEN (departamento='adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as adolescentes,
							
							(SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='pre-adolescentes' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as pre,
							
							(SUM(CASE WHEN (departamento='criancas' AND ano_recepcao <= '$ano') then 1 ELSE 0 END) 
							- SUM(CASE WHEN (departamento='criancas' AND ano_exclusao BETWEEN '1' AND '$ano') 
							then 1 ELSE 0 END)) as criancas,
							
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id IN (13,17,18,19,22,23,24,25)
							";
							
							$resultado_rol_atual = mysql_query($qr_rol_atual);		
							while ($row_rol_atual = mysql_fetch_assoc($resultado_rol_atual) ) {
							$adultos_atual_total       = $row_rol_atual["adultos"];
							$jovens_atual_total        = $row_rol_atual["jovens"];
							$adolescentes_atual_total  = $row_rol_atual["adolescentes"];
							$pre_atual_total           = $row_rol_atual["pre"];
							$criancas_atual_total      = $row_rol_atual["criancas"];
							}
						
						
							$tr_atual_total = $adultos_atual_total+$jovens_atual_total+$adolescentes_atual_total+$pre_atual_total+$criancas_atual_total;		
						
						echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>ROL ATUAL[$ano]</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$criancas_atual_total</b></td>
                        <td style='font-size:13px;color:#333333;text-align:right'><b>$pre_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$adolescentes_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$jovens_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$adultos_atual_total</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$tr_atual_total</b></td>
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
