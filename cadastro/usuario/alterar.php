<?php
include_once('../../config/conexao.php');


$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}



 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
 mysql_select_db($db) or die ("Impossivel Abrir Database");

// retorna uma pesquisa
$result = mysql_query("Select * from user where id='$dados'");
while($row = mysql_fetch_array($result)) {
	//Recupera os dados do banco de dados
$codigo       = $row["id"];
$nome         = $row["nome"];
$email        = $row["email"];
$funcao       = $row["funcao"];

$codregiao    = $row["codregiao"];
$coddistrito  = $row["coddistrito"];
$login_acesso = $row["login_user"];
$senha_acesso = $row["senha_user"];
$codstatus    = $row["codstatus"];



}


?>


       <div class="panel panel-custom" style="background-color:#114a66" id='loc'>
            <div class="panel-body">
                 <div class="col-sm-3" align="CENTER">
                	<P style="font-size:25px;color:#fff;margin-top:15px;"><strong>ALTERAR DADOS</strong></P>
                </div>  
                
                <div class="col-sm-9" align="<?php echo"$botoes_aliamento"; ?>">
                
                    <a href='index.php?sessao=ver&dados=<?php echo"$codigo&pagina=$pagina$odado#loc";?>' title='Visualizar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-eye fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                    
                    <a href='index.php?sessao=al&dados=<?php echo"$codigo&pagina=$pagina$odado#loc";?>' title='Alterar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-edit fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                      
               
                                      
                    <a href='index.php?sessao=b<?php echo"&pagina=$pagina$odado#loc";?>' title='Retornar'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-undo fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                
                </div>   
                
                 
                 
            </div>
        </div>
        
        <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
					<?php 
$ato = $_GET["ato"];

$linkar = "index.php?sessao=al&ato=alt&dados=$dados&pagina=$pagina$odado#loc";
$modo = "ALTERAR DADOS";
if ($ato=="")

{

include ('tabela.php'); }

if ($ato == "alt") {

//	include('../../config/conexao.php');
	
	$link = @mysql_connect($host,$user,$pass)  or die("N&atilde;o foi poss&iacute;vel conectar");
	mysql_select_db($db) or die("N&atilde;o foi poss&iacute;vel selecionar o banco de dados");
	
	$nome          = $_POST["nome"];
	$funcao        = $_POST["funcao"];
	$email         = $_POST["email"];
	
	$login_acesso  = $_POST["login_acesso"];
	$senha_acesso  = $_POST["senha_acesso"];
	$nivel         = $_POST["nivel"];
	$codregiao     = $_POST["codregiao"];
	$coddistrito   = $_POST["coddistrito"];
	$codstatus     = $_POST["codstatus"];
		


$qr_funcao_nivel="SELECT * from usuarios_funcao where codigo='$funcao'";
$todos_funcao_nivel = mysql_query("$qr_funcao_nivel"); 
while ($dados_funcao_nivel = mysql_fetch_array($todos_funcao_nivel)) { 
$nivel_funcao    = $dados_funcao_nivel["nivel"];
}

mysql_query("UPDATE user SET 
nome='$nome',email='$email',funcao='$funcao',codstatus='$codstatus',
codnivel='$nivel_funcao',codregiao='$codregiao',coddistrito='$coddistrito',
login_user='$login_acesso',
senha_user='$senha_acesso' WHERE id='$dados' ") or die (mysql_error());
	
include "../../config/meuip.php";
	
//GRAVAR HISTORICO DA ACAO
$GRAVAR = "INSERT INTO historico_usuario
(coduser,codregiao,coddistrito, userip,sessao,
acao,codarquivo,tipo_arquivo,
data,hora)
VALUES
('$id_user','$regiao_user','$distrito_user','$user_ip','Cadastros > Usuários',
'Alterar dados de usuario $nome','$dados','usuarios',
curdate( ),curtime( ))";
$GRAVACAO = mysql_query($GRAVAR) or die (mysql_error());

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
				<strong>:: DADOS ALTERADOS ::</strong></h2>
				<p style=\"color:#fff\"  align=\"center\"><font color='#666666'><b>Os dados j&aacute; foram alterados no sistema.</p>                    
			</div>
		</div>
	</div>
</div>
<div class=\"col-sm-3\" align=\"center\"></div>

";    



mysql_close($link); 





}



?>

                
                </div>    
            </div>
        </div>
