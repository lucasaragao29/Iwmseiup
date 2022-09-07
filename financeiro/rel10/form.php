
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> IRRF</strong></h2>
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
	$conn = mysqli_connect($host, $user, $pass, $db); 
        mysqli_set_charset($conn,"utf8");
?>
    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel10'>

            <div class='col-md-2'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Regi&atilde;o</strong></label> 
                    <select name="id_categoria" id="id_categoria" class="form-control" required>
						<?php
						
						if ($nivel_user == "6" or $nivel_user == "7" or $nivel_user == "9" or $nivel_user == "8") 
						{  $regiao_filtro = "AND id = '$regiao_user'";  }
						
						if ($nivel_user != "8" )  { echo"<option value=''>Selecione</option>"; }
						
						if ($nivel_user == "8") { $distrito_filtro = "AND distrito_id='$distrito_user'";  }  
						
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
			
			if ($nivel_user == "8") { 
			
			 echo"<div class='col-md-4'>
				<div class='form-group'>
					<label style='color:#114a66'><strong>Distrito</strong></label> 
					<select name='id_sub_categoria' id='id_sub_categoria' class='form-control' required>";
					
						$result_subcat_post = "SELECT * FROM pae_distrito where id='$distrito_user' ORDER BY nome";
						$resultado_subcat_post = mysqli_query($conn, $result_subcat_post);
						while($row_subcat_post = mysqli_fetch_assoc($resultado_subcat_post) ) {
						$distrito_nome  = $row_subcat_post["nome"];
						$distrito_user  = $row_subcat_post["id"];
						
						
       					 $distrito_nome = str_replace("Distrito ", "", $distrito_nome);  
		
							echo "<option value='$distrito_user'>$distrito_nome</option>";
						}
					
					echo"</select>                
				</div>
			</div>";
			
			}
			
			else {
			
			echo"<div class='col-md-4'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Distrito</strong></label> 
                    <span class='carregando'>Aguarde, carregando...</span>
                    <select name='id_sub_categoria' id='id_sub_categoria'  class='form-control'  required>
                    <option value=''>Selecione</option>
                    </select>                
                </div>
            </div>";	
				
			}
			
			?>
            
           <?php 
		   
		   	$hoje = getdate();
			$ano = $hoje["year"];
			$mes = $hoje["mon"];
			$dia = $hoje["mday"];
		   
		   echo"<div class='col-md-3'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Data Inicial</strong></label> 
                    <input type='month' class='form-control' required name='datai'  min='2010-01' max='$dia-$mes'> 
                </div>
            </div>
            
            
			<div class='col-md-3'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Data Final</strong></label> 
                    <input type='month' class='form-control' required name='dataf' min='2010-01' max='2019-06'> 
                </div>
            </div>";
			
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript">
		$(function(){
			$('#id_categoria').change(function(){
				if( $(this).val() ) {
					$('#id_sub_categoria').hide();
					$('.carregando').show();
					$.getJSON('busca_distrito.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">Selecione o distrito</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						}	
						$('#id_sub_categoria').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#id_sub_categoria').html('<option value="">– Selecione o distrito –</option>');
				}
			});
		});
		</script>
