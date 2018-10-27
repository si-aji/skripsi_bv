<?php
function version(){
    $version = "0.2.0 - develop";

    return $version;
}
function generate_gravatar($name){
    $formated_name = str_replace(" ", "+", $name);
    return "https://ui-avatars.com/api/?background=c2c7d0&color=343a40&size=160&name=".$formated_name;
}
?>
