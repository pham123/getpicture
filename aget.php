<?php
$homepage = file_get_contents('https://www.amazon.com/dp/B082V1PGFY?customId=B0752XJYNL');
echo "<pre>";
var_dump($homepage);
echo "</pre>";
?>