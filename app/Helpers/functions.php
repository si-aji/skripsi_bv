<?php
function version(){
    $version = "v.0.5.0 - develop";

    return $version;
}
function generate_gravatar($name){
    $formated_name = str_replace(" ", "+", $name);
    return "https://ui-avatars.com/api/?background=c2c7d0&color=343a40&size=160&name=".$formated_name;
}
function idr_currency($num){
    return "Rp ".number_format((float)$num,0,',','.');
    //return $num;
}
?>
