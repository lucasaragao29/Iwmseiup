<?php



$dados = $_GET ["dados"];
$dado = $_GET ["dado"];
$pagina = $_GET ["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}



 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
 mysql_select_db($db) or die ("Impossivel Abrir Database");

// retorna uma pesquisa
$result = mysql_query("Select * from cad_ajuda where codigo='$dados'");
while($row = mysql_fetch_array($result)) {
//Recupera os dados do banco de dados
	$codigo             = $row["codigo"];
	$titulo               = $row["titulo"];
	$codarea            = $row["codarea"];
	$codstatus          = $row["codstatus"];
	$texto              = $row["texto"];
		
				//FOTO
	if ($foto == "") {$foto_opcao = "foto"; $foto_title = "Incluir imagem";}
	if ($foto <> "") {$foto_opcao = "fotoe"; $foto_title = "Excluir imagem";}

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
                   <?php 
                  if ($nivel_user == "7") {} else
					{
                    echo"<a href='index.php?sessao=al&dados=$codigo&pagina=$pagina$odado#loc' title='Alterar Dados'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-edit fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                    
				    
                    <a href='index.php?sessao=$foto_opcao&dados=$codigo&pagina=$pagina$odado#loc' title='$foto_title'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-file-image fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>
                                   
                                      
                    <a href='index.php?sessao=b&pagina=$pagina$odado#loc' title='Retornar'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-undo fa-stack-1x fa-inverse'></i>
                        </span>
           			</a>";
					}
                ?>
                
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

	
	
	$link = mysql_connect($host,$user,$pass)  or die("N&atilde;o foi poss&iacute;vel conectar");
	mysql_select_db($db) or die("N&atilde;o foi poss&iacute;vel selecionar o banco de dados");
	
	$titulo              = $_POST["titulo"];
	$codarea             = $_POST["codarea"];
	$codstatus           = $_POST["codstatus"];
	
	$texto               = $_POST["texto"];

	mysql_query("UPDATE cad_ajuda SET 
	titulo='$titulo',codarea='$codarea',codstatus ='$codstatus ',texto='$texto'
	WHERE codigo='$dados'") or die ("Erro ao adicionar Registro!!!" . mysql_error());
	

	include "../config/meuip.php";
		
	//GRAVAR HISTORICO DA ACAO
	$GRAVAR = "INSERT INTO historico_usuario
	(coduser,codpolo, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$polo_user','$user_ip','Ajuda',
	'Alterar dados do tutorial - $titulo','$dados','cad_ajuda',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());
	
	
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