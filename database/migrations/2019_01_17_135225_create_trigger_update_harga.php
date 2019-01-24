<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerUpdateHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER updateHarga_barang AFTER UPDATE ON `tbl_barang` FOR EACH ROW
            BEGIN
                UPDATE
                tbl_paket_item SET
                    barang_hAsli = new.barang_hJual
                WHERE
                    id = new.id;
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
        DB::unprepared('DROP TRIGGER `updateHarga_barang`');
    }
}
