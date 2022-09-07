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
		if ($regiao == "0") { $regiao_nome = "Geral"; }
		else {
			$result_regiao = "SELECT * FROM pae_regiao WHERE id='$regiao'";
			$resultado_regiao = mysql_query($result_regiao);		
			while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
			$regiao_nome  = $row_regiao["nome"];
			}
		}
		
		//MAIUSCULO
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "$regiao_nome2";
		
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Totalizacao',
	'Tela de impressao da listagem de totalizacao de membros + clerigos - $regiao_nome','$dados','pae_membro',
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
            TOTALIZA&Ccedil;&Atilde;O DE MEMBROS + CL&Eacute;RIGOS  <?php echo"$descricao_texto"; ?></strong></p>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->
    
    
    
<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="table-responsive">         
                <table class="table table-striped">
                
 
 <?php 
 
	 if ($regiao == "0") {               
		echo"
		<thead>
		<tr>
			<th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>REGI&Atilde;O</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>MEMBROS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>CL&Eacute;RIGOS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>TOTAL</strong></h2></th>
		</tr>
		</thead>"; 
	 }
	 
	 else { 
	 
	 echo"
		<thead>
		<tr>
			<th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>DISTRITO</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>MEMBROS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>CL&Eacute;RIGOS</strong></h2></th>
			<th style='text-align:right'><h2 style='font-size:15px;color:#000;'><strong>TOTAL</strong></h2></th>
		</tr>
		</thead>"; 
	 
	 }
	 
	 
?>
    <tbody>

		<?php 
        
		if ($regiao == "0") {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];

            //REGIOES
            $qr_regiao = "SELECT * FROM pae_regiao 
            WHERE id IN (13,17,18,19,22,23,24,25)
			ORDER BY id ASC";
            $resultado_regiao = mysql_query($qr_regiao);
            while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
            $regiao_nome  = $row_regiao["nome"];
            $regiao_id    = $row_regiao["id"];
   
                //MEMBROS
				$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
				SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
				COUNT(*) AS Total
				FROM pae_membro
				WHERE regiao_id = '$regiao_id'";
				$todos_membros = mysql_query("$qr_membros"); 
				while ($dados_membros = mysql_fetch_array($todos_membros)) {
				$recebidos_membros  = $dados_membros["recebidos"];
				$excluidos_membros  = $dados_membros["excluidos"];
				
				$membros_total = $recebidos_membros-$excluidos_membros;
				
				}
				
				//CLERIGOS
				$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
				FROM pae_clerigo
				WHERE status='Ativo'  AND regiao_id ='$regiao_id'";
				$todos_clerigo = mysql_query($qr_clerigo);
				$clerigos_total = mysql_num_rows($todos_clerigo);
				
				$total = $membros_total+$clerigos_total;
				
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$regiao_nome</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$membros_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$clerigos_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//MEMBROS
			$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
			SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
			COUNT(*) AS Total
			FROM pae_membro
			WHERE regiao_id IN (13,17,18,19,22,23,24,25)";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$recebidos_membros  = $dados_membros["recebidos"];
			$excluidos_membros  = $dados_membros["excluidos"];
			
			$membros_total = $recebidos_membros-$excluidos_membros;
			
			}
			
			//CLERIGOS
			$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
			FROM pae_clerigo
			WHERE status='Ativo'  AND regiao_id IN (13,17,18,19,22,23,24,25)";
			$todos_clerigo = mysql_query($qr_clerigo);
			$clerigos_total = mysql_num_rows($todos_clerigo);
			
			$total = $membros_total+$clerigos_total;
			
			echo"
			<tr >
			<td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$membros_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$clerigos_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$total</strong></td>
			</tr>";

			
			
        
		}
		
		else {
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
			$mes_atual = $hoje["mon"];
			$dia_atual = $hoje["mday"];

            //DISTRITOS
            $qr_regiao = "SELECT DISTINCT nome,regiao_id,id FROM pae_distrito 
            WHERE regiao_id = '$regiao'
			ORDER BY nome ASC";
            $resultado_regiao = mysql_query($qr_regiao);
            while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
            $distrito_nome  = $row_regiao["nome"];
            $distrito_id    = $row_regiao["id"];
			
			$distrito_nome = str_replace("Distrito ", "", $distrito_nome);

   
                //MEMBROS
				$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,distrito_id,
				SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
				SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
				COUNT(*) AS Total
				FROM pae_membro
				WHERE distrito_id = '$distrito_id'";
				$todos_membros = mysql_query("$qr_membros"); 
				while ($dados_membros = mysql_fetch_array($todos_membros)) {
				$recebidos_membros  = $dados_membros["recebidos"];
				$excluidos_membros  = $dados_membros["excluidos"];
				
				$membros_total = $recebidos_membros-$excluidos_membros;
				
				}
				
				//CLERIGOS
				$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
				FROM pae_clerigo
				WHERE status='Ativo'  AND distrito_id ='$distrito_id'";
				$todos_clerigo = mysql_query($qr_clerigo);
				$clerigos_total = mysql_num_rows($todos_clerigo);
				
				$total = $membros_total+$clerigos_total;
				
            echo"
            <tr >
            <td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$membros_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$clerigos_total</td>
            <td style='font-size:13px;color:#333333;text-align:right'>$total</td>
            </tr>";
			
			
			}
			
			//TOTALIZAÇÃO
			//MEMBROS
			$qr_membros = "SELECT ano_recepcao,regiao_id,distrito_id,
			SUM(CASE WHEN (ano_recepcao <= '$ano_atual') then 1 ELSE 0 END) AS recebidos,
			SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_atual') then 1 ELSE 0 END) AS excluidos,
			COUNT(*) AS Total
			FROM pae_membro
			WHERE regiao_id = '$regiao'";
			$todos_membros = mysql_query("$qr_membros"); 
			while ($dados_membros = mysql_fetch_array($todos_membros)) {
			$recebidos_membros  = $dados_membros["recebidos"];
			$excluidos_membros  = $dados_membros["excluidos"];
			
			$membros_total = $recebidos_membros-$excluidos_membros;
			
			}
			
			//CLERIGOS
			$qr_clerigo = "SELECT DISTINCT nome,distrito,distrito_id,regiao_id,status,igreja,regiao
			FROM pae_clerigo
			WHERE status='Ativo'  AND regiao_id = '$regiao_id'";
			$todos_clerigo = mysql_query($qr_clerigo);
			$clerigos_total = mysql_num_rows($todos_clerigo);
			
			$total = $membros_total+$clerigos_total;
			
			echo"
			<tr >
			<td style='font-size:13px;color:#333333;text-align:left'><strong>TOTAL</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$membros_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$clerigos_total</strong></td>
			<td style='font-size:13px;color:#333333;text-align:right'><strong>$total</strong></td>
			</tr>";			
		}
        
        ?>
                        
                    </tbody>

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
