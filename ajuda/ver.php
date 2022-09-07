<?php

$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}


$link = @mysql_connect($host,$user,$pass)  or die("N&atilde;o foi possível conectar");
mysql_select_db($db)  or die("N&atilde;o foi possível selecionar o banco de dados");

$result = mysql_query("Select * from cad_ajuda where codigo='$dados'");
while($row = mysql_fetch_array($result)) {
	$codigo      = $row['codigo'];
	$titulo      = $row["titulo"];
	$codarea     = $row["codarea"];
	$codstatus   = $row["codstatus"];
	$texto       = $row['texto'];
	$foto        = $row['foto'];
	
	$data        = $row["data"];
	$hora        = $row["hora"];
	
	//STATUS
	if ($codstatus == "1") { $status_texto = "Ativo"; } else { $status_texto = "Inativo";}
	
	//AREA
	$qr_area = "SELECT * from conf_area where codigo='$codarea'";
	$todos_area = mysql_query("$qr_area"); 
	while ($dados_area = mysql_fetch_array($todos_area)) { 
	$area_texto = $dados_area["descricao"];
	}
	
	
	//DATA DE CADASTRO
	$dia = date('d', strtotime($data));
	$mes = date('m', strtotime($data));
	$ano = date('Y', strtotime($data));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysql_query("$qr_entradames"); 
	while ($dados_entradames= mysql_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	$datar = "$dia de $mes_texto de $ano as $hora";
	
	include "../config/meuip.php";
		
	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codpolo, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$polo_user','$user_ip','Ajuda',
	'Visualizar dados da ajuda - $titulo','$dados','cad_ajuda',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die("Falha na execuç&atilde;o da consultas");	
		
					//FOTO
		if ($foto == "") {$foto_opcao = "foto"; $foto_title = "Incluir imagem";}
		if ($foto <> "") {$foto_opcao = "fotoe"; $foto_title = "Excluir imagem";}

?>


       <div class="panel panel-custom" style="background-color:#114a66" id='loc'>
            <div class="panel-body">
                 <div class="col-sm-3" align="CENTER">
                	<P style="font-size:25px;color:#fff;margin-top:15px;"><strong>VISUALIZAR DADOS</strong></P>
                </div>  
                
                <div class="col-sm-9" align="<?php echo"$botoes_aliamento"; ?>">
                
                    <a href='index.php?sessao=ver&dados=<?php echo"$codigo&pagina=$pagina$odado#loc";?>' title='Visualizar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-eye fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                    <?php 
					
				
					
                  if ($nivel_user == "1")
					{
                    echo"<a href='index.php?sessao=al&dados=$codigo&pagina=$pagina$odado#loc' title='Alterar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-edit fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                    
				    
                    <a href='index.php?sessao=$foto_opcao&dados=$codigo&pagina=$pagina$odado#loc' title='$foto_title'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-file-image fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>";
                     }              
                                      
                    echo"<a href='index.php?sessao=b&pagina=$pagina$odado#loc' title='Retornar'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-undo fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>";
					
                ?>
                
                </div>   
                
                 
                 
            </div>
        </div>
        
        
        <?php 
		
		if ($nivel_user == "1") {
			
		echo"<div class='panel panel-custom'>
            <div class='panel-body'>
                <div class='col-sm-12'>
                
                <!-- DADOS GERAIS -->                
                <h2 align='center' style='color:#114a66; font-size:$font_ver_titulo'><strong>DADOS GERAIS
                </strong></h2>
                <div class='well well-large'>
                <div class='row'> 
                    
                        <div class='form-group' style='margin-left:10px;margin-top:10px;'>
                            <div class='col-sm-12'>
                                <div class='col-sm-3' $titulo_alinhar>
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <strong>T&iacute;tulo:</strong></p>
                                </div>
                                <div class='col-sm-9'  $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <font color='#000'>$titulo</font></p>
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class='form-group' style='margin-left:10px;margin-top:10px;'>
                          <div class='col-sm-12'>
                                <div class='col-sm-3'  $titulo_alinhar >
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <strong>&Aacute;rea:</strong></p>
                                </div>
                                <div class='col-sm-9'  $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <font color='#000'>$area_texto</font></p>
                                </div>
                            </div>
                    </div>
                        
                        <div class='form-group' style='margin-left:10px;margin-top:10px;'>
                          <div class='col-sm-12'>
                                <div class='col-sm-3'  $titulo_alinhar >
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <strong>Status:</strong></p>
                                </div>
                                <div class='col-sm-9'  $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:'$font_ver'>
                                    <font color='#000'>$status_texto</font></p>
                                </div>
                            </div>
                      </div>
                
                      
                </div>
                </div><!-- FIM DADOS GERAIS -->
                
                
                <!-- DADOS DO ARQUIVO -->     
                <h2 align='center' style='color:#114a66; font-size:'$font_ver_titulo'><strong>TEXTO</strong></h2>
                <div class='well well-large'>
                    <div class='row'>         
                        <div class='form-group' $layout_texto >
                            <div class='col-sm-12'>
                                
                                <div class='col-sm-12' $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:$font_ver'>
                                    <font color='#000'>$texto</font></p>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                </div>   
                
                <!-- DADOS DO ARQUIVO -->     
                <h2 align='center' style='color:#114a66; font-size:$font_ver_titulo'><strong>DADOS DO ARQUIVO
                </strong></h2>
                <div class='well well-large'>
                <div class='row'>         
                        <div class='form-group' $layout_texto >
                            <div class='col-sm-12'>
                                <div class='col-sm-3' $titulo_alinhar >
                                    <p style='color:#114a66; font-size:$font_ver'>
                                    <strong>Criado em:</strong></p>
                                </div>
                                <div class='col-sm-9' $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:$font_ver'>
                                    <font color='#000'>$datar</font></p>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>  
                
                
                </div>    
            </div>
        </div>  
		";
		}
		
		else {
			
		$titulo = maiuscula($titulo);
			
		echo"<div class='panel panel-custom'>
            <div class='panel-body'>
                <div class='col-sm-12'>
                
                <!-- DADOS DO ARQUIVO -->     
                <h2 align='center' style='color:#114a66; font-size:'$font_ver_titulo'><strong>$titulo</strong></h2>
                <div class='well well-large'>
                    <div class='row'>         
                        <div class='form-group' $layout_texto >
                            <div class='col-sm-12'>
                                
                                <div class='col-sm-12' $titulo_alinhar2>
                                    <p style='color:#114a66; font-size:$font_ver'>
                                    <font color='#000'>$texto</font></p>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                </div>   
                
              
                
                
                </div>    
            </div>
        </div>  
		";	
			
		}
		
		?>
        
        
        
        
        
		
		
		
		
		<?php } ?>


