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
	
	$funcao   = $_GET["funcao"];
	
		//FUNCOES
		if ($funcao == "0") { $funcao_nome = "Todos"; }
		if ($funcao == "7") { $funcao_nome = "Co-pastor"; }
		if ($funcao == "8") { $funcao_nome = "Ministro Integral"; }
		if ($funcao == "9") { $funcao_nome = "Pastor Titular Integral"; }
		if ($funcao == "18") { $funcao_nome = "Ministro Parcial"; }
		if ($funcao == "19") { $funcao_nome = "Pastor Titular Parcial"; }
		if ($funcao == "11") { $funcao_nome = "Missionária"; }
		if ($funcao == "20") { $funcao_nome = "Pastor Ajudante Parcial"; }
		if ($funcao == "23") { $funcao_nome = "Pastor Ajudante (sem ônus)"; }
		if ($funcao == "24") { $funcao_nome = "Missionária (sem ônus)"; }
		if ($funcao == "22") { $funcao_nome = "Pastor Titular (sem ônus)"; }
		if ($funcao == "10") { $funcao_nome = "Pastor Ajudante Intergral"; }
		
		$funcao_nome = utf8_decode($funcao_nome);
		
		//APAGAR A PALAVRA
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		$funcao_nome2 = maiuscula($funcao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>$funcao_nome2";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Listagem',
	'Tela de impressao da listagem de clerigos ($funcao_nome) geral','$dados','pae_clerigo',
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
            LISTAGEM DE CL&Eacute;RIGOS GERAL<?php echo"$descricao_texto"; ?></strong></p>
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
                    <th style='text-align:center'><h2 style="font-size:15px;color:#000;"><strong></strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>NOME</strong></h2></th>
                    
                    <?php 
                    if ($funcao == "0") { 
                    echo "<th style='text-align:left'><h2 style='font-size:15px;color:#000;'><strong>FUN&Ccedil;&Atilde;O</strong></h2></th>";
                    }
                    
                    ?>
                    
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>IGREJA</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>DISTRITO</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>REGI&Atilde;O</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>ANIVER.</strong></h2></th>
                    <th style='text-align:left'><h2 style="font-size:15px;color:#000;"><strong>NOMEA&Ccedil;&Atilde;O</strong></h2></th>
                </tr>
            </thead> 
            <tbody>
            
			<?php 
            
			//DATA
            $anterior = $ano-1;
            
            $hoje = getdate();
            $ano_atual = $hoje["year"];
            $mes_atual = $hoje["mon"];
            $dia_atual = $hoje["mday"];
            
            if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
            if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
            
            $data_atual = "$ano_atual-$mes_atual-$dia_atual";
            
			//FUNCAO
            if ($funcao == "0") { $funcao_texto = "AND funcao_ministerial_id  IN (7,8,9,18,19,11,20,23,24,22,10)"; }
			 else { $funcao_texto = "AND funcao_ministerial_id = '$funcao'"; }	
                                                                
            //CLERIGO PESQUISADO
            $qr_clerigo = "SELECT regiao,regiao_id, distrito, instituicao, pessoa, funcao_ministerial,pessoa_id,data_nomeacao
            FROM pae_nomeacao
            WHERE funcao_ministerial_id NOT IN (1,2,3,4,5,6)
            AND data_termino='0000-00-00'
            $funcao_texto
			AND regiao_id IN (13,25,17,18,19,24,23,22)
            ORDER BY regiao, distrito, instituicao";
            $todos_clerigo = mysql_query($qr_clerigo); 
            $tr_mat = mysql_num_rows($todos_clerigo);
            $i="0";
            while ($dados_clerigo = mysql_fetch_array($todos_clerigo)) {
            $i++; 
            $nome               = $dados_clerigo["pessoa"];
            $igreja             = $dados_clerigo["instituicao"];
            $distrito           = $dados_clerigo["distrito"];
            $regiao             = $dados_clerigo["regiao"];
            $data_nomeacao      = $dados_clerigo["data_nomeacao"];
            $pessoa_id          = $dados_clerigo["pessoa_id"];
            $funcao_ministerial = $dados_clerigo["funcao_ministerial"];
			
            //DATA DE NASCIMENTO
            $qr_clerigo2 = "SELECT * FROM pae_clerigo
            WHERE id = '$pessoa_id'";
            $todos_clerigo2 = mysql_query($qr_clerigo2); 
            while ($dados_clerigo2 = mysql_fetch_array($todos_clerigo2)) {
            $niver   = $dados_clerigo2["data_nascimento"];
            }
            
            //DATA DE NASCIMENTO
            $dianasc = date('d', strtotime($niver));
            $mesnasc = date('m', strtotime($niver));
            $anonasc = date('Y', strtotime($data_nomeacao));
            $niver_texto = "$dianasc/$mesnasc";
            
            //NOMEACAO
            $dian = date('d', strtotime($data_nomeacao));
            $mesn = date('m', strtotime($data_nomeacao));
            $anon = date('Y', strtotime($data_nomeacao));
            $nomeacao_texto = "$dian/$mesn/$anon";
            
            if ($distrito == "") { $distrito = "-";  }
            
            //REMOVER PALAVRA
            $distrito = str_replace("Distrito ", "", $distrito);
            $igreja = str_replace("IMW ", "", $igreja);  				

            echo"<tr>
            <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$nome</td>";
            
            if ($funcao == "0") { 
            echo"<td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$funcao_ministerial</td>"; }						
            
            echo"<td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$igreja</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$distrito</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$regiao</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$niver_texto</td>
            <td style='font-size:13px;color:#333333;text-align:left;text-transform:capitalize;'>$nomeacao_texto</td>
            </tr>";

            }
            ?>                                            </tbody>
                
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
