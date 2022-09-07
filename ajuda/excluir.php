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
$codigo  = $row["codigo"];
$titulo  = $row["titulo"];
	
$titulo = maiuscula($titulo);
$foto     = $row["foto"];
	
	//FOTO
	if ($foto == "") { $foto_texto = ""; } 
	else { $foto_texto = "<img src='fotos/$foto' class='img-responsive img-rounded' ><BR>"; }
}

$acao = $_GET["acao"];

if ($acao == "") {$acaos="DESEJA REALMENTE APAGAR O ARQUIVO?"; }
if ($acao == "excluir") {

$resultx = mysql_query("UPDATE cad_ajuda SET ativo='0' WHERE codigo='$dados'");

$acaos="O ARQUIVO FOI DELETADO COM SUCESSO";

if ($foto <> "") {
	unlink("fotos/$foto");
	}
	
include "../config/meuip.php";
	
//GRAVAR HISTORICO DA ACAO
$GRAVAR = "INSERT INTO historico_usuario
(coduser,codpolo, userip,sessao,
acao,codarquivo,tipo_arquivo,
data,hora)
VALUES
('$id_user','$polo_user','$user_ip','Ajuda',
'Excluir dados do arquivo de ajuda','$dados','cad_ajuda',
curdate( ),curtime( ))";
$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());

}

?>


       <div class="panel panel-custom" >
            <div class="panel-body">
                <div class="col-sm-12" align="CENTER">
                	<h2 style="font-size:30px;padding-bottom:10px;color:#114a66"><strong>Excluir Dados </strong></h2>
                </div>    
            </div>
        </div>
        
        <div class="panel panel-custom">
            <div class="panel-body">
                <div class="col-sm-12">
					<form name="form1" method="post" action="index.php?sessao=e&acao=excluir&dados=<?php echo"$dados$odado"; ?>#loc">
  <br>
  	<div class="col-sm-2" id='loc'></div>
    <div class="col-sm-8 panel panel-custom3">
		<div <?php echo"$icone_excluir_posicao";?> class="media" style="background-color:transparent;">
			<div <?php echo"$icone_excluir_posicao2";?> style="vertical-align:middle">
				<span class='fa-stack fa-5x' style="margin-top:10px; color:#990000;">
							  <i class='fa fa-circle fa-stack-2x'></i>
							  <i class='fa fa-question fa-stack-1x fa-inverse' style="color:#fff;"></i>
							</span></div>
			<div class="media-body" style="padding-top:20px;" align='center'>
				
				
                <?php echo "<h2 class='media-heading' style='font-size:20px;color:#666666' align='center'>
				<strong>$acaos</strong></h2><br><p><b>$titulo</b></p><br>$foto_texto";
    
				if($acao == "") 
				{echo"<button type='submit' name='submit' class='btn btn-default'
				 style='background-color:#c20d18;color:#fff'>Sim, desejo excluir</button>
				<a href='index.php?sessao=b&pagina=$pagina$odado#loc' class='btn btn-default' 
				style='background-color:#000;color:#fff' role='button'>Retornar</a>";}
				if($acao == "excluir"){ 
				echo"<a href='index.php?sessao=b&pagina=$pagina$odado#loc' 
				 class='btn btn-default' style='background-color:#000;color:#fff' role='button'>Retornar</a>";}
				?>
                
                
              
			</div>
		</div>
        
	</div>
    <div class="col-sm-2"></div>
 
</form>

                
                </div>    
            </div>
        </div>