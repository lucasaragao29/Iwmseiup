
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> STATUS GERAL</strong></h2>
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
	$conn = OpenCon(); ?>
    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel01'>

		
            
                           <?php
					
			echo"<div class='col-md-4'>
			<div class='form-group'>
			<label style='color:#114a66'><strong>Status</strong></label>";
			echo"<select name='status' class='form-control' required>";
			echo"<OPTION VALUE='' ";            if ($status == "")  { echo ("selected");} echo ">Selecione</OPTION>";
			echo"<OPTION VALUE='Ativo' "; if ($status == "Ativo")  { echo ("selected");} echo ">Ativo</OPTION>";
			echo"<OPTION VALUE='Descontinuado' "; if ($status == "Descontinuado")  { echo ("selected");} echo ">Descontinuado</OPTION>";
			echo"<OPTION VALUE='Desligado' ";  if ($status == "Desligado")  { echo ("selected");} echo ">Desligado</OPTION>";
			echo"<OPTION VALUE='Falecido' ";    if ($status == "Falecido")  { echo ("selected");} echo ">Falecido</OPTION>";
			echo"<OPTION VALUE='Jubilado' ";    if ($status == "Jubilado")  { echo ("selected");} echo ">Jubilado</OPTION>";
			echo"<OPTION VALUE='Licenciado' ";  if ($status == "Licenciado")  { echo ("selected");} echo ">Licenciado</OPTION>";
			echo"<OPTION VALUE='Transferido' "; if ($status == "Transferido")  { echo ("selected");} echo ">Transferido</OPTION>";			

			echo"</select>
			</div><!-- form-group -->      
			</div><!-- col-md-2 -->";
			
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

		
