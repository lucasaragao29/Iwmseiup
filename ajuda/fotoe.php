<?php


$dados = $_GET ["dados"];
$codigo = $_GET["dados"];

$dado        = $_GET["dado"];
$pagina      = $_GET["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}

session_start();$login =  $_SESSION['login'];

// Chama o Banco de Dados

 @mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");

 mysql_select_db($db) or die ("Impossivel Abrir Database");

// retorna uma pesquisa

$result = mysql_query("Select * from cad_ajuda where codigo='$dados'");
while($row = mysql_fetch_array($result)) {
//Recupera os dados do banco de dados
$foto     = $row["foto"];
$codigo   = $row["codigo"];
$titulo   = $row["titulo"];
$foto     = $foto;
	
	
		//FOTO
	if ($foto == "") {$foto_opcao = "foto"; $foto_title = "Incluir imagem";}
	if ($foto <> "") {$foto_opcao = "fotoe"; $foto_title = "Excluir imagem";}
	
}

$acao = $_GET["acao"];

if ($acao == "") {$acaos="DESEJA REALMENTE APAGAR A IMAGEM?"; $fotocaminho="fotos/$foto";}

if ($acao == "excluir") {

unlink("fotos/$foto");
		
$resultx = mysql_query("update cad_ajuda set foto='' where codigo='$dados'");

$acaos="IMAGEM APAGADA COM SUCESSO";

	
include "../../config/meuip.php";
	
//GRAVAR HISTORICO DA ACAO
$GRAVAR = "INSERT INTO historico_usuario
(coduser,codpolo, userip,sessao,
acao,codarquivo,tipo_arquivo,
data,hora)
VALUES
('$id_user','$polo_user','$user_ip','Ajuda',
'Excluir imagem do tutorial - $titulo','$dados','cad_ajuda',
curdate( ),curtime( ))";
$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());	

//Atualizar para pagina de excluir foto
	echo"<meta http-equiv='refresh' 
	content='0;URL=$site_link/ajuda/index.php?sessao=foto&dados=$dados&pagina=$pagina'>";

}


?>

  <div class="panel panel-custom" style="background-color:#114a66" id='loc'>
            <div class="panel-body">
                 <div class="col-sm-3" align="CENTER">
                	<P style="font-size:25px;color:#fff;margin-top:15px;"><strong>EXCLUIR IMAGEM</strong></P>
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
                     
                    <a href='index.php?sessao=<?php echo"$foto_opcao&dados=$codigo&pagina=$pagina$odado#loc";?>' title='<?php echo"$foto_title"; ?>'>
                        <span class='fa-stack fa-2x'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='far fa-file-image fa-stack-1x fa-inverse'></i>
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
					<form name="form1" method="post" action="index.php?sessao=fotoe&acao=excluir&dados=<?php echo"$dados"; ?>#loc">
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
				<strong>$acaos</strong></h2><br><p>$titulo</p><img src='fotos/$foto' class='img-responsive' ><br>";
    
				if($acao == "") 
				{echo"<button type='submit' name='submit' class='btn btn-default'
				 style='background-color:#c20d18;color:#fff'>Sim, desejo excluir</button>
				<a href='index.php?sessao=b&pagina=$pagina#loc' class='btn btn-default' 
				style='background-color:#000;color:#fff' role='button'>Retornar</a>";}
				if($acao == "excluir"){ 
				echo"<a href='index.php?sessao=b&pagina=$pagina#loc' 
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