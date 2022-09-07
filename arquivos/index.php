<?php
session_start();   

$id_user =  $_SESSION['id_user'];
$userInfo =  $_SESSION['userInfo'];
 
/* P�gina de seguran�a aqui o script verifica se o usuario efetuou login caso n�o ele sai  */


include("../config/maiuscula.php");
include("../config/minuscula.php");
include("../config/warning_login.php");
include("../config/erros.php");
include("../config/resolucao.php");
include ('../config/config.php');
// Abre conex�o ao Mysql   
// Conecta ao Banco de dados
include('../config/conexao.php');

$conn = OpenCon(); 

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
$regiao_user   = $dados_usuario["codregiao"];
$distrito_user   = $dados_usuario["coddistrito"];	
}

$qr_painel ="SELECT * from painel_opcoes where codigo='4'";
$todos_painel = mysql_query("$qr_painel"); 
while ($dados_painel = mysql_fetch_array($todos_painel)) { 
$contagem = $dados_painel["contagem"];
}

$contar = $contagem + 1;

//CONTAR ACESSO
/* mysql_query("UPDATE painel_opcoes SET contagem='$contar' WHERE codigo='4' ")
or die ("Erro ao adicionar Registro!!!" . mysql_error()); */

?>
<!DOCTYPE html>
<html lang="pt_BR"><head>
    
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<title><?php include"../config/config.php"; echo"$title";?></title>

        
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
    <link href="style.css" rel="stylesheet">
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
                                <img class="img-responsive" src="../imagens/icone_documento.png" 
                                style="border:white 4px solid; background-color:white;border-radius: 100px;">
                            </div>
                            <div class="media-body" style="padding-top:20px;">
                                <h2 class="media-heading" style="font-size:<?php echo"$fonte_titulo"; ?>;color:#fff" align="left"><strong>ARQUIVO DIGITAL</strong></h2>
                                <p style="color:#fff"  align="left">Anexo de Documentos Digitalizados</p>                    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" <?php echo"$botoes_align $top_botao"?>>
                    <div class="btn-group <?php echo"$botao_tamamho";?>" role="group" aria-label="Basic example">
                       
                         <a href="?sessao=search" id="btnsearchFiles" class="btn btn-default">Arquivo Digital</a>
                        <a href="../painel.php" class="btn btn-default">Voltar</a>
                    </div>            
                </div>
                
            </div>
        </div>
		<!-- Inicio do Arquivo Digital-->
		<?php 
			$sessao = $_GET["sessao"]; 
			if($sessao == "search") {  include"search.php"; }
			if($sessao == "newfile")  {  include"newfile.php"; }
		?>
		<!-- Fim do Arquivo Digital -->
        </div>
</section> 

<?php

include"../config/rodape.php";

?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="../config/js/bootstrap.min.js"></script>
   <script src="../config/js/jquery.prettyPhoto.js"></script>
    <script src="../config/js/jquery.isotope.min.js"></script>
    <!-- Javascript -->
		<script src="../config/js/smooth-scroll.js"></script>
		<script>
			smoothScroll.init();
		</script>
  	<!-- <script src="../config/js/main.js"></script> -->
    <!-- <script src="../config/js/wow.min.js"></script> -->
	<script src="script.js"></script>
	<script>
		let params = '<?= json_encode($userInfo); ?>';
		let data = JSON.parse(params);
		permissions(data);
	</script>
	

   
</body>
</html>
