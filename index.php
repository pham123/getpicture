<?php
include 'config.php';
getfunc('db');
$oDB=new db();

$sql = "SELECT * FROM link WHERE LinkOption=1 OR LinkOption=2";
$arr = $oDB->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
      if (isset($_GET['get'])) {
        ?>
        
        <meta http-equiv="refresh" content="5">
        <?php
      }
    ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get Image</title>
</head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="uploadfile">
    <input type="submit" value="Upload" name="submit">
</form>
<h1><a href="?get">Get picture</a></h1>
<?php
$sql = "SELECT COUNT(*) as total FROM link Where LinkOption = 2";
$count = $oDB->query($sql)->fetchArray();

$sql = "SELECT COUNT(*) as total FROM link Where LinkOption = 1";
$count2 = $oDB->query($sql)->fetchArray();
echo "<h1>".$count['total']."/".$count2['total']."</h1>";

?>
<table id="customers">
<!-- <tr>
    <th>Id</th>
    <th>Link</th>
    <th>GetPicture</th>
    <th>title</th>
    <th>image</th>
</tr> -->


<?php
include('simple_html_dom.php');
$select = "SELECT * FROM link where LinkOption=1  LIMIT 1";
$next = $oDB->query($select)->fetchArray();
if (isset($next['LinkId'])) {
  # code...
}
// include 'function.php';

$nextlinkid   = (isset($next['LinkId'])) ? $next['LinkId'] : '' ;
function file_get_contents_curl($url) { 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    $data = curl_exec($ch); 
    curl_close($ch); 
    return $data; 
} 
// var_dump($key);

foreach ($arr as $key => $value) {
    $title ="";
    $flink ="";
    if (isset($_GET['get'])&&$nextlinkid==$value['LinkId']) {
      echo $url = $value['LinkName'];
      
      if (file_get_html($url)) {
        $html = file_get_html($url);
      } else {
        echo "Không get được file";
        $sql = "UPDATE link set LinkOption = 4 Where LinkId=?";
        $oDB->query($sql,$value['LinkId']);
        exit();
      }
      

      
      // var_dump($html);
      // exit();
      $images = array();
 
      foreach($html->find('img[id=landingImage]') as $img) {
      $images[] = $img->src;
      }
      // var_dump($image);
      $headlines = array();
      foreach($html->find('span[id=productTitle]') as $header) {
      $headlines[] = $header->plaintext;
      }


      $link = $images[0];
      $title = $headlines[0];
      $link1 = substr($link,0,36);
      // $link2 = substr($link,72,15);
      
      $pos1 = strpos($link, '.png%7C');
      echo "<Br>";
      $pos2 = strpos($link, 'C2000%7C');
      $link2 =substr($link,$pos2+8,$pos1-$pos2-4);
      if (strlen($link2)>20) {
        echo $link2;
        echo "<p>Không thành công, ko phải link ảnh</p>";
        exit();
        }
      $flink = $link1.$link2;

    //Kiểm tra link có hợp lệ không đã 
    if (substr($link2, -4) == '.png') {
      echo $link2;
    }else{
      echo $link2;
      exit();
    }
      
  $data = file_get_contents_curl($flink);
  $title = trim($title," ");
  $title = str_replace(' ', '_', $title);
  $title = preg_replace("/[^A-Za-z0-9]/", '_', $title);
    
  $name = $title.".png";
  $fp = 'image/'.$name; 
   
  file_put_contents( $fp, $data ); 
  //thay doi kich thuoc anh
  
    // $resize->resizeTo(4200, 4800);
    // $resize->saveImage('image/rs/'.$name);

    // $original_img = 'image/'.$name;// uploads/user_21098764.png
    // $new_img = 'image/rs/'.$name;//uploads/thumb_user_21098764.png
   
    // resize('4200', '4800', $new_img, $original_img);

    include('ResizeImage.php');
    $image = new SimpleImage();
    echo 'image/'.$name;
    $image->load('image/'.$name);
    // $image->resizeToWidth(4200);
    $image->save('image/rs/'.$name);

    // $im=imagecreatefrompng ( 'image/rs/'.$name );
    // $cropped = imagecropauto($im, IMG_CROP_TRANSPARENT);
    // if ($cropped !== false) { // in case a new image resource was returned
    //     imagedestroy($im);    // we destroy the original image
    //     $im = $cropped;       // and assign the cropped image to $im
    // }

    // imageAlphaBlending($im, true);
    // imageSaveAlpha($im, true);
    // imagedestroy($im);

    //đoạn này cắt phần thừa của ảnh
    $im = imagecreatefrompng('image/rs/'.$name);
    $cropped = imagecropauto($im, IMG_CROP_DEFAULT);

    if ($cropped !== false) { // in case a new image resource was returned
        imagedestroy($im);    // we destroy the original image
        $im = $cropped;       // and assign the cropped image to $im
    }

    imageAlphaBlending($im, true);
    imageSaveAlpha($im, 'image/rs/'.$name);
    imagepng($im, 'image/rs/'.$name);
    imagedestroy($im);
    // $im=imagecreatefrompng ( 'image/rs/'.$name );
    // $image->setImageResolution(500, 500);
    $image->load('image/rs/'.$name);
    $image->resizeToWidth(2100);
    $image->save('image/fn/'.$name);

    $sql = "UPDATE link set LinkOption = 2, LinkPicture=?, LinkTitle = ? Where LinkId=?";
    $oDB->query($sql,$name,$title,$value['LinkId']);

    //sleep(10);
    
    // header('Location:?get');

    // }else{
    //   // header('Location:?get');
    //   echo "ko được";
    //   //exit();
    // }
  
  
    }
    if (!isset($_GET['get'])) {
      echo "<tr>";
    echo "<td>".$value['LinkId']."</td>";
    echo "<td>".$value['LinkName']."</td>";
    echo "<td></td>";
    echo "<td>".$value['LinkTitle']."</td>";
    echo "<td>".$value['LinkPicture']."</td>";
    echo "</tr>";
    }
    
}
?>
    
</table>
<?php

$oDB = null;

?>
</body>
</html>