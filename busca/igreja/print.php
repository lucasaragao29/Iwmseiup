	<script src="../../config/js/jquery.min.js"></script>
        
	<!-- POPUP DE VIDEO -->
    <link rel="stylesheet" type="text/css" href="../../config/tiny/css/lightbox.min.css">
   
	<script type="text/javascript" src="../../config/tiny/js/lightbox.min.js"></script>

		
    <!-- core CSS -->
    <link href="../../config/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="../../config/css/animate.min.css" rel="stylesheet">
    <link href="../../config/css/prettyPhoto.css" rel="stylesheet">
    <link href="../../config/css/main.css" rel="stylesheet">
    <link href="../../config/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="../../imagens/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../imagens/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../imagens/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../imagens/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../../imagens/ico/apple-touch-icon-57-precomposed.png">
    
	<style type="text/css">
    #imaginary_container{
    margin-top:20%; /* Don't copy this */
	}
	.stylish-input-group .input-group-addon{
		background: white !important; 
	}
	.stylish-input-group .form-control{
		border-right:0; 
		box-shadow:0 0 0; 
		border-color:#ccc;
	}
	.stylish-input-group button{
		border:0;
		background:transparent;
	}
	
	</style>
	
	<style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
	}
	
	.panel.panel-custom {
	
	}
	
	.panel.panel-custom2 {
	background:#114a66;
	color:red;
	border:3px solid #114a66;
	border-radius:20px;
	}
	.panel.panel-custom3 {
	background:transparent;
	color:#666;
	border:3px solid transparent;
	border-radius:20px;
	}
    </style>
    
  
       <!-- Owl Carousel Assets -->
    <link href="../../config/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="../../config/owl-carousel/owl.theme.css" rel="stylesheet">


<?php

    include_once __DIR__ . "/../../config/conexao.php";
    $conn = OpenCon();

$busca_usuario = "SELECT * from user WHERE id = '$id_user'";
$todos_usuario = mysqli_query($conn,"$busca_usuario"); 
while ($dados_usuario = mysqli_fetch_array($todos_usuario)) { 
$id_user    = $dados_usuario["id"];
$nivel_user = $dados_usuario["codnivel"];
$polo_user   = $dados_usuario["codpolo"];


}

include ('../../config/cnpj_cpf.php');
include ('../../config/maiuscula.php');

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
	
	//MAIUSCULA
	$nome_grande = maiuscula($nome);
	
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
	'Gerar tela de impressao para os dados da Igreja $nome','$dados','pae_igreja',
	curdate( ),curtime( ))";
	$GRAVACAO = mysqli_query($conn,$GRAVAR)  or die (mysqli_error());	


?>


      
        
        <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
                
<!-- DADOS ECLESIASTICOS -->                
<h2 align="center" style="color:#114a66; font-size:<?php echo"$font_ver_titulo";?>"><strong>DADOS DA IGREJA <?php echo"$nome_grande"; ?></strong></h2>
<div class="well well-large">
<div class="row">     
        <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Nome:</strong> <?php echo"$nome"; ?></p>
                </div>
                
            </div>
        </div>
	
       <div class='form-group' style="margin-left:10px;margin-top:10px;">
                <div class='col-sm-12'>
                    <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Distrito:</strong> <?php echo"$distrito"; ?></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Regi&atilde;o:</strong> <?php echo"$regiao"; ?></p>
                </div>
            </div>
        </div>
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Data de organiza&ccedil;&atilde;o:</strong> <?php echo"$data_abertura_texto"; ?></p>
                </div>
            </div>
        </div>	
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>CNPJ:</strong> <?php echo"$cnpj_texto"; ?></p>
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
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Endere&ccedil;o:</strong> <?php echo"$endereco_texto"; ?></p>
                </div>
            </div>
        </div>
	
       <div class='form-group' style="margin-left:10px;margin-top:10px;">
                <div class='col-sm-12'>
                    <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Bairro:</strong> <?php echo"$bairro_texto"; ?></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Cidade - UF:</strong> <?php echo"$cidade_texto - $uf_texto"; ?></p>
                </div>
            </div>
        </div>

	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Pa&iacute;s:</strong> <?php echo"$pais_texto"; ?></p>
                </div>
            </div>
        </div>
 
 
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Complemento:</strong> <?php echo"$complemento_texto"; ?></p>
                </div>
            </div>
        </div>
        	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>CEP:</strong> <?php echo"$cep_texto"; ?></p>
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
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>E-mail:</strong> <?php echo"$email_texto"; ?></p>
                </div>
            </div>
        </div>
	
       <div class='form-group' style="margin-left:10px;margin-top:10px;">
                <div class='col-sm-12'>
                    <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                        <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                        <strong>Telefone:</strong> <?php echo"$telefone_texto"; ?></p>
                    </div>
                </div>
        </div>  
	
	 <div class='form-group' style="margin-left:10px;margin-top:10px;">
            <div class='col-sm-12'>
                <div class="col-sm-12" <?php echo"$titulo_alinhar";?>>
                    <p style='color:#114a66; font-size:<?php echo"$font_ver";?>'>
                    <strong>Site:</strong> <?php echo"$site_texto"; ?></p>
                </div>
            </div>
        </div>

</div>        
</div><!-- FIM DADOS DA IGREJA -->


             
                </div>    
            </div>
        </div><?php } ?>
