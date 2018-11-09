<?php
function version(){
    $version = "v.0.9.1 - develop";

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

function invoiceJual(){
    //Generate Invoice untuk transaksi Jual (Tambah Stok)
    $ivc = "INVC/JUAL/".date("dmy").'/'.time();
    return $ivc;
}
?>
