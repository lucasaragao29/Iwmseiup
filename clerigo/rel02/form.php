
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> STATUS POR REGI&Atilde;O</strong></h2>
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


    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel02'>

            <div class='col-md-4'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Regi&atilde;o</strong></label> 
                    <select name="id_categoria" id="id_categoria" class="form-control" required>
						<?php
						
    
        // Estabelece conexao com o banco de dados
        include_once __DIR__ . "/../../config/conexao.php";
        $conn = OpenCon();
						
						if ($nivel_user == "5" or $nivel_user == "7" or $nivel_user == "9" or $nivel_user == "8") 
						{  $regiao_filtro = "AND id = '$regiao_user'";   }
						
						else { echo"<option value=''>Selecione</option>"; }
						
						if ($nivel_user == "8") { $distrito_filtro = "AND id='$distrito_user'";  }  
						
                        $result_cat_post = "SELECT * FROM pae_regiao where id !='962' $regiao_filtro ORDER BY nome";
                        $resultado_cat_post = mysqli_query($conn, $result_cat_post);
                        while($row_cat_post = mysqli_fetch_assoc($resultado_cat_post) ) {
                            echo '<option value="'.$row_cat_post['id'].'">'.$row_cat_post['nome'].'</option>';
                        }
                        ?>
                    </select>                
                </div>
            </div>
			
		
            
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

		
