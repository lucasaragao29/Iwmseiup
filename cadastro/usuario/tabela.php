  <?php 
  
  
  echo"
<form  style='padding-top:20px;' name='contact-form' method='post' action='$linkar' id='validate'>
	
	<div class='col-sm-12' align='left'>
      <h2 style='font-size:20px;padding-bottom:10px;color:#114a66'>
	  <strong><i class='fa fa-chevron-right' aria-hidden='true'></i> DADOS DO USU&Aacute;RIO</strong></h2>
    </div>
	
	<div class='col-md-4'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Nome</strong></label>
			<input type='text' name='nome' value='$nome' class='form-control' required='required' maxlength='30'>
		</div>            
	</div>
				 
	
	<div class='col-md-4'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>E-mail</strong></label>
			<input type='text' name='email' value='$email' class='form-control'  maxlength='255'>
		</div>            
	</div>
	
	<div class='col-md-4'>   
	
		<div class='form-group'>
			<label style='color:#114a66'><strong>Fun&ccedil;&atilde;o</strong></label>
			<select name='funcao'  class='form-control' required>
			<OPTION VALUE='' "; if ($funcao == ""){ echo ("selected");} echo ">Selecione</OPTION> ";
			$qr_funcao="SELECT * from usuarios_funcao WHERE nivel < '20' order by nivel asc";
			$todos_funcao = mysql_query("$qr_funcao"); 
			while ($dados_funcao = mysql_fetch_array($todos_funcao)) { 
			$funcao_cod     = $dados_funcao["codigo"];
			$desc_funcao    = $dados_funcao["descricao"];
			$nivel_funcao    = $dados_funcao["nivel"];
			echo"<OPTION VALUE='$funcao_cod' ";    if ($funcao == "$funcao_cod")  { echo ("selected");} 
			echo ">$desc_funcao (N&iacute;vel $nivel_funcao)</OPTION>"; }
			echo"</select>
		</div>
		
	</div>	
	
	<div class='col-md-4'>   
	
		<div class='form-group'>
			<label style='color:#114a66'><strong>Regi&atilde;o</strong></label>
			<select name='codregiao'  class='form-control' required>
			<OPTION VALUE='' "; if ($codregiao == ""){ echo ("selected");} echo ">Selecione</OPTION>
			<OPTION VALUE='0' "; if ($codregiao == "0"){ echo ("selected");} echo ">Geral</OPTION> ";
			$qr_regiao="SELECT * from pae_regiao where id !='962'  order by nome asc";
			$todos_regiao = mysql_query("$qr_regiao"); 
			while ($dados_regiao = mysql_fetch_array($todos_regiao)) { 
			$regiao_cod     = $dados_regiao["id"];
			$desc_regiao    = $dados_regiao["nome"];
			echo"<OPTION VALUE='$regiao_cod' ";    if ($codregiao == "$regiao_cod")  { echo ("selected");} 
			echo ">$desc_regiao</OPTION>"; }
			echo"</select>
		</div>
		
	</div>	
	
	<div class='col-md-8'>   
	
		<div class='form-group'>
			<label style='color:#114a66'><strong>Distrito</strong></label>
			<select name='coddistrito'  class='form-control' required>
			<OPTION VALUE='' "; if ($coddistrito == ""){ echo ("selected");} echo ">Selecione</OPTION>
			<OPTION VALUE='0' "; if ($coddistrito == "0"){ echo ("selected");} echo ">Nenhum</OPTION> ";
			$qr_distrito="SELECT DISTINCT id,nome,regiao_id from pae_distrito order by nome asc";
			$todos_distrito = mysql_query("$qr_distrito"); 
			while ($dados_distrito = mysql_fetch_array($todos_distrito)) { 
			$distrito_cod     = $dados_distrito["id"];
			$desc_distrito    = $dados_distrito["nome"];
			$desc_codregiao    = $dados_distrito["regiao_id"];
				
				$desc_distrito = str_replace("Distrito ", "", $desc_distrito); 

				//REGIAO
				$qr_regiao_p ="SELECT * from pae_regiao where id='$desc_codregiao'";
				$todos_regiao_p = mysql_query("$qr_regiao_p"); 
				while ($dados_regiao_p = mysql_fetch_array($todos_regiao_p)) { 
				$nome_regiao    = $dados_regiao_p["nome"];
				}
			
			
			echo"<OPTION VALUE='$distrito_cod' ";    if ($coddistrito == "$distrito_cod")  { echo ("selected");} 
			echo ">$desc_distrito - $nome_regiao</OPTION>"; }
			echo"</select>
		</div>
		
	</div>	

	<div class='col-sm-12' align='left'>
      <h2 style='font-size:20px;padding-bottom:10px;color:#114a66'>
	  <strong><i class='fa fa-chevron-right' aria-hidden='true'></i> ACESSO AO SISTEMA</strong></h2>
    </div>
	
	<div class='col-md-4'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Login</strong></label>
			<input type='text' name='login_acesso' value='$login_acesso' class='form-control' required='required' maxlength='50'>
		</div>            
	</div>
	
	<div class='col-md-4'>
		<div class='form-group'>
			<label style='color:#114a66'><strong>Senha</strong></label>
			<input type='text' name='senha_acesso' value='$senha_acesso' class='form-control' required='required' maxlength='20'>
		</div>            
	</div>	
	
	
	<div class='col-md-4'>   
	
		<div class='form-group'>
			<label style='color:#114a66'><strong>Status</strong></label>
			<select name='codstatus'  class='form-control' required>";
			echo"<OPTION VALUE='' "; if ($codstatus == "")  { echo ("selected");} echo ">Selecione</OPTION>";
			echo"<OPTION VALUE='1' "; if ($codstatus == "1")  { echo ("selected");} echo ">Ativo</OPTION>";
			echo"<OPTION VALUE='0' "; if ($codstatus == "0")  { echo ("selected");} echo ">Inativo</OPTION>";
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
  
