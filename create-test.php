<?php

/*
 * Add Plus to the right answer.
 *
 * Форматирует файлы с ответами в необходимый формат:
 *
 *  1. Вопрос                             
 * -1) неправильный ответ                
 * +2) Правильный ответ                  
 * -3) неправильный ответ                
 * -4) неправильный ответ                
 * -5) неправильный ответ                
 *                                       
 */




$lines=array();
$i = 1;
$obj = (object)[];
//OtvetY:
global $otvety, $res, $realotvety;
$realotvety = (object) [];
$otvety = [];
$res = [];
$start_otvety = 0;  

$fp=fopen($argv[1], 'r');
while (!feof($fp))
{
    $line=fgets($fp);
    $line=trim($line);

    if ($line == "ОТВЕТЫ") $start_otvety = 1;  
    if ($start_otvety == 1 ) {
    preg_match('/^[\d.]+/', $line, $otvety);
    preg_match('/(\d+)(?!.*\d)/', $line, $res);
    $realotvety->biletnum->{$otvety[0]}=$res[0];
    }
}


$fp=fopen($argv[1], 'r');
while (!feof($fp))
{
    $line=fgets($fp);
    $line=trim($line);

   if ($line == "ОТВЕТЫ") $line = "";


    $ifnum = preg_match('/^\d*[\.]/', $line, $there);
    if($there){             $line = $line."\r\n";
        $obj->biletnum->$i{'otvet'}=$realotvety->biletnum->{$i};
    $i++; $j=1;
    }
    if(1 === preg_match('/^\d[\)]/', $line)){  
//    $obj->biletnum->{$i-1}{'varik'}->$j="-".$line; 
      if ($j == $obj->biletnum->{$i-1}{'otvet'}) {
    $obj->biletnum->{$i-1}{'varik'}->$j="+".$line; 
    $line = "+".$line."\n"; 
    } else     $line = "-".$line."\n"; 

    $j++;

}
    $lines[]=$line;
}

fclose($fp);


$fp = fopen($argv[1]."-res.txt", 'w');  //fwrite($h, var_export($lines, true));
foreach($lines as $val){
fwrite($fp, $val);
}
?>
