<?php
$pagina = $_GET["pagina"];

if ($pagina==""){ $pagina = $_POST["pg"];}
if ($pagina>"1"){ }

session_start();
$id_user =  $_SESSION['id_user'];

/*
  Página de segurança aqui o script verifica se o usuario efetuou login caso não ele sai
*/


include("../config/warning_login.php");
include("../config/erros.php");
// Abre conexão ao Mysql   
// Conecta ao Banco de dados
include('../config/conexao.php');
?>
<div class="panel panel-custom">
  <div class="panel-body">
    <div class="col-sm-12" align="CENTER">
      <h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong>Incluir Dados </strong></h2>
    </div>
  </div>
</div>
<div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
					<?php 
$ato = $_GET["ato"];

$linkar = "index.php?sessao=i&ato=alt&dados=$dados&pagina=$pagina$odado#loc";
$modo = "INCLUIR DADOS";
if ($ato=="")

{

include ('tabela.php'); }

if ($ato == "alt") {

	include('../config/conexao.php');
	
	$link = @mysql_connect($host,$user,$pass)  or die("N&atilde;o foi poss&iacute;vel conectar");
	mysql_select_db($db) or die("N&atilde;o foi poss&iacute;vel selecionar o banco de dados");
	
	$titulo        = $_POST["titulo"];
	$codarea       = $_POST["codarea"];
	$codstatus     = $_POST["codstatus"];
	$texto         = $_POST["texto"];
		
	$consulta = "INSERT INTO cad_ajuda
	
	(titulo,codarea,codstatus,ativo,texto,
	data,hora)
	VALUES
	('$titulo','$codarea','$codstatus','1','$texto',
	curdate( ),curtime( ))";
	
	$resultado = mysql_query($consulta)  or die (mysql_error());
		
		 
	//RECUPERAR ÚLTIMO CADASTRO
	$ultimo_dado = mysql_query("Select * from cad_ajuda ORDER BY codigo DESC limit 0,1");
	while($row_ultimo = mysql_fetch_array($ultimo_dado)) {
	$codigo_ultimo  = $row_ultimo["codigo"];
	}
		
	include "../config/meuip.php";
		 
	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codpolo, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$polo_user','$user_ip','Ajuda',
	'Incluir novo arquivo de ajuda','$codigo_ultimo','cad_ajuda',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());

echo "
<div class=\"col-sm-3\" align=\"center\"></div>
<div class=\"col-sm-6\" align=\"center\">
	<div $icone_excluir_posicao>
			<div $icone_excluir_posicao2 style=\"vertical-align:middle\">
				<span class='fa-stack fa-5x' style='margin-top:10px; color:#990000;'>
				<i class='fa fa-circle fa-stack-2x'></i>
				<i class='far fa-lightbulb fa-stack-1x fa-inverse' style='color:#fff;'></i>
				</span>
			</div>
			<div class=\"media-body\" style=\"padding-top:20px;\">
				<h2 class=\"media-heading\" style=\"font-size:20px;color:#666666\" align=\"center\">
				<strong>ARQUIVO CADASTRADO COM SUCESSO</strong></h2>
				<p style=\"color:#fff\"  align=\"center\"><font color='#666666'><b>O seu cadastro j&aacute; foi inclu&iacute;do com sucesso no sistema<br>
               <a href='index.php?sessao=i' class='btn btn-danger' role='button'>DESEJA CADASTRAR NOVO ARQUIVO?</a>
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