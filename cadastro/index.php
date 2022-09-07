<?php





session_start();   

$id_user =  $_SESSION['id_user'];

 
/* Página de segurança aqui o script verifica se o usuario efetuou login caso não ele sai  */


include("../config/maiuscula.php");
include("../config/warning_login.php");
include("../config/erros.php");
include("../config/resolucao.php");
include ('../config/config.php');
// Abre conexão ao Mysql   
// Conecta ao Banco de dados
include('../config/conexao.php');

// Chama o Banco de Dados
 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
 mysql_select_db($db) or die ("Impossivel Abrir Database");

$busca_usuario = "SELECT * from user WHERE id = '$id_user'";
$todos_usuario = mysql_query("$busca_usuario"); 
while ($dados_usuario = mysql_fetch_array($todos_usuario)) { 
$id_user    = $dados_usuario["id"];
$log_user   = $dados_usuario["login_user"];
$senha_user = $dados_usuario["senha_user"];
$nivel_user = $dados_usuario["codnivel"];
$regiao_user  = $dados_usuario["codregiao"];
$distrito_user  = $dados_usuario["coddistrito"];
	
}

$qr_painel ="SELECT * from painel_opcoes where codigo='2'";
$todos_painel = mysql_query("$qr_painel"); 
while ($dados_painel = mysql_fetch_array($todos_painel)) { 
$contagem = $dados_painel["contagem"];
}

$contar = $contagem + 1;

//CONTAR ACESSO
mysql_query("UPDATE painel_opcoes SET contagem='$contar' WHERE codigo='2' ")
or die ("Erro ao adicionar Registro!!!" . mysql_error());

?>
<!DOCTYPE html>
<html lang="en"><head>
    
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<title><?php include"../config/config.php"; echo"$title";?></title>

	<script src="../config/js/jquery.min.js"></script>
        
	<!-- POPUP DE VIDEO -->
    <link rel="stylesheet" type="text/css" href="../config/tiny/css/lightbox.min.css">   
	<script type="text/javascript" src="../config/tiny/js/lightbox.min.js"></script>

    <!-- scroll 
    <link href="config/css/scrolling-nav.css" rel="stylesheet">-->
    
    <!-- core CSS -->
    <link href="../config/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="../config/css/animate.min.css" rel="stylesheet">
    <link href="../config/css/prettyPhoto.css" rel="stylesheet">
    <link href="../config/css/main.css" rel="stylesheet">
    <link href="../config/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="../imagens/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../imagens/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../imagens/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../imagens/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../imagens/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css">
    body,td,th {
	font-family: "Open Sans", sans-serif;
	}
	
	.panel.panel-custom {
	background:#fafaf5;
	color:red;
	border:3px solid #114a66;
	border-radius:20px;
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
    <link href="../config/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="../config/owl-carousel/owl.theme.css" rel="stylesheet">
      
<meta charset="utf-8">
</head><!--/head-->

<body class="homepage" data-spy="scroll" data-target=".navbar">

<?php 
//require"../config/conexao.php";
require"../config/config.php";

require"../config/menu.php"; 

?>

 <?php 
//RESPONSIVO
if($width < "600") { 

$botoes_align= "align='center'"; 
$fonte_titulo = "20px";
$top_botao= ""; 
$botao_tamamho= "btn-group-sm"; 

} 

else { 
$canais_top= "";
$fonte_titulo = "30px";
$botoes_align= "align='right'"; 
$top_botao= "style='padding-top:40px;'"; 
$botao_tamamho= "btn-group-lg"; 


}

?>

<section id="services" class="service-item" style="background-color:#efefef;">
    <div class="container">
    
        <div class="panel panel-custom2">
            <div class="panel-body"> 
            
                <div class="col-sm-6" align="center">
                    <div class="panel panel-custom2">
                        <div class="media " style="background-color:transparent;">
                            <div class="pull-left">
                                <img class="img-responsive" src="../imagens/icone_cadastro.png" 
                                style="border:white 4px solid; background-color:white;border-radius: 100px;">
                            </div>
                            <div class="media-body" style="padding-top:20px;">
                                <h2 class="media-heading" style="font-size:<?php echo"$fonte_titulo"; ?>;color:#fff" align="left"><strong>CADASTROS</strong></h2>
                                <p style="color:#fff"  align="left">Gerenciamento de Cadastros</p>                    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" <?php echo"$botoes_align $top_botao"?>>
                    <div class="btn-group <?php echo"$botao_tamamho";?>" role="group" aria-label="Basic example">
                        <a href="index.php" class="btn btn-default">Estat&iacute;stica</a>
                        <a href="../painel.php" class="btn btn-default">Voltar</a>
                    </div>            
                </div>
                
            </div>
        </div>
			<?php 
		
			//USUARIOS					
			$qr_usuario = "SELECT * from user WHERE ativo='1' and id !='1'";
			$todos_usuario = mysql_query("$qr_usuario"); 
			$tr_usuario = mysql_num_rows($todos_usuario);
					
			//MASTER
			if ($nivel_user == "1") { include("config/opcao01.php");}
			
			//DEMAIS			
			if ($nivel_user > "1") { include("config/opcao02.php");}
		
			
		   ?>
        </div>
</section> 

<?php

include"../config/rodape.php";

?>
 
   
   
    <script src="../config/js/bootstrap.min.js"></script>
   <script src="../config/js/jquery.prettyPhoto.js"></script>
    <script src="../config/js/jquery.isotope.min.js"></script>
    <!-- Javascript -->
		<script src="../config/js/smooth-scroll.js"></script>
		<script>
			smoothScroll.init();
		</script>
  <script src="../config/js/main.js"></script>
    <script src="../config/js/wow.min.js"></script>
   
</body>
</html>
