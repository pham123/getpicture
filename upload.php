<?php
include 'config.php';
getfunc('db');
$oDB=new db();
//var_dump($_FILES);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="index.php">về trang chủ</a>
</body>
</html>
<?php

for ($i=1; $i < 251; $i++) { 
    # code...
    $sql ="UPDATE getimg.link SET LinkName = 'NA', LinkPicture = 'NA', LinkTitle='NA', LinkOption = 0 where LinkId = ?";
    $oDB->query($sql,$i);
}
$target_dir = "uploads/";
$uploadfile = $target_dir . basename($_FILES["fileToUpload"]["name"]);

echo '<pre>';
if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

$_SESSION['file']= $_FILES["fileToUpload"]["name"];

// echo 'Here is some more debugging info:';
// print_r($_FILES);

// print "</pre>";

$file = new SplFileObject($target_dir . basename($_FILES["fileToUpload"]["name"]));

// Loop until we reach the end of the file.
$i = 1;
while (!$file->eof()) {
    // Echo one line from the file.
    echo $link = $file->fgets();
    $link = trim(preg_replace('/\s\s+/', ' ', $link));
    // đẩy file lên database
    if (strlen($link)>10) {
        $sql = "UPDATE getimg.link set LinkOption = 1, LinkPicture='NA', LinkTitle = 'NA', LinkName=? Where LinkId=?";
        $oDB->query($sql,$link,$i);
    }

    $i++;

    
}

// Unset the file to call __destruct(), closing the file handle.
$file = null;

?>
