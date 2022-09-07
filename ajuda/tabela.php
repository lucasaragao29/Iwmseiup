  <?php 
  
  
  echo"
<form  style='padding-top:20px;' name='contact-form' method='post' action='$linkar'  id='validate'>
	
	<div class='col-sm-12' align='left'>
      <h2 style='font-size:20px;padding-bottom:10px;color:#114a66'>
	  <strong><i class='fa fa-chevron-right' aria-hidden='true'></i> DADOS GERAIS</strong></h2>
    </div>
	
	<div class='col-md-8'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>T&iacute;tulo</strong></label>
			<input type='text' name='titulo' value='$titulo' class='form-control' required='required' maxlength='300'>
		</div>            
	</div>	

		
	<div class='col-md-2'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>&Aacute;rea</strong></label>
			<select name='codarea'  class='form-control' required>
			<OPTION VALUE='' "; if ($codarea == ""){ echo ("selected");} echo ">Selecione</OPTION> ";
			$qr_area = "SELECT * from conf_area order by descricao asc";
			$todos_area = mysql_query("$qr_area"); 
			while ($dados_area = mysql_fetch_array($todos_area)) { 
			$area_cod    = $dados_area["codigo"];
			$desc_area   = $dados_area["descricao"];
			echo"<OPTION VALUE='$area_cod' ";    if ($codarea == "$area_cod")  { echo ("selected");} 
			echo ">$desc_area</OPTION>"; }
			echo"</select>
		</div>            
	</div>	
	
	<div class='col-md-2'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Status</strong></label>
			<select name='codstatus'  class='form-control' required>";
			echo"<OPTION VALUE='' "; if ($codstatus == "")  { echo ("selected");} echo ">Selecione</OPTION>";
			echo"<OPTION VALUE='1' "; if ($codstatus == "1")  { echo ("selected");} echo ">Ativo</OPTION>";
			echo"<OPTION VALUE='0' "; if ($codstatus == "0")  { echo ("selected");} echo ">Inativo</OPTION>";
			echo"</select>
		</div>            
	</div>	

	<div class='col-sm-12' align='left'>
      <h2 style='font-size:20px;padding-bottom:10px;color:#114a66'>
	  <strong><i class='fa fa-chevron-right' aria-hidden='true'></i> TEXTO</strong></h2>
    </div>
	
	
	<div class='col-md-12'>   
	
		<div class='form-group'>
			<textarea rows='5' cols='50' name='texto' class='form-control'>$texto</textarea>
		</div>
		
	</div>
			
	<div class='col-md-12'> 
	
		<div class='form-group'>
			<button type='submit' name='submit' class='btn btn-primary btn-sm'
			required='required'>$modo</button>
		</div>
		
	</div>

</form>
";
  
  ?>
  
<script>
CKEDITOR.replace( 'texto', {
height:600
} );
</script>  
