<?php

$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}

include("../../config/minuscula.php");

$result = mysqli_query($conn,"Select * from pae_igreja where id='$dados'");
while($row = mysqli_fetch_array($result)) {
	$codigo        = $row["id"];
	$nome          = $row["nome"];
	$distrito      = $row["distrito"];
	$regiao        = $row["regiao"];
	$endereco      = $row["endereco"];
	$bairro        = $row["bairro"];
	$cep           = $row["cep"];
	$cidade        = $row["cidade"];
	$numero        = $row["numero"];
	$uf            = $row["uf"];
	$pais          = $row["pais"];
	$email         = $row["email"];
	$site          = $row["site"];
	$telefone      = $row["telefone"];
	$ddd           = $row["ddd"];
	$cnpj          = $row["cnpj"];
	$data_abertura = $row["data_abertura"];
	
	//APAGAR A PALAVRA
	$distrito = str_replace("Distrito ", "", $distrito); 
	$nome = str_replace("IMW ", "", $nome); 
	
	//CNPJ
	$cnpj = formatarCnpj($cnpj);
	
	//CEP
	$cep = preg_replace("/^(\d{5})(\d{3})$/", "\\1-\\2", $cep);
	
	//MINUSCULA
	$regiao = minuscula($regiao);
	
	//DATA DE ABERTURA
	if ($data_abertura == "0000-00-00") { $data_abertura_texto = "Dado n&atilde;o informado"; }
	else {
		
	$dia = date('d', strtotime($data_abertura));
	$mes = date('m', strtotime($data_abertura));
	$ano = date('Y', strtotime($data_abertura));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysqli_query($conn,"$qr_entradames"); 
	while ($dados_entradames= mysqli_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	//PAIS
	$qr_pais = "SELECT * from conf_pais where codigo = '$pais'";
	$todos_pais = mysqli_query($conn,"$qr_pais"); 
	while ($dados_pais = mysqli_fetch_array($todos_pais)) { 
	$pais   = $dados_pais["nome"];
	}
	
	//ESTADO
	$qr_estado = "SELECT * from conf_estado where sigla = '$uf'";
	$todos_estado = mysqli_query($conn,"$qr_estado"); 
	while ($dados_estado = mysqli_fetch_array($todos_estado)) { 
	$uf   = $dados_estado["nome"];
	}
	
	//DIA PRIMEIRO
	if ($dia == "01") { $dia = "1&ordm;"; }
	
	$data_abertura_texto = "$dia de $mes_texto de $ano";
	}
	
	//FILTROS
	if ($endereco == "") { $endereco_texto = "Dado n&atilde;o informado"; } else { $endereco_texto = "$endereco, $numero"; }
	if ($bairro == "")   { $bairro_texto = "Dado n&atilde;o informado"; }   else { $bairro_texto = $bairro; }
	if ($cidade == "")   { $cidade_texto = "Dado n&atilde;o informado"; }   else { $cidade_texto = $cidade; }
	if ($uf == "")       { $uf_texto = "Dado n&atilde;o informado"; } else { $uf_texto = $uf; }
	if ($pais == "")     { $pais_texto = "Dado n&atilde;o informado"; } else { $pais_texto = $pais; }
	if ($complemento == "") { $complemento_texto = "Dado n&atilde;o informado"; } else { $complemento_texto = $complemento; }
	if ($cep == "")         { $cep_texto = "Dado n&atilde;o informado"; } else { $cep_texto = $cep; }

	if ($email == "")         { $email_texto = "Dado n&atilde;o informado"; } else { $email_texto = $email; }
	if ($site == "")         { $site_texto = "Dado n&atilde;o informado"; } else { $site_texto = $site; }
	if ($telefone == "")         { $telefone_texto = "Dado n&atilde;o informado"; } else { $telefone_texto = "($ddd) $telefone"; }
	if ($cnpj == "")         { $cnpj_texto = "Dado n&atilde;o informado"; } else { $cnpj_texto = "$cnpj"; }
	
	include "../../config/meuip.php";
		
	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codregiao,coddistrito,userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$regiao_user','$distrito_user','$user_ip','Busca > Igrejas',
	'Visualizar dados da Igreja $nome','$dados','pae_igreja',
	curdate( ),curtime( ))";
	$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die (mysqli_error());	


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
                    
                    <a href='print.php?dados=<?php echo"$codigo&pagina=$pagina$odado#loc";?>' target="_blank" 
                    title='Tela de impress&atilde;o Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fas fa-print fa-stack-1x fa-inverse'></i>
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
                
<!-- DADOS ECLESIASTICOS -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DADOS DA IGREJA</strong></h2>
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
                    <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Distrito:</strong></p>
                    </div>
                    <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <font color="#000"><?php echo"$distrito"; ?></font></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Regi&atilde;o:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$regiao"; ?></font></p>
                </div>
            </div>
        </div>
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Data de organiza&ccedil;&atilde;o:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$data_abertura_texto"; ?></font></p>
                </div>
            </div>
        </div>	
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>CNPJ:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$cnpj_texto"; ?></font></p>
                </div>
            </div>
        </div>	
            
</div>        
</div><!-- FIM DADOS DA IGREJA -->

<!-- DADOS LOCALIZACAO -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>LOCALIZA&Ccedil;&Atilde;O</strong></h2>
<div class="well well-large">
<div class="row">     
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Endere&ccedil;o:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$endereco_texto"; ?></font></p>
                </div>
            </div>
        </div>
	
       <div class='form-group' style="margin-left:10px;margin-top:10px;">
                <div class='col-sm-12'>
                    <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Bairro:</strong></p>
                    </div>
                    <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <font color="#000"><?php echo"$bairro_texto"; ?></font></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Cidade - UF:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$cidade_texto - $uf_texto"; ?></font></p>
                </div>
            </div>
        </div>

	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Pa&iacute;s:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$pais_texto"; ?></font></p>
                </div>
            </div>
        </div>
 
 
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Complemento:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$complemento_texto"; ?></font></p>
                </div>
            </div>
        </div>
        	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>CEP:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$cep_texto"; ?></font></p>
                </div>
            </div>
        </div>           
</div>        
</div><!-- FIM DADOS DA IGREJA -->

<!-- DADOS CONTATOS -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>CONTATOS</strong></h2>
<div class="well well-large">
<div class="row">     
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
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
                    <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Telefone:</strong></p>
                    </div>
                    <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <font color="#000"><?php echo"$telefone_texto"; ?></font></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Site:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$site_texto"; ?></font></p>
                </div>
            </div>
        </div>

</div>        
</div><!-- FIM DADOS DA IGREJA -->


             
                </div>    
            </div>
        </div><?php } ?>
