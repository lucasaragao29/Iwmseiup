  <?php 
  
  
  echo"
  <form  style='padding-top:20px;'
name='contact-form' method='post' action='$linkar'>

<div class='col-md-12'>
<div class='form-group'>
<label style='color:#114a66'><strong>Login (Máximo de 30 caracteres)</strong></label>
<input type='text' name='log_user' value='$log_user' class='form-control' required='required' maxlength='30'>
</div>
            
</div>
<div class='col-md-12'>   
<div class='form-group'>
<label style='color:#114a66'><strong>Senha</strong></label>
<input type='password' name='senha_user' value='$senha_user' class='form-control' maxlength='30' required='required'>
</div>
</div>
<div class='col-md-12'> 
<div class='form-group'>
<button type='submit' name='submit' class='btn btn-primary btn-sm'
required='required'>ALTERAR DADOS</button>
</div>
</div>
</form>
";
  
  ?>
  
