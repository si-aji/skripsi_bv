<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPembelianItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembelian_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pembelian_id')->unsigned(); //Relation dengan tbl_pembelian (id)
            $table->integer('barang_id')->unsigned(); //Relation dengan tbl_barang (id)
            $table->integer('harga_beli');
            $table->integer('beli_qty');
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_pembelian_item', function(Blueprint $table){
            $table->foreign('pembelian_id')
                ->references('id')
                ->on('tbl_pembelian')
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
        Schema::table('tbl_pembelian_item', function(Blueprint $table){
            $table->dropForeign('tbl_pembelian_item_pembelian_id_foreign');
        });
        //Drop foreign
        Schema::table('tbl_pembelian_item', function(Blueprint $table){
            $table->dropForeign('tbl_pembelian_item_barang_id_foreign');
        });
        Schema::dropIfExists('tbl_pembelian_item');
    }
}
