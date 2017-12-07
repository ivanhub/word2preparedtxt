<?php

/* 
 * Add Plus to the right answer.
 * 
 * Форматирует файлы с ответами в необходимый формат:
 * 1. Вопрос
 * -а) неправильный ответ
 * +б) Правильный ответ
 * -в) неправильный ответ
 * -г) неправильный ответ
 * -д) неправильный ответ
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
    preg_match('/([абвгд]+)(?!.*\d)/', $line, $res);
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
//    $obj->biletnum->$i{'vorpos'}=$line; 
        $obj->biletnum->$i{'otvet'}=$realotvety->biletnum->{$i};
    $i++; $j=1;
    }
    if(1 === preg_match('/^[абвгде]*[\)]/', $line)){  
//    $obj->biletnum->{$i-1}{'varik'}->$j="-".$line; 
//    echo $j."and:".$obj->biletnum->{$i-1}{'otvet'};

      if (($j==1) and ('а' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 
    elseif (($j==2) and ('б' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 
    elseif (($j==3) and ('в' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 
    elseif (($j==4) and ('г' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 
    elseif (($j==5) and ('д' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 
    elseif (($j==6) and ('е' == $obj->biletnum->{$i-1}{'otvet'})) {    $line = "+".$line."\n"; } 

    else     $line = "-".$line."\n"; 

    $j++;

//    $obj->biletnum->{$i-1}{'varik'}->$j="+".$line; 

}
    $lines[]=$line;
}

fclose($fp);


$fp = fopen($argv[1]."-res.txt", 'w');  //fwrite($h, var_export($lines, true));
foreach($lines as $val){
fwrite($fp, $val);
}
?>
