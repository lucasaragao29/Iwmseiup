<?php
session_start();   

$id_user =  $_SESSION['id_user'];

 
/* Página de segurança aqui o script verifica se o usuario efetuou login caso não ele sai  */


include("../config/maiuscula.php");
include("../config/minuscula.php");
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
$regiao_user   = $dados_usuario["codregiao"];
$distrito_user   = $dados_usuario["coddistrito"];	
}

$qr_painel ="SELECT * from painel_opcoes where codigo='5'";
$todos_painel = mysql_query("$qr_painel"); 
while ($dados_painel = mysql_fetch_array($todos_painel)) { 
$contagem = $dados_painel["contagem"];
}

$contar = $contagem + 1;

//CONTAR ACESSO
mysql_query("UPDATE painel_opcoes SET contagem='$contar' WHERE codigo='5' ")
or die ("Erro ao adicionar Registro!!!" . mysql_error());

?>
<!DOCTYPE html>
<html lang="en"><head>
    
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
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
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    
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
                                <img class="img-responsive" src="../imagens/icone_tesouraria.png" 
                                style="border:white 4px solid; background-color:white;border-radius: 100px;">
                            </div>
                            <div class="media-body" style="padding-top:20px;">
                                <h2 class="media-heading" style="font-size:<?php echo"$fonte_titulo"; ?>;color:#fff"
                                 align="left"><strong>FINANCEIRO</strong></h2>
                                <p style="color:#fff"  align="left">Relat&oacute;rios financeiros</p>                    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" <?php echo"$botoes_align $top_botao"?>>
                    <div class="btn-group <?php echo"$botao_tamamho";?>" role="group" aria-label="Basic example">
                       
                         <a href="index.php" class="btn btn-default">Relat&oacute;rios</a>
                        <a href="../painel.php" class="btn btn-default">Voltar</a>
                    </div>            
                </div>
                
            </div>
        </div>
		
			<?php 
			
				$sessao = $_GET["sessao"];  
					
				 //NIVEIS     
				if($sessao == "" and $nivel_user == "1")  {  include"lista.php"; }
				if($sessao == "" and $nivel_user == "2")  {  include"lista.php"; }
				if($sessao == "" and $nivel_user == "3")  {  include"lista.php"; }
				if($sessao == "" and $nivel_user == "4")  {  include"restrito.php"; }
				if($sessao == "" and $nivel_user == "5")  {  include"restrito.php"; }
				if($sessao == "" and $nivel_user == "6")  {  include"lista2.php"; }
				if($sessao == "" and $nivel_user == "7")  {  include"lista2.php"; }
				if($sessao == "" and $nivel_user == "8")  {  include"lista3.php"; }
				if($sessao == "" and $nivel_user == "9")  {  include"lista2.php"; }
				if($sessao == "" and $nivel_user == "10") {  include"lista.php"; }
				
            
			
            if($sessao == "form01") {  include"rel01/form.php"; }
            if($sessao == "rel01")  {  include"rel01/rel.php"; }

            if($sessao == "form02") {  include"rel02/form.php"; }
            if($sessao == "rel02")  {  include"rel02/rel.php"; }
            
            if($sessao == "form03") {  include"rel03/form.php"; }
            if($sessao == "rel03")  {  include"rel03/rel.php"; }
            
            if($sessao == "form04") {  include"rel04/form.php"; }
            if($sessao == "rel04")  {  include"rel04/rel.php"; }
			
            if($sessao == "form05") {  include"rel05/form.php"; }
            if($sessao == "rel05")  {  include"rel05/rel.php"; }
            
            if($sessao == "form06") {  include"rel06/form.php"; }
            if($sessao == "rel06")  {  include"rel06/rel.php"; }
            
            if($sessao == "form07") {  include"rel07/form.php"; }
            if($sessao == "rel07")  {  include"rel07/rel.php"; }
            
            if($sessao == "form08") {  include"rel08/form.php"; }
            if($sessao == "rel08")  {  include"rel08/rel.php"; }				
            
            if($sessao == "form09") {  include"rel09/form.php"; }
            if($sessao == "rel09")  {  include"rel09/rel.php"; }
            
            if($sessao == "form10") {  include"rel10/form.php"; }
            if($sessao == "rel10")  {  include"rel10/rel.php"; }
            
            if($sessao == "form11") {  include"rel11/form.php"; }
            if($sessao == "rel11")  {  include"rel11/rel.php"; }
             
            if($sessao == "form12") {  include"rel12/form.php"; }
            if($sessao == "rel12")  {  include"rel12/rel.php"; }
            
            if($sessao == "form13") {  include"rel13/form.php"; }
            if($sessao == "rel13")  {  include"rel13/rel.php"; }
             
            if($sessao == "form14") {  include"rel14/form.php"; }
            if($sessao == "rel14")  {  include"rel14/rel.php"; }

            if($sessao == "form15") {  include"rel15/form.php"; }
            if($sessao == "rel15")  {  include"rel15/rel.php"; }

            if($sessao == "form16") {  include"rel16/form.php"; }
            if($sessao == "rel16")  {  include"rel16/rel.php"; }
    
	        if($sessao == "form17") {  include"rel17/form.php"; }
            if($sessao == "rel17")  {  include"rel17/rel.php"; }
    
	        if($sessao == "form18") {  include"rel18/form.php"; }
            if($sessao == "rel18")  {  include"rel18/rel.php"; }
             
            if($sessao == "form20") {  include"rel20/form.php"; }
            if($sessao == "rel20")  {  include"rel20/rel.php"; }                      
              
            if($sessao == "form21") {  include"rel21/form.php"; }
            if($sessao == "rel21")  {  include"rel21/rel.php"; }                      
              
            if($sessao == "form22") {  include"rel22/form.php"; }
            if($sessao == "rel22")  {  include"rel22/rel.php"; }                      
              
            if($sessao == "form23") {  include"rel23/form.php"; }
            if($sessao == "rel23")  {  include"rel23/rel.php"; }                      
              
            if($sessao == "form24") {  include"rel24/form.php"; }
            if($sessao == "rel24")  {  include"rel24/rel.php"; }                      
              
            if($sessao == "form25") {  include"rel25/form.php"; }
            if($sessao == "rel25")  {  include"rel25/rel.php"; }                      
              
            if($sessao == "form26") {  include"rel26/form.php"; }
            if($sessao == "rel26")  {  include"rel26/rel.php"; }                      
 
            if($sessao == "form27") {  include"rel27/form.php"; }
            if($sessao == "rel27")  {  include"rel27/rel.php"; }                      
        
		   
		   
		   
		    ?>
            
        </div>
</section> 

<?php

include"../config/rodape.php";

?>
 <script type="text/javascript">
	    $('.date-own').datepicker({
	       minViewMode: 1,
	       format: 'yyyy-mm'
	     });
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
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
   
</body>
</html>
