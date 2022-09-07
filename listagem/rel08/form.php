
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> LISTAGEM DE CL&Eacute;RIGOS POR REGI&Atilde;O</strong></h2>
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

    
    <?php 
	
	//include_once("../../config/conexao.php");
	$conn = mysqli_connect($host, $user, $pass, $db); 
        mysqli_set_charset($conn,"utf8"); ?>

    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel08'>

            <div class='col-md-4'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Regi&atilde;o</strong></label> 
                    <select name="id_categoria" id="id_categoria" class="form-control" required>
                    <option value="">Selecione</option>
						<?php
                        $result_cat_post = "SELECT * FROM pae_regiao where id !='962' ORDER BY nome";
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
			<label style='color:#114a66'><strong>Fun&ccedil;&atilde;o Eclesi&aacute;stica</strong></label>";
			
			$conn = mysql_connect($host,$user,$pass);
			$banco = mysql_select_db($db); 
			
			$hoje = getdate();
			$ano_atual = $hoje["year"];
							  
			echo"<select name='funcao' class='form-control' required>";
			echo"<OPTION VALUE='' ";   if ($funcao == "")   { echo ("selected");} echo ">Selecione</OPTION>";
			echo"<OPTION VALUE='0' ";  if ($funcao == "0")  { echo ("selected");} echo ">Todos</OPTION>";
			echo"<OPTION VALUE='7' ";  if ($funcao == "7")  { echo ("selected");} echo ">Co-pastor</OPTION>";
			echo"<OPTION VALUE='8' ";  if ($funcao == "8")  { echo ("selected");} echo ">Ministro Integral</OPTION>";
			echo"<OPTION VALUE='9' ";  if ($funcao == "9")  { echo ("selected");} echo ">Pastor Titular Integral</OPTION>";
			echo"<OPTION VALUE='11' "; if ($funcao == "11") { echo ("selected");} echo ">Mission&aacute;ria</OPTION>";
			echo"<OPTION VALUE='10' "; if ($funcao == "10") { echo ("selected");} echo ">Pastor Ajudante Intergral</OPTION>";
			echo"<OPTION VALUE='18' "; if ($funcao == "18") { echo ("selected");} echo ">Ministro Parcial</OPTION>";
			echo"<OPTION VALUE='19' "; if ($funcao == "19") { echo ("selected");} echo ">Pastor Titular Parcial</OPTION>";
			echo"<OPTION VALUE='20' "; if ($funcao == "20") { echo ("selected");} echo ">Pastor Ajudante Parcial</OPTION>";
			echo"<OPTION VALUE='22' "; if ($funcao == "22") { echo ("selected");} echo ">Pastor Titular (sem &ocirc;nus)</OPTION>";
			echo"<OPTION VALUE='23' "; if ($funcao == "23") { echo ("selected");} echo ">Pastor Ajudante (sem &ocirc;nus)</OPTION>";
			echo"<OPTION VALUE='24' "; if ($funcao == "24") { echo ("selected");} echo ">Mission&aacute;ria (sem &ocirc;nus)</OPTION>";
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

