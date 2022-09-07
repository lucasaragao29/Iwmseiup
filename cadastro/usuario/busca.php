

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
include_once('../../config/conexao.php');

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


$conn = @mysql_connect($host,$user,$pass);
$banco = mysql_select_db($db); 

			
			
$qr="SELECT * FROM user WHERE nome LIKE '%$dados$busca%' and ativo='1' and id !='1' ORDER BY id DESC";

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
	$codigo     = $dados["id"];
	$nome       = $dados["nome"];
	$data       =  $dados["data"];
	$hora       =  $dados["hora"];
	$funcao     =  $dados["funcao"];
	$codpolo    =  $dados["codpolo"];
	$codstatus  =  $dados["codstatus"];	
	
	//STATUS
	
	if ($codstatus == "1") { $status_texto = "Ativo"; } else { $status_texto = "Inativo"; }
	
	
	$nome = maiuscula($nome);
	
	$dia = date('d', strtotime($data));
	$mes = date('m', strtotime($data));
	$ano = date('Y', strtotime($data));
	
	// DATA POR EXTENSO
	$qr_entradames="SELECT * from conf_mes where mes = '$mes'";
	$todos_entradames= mysql_query("$qr_entradames"); 
	while ($dados_entradames= mysql_fetch_array($todos_entradames)) { 
	$mes_texto   = $dados_entradames["descricao"];
	}
	
	$data_cadastro = "$dia de $mes_texto de $ano &agrave;s $hora";
	
	// REGIAO
	$qr_regiao = "SELECT * from cad_regiao where codigo = '$codregiao'";
	$todos_regiao = mysql_query("$qr_regiao"); 
	while ($dados_regiao = mysql_fetch_array($todos_regiao)) { 
	$regiao_texto   = $dados_regiao["nome"];
	}
	
	if ($codregiao == "0") { $regiao_texto = "Geral";}
	
	//FUNÇÃO
	$qr_funcao="SELECT * from usuarios_funcao where codigo = '$funcao'";
	$todos_funcao= mysql_query("$qr_funcao"); 
	while ($dados_funcao = mysql_fetch_array($todos_funcao)) { 
	$funcao_texto   = $dados_funcao["descricao"];
	$nivel_funcao    = $dados_funcao["nivel"];
	}
	
	if ($funcao_texto == "") { $funcao_texto = "";}
	
	//ULYIMO ACESSO
	$qr_acesso ="SELECT * from historico_usuario where coduser = '$codigo' order by data desc limit 0,1";
	$todos_acesso = mysql_query("$qr_acesso"); 
	while ($dados_acesso = mysql_fetch_array($todos_acesso)) { 
	$data_acesso   = $dados_acesso["data"];
	$hora_acesso   = $dados_acesso["hora"];
	
	}	
	
	//DIA DE HOJE
	$hoje = getdate();
	$dia = $hoje["mday"];
	$mes = $hoje["mon"];
	$ano = $hoje["year"];

	if ($dia < "10") { $dia = "0$dia"; } else { $dia = $dia; }
	if ($mes < "10") { $mes = "0$mes"; } else { $mes = $mes; }
	
	$data_atual = "$ano-$mes-$dia";
	
	
	
	// Calcula a diferença em segundos entre as datas
	$diferenca = strtotime($data_acesso) - strtotime($data_atual);
	
	//Calcula a diferença em dias
	$dias = floor($diferenca / (60 * 60 * -24));
	
	if ($data_acesso == "") { $dias = "Nunca acessou"; } else { $dias = "$dias dias"; }


echo"<div class='panel panel-default $panel_horizontal' style='background-color:#114a66;border:3px solid #114a66;border-radius:20px'>
		<div class='panel-heading' style='background-color:#114a66;'>
			<div  align='center' $style_botoes>				
				
				<a href='index.php?sessao=ver&dados=$codigo&pagina=$pagina$odado#loc' title='Visualizar dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fa fa-eye fa-stack-1x fa-inverse'></i>
					</span>
				</a>
				
				<a href='index.php?sessao=al&dados=$codigo&pagina=$pagina$odado#loc' title='Alterar dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='far fa-edit fa-stack-1x fa-inverse'></i>
					</span>
				</a>

				
				<a href='index.php?sessao=e&dados=$codigo&pagina=$pagina$odado#loc' title='Excluir dados'>
					<span class='fa-stack fa-2x'>
					  <i class='fa fa-circle fa-stack-2x'></i>
					  <i class='fa fa-times fa-stack-1x fa-inverse'></i>
					</span>
				</a>
				
			</div>
		</div>
		
		$foto_texto
		
		<div class='panel-body' style='background-color:#fff;'>
			
			
			<div style='vertical-align: middle;' align='left' >
			
				<p style='margin-top:10px;margin-bottom:10px; text-align:justify'>
				<font color='#666666'><b>USU&Aacute;RIO: $nome</b>
				<br>Regi&atilde;o: $regiao_texto | Fun&ccedil;&atilde;o: $funcao_texto (N&iacute;vel $nivel_funcao)
				<br>Status: $status_texto |  &Uacute;ltimo acesso: $dias
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
