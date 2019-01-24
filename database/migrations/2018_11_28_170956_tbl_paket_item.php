<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblPaketItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_paket_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paket_id')->unsigned(); //Relation dengan tbl_paket (id)
            $table->integer('barang_id')->unsigned(); //Relation dengan tbl_barang (id)
            $table->integer('barang_hAsli');
            $table->integer('barang_hJual');
            $table->timestamps();
        });
        //Set foreign key
        Schema::table('tbl_paket_item', function(Blueprint $table){
            $table->foreign('paket_id')
                ->references('id')
                ->on('tbl_paket')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        //Set foreign key
        Schema::table('tbl_paket_item', function(Blueprint $table){
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
        Schema::table('tbl_paket_item', function(Blueprint $table){
            $table->dropForeign('tbl_paket_item_barang_id_foreign');
        });
        Schema::dropIfExists('tbl_paket_item');
    }
}
