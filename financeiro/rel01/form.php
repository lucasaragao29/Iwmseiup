
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> BALANCETE DE IGREJA</strong></h2>
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

        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel01'>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Distrito</strong></label> 
                    <select name="id_categoria" id="id_categoria" class="form-control" required>
						<?php
						
        // Estabelece conexao com o banco de dados
        include_once __DIR__ . "/../../config/conexao.php";
        $conn = OpenCon();

						if ($nivel_user == "6" or $nivel_user == "7" or $nivel_user == "9" or $nivel_user == "8") 
						{  $regiao_filtro = "AND regiao_id = '$regiao_user'";  }
						
						echo"<option value=''>Selecione</option>";
						
						if ($nivel_user == "8") { $distrito_filtro = "AND id='$distrito_user'";  }  
												
                        $result_cat_post = "SELECT DISTINCT nome,regiao,id
						FROM pae_distrito
						WHERE regiao_id !='26' 
						AND regiao_id !='2762' 
						AND regiao_id !='962'
						$regiao_filtro
						$distrito_filtro
						ORDER BY nome ASC";
                        $resultado_cat_post = mysqli_query($conn, $result_cat_post);
                        while($row_cat_post = mysqli_fetch_assoc($resultado_cat_post) ) {
						$distrito_nome  = $row_cat_post["nome"];	
						$distrito_nome = str_replace("Distrito ", "", $distrito_nome);
                            echo '<option value="'.$row_cat_post['id'].'">'.$distrito_nome.' - '.$row_cat_post['regiao'].'</option>';
                        }
                        ?>
                    </select>                
                </div>
            </div>
			
			<div class='col-md-6'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Igrejas</strong></label> 
                    <span class="carregando">Aguarde, carregando...</span>
                    <select name="id_sub_categoria" id="id_sub_categoria"  class="form-control"  required>
                    <option value="">Selecione</option>
                    </select>                
                </div>
            </div>
            
            <?php 
		   
		   	$hoje = getdate();
			$ano = $hoje["year"];
			$mes = $hoje["mon"];
			$dia = $hoje["mday"];
			
			if ($dia < "10") { $dia = "0$dia";  } else { $dia = $dia; }
			if ($mes < "10") { $mes = "0$dia";  } else { $mes = $mes; }
		   
		   echo"<div class='col-md-3'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Data Inicial</strong></label> 
                    <input type='month' class='form-control' required name='datai'  max='$ano-$mes-$dia'> 
                </div>
            </div>";
					   
		   echo"<div class='col-md-3'>
                <div class='form-group'>
                    <label style='color:#114a66'><strong>Data Final</strong></label> 
                    <input type='month' class='form-control' required name='dataf'  max='$ano-$mes-$dia'> 
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
					$.getJSON('busca_igreja.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">Escolha a Igreja</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						}	
						$('#id_sub_categoria').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#id_sub_categoria').html('<option value="">– Escolha a Igreja –</option>');
				}
			});
		});
		</script>
