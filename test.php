<?php
    error_reporting(0);

    $arr = array();

    array_push($arr,1);
    array_push($arr,2);
    array_push($arr,3);

    foreach ($arr as $key => $value){
        $arr[$key] = $value + 1;
    }

    var_dump($arr);

?>