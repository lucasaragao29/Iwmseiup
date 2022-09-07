<?php
session_start(); 

include("config/conexao.php");
include("config/config.php");

$login = trim($_POST['login']);
$senha = trim($_POST['senha']);



//conecta();
$sql       = "SELECT * FROM user WHERE login_user ='$login' AND senha_user='$senha' and codstatus='1'";
$sql_login = mysql_query($sql);
$num       = mysql_num_rows($sql_login);
$result    = mysql_query($sql);

	

	if($num==0){
		echo '<script>window.location="/index.php?mensagem=Login incorreto.Tente novamente.";</script>';
//		echo '<script>window.location="http://imw6ti.acampamentoefraim.com.br/sei/index.php?mensagem=Login incorreto.Tente novamente.";</script>';
	}
	else{
	
//	include('config/conexao.php');
	@mysql_connect($host,$user,$pass) or die ("Impossivel Conectar ao Servidor MySQL");
	mysql_select_db($db) or die ("Impossivel Abrir Database");

	$qr_usuario = "SELECT * from user WHERE login_user = '$login' and senha_user = '$senha'";
	$todos_usuario = mysql_query("$qr_usuario"); 
	while ($dados_usuario = mysql_fetch_array($todos_usuario)) { 
	$id_user       = $dados_usuario["id"];
	$contagem      = $dados_usuario["contagem"];
	$distrito_user = $dados_usuario["coddistrito"];
	$regiao_user   = $dados_usuario["codregiao"];
	$nome_user     = $dados_usuario["nome"];
	
	$contando = $contagem+1;
	}
	
	include "config/meuip.php";
		
	//GRAVAR HISTORICO DA ACAO
	/* $GRAVAR = "INSERT INTO historico_usuario
	(coduser,coddistrito,codregiao, userip,sessao,
	acao,codarquivo,tipo_arquivo,
	data,hora)
	VALUES
	('$id_user','$distrito_user','$regiao_user','$user_ip','Tela de Login',
	'Logando no sistema','$id','Usuario $nome_user Logando',
	curdate( ),curtime( ))";
	$GRAVACAO = mysql_query($GRAVAR)  or die (mysql_error());	 */
			
	$_SESSION["id_user"] = $id_user;
	
		//mysql_query("UPDATE user SET contagem='$contando'  WHERE id='$id_user' ") or die ("Erro ao adicionar Registro!!!" . mysql_error()); 

	
		echo '<script>window.location="painel.php";</script>';
	}
	?>
