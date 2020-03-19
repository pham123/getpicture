<?php
 
// include('simple_html_dom.php');
 
// $url = 'https://www.amazon.com/dp/B081FTR951';
$url = 'https://www.amazon.com/dp/B07L1XZMXR';

// $html = file_get_html($url);
// $homepage = file_get_contents($url);
// echo $homepage;

$opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
    )
  );
  
  $context = stream_context_create($opts);
  
  // Open the file using the HTTP headers set above
  $file = file_get_contents($url, false, $context);

//   var_dump($file);

// $myfile = fopen("testfile2.txt", "w");
// $myfile = fopen("testfile2.txt", "w") or die("Unable to open file!");
// fwrite($myfile, $file);
// fclose($myfile);

$subject = $file;
$pattern = '/\<span id\=\"productTitle\" class\=\"a-size-large\"\>[\d\w\n\s\-\_\'\%\*\^\&\#\@\!\.\,\[\]\{\}\+\=\|\)\(\$\;\:\"\?]+\<\/span\>/';
preg_match($pattern, substr($subject,3), $matches, PREG_OFFSET_CAPTURE);
print_r($matches);
$title = $matches[0][0];
$title = trim(preg_replace('/\s+/', ' ', $title));
$title = trim(preg_replace('/\<span id\=\"productTitle\" class\=\"a-size-large\"\>/', ' ', $title));
$title = trim(preg_replace('/\<\/span\>/', ' ', $title));
$title2 = trim(preg_replace('/\s+/', '_', $title));

echo $title;
echo "</br>";
echo $title2;
echo "</br>";
// exit();
$pattern2 = '/data-old-hires\=\"https\:\/\/m\.media\-amazon\.com\/images\/I\/[\d\w\.\%\-\_]+\.png\%/';
preg_match($pattern2, substr($subject,3), $matches2, PREG_OFFSET_CAPTURE);
print_r($matches2);
$fulllink = $matches2[0][0];
$pattern3 = '/0\%7C[\d\w\%\-\_]+.png/';
preg_match($pattern3, substr($fulllink,3), $matches3, PREG_OFFSET_CAPTURE);
echo $matches3[0][0];
echo "</br>";
$prelink = substr($matches3[0][0],4);
echo "https://m.media-amazon.com/images/I/".$prelink;


// $matches = array();
// preg_match('/id=([0-9]+)\?/', $url, $matches);