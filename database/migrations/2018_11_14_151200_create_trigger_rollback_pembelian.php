<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerRollbackPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER rollback_pembelian AFTER DELETE ON `tbl_pembelian_item` FOR EACH ROW
            BEGIN
                UPDATE
                tbl_barang SET
                    barang_stok = barang_stok - old.beli_qty
                WHERE
                    id = old.barang_id;
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
        DB::unprepared('DROP TRIGGER `rollback_pembelian`');
    }
}
