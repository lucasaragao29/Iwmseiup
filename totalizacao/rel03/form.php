
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> TOTALIZA&Ccedil;&Atilde;O DE DISTRITOS</strong></h2>
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
        mysqli_set_charset($conn,"utf8"); ?>

    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel03'>

            <div class='col-md-3'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Regi&atilde;o</strong></label> 
                    <select name="id_categoria" id="id_categoria" class="form-control" required>
						<?php
						
						if ($nivel_user == "7" or $nivel_user == "9" or $nivel_user == "5") 
						{  $regiao_filtro = "AND id = '$regiao_user'";   }
						
						else { echo"<option value=''>Selecione</option><option value='0'>Geral</option>"; }
						
                        $result_cat_post = "SELECT * FROM pae_regiao where id !='962' $regiao_filtro ORDER BY nome";
                        $resultado_cat_post = mysqli_query($conn, $result_cat_post);
                        while($row_cat_post = mysqli_fetch_assoc($resultado_cat_post) ) {
                        echo '<option value="'.$row_cat_post['id'].'">'.$row_cat_post['nome'].'</option>';
                        }
                        ?>
                    </select>                
                </div>
            </div>
			

            
  
            
          
            
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

		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  google.load("jquery", "1.4.2");
		</script>
	
		<script type="text/javascript">
		$(function(){
			$('#id_categoria').change(function(){
				if( $(this).val() ) {
					$('#id_sub_categoria').hide();
					$('.carregando').show();
					$.getJSON('busca_distrito.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">Escolha o distrito</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						}	
						$('#id_sub_categoria').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#id_sub_categoria').html('<option value="">– Escolha Subcategoria –</option>');
				}
			});
		});
		</script>
