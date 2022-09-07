  <header id="header"> 
        
        <div class="top-bar" style="background-image:url(/imagens/fundo_login.jpg);background-repeat: no-repeat;background-size: cover;";>  
         <div class="container">
                <div class="row">
                    <div class="col-sm-2"  align="center"></div>
                    <div class="col-sm-8"  align="center">
                      <img src="<?php echo"$site_link"; ?>/imagens/logo_dream.png" alt="logo" class="img-responsive">
                       </div>
                       <div class="col-sm-2"  align="center"></div>
                   
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                   
                </div>
				

                <div class="collapse navbar-collapse navbar-center">
                    <ul class="nav navbar-nav">
                    
                        <li><a href="<?php echo"$site_link"; ?>/painel.php"><font color="yellow">PRINCIPAL</font></a></li> 
                        
						
						<?php 
						 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
						 mysql_select_db($db) or die ("Impossivel Abrir Database");
						
						    
						//NÍVEL 1 - MASTER
						if ($nivel_user == "1") { $codpainel = "and master='1'";}
						
						//NÍVEL 2 - BISPO GERAL
						if ($nivel_user == "2") { $codpainel = "and bispo_geral='1'";}
						
						//NÍVEL 3 - SECRETARIO GERAL DE FINANCAS
						if ($nivel_user == "3") { $codpainel = "and sec_g_financa='1'";}
						
						//NÍVEL 4 - SECRETARIO GERAL DE ADMINISTRACAO
						if ($nivel_user == "4") { $codpainel = "and sec_g_adm='1'";}
						
						//NÍVEL 5 - SECRETARIO REGIONAL DE ADMINISTRACAO
						if ($nivel_user == "5") { $codpainel = "and sec_r_adm='1'";}
						
						//NÍVEL 6 - SECRETARIO REGIONAL DE FINANCAS
						if ($nivel_user == "6") { $codpainel = "and sec_r_financa='1'";}
						
						//NÍVEL 7 - BISPO REGIONAL
						if ($nivel_user == "7") { $codpainel = "and bispo_regional='1'";}
						
						//NÍVEL 8 - SD
						if ($nivel_user == "7") { $codpainel = "and sd='1'";}
						
						//NÍVEL 8 - COMISSAO GERAL
						if ($nivel_user == "9") { $codpainel = "and comissaoregional='1'";}
						
						//NÍVEL 8 - COMISSAO REGIONAL
						if ($nivel_user == "10") { $codpainel = "and comissaogeral='1'";}
						
						//GERAR MENU PERSONALIZADO AO NIVEL DE ACESSO
						$qr_painel ="SELECT * from painel_opcoes WHERE codstatus='1' $codpainel order by contagem desc limit 0,7";
						$todos_painel = mysql_query("$qr_painel"); 
						while ($dados_painel = mysql_fetch_array($todos_painel)) { 
						$descricao_opcao = $dados_painel["descricao"];
						$link_opcao      = $dados_painel["link"];
						
						echo"<li><a href=\"$link_opcao\">$descricao_opcao</a></li> ";
						
						}
						?>
						
                        <li><a href="<?php echo"$site_link"; ?>/"><font color="yellow">SAIR</font></a></li>  
                        
                                              
                    </ul>
                </div>
            </div>
            
       </nav>
        </header><!--/header-->
