<?php
include 'config.php';
getfunc('db');
$oDB=new db();
$sql = "INSERT INTO link (`LinkName`,`LinkOption`) VALUES (?,?)";
for ($i=0; $i < 250 ; $i++) { 
    $oDB->query($sql,'Name'.$i,0);
}