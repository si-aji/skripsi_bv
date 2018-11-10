<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kostumer_id')->unsigned()->nullable(); //Relation dengan tbl_kostumer (id)
            $table->integer('toko_id')->unsigned(); //Relation dengan tbl_toko (id)
            $table->string('penjualan_invoice');
            $table->timestamp('penjualan_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('penjualan_detail')->nullable();
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_penjualan', function(Blueprint $table){
            $table->foreign('kostumer_id')
                ->references('id')
                ->on('tbl_kostumer')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('toko_id')
                ->references('id')
                ->on('tbl_toko')
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
        Schema::table('tbl_penjualan', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_kostumer_id_foreign');
        });
        //Drop foreign
        Schema::table('tbl_penjualan', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_toko_id_foreign');
        });

        Schema::dropIfExists('tbl_penjualan');
    }
}
