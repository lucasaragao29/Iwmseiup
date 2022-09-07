<?php 
//DESCOBRIR TAMANHO DA TELA PARA REDIMENSIONAR LAYOUT
if (!isset($_COOKIE['resolucao'])) {
?>
<script language='javascript'>
document.cookie = "resolucao="+screen.width+"x"+screen.height;
self.location.reload();
</script>
<?php }else

$resolucao = list($width,$height)=explode("x",$_COOKIE['resolucao']);
///echo "<h3>Sua resolu&ccedil;&atilde;o &eacute; $width por $height</h3>";

?>