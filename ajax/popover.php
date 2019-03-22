<?php

if($_REQUEST['button'])
    setcookie("popover", true, time() + (10 * 365 * 24 * 60 * 60));

if(!isset($_COOKIE["popover"]) && !$_COOKIE["popover"]){
    print json_encode(array("response" => true));
}






