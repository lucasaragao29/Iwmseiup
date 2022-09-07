
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> ESTAT&Iacute;STICAS DE RECEP&Ccedil;&Atilde;O,DESLIGAMENTO E<BR>TRANSFER&Ecirc;NCIA GERAL</strong></h2>
        </div> <!-- col-sm-12 -->  
    </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->
<style type="text/css">
			.carregando{
				color:#ff0000;
				display:none;
			}
		</style>
<div class="panel panel-custom">
    <div class="panel-body">
        <div class="col-sm-12">        

    
    <?php //include_once("../../config/conexao.php");
	$conn = mysqli_connect($host, $user, $pass, $db); ?>
    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel17'>

           
            
            <?php
					
			echo"<div class='col-md-2'>
			<div class='form-group'>
			<label style='color:#114a66'><strong>Ano Eclesi&aacute;stico</strong></label>";
			
			$conn = mysql_connect($host,$user,$pass);
			$banco = mysql_select_db($db); 
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
							  
			echo"<select name='ano' class='form-control' required>";
				
				$qr_ano = "SELECT * from  conf_ano WHERE ano between '2010' and $ano_atual order by ano desc";
				$todos_ano = mysql_query("$qr_ano"); 
				while ($dados_ano = mysql_fetch_array($todos_ano)) {
				$ano_texto  = $dados_ano["ano"];
			
			echo"<OPTION VALUE='$ano_texto' ";    if ($ano == "$ano_texto")  { echo ("selected");} echo ">$ano_texto</OPTION>"; 
			
			}
			echo"</select>
			</div><!-- form-group -->      
			</div><!-- col-md-4 -->";
			
			?> 
            
        
            
             <div class='col-md-12'> 
                <div class='form-group'>
                    <button type='submit' name='submit' class='btn btn-primary btn-sm'
                    required='required'>GERAR RELAT&Oacute;RIO</button>
                </div> <!-- form-group --> 
            </div> <!-- col-md-12 -->
        
        </form>           
        
        
        
        </div>  <!-- col-sm-12 -->  
        </div> <!-- panel-body -->
</div> <!-- panel panel-custom -->

	