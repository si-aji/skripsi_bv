<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerStokUpdatePenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER stokUpdate_penjualan AFTER UPDATE ON `tbl_penjualan_item` FOR EACH ROW
            BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = CASE WHEN barang_stokStatus = "Aktif" THEN barang_stok - (new.jual_qty - old.jual_qty) WHEN barang_stokStatus = "Tidak Aktif" THEN 0 END
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
        DB::unprepared('DROP TRIGGER `stokUpdate_penjualan`');
    }
}
