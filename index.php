<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include 'config.php';
getfunc('db');
$oDB=new db();
// var_dump($_SESSION['link']);
if (isset($_SESSION['link']['id'])) {
  # code...
  // echo "Đã tồn tại";
}else{
  $_SESSION['link']['id']=1;
  $_SESSION['link']['time']=1;
}

$sql = "SELECT * FROM link WHERE LinkOption=1 OR LinkOption=2";
$arr = $oDB->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    $timerf = rand(7,12);
      if (isset($_GET['get'])) {
        ?>
        
        <meta http-equiv="refresh" content="<?php echo($timerf) ?>">
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

<body onLoad="newpage();">

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

$sql = "SELECT COUNT(*) as total FROM link Where LinkOption = 4";
$count3 = $oDB->query($sql)->fetchArray();

echo "<h1>Đã tải : ".$count['total']." - Lỗi :".$count3['total']."  / Còn lại :".$count2['total']."</h1>";
echo "<h3>Reset sau :".$timerf." giây</h3>"
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
$openlink = 0;


    //echo $value['LinkId'];
    if (isset($_GET['get'])) {
      $url = $next['LinkName'];
      // echo $nextlinkid;
      // echo "</Br>";
      // var_dump($_SESSION['link']);
      // echo "</Br>";
      if ($_SESSION['link']['id']==$nextlinkid) {
        // echo "Đã tồn tại";
        if ($_SESSION['link']['time']>5) {
          $sql = "UPDATE link set LinkOption = 4 Where LinkId=?";
          $oDB->query($sql,$nextlinkid);
          exit();
        }
        $_SESSION['link']['time'] += 1;
      }else{
        // echo "Chưa tồn tại";
        $_SESSION['link']['id'] =$nextlinkid;
        $_SESSION['link']['time'] =1;
      }
      // exit();
      echo "</br>";
      echo "<a href='".$url."' target='_blank'>".$url."</a>";
      $arraytime = array();
      $arraytime[] = 3;
      for ($i=1; $i < 60; $i++) { 
        $arraytime[] = $i*40;
      }
      if (in_array($nextlinkid,$arraytime)) {
        $openlink = 1;
      }
      
      if (file_get_html($url)) {
        $html = file_get_html($url);
        $_SESSION['getimage']['link']=$url;
      } else {
        echo "Không get được file";
        $sql = "UPDATE link set LinkOption = 4 Where LinkId=?";
        $oDB->query($sql,$nextlinkid);
        exit();
      }
      

      
      // var_dump($html);
      // exit();
      $images = array();
 
      foreach($html->find('img') as $img) {
        if (strlen($img->src)==150) {
          $target = $img->src;
        }
        $images[] = $img->src;
      }
      echo "<pre>";
      var_dump($images);
      echo "</pre>";
      // exit();
      $headlines = array();
      foreach($html->find('span[id=productTitle]') as $header) {
      $headlines[] = $header->plaintext;
      }

      if (!isset($images[0])) {
        header('Location: index.php');
        exit();
        echo $target;
      }
      $target = (isset($target)) ? $target : $images[6] ;
      $link = $target;
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
        echo "</br>";
        var_dump ($_SESSION['link']);
        exit();
        }
      $flink = $link1.$link2;

    //Kiểm tra link có hợp lệ không đã 
    if (substr($link2, -4) == '.png') {
      echo $link2;
      echo "</br>";
      // unset($_SESSION['link'][$nextlinkid]);
    }else{
      echo $link2;
      echo "</br>";
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
    $image->resizeToWidth(2400);
    $image->save('image/fn/'.$name);

    $sql = "UPDATE link set LinkOption = 2, LinkPicture=?, LinkTitle = ? Where LinkId=?";
    $oDB->query($sql,$name,$title,$nextlinkid);
    
    
    if ($openlink==1) {
      ?>
      <script>
        function newpage() {
           window.open("<?php echo $_SESSION['getimage']['link'] ?>", '_blank');
        }
  </script>

      <?php
      $openlink=0;

    }
    
    }
foreach ($arr as $key => $value) {
  $title ="";
  $flink ="";
    if (!isset($_GET['get'])) {
      echo "<tr>";
    echo "<td>".$value['LinkId']."</td>";
    echo "<td><a href='".$value['LinkName']."'>".$value['LinkName']."</a></td>";
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