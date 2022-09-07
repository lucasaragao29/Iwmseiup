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
	$distrito = $_GET["distrito"];
	$regiao   = $_GET["regiao"];
	$ordem    = $_GET["ordem"];
		
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
		$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO		
		$distrito_nome2 = maiuscula($distrito_nome);
		$regiao_nome = maiuscula($regiao_nome);
		
		//DESCRICAO
		if ($distrito > "0") { $descricao_texto = "<br>DISTRITO DE $distrito_nome2 - $regiao_nome - $ano";
		 $frase="do distrito $distrito_nome"; }
		else { $descricao_texto = "<br>$regiao_nome - $ano"; 
		$frase = "da $regiao_nome"; }
		
		 
		
			include "../../config/meuip.php";
		
			//GRAVAR HISTORICO DA ACAO
			$GRAVAR = "INSERT INTO historico_usuario
			(coduser,codregiao,coddistrito, userip,sessao,
			acao,codarquivo,tipo_arquivo,
			data,hora)
			VALUES
			('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
			'Tela de impressao da listagem da Quantidade de membros por igreja $frase no ano de $ano','$dados','pae_membro',
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
            QUANTIDADE DE MEMBROS POR IGREJA<?php echo"$descricao_texto"; ?></strong></p>
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
                        <th style='text-align:center'><h2 style="font-size:13px;color:#000;"><strong></strong></h2></th>
                        <th style='text-align:left'><h2 style="font-size:13px;color:#000;"><strong>IGREJA</strong></h2></th>
                        <?php if ($distrito == "0") 
				{ echo"<th style='text-align:left'><h2 style='font-size:15px;color:#114a66;'><strong>DISTRITO</strong></h2></th>"; 
				}  ?>
                        <th style='text-align:right'><h2 style="font-size:13px;color:#000;"><strong>MEMBROS</strong></h2></th>
                    </tr>
                </thead> 
                    <tbody>
                    
	<?php 
						
                        //IGREJAS
						//ORDENAR POR
						if ($ordem == "1") { $ordem_texto = "order by nome asc "; }
						if ($ordem == "2") { $ordem_texto = "order by distrito asc,nome asc "; }
						
                        //IGREJAS
						if ($distrito > "0") {
                        $qr_mat = "SELECT DISTINCT nome,id,distrito,regiao
						 from pae_igreja WHERE distrito_id = '$distrito' $ordem_texto";
						}
						else {
						 $qr_mat = "SELECT DISTINCT nome,id,distrito,regiao,regiao_id
						 from pae_igreja WHERE regiao_id = '$regiao' $ordem_texto";	
						}
						 
                        $todos_mat = mysql_query("$qr_mat"); 
						$tr_mat = mysql_num_rows($todos_mat);
						$i="0";
                        while ($dados_mat = mysql_fetch_array($todos_mat)) {
						$i++; 
						$nome           = $dados_mat["nome"];
						$igreja_id      = $dados_mat["id"];
						$distrito_nome  =  $dados_mat["distrito"];
						$regiao_nome    = $dados_mat["regiao"];
						
						//REMOVER PALAVRA
						$nome = str_replace("IMW ", "", $nome);
						$distrito_nome = str_replace("Distrito ", "", $distrito_nome);  				
						
							
							//TOTAL
							$qr_idade_t = "SELECT igreja_id,ano_recepcao,ano_exclusao,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE igreja_id='$igreja_id'";
							$todos_idade_t = mysql_query("$qr_idade_t"); 
							while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
							$recebidos  = $dados_idade_t["recebidos"];
							$excluidos   = $dados_idade_t["excluidos"];	
												
							$total = $recebidos-$excluidos;
							
						if ($distrito == "0") {	
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$total</td>
                        </tr>";
						}
						else {
                        echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:right'>$total</td>
                        </tr>";						}
						
							}
                        }
						
						
							//TOTAL GERAL
							if ($distrito == "0") {
							$qr_idade_t = "SELECT distrito_id,ano_recepcao,ano_exclusao,regiao_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE regiao_id='$regiao'";
							}
							else {
							$qr_idade_t = "SELECT distrito_id,ano_recepcao,ano_exclusao,
							SUM(CASE WHEN (ano_recepcao <= '$ano') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro 
							WHERE distrito_id='$distrito'";							}
							$todos_idade_t = mysql_query("$qr_idade_t"); 
							while ($dados_idade_t = mysql_fetch_array($todos_idade_t)) {
							$recebidos           = $dados_idade_t["recebidos"];
							$excluidos           = $dados_idade_t["excluidos"];	
												
							$total_geral = $recebidos-$excluidos;
							

                       echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'></td>
						<td style='font-size:13px;color:#333333;text-align:left'><b>TOTAL</b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>$total_geral</b></td>
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
