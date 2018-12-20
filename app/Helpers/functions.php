<?php
function version(){
    $version = "v.0.14.1 - develop";

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
function formated_date($date){
    return date("M", strtotime($date))." ".date("d", strtotime($date)).", ".date("Y", strtotime($date))." / ".date("H", strtotime($date)).":".date("i", strtotime($date)).":".date("s", strtotime($date))." WIB";
}
function only_date($date){
    return date("M", strtotime($date))." ".date("d", strtotime($date)).", ".date("Y", strtotime($date));
}

function generateInvoice($request){
    $tipe = "";

    if($request == "Beli"){
        $tipe = "BELI";
    } else if($request == "Jual"){
        $tipe = "JUAL";
    }

    //Generate Invoice untuk transaksi Jual (Tambah Stok)
    $generate_number = time() + random_int (9, 199);
    $ivc = "INVC/".$tipe."/".date("dmy").'/'.$generate_number;
    return $ivc;
}
?>
