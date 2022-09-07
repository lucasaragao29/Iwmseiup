

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

if ($nivel_user == "1") { $ativo_texto = "";} else { $ativo_texto = "and $codstatus='1'";}

$conn = @mysql_connect($host,$user,$pass);
$banco = mysql_select_db($db); 

$qr="SELECT * from cad_ajuda where titulo like '%$dados$busca%' and ativo='1' $ativo_texto order by codigo desc";
$busca = "$qr";                                                                                       
$total_reg = "50"; // n&uacute;mero de registros por p&aacute;gina
if ($pagina == "0" or $pagina == "") { $pagina = "1"; }
if (!$pagina) { 
$pc = "1"; 
} else { 
$pc = $pagina; 
} 
$inicio = $pc - 1; 
$inicio = $inicio * $total_reg; 
$limite = mysql_query("$busca LIMIT $inicio,$total_reg"); 
$todos = mysql_query("$busca"); 

$tr = mysql_num_rows($todos); // verifica o n&uacute;mero total de registros 
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
while ($dados = mysql_fetch_array($limite)) { 
	$codigo    = $dados["codigo"];
	$titulo    = $dados["titulo"];
	$codarea   = $dados["codarea"];
	$codstatus = $dados["codstatus"];
	$contagem  = $dados["contagem"];
	$foto      = $dados["foto"];
	$data      = $dados["data"];
	$hora      = $dados["hora"];
	
	//FOTO
	if ($foto == "") { $foto_texto = "";}
	else {
		
	if ($width < "700") {
	$foto_texto="<div class='panel-body' style='background-color:#fff'>
	<p style='margin-top:10px;margin-bottom:10px; text-align:center;'><img src='fotos/$foto' class='img-responsive 
	img-rounded' ></p></div>";
	}
	else {
	$foto_texto="<div class='panel-body' style='background-color:#fff;width:120px'>
	<p style='margin-top:10px;margin-bottom:10px; text-align:center;'><img src='fotos/$foto' class='img-responsive 
	img-rounded' ></p></div>";
	}
	}	

	if ($foto == "") {$foto_opcao = "foto"; $foto_title = "Incluir imagem";}
	if ($foto <> "") {$foto_opcao = "fotoe"; $foto_title = "Excluir imagem";}
	
	//STATUS
	if ($codstatus == "1") {$status_texto = "Ativo"; }
	if ($codstatus == "0") {$status_texto = "Inativo"; }

	//AREA
	if ($codarea == "0") { $area_texto = "N&atilde;o informado"; } 
	else {
		$busca_area = "SELECT * from conf_area where codigo='$codarea'";
		$todos_area = mysql_query("$busca_area"); 
		while ($dados_area = mysql_fetch_array($todos_area)) { 
		$area_texto  = $dados_area["descricao"];
		}
	}
	
	//DATA POR EXTENSO
	$dia_cad = date('d', strtotime($data));
	$mes_cad = date('m', strtotime($data));
	$ano_cad = date('Y', strtotime($data));
	
	$qr_entradames="SELECT * from conf_mes where mes = '$mes_cad'";
	$todos_entradames= mysql_query("$qr_entradames"); 
	while ($dados_entradames= mysql_fetch_array($todos_entradames)) { 
	$mes_cad_texto   = $dados_entradames["descricao"];
	}
	
	$data_cadastro = "$dia_cad de $mes_cad_texto de $ano_cad &agrave;s $hora";
	
	if ($nivel_user == "1") { $ativo_ver = "| Situa&ccedil;&atilde;o: $status_texto";} else { $ativo_ver = "";}
	
	
	//MAIUSCULA
	$titulo = maiuscula($titulo);

echo"<div class='panel panel-default $panel_horizontal' style='background-color:#114a66;border:3px solid #114a66;border-radius:20px'>
		<div class='panel-heading' style='background-color:#114a66;'>
			<div  align='center' $style_botoes>	";			
				
				
				echo"<a href='index.php?sessao=ver&dados=$codigo&pagina=$pagina$odado#loc' title='Visualizar dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fa fa-eye fa-stack-1x fa-inverse'></i>
					</span>
				</a>";
				
				
				
				if ($nivel_user == "1") {
				echo"<a href='index.php?sessao=al&dados=$codigo&pagina=$pagina$odado#loc' title='Alterar dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='far fa-edit fa-stack-1x fa-inverse'></i>
					</span>
				</a>";
			
				echo"<a href='index.php?sessao=$foto_opcao&dados=$codigo&pagina=$pagina$odado#loc' title='$foto_title'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='far fa-file-image fa-stack-1x fa-inverse'></i>
					</span>
				</a>";
				
				echo"<a href='index.php?sessao=e&dados=$codigo&pagina=$pagina$odado#loc' title='Excluir dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fa fa-times fa-stack-1x fa-inverse'></i>
					</span>
				</a>";
				}
			echo"</div>
		</div>
		
		$foto_texto
		
		<div class='panel-body' style='background-color:#fff;'>
		
			<div style='vertical-align: middle;' align='left' >
			
				<p style='margin-top:10px;margin-bottom:10px; text-align:justify'>
				<font color='#666666'><b>T&Iacute;TULO: $titulo </b>
				<br>&Aacute;rea: $area_texto | Clique: $contagem $ativo_ver
				<br>Cadastrado em $data_cadastro</p>
			
			</div>
		
		</div>
	</div>
<br>";




}





mysql_close($conn);


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