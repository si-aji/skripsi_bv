<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerStokPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER stok_pembelian AFTER INSERT ON `tbl_pembelian_item` FOR EACH ROW
            BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok + new.beli_qty,
                    barang_hBeli = new.harga_beli
                WHERE
                    id = new.barang_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `stok_pembelian`');
    }
}
