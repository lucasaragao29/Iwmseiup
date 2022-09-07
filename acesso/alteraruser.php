


       <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12" align="CENTER">
                	<h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong>Alterar Dados </strong></h2>
                </div>    
            </div>
        </div>
        
        <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
					<?php 
$ato = $_GET["ato"];

$linkar = "index.php?sessao=usuario&ato=alt&dados=$id_user";

if ($ato=="")

{

include ('tabela.php'); }

if ($ato == "alt") {

    <?php include_once __DIR__ . "/../../config/conexao.php";
    $conn = OpenCon(); ?>
	
	$log_user   = $_POST["log_user"];
	$senha_user = $_POST["senha_user"];
	
	
  

mysqli_query(conn,"UPDATE user SET login_user='$log_user',senha_user='$senha_user' WHERE id='$id_user' ") or die ("Erro ao adicionar Registro!!!" . mysql_error());

include "../config/meuip.php";

$frase_descricao = "Alterou dados de acesso do usuário"; $frase_descricao = utf8_decode($frase_descricao);

//GRAVAR HISTORICO DA ACAO
$consulta = "INSERT INTO historico_usuario
(coduser,codregiao,coddistrito, userip,sessao,
acao,codarquivo,tipo_arquivo,
data,hora)
VALUES
('$id_user','$user_regiao','$user_distrito','$user_ip','Acesso',
'$frase_descricao','$id','usuarios',
curdate( ),curtime( ))";
$resultado = mysqli_query($conn,$consulta)  or die (mysql_error());

echo "
<div class=\"col-sm-3\" align=\"center\"></div>
<div class=\"col-sm-6\" align=\"center\">
	<div class=\"panel panel-custom3\">
		<div class=\"media\" style=\"background-color:transparent;\">
			<div >
				<span class='fa-stack fa-5x' style='margin-top:10px; color:#990000;'>
				<i class='fa fa-circle fa-stack-2x'></i>
				<i class='far fa-lightbulb fa-stack-1x fa-inverse' style='color:#fff;'></i>
				</span>
			</div>
			<div class=\"media-body\" style=\"padding-top:20px;\">
				<h2 class=\"media-heading\" style=\"font-size:20px;color:#666666\" align=\"center\">
				<strong>:: DADOS DE ACESSO ALTERADOS ::</strong></h2>
				<p style=\"color:#fff\"  align=\"center\"><font color='#666666'><b>Os dados j&aacute; foram alterados no sistema.</p>                    
			</div>
		</div>
	</div>
</div>
<div class=\"col-sm-3\" align=\"center\"></div>

";    



mysqli_close($conn); 





}



?>

                
                </div>    
            </div>
        </div>
