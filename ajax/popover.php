<?php

if(!isset($_COOKIE["popover"]) && !$_COOKIE["popover"]){
    setcookie("popover", true, time() + (10 * 365 * 24 * 60 * 60));
    print json_encode(array("response" => true));
}





