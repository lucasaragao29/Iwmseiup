<?php



$sessao = $_GET["sessao"];

session_start();   

$id_user =  $_SESSION['id_user'];

 include ('../config/config.php');
/* Página de segurança aqui o script verifica se o usuario efetuou login caso não ele sai  */


include("../config/maiuscula.php");
include("../config/warning_login.php");
include("../config/erros.php");
include("../config/resolucao.php");

// Abre conexão ao Mysql   
// Conecta ao Banco de dados
<?php include_once __DIR__ . "/../../config/conexao.php";
$conn = OpenCon(); ?>

$busca_usuario = "SELECT * from user WHERE id = '$id_user'";
$todos_usuario = mysqli_query($conn,"$busca_usuario"); 
while ($dados_usuario = mysqli_fetch_array($todos_usuario)) { 
	$id_user        = $dados_usuario["id"];
	$log_user       = $dados_usuario["login_user"];
	$senha_user     = $dados_usuario["senha_user"];
	$nivel_user     = $dados_usuario["codnivel"];
	$user_regiao    = $dados_usuario["codregiao"];
	$user_distrito  = $dados_usuario["coddistrito"];
	}

	//PAINEL
	$qr_painel ="SELECT * from painel_opcoes where codigo='1'";
	$todos_painel = mysqli_query($conn,"$qr_painel"); 
	while ($dados_painel = mysqli_fetch_array($todos_painel)) { 
	$contagem = $dados_painel["contagem"];
	}

	$contar = $contagem + 1;
	
	//CONTAR ACESSO
	mysqli_query($conn,"UPDATE painel_opcoes SET contagem='$contar' WHERE codigo='1' ")
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

 <style>
 
   </style>
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
require"../config/conexao.php";
require"../config/config.php";

 include"../config/menu.php"; 
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
$botoes_align= "align='right'"; 
$fonte_titulo = "30px";
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
                                <img class="img-responsive" src="../imagens/icone_acesso.png" 
                                style="border:white 4px solid; background-color:white;border-radius: 100px;">
                            </div>
                            <div class="media-body" style="padding-top:20px;">
                                <h2 class="media-heading" style="font-size:<?php echo"$fonte_titulo"; ?>;color:#fff" align="left"><strong>ACESSO</strong></h2>
                                <p style="color:#fff"  align="left">Alterar dados de login e senha</p>                    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" <?php echo"$botoes_align $top_botao"?>>
                    <div class="btn-group <?php echo"$botao_tamamho";?>" role="group" aria-label="Basic example">
                        <a href="index.php" class="btn btn-default">Alterar</a>
                        <a href="../painel.php" class="btn btn-default">Voltar</a>
                    </div>            
                </div>
                
            </div>
        </div>
        
					<?php
                    
                    if ($sessao == "")       { include ("alteraruser.php");}                    
                    if ($sessao == "usuario"){ include ("alteraruser.php");}
                    
                    ?>
    
    </div> 
    
</section> 

<?php

include"../config/rodape.php";

?>
 
    	 
	<script src="../config/owl-carousel/owl.carousel.js"></script>
    <style>
    #owl-demo .item{
        background-color:rgba(255, 255, 255, 0.8);
		padding: 30px 0px;
        margin: 5px;
        color: #FFF;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        text-align: center;
    }
    </style>


 <script>
    $(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 6,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
 
});
    </script>
    
	<!-- VÍDEO DO POPUP  -->
	<script type="text/javascript">
		$('.examples1 a').simpleLightboxVideo();
		$('.examples2 a').simpleLightboxVideo();
	</script>
   
   
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
    

    
    <script type="text/javascript" src="../../config/mask/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="../../config/mask/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../config/mask/jquery.zebra-datepicker.js"></script>


   
</body>
</html>
