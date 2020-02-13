<?php
 
include('simple_html_dom.php');
 
echo $url = 'https://www.amazon.com/dp/B07RN6SCXQ';
 
$html = file_get_html($url);

// var_dump($html);

// exit();
$images = array();
foreach($html->find('div') as $img) {
 $images[] = $img->attr;
}

// foreach($html->find('img[id=landingImage]') as $img) {
//     $images[] = $img->src;
//     }

echo "<pre>";
var_dump($images);
echo "</pre>";
exit();
$headlines = array();
foreach($html->find('span[id=productTitle]') as $header) {
 $headlines[] = $header->plaintext;
}
print_r($headlines);
// $ret = $html->find('span[id=productTitle]');
   
echo "<pre>";
var_dump($images);
echo "</pre>";

// Array ( [0] => It's a Ball Thing You Wouldn't Get It - Family - Last Name T-Shirt )
// array(1) {
//   [0]=>
//   string(151) "https://m.media-amazon.com/images/I/A13usaonutL._AC_CLa%7C2140%2C2000%7C71DBCcLK93L.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0._SX342_.png"
// }
// https://m.media-amazon.com/images/I/A13usaonutL._CLa%7C500%2C468%7C41I1J3hKa0L.png%7C0%2C0%2C500%2C468%2B0.0%2C0.0%2C500.0%2C468.0._SX342_.png
$link = $images[0];

echo $link1 = substr($link,0,36);
// echo "<br>";
// echo $link2 = substr($link,72,15);

// echo $link1.$link2;

$mystring = 'abc';
$findme   = 'a';
echo "<br>";
$pos1 = strpos($link, '.png%7C');
$pos2 = strpos($link, 'C2000%7C');
echo $imgname =substr($link,$pos2+8,$pos1-$pos2-4);
?>
<!-- <img src="<?php echo $link1.$link2 ?>" alt="" style='width:250px;'> -->
