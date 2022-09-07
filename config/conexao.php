<?php


$hostname = "localhost"; // Host do servidor
$user     = "root";     // Conta do Usuario
$password = "";     // Senha do Usuario
$database = "sei" ; // Banco de Dados

$host     = "localhost"; // Host do servidor
$user     = "root";     // Conta do Usuario
$pass     = "";     // Senha do Usuario
$db       = "sei" ; // Banco de Dados


$conectar = @mysql_connect($hostname, $user, $password);
mysql_select_db($database);
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

function OpenCon() {

$dbhost = "localhost"; // Host do servidor
$dbuser = "root";     // Conta do Usuario
$dbpass = "";     // Senha do Usuario
$dbname = "sei" ; // Banco de Dados

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Connection failed: %s\n". $conn -> error);
mysqli_set_charset($conn,"utf8");

return $conn;
}

?>
