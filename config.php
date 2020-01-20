<?php
define('_DB_HOST_','localhost');
define('_DB_USER_','root');
define('_DB_PASS_','Yuntong2412');
define('_DB_name_','getimg');
define('_DB_PREFIX_','');
define('_site_','smes');

define('ROOT_DIR', dirname(__FILE__));
function i_func($func_name)
{
    include ROOT_DIR.'/function/'.$func_name.'.php';
}
function getfunc($func_name)
{
    include ROOT_DIR.'/function/'.$func_name.'.php';
}
?>
