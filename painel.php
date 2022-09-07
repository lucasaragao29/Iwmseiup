<?php



session_start();

  $id_user =  $_SESSION['id_user'];
 // $login =  $_SESSION['login'];
 
/*
  P�gina de seguran�a aqui o script verifica se o usuario efetuou login caso n�o ele sai
*/

include("config/warning_login.php");
include("config/erros.php");
include ('config/config.php');

// Abre conex�o ao Mysql   
// Conecta ao Banco de dados

include('config/conexao.php');
 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
 mysql_select_db($db) or die ("Impossivel Abrir Database");
 
$busca_usuario ="SELECT * from user WHERE id='$id_user'";
$todos_usuario = mysql_query("$busca_usuario"); 
while ($dados_usuario = mysql_fetch_array($todos_usuario)) { 
    $id_user    = $dados_usuario["id"];
    $nivel_user = $dados_usuario["codnivel"];
    $log_user   = $dados_usuario["login_user"];
    $senha_user = $dados_usuario["senha_user"];
    $nome_user  = $dados_usuario["nome"];
    $contagem   = $dados_usuario["contagem"];

    $_SESSION['userInfo'] = [
         'id' => $id_user,
         'login' => $log_user,
         'nivel' => $nivel_user,
         'distrito' => $dados_usuario["coddistrito"],  
         'regiao' => $dados_usuario["codregiao"],        
    ];
}

?>
<!DOCTYPE html>
<html lang="en"><head>
    
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<title><?php include"config/config.php"; echo"$title";?></title>

	<script src="config/js/jquery.min.js"></script>
        
	<!-- POPUP DE VIDEO -->
    <link rel="stylesheet" type="text/css" href="config/tiny/css/lightbox.min.css">
   
	<script type="text/javascript" src="config/tiny/js/lightbox.min.js"></script>

 <style>
 
   </style>
    <!-- scroll 
    <link href="config/css/scrolling-nav.css" rel="stylesheet">-->
    
    <!-- core CSS -->
    <link href="config/css/bootstrap.min.css" rel="stylesheet">
    <link href="config/css/font-awesome.min.css" rel="stylesheet">
    <link href="config/css/animate.min.css" rel="stylesheet">
    <link href="config/css/prettyPhoto.css" rel="stylesheet">
    <link href="config/css/main.css" rel="stylesheet">
    <link href="config/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="imagens/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="imagens/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="imagens/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="imagens/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="imagens/ico/apple-touch-icon-57-precomposed.png">
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
    </style>
    
  
       <!-- Owl Carousel Assets -->
    <link href="config/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="config/owl-carousel/owl.theme.css" rel="stylesheet">
      
<meta charset="utf-8">
</head><!--/head-->

<body class="homepage" data-spy="scroll" data-target=".navbar">

<?php 



//require"config/conexao.php";
require"config/config.php";

 include"config/menu.php";

$hora = date("H");

if ($hora >= 0 and $hora < 6) {
    $saudacao = "Boa Madrugada!";
    }
elseif ($hora >= 6 and $hora < 12) {
    $saudacao = "Bom dia!";
    }
elseif ($hora >= 12 and $hora < 18) {
    $saudacao = "Boa tarde!";
    }
    else {
    $saudacao = "Boa noite";
    }    


?>


<section id="services" class="service-item" style="background-color:#efefef;">
<div class="container">
    <div class="panel panel-custom2">
        <div class="panel-body">        
            <div class="center" style="padding-bottom:0px;">    
                <h2 style="color:#fff">Tela Principal</h2>
                <p class="lead" style="color:#fff;"><?php echo"$saudacao <font color='yellow'>$nome_user</font>";?> ao SEI este &eacute; o seu acesso n&ordm; <?php echo"<font color='yellow'>$contagem</font>";?></p>
            </div>        
        </div>
    </div>

    <?php
    
	//N�VEL 1 - MASTER
	if ($nivel_user == "1") { include("config/nivel01.php");}
	
	//N�VEL 2 - BISPO GERAL
	if ($nivel_user == "2") { include("config/nivel02.php");}
	
	//N�VEL 3 - SECRETARIO GERAL DE FINANCAS
	if ($nivel_user == "3") { include("config/nivel03.php");}
	
	//N�VEL 4 - SECRETARIO GERAL DE ADMINISTRACAO
	if ($nivel_user == "4") { include("config/nivel04.php");}
	
	//N�VEL 5 - SECRETARIO REGIONAL DE ADMINISTRACAO
	if ($nivel_user == "5") { include("config/nivel05.php");}
	
	//N�VEL 6 - SECRETARIO REGIONAL DE FINANCAS
	if ($nivel_user == "6") { include("config/nivel06.php");}
	
	//N�VEL 7 - BISPO REGIONAL
	if ($nivel_user == "7") { include("config/nivel07.php");}
	
	//N�VEL 8 - SD
	if ($nivel_user == "8") { include("config/nivel08.php");}
	
	//N�VEL 8 - COMISSAO GERAL
	if ($nivel_user == "9") { include("config/nivel09.php");}
	
	//N�VEL 8 - COMISSAO REGIONAL
	if ($nivel_user == "10") { include("config/nivel10.php");}
	
	?>
    
    </div> 

</div> 

</section> 

<?php

include"config/rodape.php";

?>
 
    	 
	<script src="config/owl-carousel/owl.carousel.js"></script>
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
    
	<!-- V�DEO DO POPUP  -->
	<script type="text/javascript">
		$('.examples1 a').simpleLightboxVideo();
		$('.examples2 a').simpleLightboxVideo();
	</script>
   
   
    <script src="config/js/bootstrap.min.js"></script>
   <script src="config/js/jquery.prettyPhoto.js"></script>
    <script src="config/js/jquery.isotope.min.js"></script>
    <!-- Javascript -->
		<script src="config/js/smooth-scroll.js"></script>
		<script>
			smoothScroll.init();
		</script>
  <script src="config/js/main.js"></script>
    <script src="config/js/wow.min.js"></script>
    

    
    <script type="text/javascript" src="../../config/mask/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="../../config/mask/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../config/mask/jquery.zebra-datepicker.js"></script>


   
</body>
</html>
