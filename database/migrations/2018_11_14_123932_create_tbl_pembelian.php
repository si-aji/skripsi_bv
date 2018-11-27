<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id')->unsigned(); //Relation dengan tbl_supplier (id)
            $table->string('pembelian_invoice');
            $table->timestamp('pembelian_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('pembelian_detail')->nullable();
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_pembelian', function(Blueprint $table){
            $table->foreign('supplier_id')
                ->references('id')
                ->on('tbl_supplier')
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
        Schema::table('tbl_pembelian', function(Blueprint $table){
            $table->dropForeign('tbl_pembelian_supplier_id_foreign');
        });
        Schema::dropIfExists('tbl_pembelian');
    }
}
