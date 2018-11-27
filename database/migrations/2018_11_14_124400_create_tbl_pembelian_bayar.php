<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPembelianBayar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembelian_bayar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pembelian_id')->unsigned(); //Relation dengan tbl_pembelian (id)
            $table->integer('user_id')->unsigned(); //Relation dengan user (id)
            $table->timestamp('pembayaran_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('biaya_lain');
            $table->integer('diskon');
            $table->integer('bayar');
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_pembelian_bayar', function(Blueprint $table){
            $table->foreign('pembelian_id')
                ->references('id')
                ->on('tbl_pembelian')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('tbl_pembelian_bayar', function(Blueprint $table){
            $table->dropForeign('tbl_pembelian_bayar_pembelian_id_foreign');
        });
        //Drop foreign
        Schema::table('tbl_pembelian_bayar', function(Blueprint $table){
            $table->dropForeign('tbl_pembelian_bayar_user_id_foreign');
        });
        Schema::dropIfExists('tbl_pembelian_bayar');
    }
}
