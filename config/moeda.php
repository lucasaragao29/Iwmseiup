<?php 

function so_numeros($var){
  $s="";
  for ($x=1; $x<=strlen($var); $x=$x+1)
  {

    $ch=substr($var,$x-1,1);
    if (ord($ch)>=48 && ord($ch)<=57)
    {

      $s=$s.$ch;
    }


  } return $s;
} 

function moedaold($valor){
     $valor=so_numeros($valor);
     $total=substr("$valor", 0, -2);
     $centavos=substr("$valor", -2);
     if (strlen($total)==0){
        $total="0";
     }
     if (strlen($centavos)==0){
        $centavos="00";
       } else if (strlen($centavos)==1)  {
         switch ($centavos)
           {
           case "0":
             $centavos="00";
             break;  
           case "1":
             $centavos="01";
             break;
           case "2":
             $centavos="02";
             break;
           case "3":
             $centavos="03";
             break;
           case "4":
             $centavos="04";
             break;
           case "5":
             $centavos="05";
             break;
           case "6":
             $centavos="06";
             break;
           case "7":
             $centavos="07";
             break;
           case "8":
             $centavos="08";
             break;
           case "9":
             $centavos="09";
             break;
           } 
     }

     $cont=strlen($total);
     
       if($cont%3==0)
         {
          $contador=(($cont-strlen($total)%3)/3)-1;
       } 
       else 
         {
          $contador=(($cont-strlen($total)%3)/3);
       }
     
       while ($contador>0)
         {
         $total_f = substr("$total",0,-3*$contador);
         $total_i = substr("$total",-3*$contador);
         $total = $total_f.".".$total_i;
         $contador-- ;
       }                 
     $valor = "R$ ".$total.",".$centavos;
     return $valor;
}

function moeda($valor){
   setlocale(LC_MONETARY, 'pt_BR');
   $valor=money_format('%+#10n',$valor)."\n";
   return $valor;
}

?>
