<?
//include("miniatura.php");
$codigos     = $_GET["dados"];
$codigo      = $_GET["dados"];
$dados       = $_GET["dados"];
$dado        = $_GET["dado"];
$pagina      = $_GET["pagina"];

if ($dado == "") { $odado = "";}
if ($dado <> "") { $odado = "&dado=$dado";}


////////////////////////////////////////////////////////////////////////////
//include ("../config/conexao.php");		
//Abra conexao com o MySql

@mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
//Conecta ao Banco de Dados

$verificacao = mysql_query("Select * from cad_ajuda where codigo='$codigo'");

while($row = mysql_fetch_array($verificacao)) { 
$fotografia     = $row ["foto"];
$foto           = $row ["foto"];
$titulo           = $row ["titulo"];	
		
		//FOTO
	if ($foto == "") {$foto_opcao = "foto"; $foto_title = "Incluir imagem";}
	if ($foto <> "") {$foto_opcao = "fotoe"; $foto_title = "Excluir imagem";}
}

////////////////////////////////////////////////////////////////////////////



// Prepara a vari&aacute;vel caso o formul&aacute;rio tenha sido postado
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

$config = array();
// Tamano m&aacute;ximo da imagem, em bytes
$config["tamanho"] = 10485760;
// Largura M&aacute;xima, em pixels
$config["largura"] = 500;
// Altura M&aacute;xima, em pixels
$config["altura"] = 500;
// Diretório onde a imagem ser&aacute; salva
$config["diretorio"] = "fotos/";

// Gera um nome para a imagem e verifica se j&aacute; não existe, caso exista, gera outro nome e assim sucessivamente..
// Função Recursiva
function nome($extensao)
{
    global $config;

    // Gera um nome único para a imagem
    $temp = substr(md5(uniqid(time())), 0, 10);
    $imagem_nome = $temp . "." . $extensao;
    
    // Verifica se o arquivo j&aacute; existe, caso positivo, chama essa função novamente
    if(file_exists($config["diretorio"] . $imagem_nome))
    {
        $imagem_nome = nome($extensao);
    }

    return $imagem_nome;
}

if($arquivo)
{
    $erro = array();
    
    // Verifica o mime-type do arquivo para ver se é de imagem.
    // Caso fosse verificar a extensão do nome de arquivo, o código deveria ser:
    //
    // if(!eregi("\.(jpg|jpeg|bmp|gif|png){1}$", $arquivo["name"])) {
    //      $erro[] = "Arquivo em formato inv&aacute;lido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo"; }
    //
    // Mas, o que ocorre é que alguns usu&aacute;rios mal-intencionados, podem pegar um vírus .exe e simplesmente mudar a extensão
    // para alguma das imagens e enviar. Então, não adiantaria em nada verificar a extensão do nome do arquivo.
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $arquivo["type"]))
    {
        $erro[] = "Arquivo em formato inv&aacute;lido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no m&aacute;ximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        
        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $erro[] = "Largura da imagem n&atilde;o deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $erro[] = "Altura da imagem n&atilde;o deve ultrapassar " . $config["altura"] . " pixels";
        }
    }

    if(!sizeof($erro))
    {
        // Pega extensão do arquivo, o indice 1 do array conter&aacute; a extensão
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
        
        // Gera nome único para a imagem
        $imagem_nome = nome($ext[1]);

        // Caminho de onde a imagem ficar&aacute;
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
		
		//include ("../config/conexao.php");		
		//Abra conexao com o MySql
 		@mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
		
 		//Conecta ao Banco de Dados
		$buscar = $_POST["buscar"];$layout = $_POST["layout"];
		$result = mysql_query("Select * from cad_ajuda where codigo='$codigo'");

		while($row = mysql_fetch_array($result)) { 
		$foto     = $row ["foto"];}

		$imagem = "fotos/$imagem_nome";
		$aprox = "170";

		//$thumbs= thumbMaker($imagem, $aprox);

		mysql_query("UPDATE cad_ajuda SET foto='$imagem_nome' WHERE codigo='$codigo' ")
		 or die ("Erro ao adicionar Registro!!!" . mysql_error());
		
				
		include "../../config/meuip.php";
			
		//GRAVAR HISTORICO DA ACAO
		$GRAVAR = "INSERT INTO historico_usuario
		(coduser,codpolo, userip,sessao,
		acao,codarquivo,tipo_arquivo,
		data,hora)
		VALUES
		('$id_user','$polo_user','$user_ip','Ajuda',
		'Incluir imagem no tutorial - $titulo','$codigo','cad_ajuda',
		curdate( ),curtime( ))";
		$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());	
	
    }
}

?>
       <div class="panel panel-custom" style="background-color:#114a66" id='loc'>
            <div class="panel-body">
                 <div class="col-sm-3" align="CENTER">
                	<P style="font-size:25px;color:#fff;margin-top:15px;"><strong>INCLUIR IMAGEM</strong></P>
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
				
			<?
				
			// Imagem foi enviada com sucesso, mostra noticia de SUCESSO
			if($arquivo && !sizeof($erro))
			{
				echo "<img src=\"" . $imagem_dir . "\" width=350 border=0 class='borda_img'><font color='black'><BR><BR>Sua foto foi enviada com sucesso!";


				//Atualizar para pagina de excluir foto
				echo"<meta http-equiv='refresh' 
				content='0;URL=$site_link/ajuda/index.php?sessao=fotoe&dados=$dados&pagina=$pagina'>";

			}

			// Ocorreu algum erro ou ainda o formul&aacute;rio n&atilde;o foi postado
			else
			{ //<?echo $PHP_SELF?>
					</P>
					<form action="index.php?sessao=foto&dados=<?php echo"$codigos&pagina=$pagina$odado";?>#loc" method=post  ENCTYPE="multipart/form-data">
					  <div align="center" CLASS='TEXTO'><font color="black">Envie sua foto em formato gif, jpg, 
						bmp ou png.<BR>
						A imagem n&atilde;o deve ter mais que
						<? $kbs=$config["tamanho"]/1024; echo"$kbs";  ?>
						kb (quilobyte) e deve ter no m&aacute;ximo <? echo $config["largura"] . "x" . $config["altura"] ?> pixels.</font><BR>
					  </div>
					  
						<?
				if(sizeof($erro))
				{
					echo "<div class=\"alert alert-danger\">
  <strong> Ocorreu(am) o(s) seguinte(s) erro(s):</strong><BR>";
					foreach($erro as $err)
					{
						echo " - " . $err . "<BR>";
					}
					echo "</div>";
				}
			?>

           
            
            <div class="col-sm-12"><input type='file' size='30' name='foto' class='form-control'><br></div>
             <div class="col-sm-12"> <button type='submit' name='submit' class='btn btn-default'
				 style='background-color:#c20d18;color:#fff'>Sim, desejo enviar</button>
				<a href='index.php?sessao=b&pagina=<?php echo"$pagina";?>#loc' class='btn btn-default' 
				style='background-color:#000;color:#fff' role='button'>Retornar</a></div>
            
          </table>
          <? } ?>
        </form>
              
			</div>
		</div>
        
	</div>
    <div class="col-sm-2"></div>
 
</form>

                
                </div>    
            </div>
        </div>