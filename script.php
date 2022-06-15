<?php
require "C:/xampp/htdocs/scrapping/vendor/autoload.php";

while(true)
{
    sleep(5);
    $data = file_get_contents("http://localhost/scrapping/public/lists/test_api");
    echo $data;
}