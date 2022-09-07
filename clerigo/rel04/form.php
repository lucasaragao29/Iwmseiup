
<div class="panel panel-custom" id='loc'>
    <div class="panel-body">
        <div class="col-sm-12" align="CENTER">
        <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong><i class="fa fa-file-text"></i> LISTA DE ANIVERSARIANTES GERAL</strong></h2>
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
    
        <form  style='padding-top:20px;' name='contact-form' method='post' action='index.php?sessao=rel04'>

			
                           <?php
					
			echo"<div class='col-md-4'>
			<div class='form-group'>
			<label style='color:#114a66'><strong>M&ecirc;s</strong></label>";
			echo"<select name='mes' class='form-control' required>";
			echo"<OPTION VALUE='0' ";  if ($mes == "0")  { echo ("selected");} echo ">Todo os meses</OPTION>";
			echo"<OPTION VALUE='01' "; if ($mes == "01")  { echo ("selected");} echo ">Janeiro</OPTION>";
			echo"<OPTION VALUE='02' "; if ($mes == "02")  { echo ("selected");} echo ">Fevereiro</OPTION>";
			echo"<OPTION VALUE='03' "; if ($mes == "03")  { echo ("selected");} echo ">Mar&ccedil;o</OPTION>";
			echo"<OPTION VALUE='04' "; if ($mes == "04")  { echo ("selected");} echo ">Abril</OPTION>";
			echo"<OPTION VALUE='05' "; if ($mes == "05")  { echo ("selected");} echo ">Maio</OPTION>";
			echo"<OPTION VALUE='06' "; if ($mes == "06")  { echo ("selected");} echo ">Junho</OPTION>";
			echo"<OPTION VALUE='07' "; if ($mes == "07")  { echo ("selected");} echo ">Julho</OPTION>";
			echo"<OPTION VALUE='08' "; if ($mes == "08")  { echo ("selected");} echo ">Agosto</OPTION>";
			echo"<OPTION VALUE='09' "; if ($mes == "09")  { echo ("selected");} echo ">Setembro</OPTION>";
			echo"<OPTION VALUE='10' "; if ($mes == "10")  { echo ("selected");} echo ">Outubro</OPTION>";
			echo"<OPTION VALUE='11' "; if ($mes == "11")  { echo ("selected");} echo ">Novembro</OPTION>";	
			echo"<OPTION VALUE='12' "; if ($mes == "12")  { echo ("selected");} echo ">Dezembro</OPTION>";				

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