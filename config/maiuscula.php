<?php 
function maiuscula ($cadeias){ 
    $cadeias = mb_strtoupper($cadeias, mb_detect_encoding($cadeias));
//    $cadeias = strtoupper($cadeias); 
    $mai = array(0=>"�", 1=>"�", 2=>"�", 3=>"�", 4=>"�", 5=>"�", 6=>"�", 7=>"�", 
                 8=>"�", 9=>"�", 10=>"�", 11=>"�", 12=>"�", 13=>"�", 14=>"�", 
                 15=>"�", 16=>"�", 17=>"�", 18=>"�", 19=>"�", 20=>"�", 21=>"�", 22=>"�", 
                 ); 
                 
    $min = array(0=>"�", 1=>"�", 2=>"�", 3=>"�", 4=>"�", 5=>"�", 6=>"�", 7=>"�", 
                 8=>"�", 9=>"�", 10=>"�", 11=>"�", 12=>"�", 13=>"�", 14=>"�", 
                 15=>"�", 16=>"�", 17=>"�", 18=>"�", 19=>"�", 20=>"�", 21=>"�", 22=>"�", 
                 ); 
                 
    for ($i=0; $i<23; $i++){ 
 //       $cadeias = str_replace($mai[$i], $min[$i], $cadeias); 
    } 
    return $cadeias; 
} 
?>