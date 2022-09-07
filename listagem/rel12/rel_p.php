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
		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = " - $regiao_nome";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Listagem',
	'Tela de impressao da listagem fiscal da $regiao_nome','$dados','pae_clerigo',
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
<TABLE WIDTH="950" BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR>
    <TD height="20"><table width="950" height="190" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_">
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
            LISTAGEM FISCAL <?php echo"$descricao_texto"; ?></strong></p>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->
    
    
    
<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="table-responsive">         
                <table class="table table-striped">
                 
                 
       <?php
	   
		//CLERIGO PESQUISADO
		$qr_clerigo = "SELECT regiao,regiao_id, distrito, instituicao, pessoa,
		funcao_ministerial,pessoa_id,data_nomeacao,pessoa_id
		FROM pae_nomeacao
		WHERE data_termino='0000-00-00'
		AND funcao_ministerial_id  IN (7,8,9,18,19,20,23,22,10)
		AND regiao_id = '$regiao'
		ORDER BY pessoa ASC";
		$todos_clerigo = mysql_query($qr_clerigo); 
		$tr_mat = mysql_num_rows($todos_clerigo);
		$i="0";
		while ($dados_clerigo = mysql_fetch_array($todos_clerigo)) {
		$i++; 
		$id_clerigo         = $dados_clerigo["pessoa_id"];
		$nome               = $dados_clerigo["pessoa"];
		$igreja             = $dados_clerigo["instituicao"];
		$distrito           = $dados_clerigo["distrito"];
		$regiao             = $dados_clerigo["regiao"];
		$data_nomeacao      = $dados_clerigo["data_nomeacao"];
		$pessoa_id          = $dados_clerigo["pessoa_id"];
		$funcao_ministerial = $dados_clerigo["funcao_ministerial"];
		
		$nome = maiuscula($nome);
		$igreja = maiuscula($igreja);
		$distrito = maiuscula($distrito);
		$regiao = maiuscula($regiao);
						
		//PARENTES
		$qr_familia_q = "SELECT * FROM pae_clerigo_dependente
		WHERE pessoa_id = '$id_clerigo' 
		ORDER BY parentesco ASC, nascimento ASC";
		$todos_familia_q = mysql_query($qr_familia_q); 
		$tr_familia_q = mysql_num_rows($todos_familia_q);
						
		echo"<thead >
		<tr bgcolor='#000000'>
		<th colspan='4' style='text-align:center'><h2 style='font-size:15px;color:#fff;'><strong>$nome - $igreja - $distrito - $regiao</strong></h2></th>
		</tr>";
		
		if ($tr_familia_q > "0" or $tr_familia_q != "") {
		echo"<tr >
		<th style='text-align:left'><h2 style='font-size:15px;color:#000000;'><strong>PARENTESCO</strong></h2></th>
		<th style='text-align:left'><h2 style='font-size:15px;color:#000000;'><strong>NOME</strong></h2></th>
		<th style='text-align:left'><h2 style='font-size:15px;color:#000000;'><strong>CPF</strong></h2></th> 
		<th style='text-align:left'><h2 style='font-size:15px;color:#000000;'><strong>DATA DE NASCIMENTO</strong></h2></th> 
		</tr>";
		}
		
		if ($tr_familia_q == "0") {  
		
		echo"<tr >
		<th colspan='5' style='text-align:center'><h2 style='font-size:15px;color:#000000;'><strong>N&Atilde;O H&Aacute; PARENTES INFORMADOS</strong></h2></th>
		</tr>";
		
		
		}
		
		echo"</thead> 
		<tbody>";          
                 
			
			//DESCRITIVO
			$qr_familia = "SELECT * FROM pae_clerigo_dependente
			WHERE pessoa_id = '$id_clerigo' 
			ORDER BY parentesco ASC, nascimento ASC";
			
			$todos_familia = mysql_query("$qr_familia"); 
			while ($dados_familia = mysql_fetch_array($todos_familia)) {
			$nome       =  $dados_familia["nome"];
			$cpf        = $dados_familia["cpf"];
			$nascimento = $dados_familia["nascimento"];
			$parentesco = $dados_familia["parentesco"];
			
			$nome = ucwords(strtolower($nome));
			
			//CPF
			if ($cpf == '\N' or $cpf == '') { $monta_cpf = "***"; }
			else {
			$parte_um     = substr($cpf, 0, 3);
			$parte_dois   = substr($cpf, 3, 3);
			$parte_tres   = substr($cpf, 6, 3);
			$parte_quatro = substr($cpf, 9, 2);
			
			$monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
			}
			
			//ANIVERSÁRIO
			$dia_nasc  = date('d', strtotime($nascimento));
			$mes_nasc  = date('m', strtotime($nascimento));
			$ano_nasc  = date('Y', strtotime($nascimento));
			$aniversario = "$dia_nasc/$mes_nasc/$ano_nasc";

			
			//PARENTESCO
			if ($parentesco == "C") { $parentesco_texto = "C&ocirc;njuge";}
			if ($parentesco == "F") { $parentesco_texto = "Filho";}
			
			 echo"<tr>
			<td style='font-size:13px;color:#333333;text-align:left'>$parentesco_texto</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$monta_cpf</td>
			<td style='font-size:13px;color:#333333;text-align:left'>$aniversario</td>
			</tr>";
			
			}
		
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
