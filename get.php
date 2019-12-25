<?php 
include 'function.php';
function file_get_contents_curl($url) { 
    $ch = curl_init(); 
  
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
} 
  
$data = file_get_contents_curl( 
'https://m.media-amazon.com/images/I/71DBCcLK93L.png'); 
  
$name = 'Logo-1.png';
$fp = 'image/'.$name; 
 
file_put_contents( $fp, $data ); 

//thay doi kich thuoc anh
$resize = new ResizeImage($fp);
$resize->resizeTo(4200, 4800, 'maxWidth');
$resize->saveImage("image/rs/".$name);


echo "File downloaded!"
  
?> 