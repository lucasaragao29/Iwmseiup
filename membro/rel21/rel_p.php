<?php
error_reporting(0);
?>

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
	
	$anoi     = $_GET["anoi"];
	$anof     = $_GET["anof"];
	$ativo    = $_GET["ativo"];
	$distrito = $_GET["distrito"];
	$regiao   = $_GET["regiao"];
	$ordem    = $_GET["ordem"];
		
		//ANOS
		if ($anoi == $anof) { $ano_texto = "$anoi"; } else { $ano_texto = " PER&Iacute;ODO $anoi A $anof";  }
		
		//DESCOBRIR REGIAO
		$result_regiao = "SELECT * FROM pae_regiao WHERE id=$regiao";
		$resultado_regiao = mysql_query($result_regiao);		
		while ($row_regiao = mysql_fetch_assoc($resultado_regiao) ) {
		$regiao_nome  = $row_regiao["nome"];
		}
		
		//APAGAR A PALAVRA
		//$distrito_nome = str_replace("Distrito ", "", $distrito_nome); 
		
		//MAIUSCULO
		
		$regiao_nome2 = maiuscula($regiao_nome);
		
		//DESCRICAO
		$descricao_texto = "<br>$regiao_nome2 POR IGREJA - $ano_texto";
		
	include "../../config/meuip.php";

	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Relatorios > Membresia',
	'Tela de impressao da Evolucao de Crescimento da $regiao_nome no periodo de $anoi a $anof','$dados','pae_membro',
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
            EVOLU&Ccedil;&Atilde;O DE CRESCIMENTO<?php echo"$descricao_texto"; ?></strong></p>
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
                        <th style="text-align:center"><h2 style="font-size:13px;color:#000;"><strong></strong></h2></th>
                        <th style="text-align:left"><h2 style="font-size:13px;color:#000;"><strong>IGREJA</strong></h2></th>
                        <th style="text-align:left"><h2 style="font-size:13px;color:#000;"><strong>DISTRITO</strong></h2></th>
                        
						<?php 
						
                        //ANOS
                        $qr_anos = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
                        $todos_anos = mysql_query("$qr_anos");
                        while ($dados_anos = mysql_fetch_array($todos_anos)) {
						$ano  = $dados_anos["ano"];
						echo"<th style=\"text-align:right\"><h2 style='font-size:13px;color:#000;'><strong>$ano</strong></h2></th> ";
						
						}
						
						?>
                        
                        
                        
                        <th style="text-align:center"><h2 style="font-size:13px;color:#000;"><strong>%</strong></h2></th> 
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
						
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
						
						//ORDENAR POR
						if ($ordem == "1") { $ordem_texto = "nome ASC"; }
						if ($ordem == "2") { $ordem_texto = "distrito ASC, nome ASC"; }
																				
                        //IGREJAS
                        $qr_igreja = "SELECT DISTINCT nome,id,distrito_id,distrito,regiao
						FROM pae_igreja
						WHERE regiao_id = '$regiao'
						ORDER BY $ordem_texto";
                        $todos_igreja = mysql_query("$qr_igreja"); 
						$tr_igreja = mysql_num_rows($todos_igreja);
						$i="0";
                        while ($dados_igreja = mysql_fetch_array($todos_igreja)) {
						$i++; 
						$nome           = $dados_igreja["nome"];
						$igreja_id      = $dados_igreja["id"];
						$distrito_nome  = $dados_igreja["distrito"];
						$regiao_nome    = $dados_igreja["regiao"];
						
						//REMOVER PALAVRA
						$nome = str_replace("IMW ", "", $nome);
						$distrito_nome = str_replace("Distrito ", "", $distrito_nome);  
						
						echo"<tr>
                        <td style='font-size:13px;color:#333333;text-align:center'>$i</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$nome</td>
						<td style='font-size:13px;color:#333333;text-align:left'>$distrito_nome</td>";
						
						
						//ANOS DE ESTATISTICA						
						$qr_anos = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
                        $todos_anos = mysql_query("$qr_anos");
                        while ($dados_anos = mysql_fetch_array($todos_anos)) {
						$ano_periodo  = $dados_anos["ano"];
						
							//TOTAL DE MEMBROS POR ANO
							$qr_data_t = "SELECT ano_recepcao,regiao_id,distrito_id,ano_exclusao,igreja_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano_periodo') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_periodo') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE igreja_id = '$igreja_id'";
							$todos_data_t = mysql_query("$qr_data_t"); 
							while ($dados_data_t = mysql_fetch_array($todos_data_t)) {
							$recebidos  = $dados_data_t["recebidos"];
							$excluidos  = $dados_data_t["excluidos"];
							
							$rol_final_t = $recebidos-$excluidos;
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'>$rol_final_t</td>";
							
							
							}		
							
											
						 }
						 
							//PORCENTAGEM
							$qr_data_porc_t = "SELECT ano_recepcao,regiao_id,igreja_id,
							SUM(CASE WHEN (ano_recepcao <= '$anoi') then 1 ELSE 0 END) AS recebidos_inicial,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anoi') then 1 ELSE 0 END) AS excluidos_inicial,
							SUM(CASE WHEN (ano_recepcao <= '$anof') then 1 ELSE 0 END) AS recebidos_final,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anof') then 1 ELSE 0 END) AS excluidos_final,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE regiao_id = '$regiao'
							AND igreja_id = '$igreja_id'";
							$todos_data_porc_t  = mysql_query("$qr_data_porc_t"); 
							while ($dados_data_porc_t  = mysql_fetch_array($todos_data_porc_t)) {
							$recebidos_inicial = $dados_data_porc_t["recebidos_inicial"];
							$excluidos_inicial = $dados_data_porc_t["excluidos_inicial"];
							$recebidos_final   = $dados_data_porc_t["recebidos_final"];
							$excluidos_final   = $dados_data_porc_t["excluidos_final"];
							
							$rol_ano_inicial_t = $recebidos_inicial-$excluidos_inicial;
							$rol_ano_final_t = $recebidos_final-$excluidos_final;
							
								//PORCENTAGEM
								if ($rol_ano_inicial_t == $rol_ano_final_t) { $porcentagem = "0"; }
								else { $porcentagem = (($rol_ano_final_t-$rol_ano_inicial_t)/$rol_ano_inicial_t)*100;
								$porcentagem = number_format($porcentagem,2,'.','');  
								}
							
								echo"<td style='font-size:13px;color:#333333;text-align:center'>$porcentagem</td></tr>";
	
							 
						    }
							
						
						
						
							
                        
                       }
						

                        ?>

						<?php 
						
						$hoje = getdate();
						$ano_atual = $hoje["year"];
						$mes_atual = $hoje["mon"];

						$dia_atual = $hoje["mday"];
						
						if ($mes_atual < "10") { $mes_atual = "0$mes_atual"; } else { $mes_atual = $mes_atual; }
						if ($dia_atual < "10") { $dia_atual = "0$dia_atual"; } else { $dia_atual = $dia_atual; }
						
						$data_atual = "$ano_atual-$mes_atual-$dia_atual";
																				
						
						//REMOVER PALAVRA
						$nome = str_replace("Distrito ", "", $nome); 
                       
                        echo"<tr>
						<td style='font-size:13px;color:#333333;text-align:center'><b></b></td>
						<td style='font-size:13px;color:#333333;text-align:right'><b>TOTAL</b></td>";
						
						
						//MEMBRESIA DATAS
                        $qr_periodo = "SELECT * from conf_ano WHERE ano between '$anoi' and '$anof' order by ano asc";
                        $todos_periodo = mysql_query("$qr_periodo");
                        while ($dados_periodo = mysql_fetch_array($todos_periodo)) {
						$ano_periodo  = $dados_periodo["ano"];
						
							//TOTAL DE MEMBROS POR ANO
							$qr_data_t = "SELECT ano_recepcao,regiao_id,distrito_id,ano_exclusao,igreja_id,
							SUM(CASE WHEN (ano_recepcao <= '$ano_periodo') then 1 ELSE 0 END) AS recebidos,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$ano_periodo') then 1 ELSE 0 END) AS excluidos,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE regiao_id = '$regiao'";
							$todos_data_t = mysql_query("$qr_data_t"); 
							while ($dados_data_t = mysql_fetch_array($todos_data_t)) {
							$recebidos  = $dados_data_t["recebidos"];
							$excluidos  = $dados_data_t["excluidos"];
							
							$rol_final_t = $recebidos-$excluidos;
							
							echo"<td style='font-size:13px;color:#333333;text-align:right'><b>$rol_final_t</b></td>";
							
							
							}		
							
						}	
						
							//PORCENTAGEM
							$qr_data_porc_t = "SELECT ano_recepcao,regiao_id,igreja_id,
							SUM(CASE WHEN (ano_recepcao <= '$anoi') then 1 ELSE 0 END) AS recebidos_inicial,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anoi') then 1 ELSE 0 END) AS excluidos_inicial,
							SUM(CASE WHEN (ano_recepcao <= '$anof') then 1 ELSE 0 END) AS recebidos_final,
							SUM(CASE WHEN (ano_exclusao BETWEEN '1' AND '$anof') then 1 ELSE 0 END) AS excluidos_final,
							COUNT(*) AS Total
							FROM pae_membro
							WHERE regiao_id = '$regiao'";
							$todos_data_porc_t  = mysql_query("$qr_data_porc_t"); 
							while ($dados_data_porc_t  = mysql_fetch_array($todos_data_porc_t)) {
							$recebidos_inicial = $dados_data_porc_t["recebidos_inicial"];
							$excluidos_inicial = $dados_data_porc_t["excluidos_inicial"];
							$recebidos_final   = $dados_data_porc_t["recebidos_final"];
							$excluidos_final   = $dados_data_porc_t["excluidos_final"];
							
							$rol_ano_inicial_t = $recebidos_inicial-$excluidos_inicial;
							$rol_ano_final_t = $recebidos_final-$excluidos_final;
							
								//PORCENTAGEM
								if ($rol_ano_inicial_t == $rol_ano_final_t) { $porcentagem = "0"; }
								else { $porcentagem = (($rol_ano_final_t-$rol_ano_inicial_t)/$rol_ano_inicial_t)*100;
								$porcentagem = number_format($porcentagem,2,'.','');  
								}
							
								echo"<td style='font-size:13px;color:#333333;text-align:center'>$porcentagem</td></tr>";
	
							 
						    }
                        
						

                        ?>                      </tbody>
                
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
