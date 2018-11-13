<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPenjualanItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_penjualan_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('penjualan_id')->unsigned(); //Relation dengan tbl_penjualan (id)
            $table->integer('barang_id')->unsigned(); //Relation dengan tbl_barang (id)
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('jual_qty');
            $table->integer('diskon')->default('0');
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_penjualan_item', function(Blueprint $table){
            $table->foreign('penjualan_id')
                ->references('id')
                ->on('tbl_penjualan')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('barang_id')
                ->references('id')
                ->on('tbl_barang')
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
        //Drop foreign
        Schema::table('tbl_penjualan_item', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_item_penjualan_id_foreign');
        });
        //Drop foreign
        Schema::table('tbl_penjualan_item', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_item_barang_id_foreign');
        });
        Schema::dropIfExists('tbl_penjualan_item');
    }
}
