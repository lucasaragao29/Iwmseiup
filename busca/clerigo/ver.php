<?php

$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}

include("../../config/minuscula.php");

$result = mysqli_query($conn,"Select * from pae_clerigo where id='$dados'");
while($row = mysqli_fetch_array($result)) {
	$codigo          = $row["id"];
	$nome            = $row["nome"];
	$status          = $row["status"];
	$estado_civil    = $row["estado_civil"];
	$data_nascimento = $row["data_nascimento"];
	$sexo            = $row["sexo"];
	
	$identidade      = $row["identidade"];
	$orgao_emissor   = $row["orgao_emissor"];
	$data_emissao    = $row["data_emissao"];
	$cpf             = $row["cpf"];
	
	$endereco        = $row["endereco"];
	$numero          = $row["numero"];
	$complemento     = $row["complemento"];
	$bairro          = $row["bairro"];
	$cidade          = $row["cidade"];
	$uf              = $row["uf"];
	$pais            = $row["pais"];
	$cep             = $row["cep"];
	
	$email           = $row["email"];
	
	//ESTADO CIVIL
	if ($estado_civil == "C") {  $civil_texto = "Casado(a)"; }
	if ($estado_civil == "S") {  $civil_texto = "Solteiro(a)"; }
	if ($estado_civil == "V") {  $civil_texto = "Vi&uacute;vo(a)"; }
	if ($estado_civil == "X") {  $civil_texto = "X"; }
	if ($estado_civil == "D") {  $civil_texto = "Divorciado(a)"; }
	if ($estado_civil == "Y") {  $civil_texto = "Y"; }
	if ($estado_civil == "")  {  $civil_texto = "N&atilde;o informado"; }
	
	//SEXO
	if ($sexo == "F") {  $sexo_texto = "Feminino"; }
	if ($sexo == "M") {  $sexo_texto = "Masculino"; }
	if ($sexo == "")  {  $sexo_texto = "N&atilde;o informado"; }	
	
	//APAGAR A PALAVRA
	$distrito = str_replace("Distrito ", "", $distrito); 
	$nome = str_replace("IMW ", "", $nome); 
	
	//CNPJ
	if ($cpf == "") { $cpf_texto = "N&atilde;o informado";}
	else { $cpf_texto = formatarCnpj($cpf); }

	//DATA DE EMISSÃO
	if ($data_emissao == "0000-00-00") { $data_emissao_texto = "Dado n&atilde;o informado"; }
	else {
		
	$dia = date('d', strtotime($data_emissao));
	$mes = date('m', strtotime($data_emissao));
	$ano = date('Y', strtotime($data_emissao));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysqli_query($conn,"$qr_entradames"); 
	while ($dados_entradames= mysqli_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	//DIA PRIMEIRO
	if ($dia == "01") { $dia = "1&ordm;"; }
	
	$data_emissao_texto = "$dia de $mes_texto de $ano";
	}
	
		
	//IDENTIDADE
	if ($identidade == "") { $identidade_texto = "N&atilde;o informado"; }
	 else { $identidade_texto = "$identidade | Org&atilde;o Emissor: $orgao_emissor | Expedido em $data_emissao_texto"; }
	 

	
	//CEP
	$cep = preg_replace("/^(\d{5})(\d{3})$/", "\\1-\\2", $cep);
	
	//DATA DE ABERTURA
	if ($data_nascimento == "0000-00-00") { $data_nascimento_texto = "Dado n&atilde;o informado"; }
	else {
		
	$dia = date('d', strtotime($data_nascimento));
	$mes = date('m', strtotime($data_nascimento));
	$ano = date('Y', strtotime($data_nascimento));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysqli_query($conn,"$qr_entradames"); 
	while ($dados_entradames= mysqli_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	//DIA PRIMEIRO
	if ($dia == "01") { $dia = "1&ordm;"; }
	
	$data_nascimento_texto = "$dia de $mes_texto de $ano";
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
	('$id_user','$regiao_user','$distrito_user','$user_ip','Busca > Clerigo',
	'Visualizar dados do Clerigo $nome','$dados','pae_clerigo',
	curdate( ),curtime( ))";
	$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die (mysql_error());	


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
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DADOS DO CL&Eacute;RIGO</strong></h2>
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
                        <strong>Estado C&iacute;vil:</strong></p>
                    </div>
                    <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <font color="#000"><?php echo"$civil_texto"; ?></font></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Sexo:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$sexo_texto"; ?></font></p>
                </div>
            </div>
        </div>
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Data de Nascimento:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$data_nascimento_texto"; ?></font></p>
                </div>
            </div>
        </div>	
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Status:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$status"; ?></font></p>
                </div>
            </div>
        </div>	
            
</div>        
</div><!-- FIM DADOS DA IGREJA -->

<!-- DADOS LOCALIZACAO -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>ONDE RESIDE</strong></h2>
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
</div><!-- FIM DADOS CONTATOS -->

<!-- DADOS DOCUMENTACAO -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DOCUMENTA&Ccedil;&Atilde;O</strong></h2>
<div class="well well-large">
<div class="row">     
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>CPF:</strong></p>
                </div>
                <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <font color="#000"><?php echo"$cpf_texto"; ?></font></p>
                </div>
            </div>
        </div>
	
       <div class='form-group' style="margin-left:10px;margin-top:10px;">
                <div class='col-sm-12'>
                    <div class="col-sm-3" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Identidade:</strong></p>
                    </div>
                    <div class="col-sm-9" <?php echo"$titulo_alinhar2";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <font color="#000"><?php echo"$identidade_texto"; ?></font></p>
                    </div>
                </div>
        </div>  
	

</div>        
</div><!-- FIM DADOS DOCUMENTAÇÃO -->

<!-- DADOS DOCUMENTACAO -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>NOMEA&Ccedil;&Otilde;ES</strong></h2>
<div class="well well-large">
<div class="row"> 

    
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-2" align="center">
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>DATA</strong></p>
                </div>
                <div class="col-sm-5" align="center">
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>INSTITUI&Ccedil;&Atilde;O</strong></p>
                </div>
                <div class="col-sm-5" align="center">
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>FUN&Ccedil;&Atilde;O MINISTERIAL</strong></p>
                </div>
            </div>
        </div>

	<?php 
    
		$nomeacao_qr = mysqli_query($conn,"Select * from pae_nomeacao where pessoa_id='$dados' order by data_nomeacao desc");
		while($nomeacao_row = mysqli_fetch_array($nomeacao_qr)) {
		$codigo             = $nomeacao_row["id"];
		$data_nomeacao      = $nomeacao_row["data_nomeacao"];
		$instituicao        = $nomeacao_row["instituicao"];
		$funcao_ministerial = $nomeacao_row["funcao_ministerial"];
		
			//DATA DO CADASTRO POR EXTENSO
			$dia_nomeacao = date('d', strtotime($data_nomeacao));
			$mes_nomeacao = date('m', strtotime($data_nomeacao));
			$ano_nomeacao = date('Y', strtotime($data_nomeacao));
			
			$data_nomeacao_texto = "$dia_nomeacao/$mes_nomeacao/$ano_nomeacao";

		
		echo"<div class='form-group' style='margin-left:10px;margin-top:10px;'>
                <div class='col-sm-12'>
                    <div class='col-sm-2' align='center'>
                        <p style='color:#114a66; font-size:$font_ver'>
                        <font color='#000'>$data_nomeacao_texto</font></p>
                    </div>
                     <div class='col-sm-5' align='center'>
                        <p style='color:#114a66; font-size:$font_ver'>
                        <font color='#000'>$instituicao</font></p>
                    </div>
                     <div class='col-sm-5' align='center'>
                        <p style='color:#114a66; font-size:$font_ver'>
                        <font color='#000'>$funcao_ministerial</font></p>
                    </div>
               </div>
       		 </div>  ";
		
		}
    
    
    
    ?>
	
       
	

</div>        
</div><!-- FIM DADOS DOCUMENTAÇÃO -->

             
                </div>    
            </div>
        </div><?php } ?>
