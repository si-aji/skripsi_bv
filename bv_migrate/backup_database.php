<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "bu_bv";

$db_host_new = "localhost";
$db_user_new = "root";
$db_pass_new = "";
$db_name_new = "project_bakulvisor-skripsi_master";

//Make an Object
$conn = new \mysqli($db_host, $db_user, $db_pass, $db_name);
$conn2 = new \mysqli($db_host_new, $db_user_new, $db_pass_new, $db_name_new);
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

//Kategori
$sql_kategori = $conn->query("SELECT * FROM tbl_kategori ORDER BY kategori_kd ASC");
while($kategori = $sql_kategori->fetch_array()){
    //echo "INSERT INTO tbl_kategori (kategori_kode, kategori_nama, created_at, updated_at) VALUES ('".$kategori['kategori_kd']."', '".$kategori['kategori_nama']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Barang
$sql_barang = $conn->query("SELECT * FROM tbl_barang ORDER BY barang_kd ASC");
while($barang = $sql_barang->fetch_array()){
    $sql_kategori = $conn2->query("SELECT * FROM tbl_kategori WHERE kategori_kode = '".$barang['kategori_kd']."'");
    $kategori = $sql_kategori->fetch_assoc();

    //echo "INSERT INTO tbl_barang (id, kategori_id, barang_kode, barang_nama, barang_stokStatus, barang_stok, barang_hBeli, barang_hJual, barang_detail, barang_status, created_at, updated_at) VALUES ('".$barang['barang_kd']."', '".$kategori['id']."', '".$barang['barang_id']."', '".$barang['barang_nama']."', 'Aktif', '".$barang['barang_stok']."', '".$barang['barang_hBeli']."', '".$barang['barang_hJual']."', '".$barang['barang_detail']."', 'Aktif', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Kostumer
$sql_kostumer = $conn->query("SELECT * FROM tbl_cust");
while($cust = $sql_kostumer->fetch_array()){
    if($cust['cust_kontak'] == '1'){
        $kontak = null;
    } else {
        $kontak = $cust['cust_kontak'];
    }

    //echo "INSERT INTO tbl_kostumer (id, kostumer_nama, kostumer_kontak, kostumer_detail, created_at, updated_at) VALUES ('".$cust['cust_id']."', '".ucwords(strtolower($cust['cust_nama']))."', '".$kontak."', '".$cust['cust_detail']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Supplier
$sql_supplier = $conn->query("SELECT * FROM tbl_supplier");
while($supplier = $sql_supplier->fetch_array()){
    //echo "INSERT INTO tbl_supplier (id, supplier_nama, supplier_kontak, supplier_detail, supplier_status, created_at, updated_at) VALUES ('".$supplier['supplier_id']."', '".$supplier['supplier_nama']."', '".$supplier['supplier_kontak']."', '".strip_tags($supplier['supplier_detail'])."', 'Aktif', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Toko
$sql_toko = $conn->query("SELECT * FROM tbl_toko");
while($toko = $sql_toko->fetch_array()){
    //echo "INSERT INTO tbl_toko (id, toko_tipe, toko_nama, toko_alamat, toko_kontak, toko_status, created_at, updated_at) VALUES ('".$toko['toko_id']."', '".$toko['toko_tipe']."', '".$toko['toko_nama']."', '".$supplier['toko_alamat']."', '".$toko['toko_cp']."', 'Aktif', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Pembelian
$sql_pembelian = $conn->query("SELECT * FROM tbl_beli ORDER BY beli_tgl ASC");
while($beli = $sql_pembelian->fetch_array()){
    //echo "INSERT INTO tbl_pembelian (supplier_id, pembelian_invoice, pembelian_tgl, pembelian_detail, created_at, updated_at) VALUES ('".$beli['supplier_id']."', '".$beli['beli_invoice']."', '".$beli['beli_tgl']."', '".htmlspecialchars($beli['beli_detail'])."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Pembelian Item
$sql_pembelian_item = $conn->query("SELECT * FROM tbl_belidetail");
while($beli_item = $sql_pembelian_item->fetch_array()){
    $sql_pembelian = $conn2->query("SELECT * FROM tbl_pembelian WHERE pembelian_invoice = '".$beli_item['beli_invoice']."'");
    $beli = $sql_pembelian->fetch_assoc();

    //echo "INSERT INTO tbl_pembelian_item (pembelian_id, barang_id, harga_beli, beli_qty, created_at, updated_at) VALUES ('".$beli['id']."', '".$beli_item['barang_kd']."', '".$beli_item['beli_hBeli']."', '".$beli_item['beli_jumlah']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Pembelian Bayar
$sql_pembelian_bayar = $conn->query("SELECT * FROM tbl_belilog");
while($beli_bayar = $sql_pembelian_bayar->fetch_array()){
    $sql_pembelian = $conn2->query("SELECT * FROM tbl_pembelian WHERE pembelian_invoice = '".$beli_bayar['beli_invoice']."'");
    $beli = $sql_pembelian->fetch_assoc();

    //echo "INSERT INTO tbl_pembelian_bayar (pembelian_id, user_id, pembayaran_tgl, biaya_lain, diskon, bayar, created_at, updated_at) VALUES ('".$beli['id']."', '".$beli_bayar['akun_id']."', '".$beli_bayar['log_tanggal']."', '".$beli_bayar['log_biayaLain']."', '0', '".$beli_bayar['log_bayar']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Penjualan
$sql_penjualan = $conn->query("SELECT * FROM tbl_jual ORDER BY jual_tgl ASC");
while($jual = $sql_penjualan->fetch_array()){
    if(!is_null($jual['cust_id'])){
        $cust = "'".$jual['cust_id']."'";
    } else {
        $cust = 'null';
    }

    //echo "INSERT INTO tbl_penjualan (kostumer_id, toko_id, penjualan_invoice, penjualan_tgl, penjualan_detail, created_at, updated_at) VALUES (".$cust.", '".$jual['toko_id']."', '".$jual['jual_invoice']."', '".$jual['jual_tgl']."', '".htmlspecialchars($jual['jual_detail'])."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Penjualan Item
$sql_penjualan_item = $conn->query("SELECT * FROM tbl_jualdetail");
while($jual_item = $sql_penjualan_item->fetch_array()){
    $sql_penjualan = $conn2->query("SELECT * FROM tbl_penjualan WHERE penjualan_invoice = '".$jual_item['jual_invoice']."'");
    $jual = $sql_penjualan->fetch_assoc();

    //echo "INSERT INTO tbl_penjualan_item (penjualan_id, barang_id, harga_beli, harga_jual, jual_qty, diskon, created_at, updated_at) VALUES ('".$jual['id']."', '".$jual_item['barang_kd']."', '".$jual_item['beli_harga']."', '".$jual_item['jual_harga']."', '".$jual_item['jual_jumlah']."', '".$jual_item['jual_diskon']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}

//Penjualan Bayar
$sql_penjualan_bayar = $conn->query("SELECT * FROM tbl_juallog");
while($jual_bayar = $sql_penjualan_bayar->fetch_array()){
    $sql_penjualan = $conn2->query("SELECT * FROM tbl_penjualan WHERE penjualan_invoice = '".$jual_bayar['jual_invoice']."'");
    $jual = $sql_penjualan->fetch_assoc();

    //echo "INSERT INTO tbl_penjualan_bayar (penjualan_id, user_id, pembayaran_tgl, biaya_lain, bayar, created_at, updated_at) VALUES ('".$jual['id']."', '".$jual_bayar['akun_id']."', '".$jual_bayar['log_tanggal']."', '".$jual_bayar['log_biayaLain']."', '".$jual_bayar['log_bayar']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');\n";
}
?>
