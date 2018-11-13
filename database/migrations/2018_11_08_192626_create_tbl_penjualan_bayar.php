<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPenjualanBayar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_penjualan_bayar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('penjualan_id')->unsigned(); //Relation dengan tbl_penjualan (id)
            $table->integer('user_id')->unsigned(); //Relation dengan user (id)
            $table->timestamp('pembayaran_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('biaya_lain');
            $table->integer('bayar');
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_penjualan_bayar', function(Blueprint $table){
            $table->foreign('penjualan_id')
                ->references('id')
                ->on('tbl_penjualan')
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
        Schema::table('tbl_penjualan_bayar', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_bayar_penjualan_id_foreign');
        });
        //Drop foreign
        Schema::table('tbl_penjualan_bayar', function(Blueprint $table){
            $table->dropForeign('tbl_penjualan_bayar_user_id_foreign');
        });
        Schema::dropIfExists('tbl_penjualan_bayar');
    }
}
