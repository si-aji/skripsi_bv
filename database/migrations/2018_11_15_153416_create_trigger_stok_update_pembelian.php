<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerStokUpdatePembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER stokUpdate_pembelian AFTER UPDATE ON `tbl_pembelian_item` FOR EACH ROW
            BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok + (new.beli_qty - old.beli_qty),
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
        DB::unprepared('DROP TRIGGER `stokUpdate_pembelian`');
    }
}
