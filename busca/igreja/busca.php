

 <form name="form2" method="post" action="index.php?sessao=b#loc">
       <div class="panel " style="background-color:transparent;">
            <div class="panel-body">
               <div class="input-group stylish-input-group">
                    <input type="text" class="form-control" name="busca" id="dado" placeholder="Pesquisa Dados" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="fa fa-search"></span>
                        </button>  
                    </span>
                </div>
            </div>
        </div>
  </form>      
        <div class="panel panel-custom" id="loc">
       
					<?php

include("../../config/minuscula.php");

$pagina = $_GET["pagina"];

if ($pagina==""){ $pagina = $_POST["pg"];}
if ($pagina>"1"){ }



if ($pagina == "") {$pagina = "1";}
if ($pagina == "1"){ $dados = isset( $_GET['dado'] ) ? $_GET['dado'] : '';   
					 $busca = isset( $_POST['busca'] ) ? $_POST['busca'] : '';}
if ($pagina > "1") { $dados = isset( $_GET['dado'] ) ? $_GET['dado'] : '';}


if ($dados == "" and $busca == "") { $odado = "";}
if ($busca <> "") { $odado = "&dado=$busca";}
if ($dados <> "") { $odado = "&dado=$dados";}


$pagina0 = $pagina-1; if ($pagina0 == "0" ) { $pagina0 = ""; $espaco = "";} if ($pagina0 > "0") {$espaco = "&nbsp;&nbsp;";}
$pagina2 = $pagina+1;
$pagina3 = $pagina2+1;
$pagina4 = $pagina3+1; if ($pagina0 == "0") { $espaco4 = "&nbsp;&nbsp;";} if ($pagina0 > "0") {$pagina4 = ""; $espaco4 = "&nbsp;&nbsp;";}


//$conn = @mysql_connect($host,$user,$pass);
//$banco = mysql_select_db($db); 

			
			
$qr="SELECT * from pae_igreja WHERE nome like '%$dados$busca%' order by id desc";

$busca = "$qr";                                                                                       
$total_reg = "100"; // n&uacute;mero de registros por p&aacute;gina
if ($pagina == "0" or $pagina == "") { $pagina = "1"; }
if (!$pagina) { 
$pc = "1"; 
} else { 
$pc = $pagina; 
} 
$inicio = $pc - 1; 
$inicio = $inicio * $total_reg; 
$limite = mysqli_query($conn,"$busca LIMIT $inicio,$total_reg"); 
$todos = mysqli_query($conn,"$busca"); 

$tr = mysqli_num_rows($todos); // verifica o n&uacute;mero total de registros 
$tp = $tr / $total_reg; // verifica o n&uacute;mero total de p&aacute;ginas 

// agora vamos criar os botões "Anterior e próximo"
  $anterior = $pc -1;
  $proximo = $pc +1;echo" <div class=\"panel-heading\"  align='center'><h2><strong><font color='#114a66'>ARQUIVOS LOCALIZADOS: $tr</font></strong></h2>";
echo "<ul class=\"pagination\">";

if ($pc > "1") { echo "<li class='active'><a href=\"index.php?sessao=b&pagina=$anterior$odado#loc\"><i class='fa fa-arrow-left'></i></a></li>"; }
else {  echo "<li class='disabled'><a><i class='fa fa-arrow-left'></i></a></li>";}

	
		echo "<li><a href=\"#loc\">$pagina</a></li>";
	

	if ($pc < $tp) { echo "<li class='active'><a href=\"index.php?sessao=b&pagina=$proximo$odado#loc\"><i class='fa fa-arrow-right'></i></a></li>"; }
else { echo "<li class='disabled'><a><i class='fa fa-arrow-right'></i></a></li>"; }

echo"</ul></div>";
            echo"<div class=\"panel-body\">
                <div class=\"col-sm-12\">";

echo"<div class='panel-group'>"; 

// vamos criar a visualiza&ccedil;&atilde;o 
while ($dados = mysqli_fetch_array($limite)) { 
	$codigo      = $dados["id"];
	$nome        = $dados["nome"];
	$coddistrito = $dados["distrito_id"];
	$regiao      = $dados["regiao"];
	$data        = $dados["data"];
	$hora        = $dados["hora"];
	
	//DISTRITO
	$qr_distrito = "SELECT * from pae_distrito where id='$coddistrito'";
	$todos_distrito = mysqli_query(conn,"$qr_distrito"); 
	while ($dados_distrito = mysqli_fetch_array($todos_distrito)) { 
	$distrito_texto    = $dados_distrito["nome"];
	}
	
	//APAGAR A PALAVRA
	$distrito_texto = str_replace("Distrito ", "", $distrito_texto); 
	$nome = str_replace("IMW ", "", $nome); 

		
	//DATA DO CADASTRO POR EXTENSO
	$dia = date('d', strtotime($data));
	$mes = date('m', strtotime($data));
	$ano = date('Y', strtotime($data));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysqli_query(conn,"$qr_entradames"); 
	while ($dados_entradames= mysqli_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	$data_cadastro = "$dia de $mes_texto de $ano &agrave;s $hora";

	$nome = maiuscula($nome);
//	$regiao = minuscula($regiao);

echo"<div class='panel panel-default $panel_horizontal' style='background-color:#114a66;border:3px solid #114a66;border-radius:20px;'>
		<div class='panel-heading' style='background-color:#114a66;$panel_medida'>
			<div  align='center' $style_botoes>				
				
				<a href='index.php?sessao=ver&dados=$codigo&pagina=$pagina$odado#loc' title='Visualizar dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fa fa-eye fa-stack-1x fa-inverse'></i>
					</span>
				</a>
				
				<a href='print.php?&dados=$codigo&pagina=$pagina$odado#loc' target=\"_blank\" title='Tela de impress&atildeo;'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fas fa-print fa-stack-1x fa-inverse'></i>
					</span>
				</a>
				
			</div>
		</div>
		
		$foto_texto
		
		<div class='panel-body' style='background-color:#fff;'>
			
			
			<div style='vertical-align: middle;' align='left' >
			
				<p style='margin-top:10px;margin-bottom:10px; text-align:justify'>
				<font color='#666666'><b>IGREJA: $nome</b>
				<br>Distrito: $distrito_texto | Regi&atilde;o: $regiao</p>
			
			</div>
		
		</div>
	</div>
<br>";

}

mysqli_close($conn);


?>

                
                </div>   <?php 
				echo"<div align=\"center\">";
echo "<ul class=\"pagination\">";

if ($pc > "1") { echo "<li class='active'><a href=\"index.php?sessao=b&pagina=$anterior$odado#loc\"><i class='fa fa-arrow-left'></i></a></li>"; }
else {  echo "<li class='disabled'><a><i class='fa fa-arrow-left'></i></a></li>";}

	
		echo "<li><a href=\"#loc\">$pagina</a></li>";
	

	if ($pc < $tp) { echo "<li class='active'><a href=\"index.php?sessao=b&pagina=$proximo$odado#loc\"><i class='fa fa-arrow-right'></i></a></li>"; }
else { echo "<li class='disabled'><a><i class='fa fa-arrow-right'></i></a></li>"; }

echo"</ul></div>";
				
				?> 
            </div>
        </div>
