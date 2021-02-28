<?php

$json = file_get_contents('/volume1/service/test.json');
$array = json_decode($json, true);
$test = $array["user"];
echo "$test";

?>