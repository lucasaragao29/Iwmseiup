<?php



//$mensagem = $_GET['mensagem'];

session_start(); 

session_destroy(); 

include ('config/config.php');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
      <title><?php echo"$title";?></title>
    
    <!-- core CSS -->
    <link href="config/css/bootstrap.min.css" rel="stylesheet">
    <link href="config/css/font-awesome.min.css" rel="stylesheet">
    <link href="config/css/prettyPhoto.css" rel="stylesheet">
    <link href="config/css/animate.min.css" rel="stylesheet">
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
    
 <style>
 .btn-sample { 
  color: #ffffff; 
  background-color: #171B7C; 
  border-color: #080A4A; 
} 
 
.btn-sample:hover, 
.btn-sample:focus, 
.btn-sample:active, 
.btn-sample.active, 
.open .dropdown-toggle.btn-sample { 
  color: #ffffff; 
  background-color: #ab040b; 
  border-color: #080A4A; 
} 
 
.btn-sample:active, 
.btn-sample.active, 
.open .dropdown-toggle.btn-sample { 
  background-image: none; 
} 
 
.btn-sample.disabled, 
.btn-sample[disabled],fieldset[disabled] .btn-sample, .btn-sample.disabled:hover,
.btn-sample[disabled]:hover, fieldset[disabled] .btn-sample:hover, .btn-sample.disabled:focus, 
.btn-sample[disabled]:focus,fieldset[disabled] .btn-sample:focus, .btn-sample.disabled:active, 
.btn-sample[disabled]:active, fieldset[disabled] .btn-sample:active, .btn-sample.disabled.active, 
.btn-sample[disabled].active, fieldset[disabled] .btn-sample.active { 
  background-color: #171B7C; 
  border-color: #080A4A; 
} 
 
.btn-sample .badge { 
  color: #171B7C; 
  background-color: #ffffff; 
}
 </style>   
    
</head><!--/head-->

<body style="background-image:url(imagens/fundo_login.jpg);background-repeat: no-repeat;background-size: cover;padding-top: 40px;
  padding-bottom: 40px; ">

 
<section id="contact-page">

    <div class="container">
    	<div class="row">
            <div class="col-md-4" align="center"></div>
            <div class="col-md-4" align="center">
            
                <div ><img src="imagens/logo_entrada.png" class="img-responsive"></div>  
                <div class="status alert alert-success" style="display: none"></div>            
                <form action="index2.php" method="post" role="form">
                    
                    <div class="col-md-12">
                    
                        <div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="Login" id="login" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="password" name="senha" class="form-control" placeholder="senha" id="pwd" required>
                        </div>
                        
                        <div class="form-group">
                            
                        </div>  
                        <button type="submit" name="submit" class="btn btn-lg btn-sample btn-block" >Logar</button>
                        <div class="form-group">
                            <label align="center"><strong><font color="#190D67">IGREJA METODISTA WESLEYANA</font>
                            </strong></button></label>
                        </div>
                                       
                    </div>
                    
                </form>  
            
            </div><!-- col-row-4-->
            <div class="col-md-4" align="center"></div>
            
            
      </div> <!-- row -->  
    </div><!--/.container-->
    
</section><!--/#contact-page-->



    <script src="config/js/jquery.js"></script>
    <script src="config/js/bootstrap.min.js"></script>
    <script src="config/js/jquery.prettyPhoto.js"></script>
    <script src="config/js/jquery.isotope.min.js"></script>
    <script src="config/js/main.js"></script>
    <script src="config/js/wow.min.js"></script>
</body>
</html>
