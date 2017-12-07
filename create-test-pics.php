<?php         

// 
// If one of the questions has a picture, we find the picture's name and put this name after the question.
//

// Форматирует файлы с ответами в необходимый формат:
// 1. Вопрос
// @image1.jpg (если была картинка в .docx файле в этом вопросе)
// -1) Неправильный ответ.
// +2) Правильный ответ.
// -3) Неправильный ответ.
// -4) Неправильный ответ.
// -5) нНеправильный ответ.
//


$lines=array();
$i = 1;

$obj = (object)[];


//OtvetY:

global $otvety, $res, $realotvety, $s_num;
$realotvety = (object) [];

//$realotvety['bil']=array();
//$realotvety['res']=array();
$start_otvety = 0;  
$s_num[1]="";
$i = 0;
$file= $argv[1].'.docx.xml';
$fp=fopen($file, 'r');
while (!feof($fp))
{
    $line=fgets($fp);
    //process line however you like
    $line=trim($line);
    

$search = '<w:t xml:space="preserve">';
$search_pic = '<pic:blipFill';

if (strpos($line, $search) !== false) {
preg_match('/<w:t xml:space="preserve">(\d+)/', $line, $s_num);
   
    if (is_numeric($s_num[1])) { 
    $all_num[$s_num[1]] = $s_num[1]; $i++; 
//    $a = array_slice(array_diff($all_num,['']),1,1);
//echo $i;

//   print_r($all_num[$s_num[1]]);

    echo "\n";
}
}


if (strpos($line, $search_pic) !== false) {
    $image_num[] = end($all_num);
//    echo $i;
//    echo $all_num[$s_num[1]];
//    echo "\n";
}
}

//print_r($all_num);
//print_r($image_num);



$lines=array();
$i = 1;
$obj = (object)[];

//OtvetY:

global $otvety, $res, $realotvety;
$realotvety = (object) [];
$otvety = [];
$res = [];
$start_otvety = 0;  


if ($course) $course_file = $coursename.$course.".txt";
else $course_file = "pic.txt";
//echo 'file: '.$course_file.'<br/><br/>';

//$course_file = "vik6.6.txt";
//echo gettype($course_file);




$fp=fopen($argv[1].'.txt', 'r');
while (!feof($fp))
{
    $line=fgets($fp);

    //process line however you like
    $line=trim($line);



    if ($line == "ОТВЕТЫ") $start_otvety = 1;  
    if ($start_otvety == 1 ) {

//preg_match('/^(\d+)/', $line, $matches);
//if (preg_match_all('/^(\d+)/', $line, $m))   print_r($m[0]);
preg_match('/^[\d.]+/', $line, $otvety);
preg_match('/(\d+)(?!.*\d)/', $line, $res);
echo "\n";

$realotvety->biletnum->{$otvety[0]}=$res[0];
}
}






$fp=fopen($argv[1].'.txt', 'r');
$b=1;
while (!feof($fp))
{
    $line=fgets($fp);
    //process line however you like
    $line=trim($line);



    if ($line == "ОТВЕТЫ") $line = "";


    $ifnum = preg_match('/^\d*[\.]/', $line, $whichnum);
    if(1 === $ifnum){             $line = $line."\n";

       preg_match('/\d*/', $line, $num);
    // print_r($num);    echo "\n";  //count BILETNUM
//     var_dump($image_num[$num]);    echo "\n";  //count BILETNUM
    if (in_array($num[0], $image_num)) {$line = $line."@image".$b.".jpg\n";     $b++;}
    else {$line = $line."@default.jpg\n"; }

    $obj->biletnum->$i{'vorpos'}=$line; 

    //echo "\n";
    //echo $obj->biletnum; 
    //echo "\n";

    $obj->biletnum->$i{'vorpos'}=$line; 
        $obj->biletnum->$i{'otvet'}=$realotvety->biletnum->{$i};
//        print_r($line);
    $i++; $j=1;
    }

    if(1 === preg_match('/^\d[\)]/', $line)){  
//    print_r($line);    
    echo "\n";  //count BILETNUM
    $obj->biletnum->{$i-1}{'varik'}->$j="-".$line; 

    if ($j == $obj->biletnum->{$i-1}{'otvet'}) {
    $obj->biletnum->{$i-1}{'varik'}->$j="+".$line; 
    $line = "+".$line."\n"; //var_dump( $line);
    } else $line = "-".$line."\n"; 
//var_dump($obj->biletnum->{$i-1}{'varik'}-$j);
//    $obj->biletnum->$i{vopros}->$i{varik}{$j}=$line;
    echo "\n";
//    echo $obj->biletnum[2]; 
    echo "\n";

    $j++;
//if ($j == 4) $j = 1;
}

    //add to array
    $lines[]=$line;
}
//print_r($lines);
fclose($fp);


//print_r($realotvety->biletnum);
$fp = fopen($argv[1].'-res.txt', 'w');  //fwrite($h, var_export($lines, true));
foreach($lines as $val){ fwrite($fp, $val); }

?>