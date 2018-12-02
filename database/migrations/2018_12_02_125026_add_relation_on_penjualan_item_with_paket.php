<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationOnPenjualanItemWithPaket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_penjualan_item', function (Blueprint $table) {
            $table->foreign('paket_id')
                ->references('id')
                ->on('tbl_paket')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_penjualan_item', function (Blueprint $table) {
            //Drop foreign
            Schema::table('tbl_penjualan_item', function(Blueprint $table){
                $table->dropForeign('tbl_penjualan_item_paket_id_foreign');
            });
        });
    }
}
