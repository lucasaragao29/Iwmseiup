<?php



//$mensagem = $_GET['mensagem'];

session_start();

session_destroy();

include ('config/config.php');
$title2 = "teste teste";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
      <title><?php echo"$title";?></title>
<?php echo"$title2";?>
</head>
</html>
