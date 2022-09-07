  <?php 
  
  
  echo"
<form  style='padding-top:20px;' name='contact-form' method='post' action='$linkar' id='validate'>
	
	<div class='col-sm-12' align='left'>
      <h2 style='font-size:20px;padding-bottom:10px;color:#114a66'>
	  <strong><i class='fa fa-chevron-right' aria-hidden='true'></i> DADOS DA IGREJA</strong></h2>
    </div>
	
	<div class='col-md-5'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Nome</strong></label>
			<input type='text' name='nome' value='$nome' class=' form-control' required='required' maxlength='255'>
		</div>            
	</div>
	
	<div class='col-md-5'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Distrito</strong></label>			
			<select name='coddistrito' class='form-control' required>";
			echo"<OPTION VALUE='' ";  if ($coddistrito == "") { echo ("selected");} echo ">Selecione</OPTION>";
					
			$qr_distrito = "SELECT * from cad_distrito order by nome asc";
			$todos_distrito = mysql_query("$qr_distrito"); 			
			while ($dados_distrito = mysql_fetch_array($todos_distrito)) { 
				$distrito_cod  = $dados_distrito["codigo"];
				$distrito_nome = $dados_distrito["nome"];
				
				echo"<OPTION VALUE='$distrito_cod' ";    
				if ($coddistrito == "$distrito_cod")  { 
					echo ("selected");
				} 
				echo ">$distrito_nome</OPTION>"; 		 
			}
	
			echo "</select>
		</div>            
	</div>	
			
	<div class='col-md-2'>   
	
		<div class='form-group'>
			<label style='color:#114a66'><strong>Status</strong></label>
			<select name='codstatus'  class='form-control'>";
			echo"<OPTION VALUE='' ";  if ($codstatus == "") { echo ("selected");} echo ">Selecione</OPTION>";
			echo"<OPTION VALUE='1' "; if ($codstatus == "1"){ echo ("selected");} echo ">Ativo</OPTION>";
			echo"<OPTION VALUE='2' "; if ($codstatus == "0"){ echo ("selected");} echo ">Inativo</OPTION>";
			echo"</select>
			
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