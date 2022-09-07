<?php

$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}

include_once("../../config/conexao.php");
$link = @mysql_connect($host,$user,$pass)  or die("Não foi possível conectar");
mysql_select_db($db)  or die("Não foi possível selecionar o banco de dados");

$result = mysql_query("Select * from user where id='$dados'");
while($row = mysql_fetch_array($result)) {
$codigo       = $row["id"];
$nome         = $row["nome"];
$funcao       = $row["funcao"];
$codregiao    = $row["codregiao"];
$coddistrito  = $row["coddistrito"];
$codstatus    = $row["codstatus"];
$nivel        = $row["codnivel"];
$email        = $row["email"];
$login_acesso = $row["login_user"];
$senha_acesso = $row["senha_user"];
$data         = $row["data"];
$hora         = $row["hora"];
	
	//STATUS
	
	if ($codstatus == "1") { $status_texto = "Ativo"; } else { $status_texto = "Inativo"; }
	
	//DATA	
	
	$dia = date('d', strtotime($data));
	$mes = date('m', strtotime($data));
	$ano = date('Y', strtotime($data));
	
	//E-MAIL
	
	if ($email == "") { $email_texto = "N&atilde;o Informado";}
	if ($email <> "") { $email_texto = "$email";}
	
	if ($codregiao == "0") { $regiao_texto = "Geral"; }
	else {
		//REGIAO
		$qr_regiao="SELECT * from cad_regiao WHERE codigo='$codregiao'";
		$todos_regiao = mysql_query("$qr_regiao"); 
		while ($dados_regiao = mysql_fetch_array($todos_regiao)) { 
		$regiao_texto    = $dados_regiao["nome"];
		}
	}
	
		//DISTRITO	
	if ($coddistrito == "0") { $distrito_texto = "Nenhum"; }
	else {

		$qr_distrito="SELECT * from pae_distrito WHERE id='$coddistrito'";
		$todos_distrito = mysql_query("$qr_distrito"); 
		while ($dados_distrito = mysql_fetch_array($todos_distrito)) { 
		$distrito_cod     = $dados_distrito["id"];
		$desc_distrito    = $dados_distrito["nome"];
		$desc_codregiao    = $dados_distrito["regiao_id"];
		
			//REGIAO
			$qr_regiao_p ="SELECT * from pae_regiao where id='$desc_codregiao'";
			$todos_regiao_p = mysql_query("$qr_regiao_p"); 
			while ($dados_regiao_p = mysql_fetch_array($todos_regiao_p)) { 
			$nome_regiao    = $dados_regiao_p["nome"];
			}
			
		$distrito_texto = "$desc_distrito - $nome_regiao";
		
		}		
	}
	
	// DATA POR EXTENSO
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysql_query("$qr_entradames"); 
	while ($dados_entradames= mysql_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	$data_cadastro = "$dia de $mes_texto de $ano as $hora";
	
	
	//FUNÇÃO
	$qr_funcao="SELECT * from usuarios_funcao where codigo = '$funcao'";
	$todos_funcao= mysql_query("$qr_funcao"); 
	while ($dados_funcao = mysql_fetch_array($todos_funcao)) { 
	$funcao_texto   = $dados_funcao["descricao"];
	}


include "../../config/meuip.php";
	
//GRAVAR HISTORICO DA ACAO
$GRAVAR = "INSERT INTO historico_usuario
(coduser,codregiao,coddistrito, userip,sessao,
acao,codarquivo,tipo_arquivo,
data,hora)
VALUES
('$id_user','$regiao_user','$distrito_user','$user_ip','Cadastros > Usuarios',
'Visualizar dados de usuario','$dados','usuarios',
curdate( ),curtime( ))";
$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());	
	

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
                    
                    <a href='index.php?sessao=al&dados=<?php echo"$codigo&pagina=$pagina$odado#loc";?>' title='Alterar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-edit fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                 
                                      
                    <a href='index.php?sessao=b<?php echo"&pagina=$pagina$odado#loc";?>' title='Retornar'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-undo fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                
                </div>   
                
                 
                 
            </div>
        </div>
        
        <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
                
<!-- DADOS GERAIS -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DADOS DO USU&Aacute;RIO</strong></h2>
<div class="well well-large">
<div class="row">     
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Nome:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$nome"; ?></font></p>
                </div>
            </div>
        </div>
             
      
                            
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
       	   <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>E-mail:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$email_texto"; ?></font></p>
                </div>
        	</div>
        </div>

           
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
       	   <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Fun&ccedil;&atilde;o:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$funcao_texto"; ?></font></p>
                </div>
        	</div>
        </div>

                                               
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
       	   <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Regi&atilde;o:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$regiao_texto"; ?></font></p>
                </div>
        	</div>
        </div>

                                               
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
       	   <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Distrito:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$distrito_texto"; ?></font></p>
                </div>
        	</div>
        </div>                                               
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
       	   <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Status:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$status_texto"; ?></font></p>
                </div>
        	</div>
        </div>

        
</div>        
</div><!-- FIM DADOS GERAIS -->


<!-- DADOS DO ARQUIVO -->     
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>ACESSO AO SISTEMA</strong></h2>
<div class="well well-large">
 <div class="row"> 
         
        <div class='form-group' <?php echo"$layout_texto";?> >
        	<div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Login:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$login_acesso"; ?></font></p>
                </div>
        	</div>
        </div>
          
        <div class='form-group' <?php echo"$layout_texto";?> >
        	<div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Senha:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$senha_acesso"; ?></font></p>
                </div>
        	</div>
        </div>       
 </div>
</div>  


<!-- DADOS DO ARQUIVO -->     
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DADOS DO ARQUIVO</strong></h2>
<div class="well well-large">
 <div class="row">         
        <div class='form-group' <?php echo"$layout_texto";?> >
        	<div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?> >
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Criado em:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$data_cadastro"; ?></font></p>
                </div>
        	</div>
        </div>
 </div>
</div>                
                </div>    
            </div>
        </div><?php } ?>
