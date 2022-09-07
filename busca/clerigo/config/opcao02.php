<section id="services" class="service-item" style="background-color:#efefef;">
    <div class="container">
    
        <div class="panel panel-custom2">
            <div class="panel-body"> 
            
                <div class="col-sm-6" align="center">
                    <div class="panel panel-custom2">
                        <div class="media " style="background-color:transparent;">
                            <div class="pull-left">
                                <img class="img-responsive" src="../../imagens/icone_cadastro.png" 
                                style="border:white 4px solid; background-color:white;border-radius: 100px;">
                            </div>
                            <div class="media-body" style="padding-top:20px;">
                                <h2 class="media-heading" style="font-size:<?php echo"$fonte_titulo"; ?>;color:#fff" align="left"><strong>CADASTRO</strong></h2>
                                <p style="color:#fff"  align="left"><strong>IGREJAS</strong></p>                    
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" <?php echo"$botoes_align $top_botao"?>>
                    <div class="btn-group <?php echo"$botao_tamamho";?>" role="group" aria-label="Basic example">
             
                        
                        <?php  if ($nivel_user == '7') 
							{ echo"<a href='index.php?sessao=b' class='btn btn-default'>Visualizar</a>"; } ?> 
                        <a href="../index.php" class="btn btn-default">Voltar</a>
                    </div>            
                </div>
                
            </div>
        </div>

		<?php

			echo"
			<div class='panel panel-custom3'>
				<div class='panel-body'>
					<div class='col-sm-12' align='CENTER'>
					<h3 style=\"padding:50px;color:black;\"><b>OP&Ccedil;&Atilde;O N&Atilde;O HABILITADA PARA ESTE USU&Aacute;RIO</b></h3>
					</div>    
				</div>
			</div>"; 		
			

		?>
    
    </div> 
    
</section> 