<?php
 
include('simple_html_dom.php');
 
echo $url = 'https://www.amazon.com/Disney-Frozen-Character-Panels-T-Shirt/dp/B07YQJQGBQ/ref=pd_sbs_193_1/141-7775437-9676220?_encoding=UTF8&pd_rd_i=B07YQJQGBQ&pd_rd_r=093f0dc2-907b-4b86-861d-128ca94fb06c&pd_rd_w=ZydmK&pd_rd_wg=onZEV&pf_rd_p=bdd201df-734f-454e-883c-73b0d8ccd4c3&pf_rd_r=6Y90918TFX60NZJX0YJB&psc=1&refRID=6Y90918TFX60NZJX0YJB';
 
$html = file_get_html($url);

// var_dump($html);

// exit();
$images = array();
foreach($html->find('img') as $img) {
 $images[] = $img->src;
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
