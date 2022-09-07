<?php 
function formatarCnpj($cnpj_cpf)
{
  if (strlen(preg_replace("/\D/", '', $cnpj_cpf)) === 11) {
    $response = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } else {
    $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
  }

  return $response;
}?>