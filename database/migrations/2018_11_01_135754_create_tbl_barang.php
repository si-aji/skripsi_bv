<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create tbl_barang
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kategori_id')->unsigned(); //Relation dengan tbl_kategori (id)
            $table->string('barang_kode'); //Untuk menyimpan nomor berdasarkan kode kategori
            $table->string('barang_nama');
            $table->enum('barang_stokStatus', ['Aktif', 'Tidak Aktif']); //Jika aktif maka stok bisa diubah"
            $table->integer('barang_stok');
            $table->integer('barang_hBeli');
            $table->integer('barang_hJual');
            $table->text('barang_detail')->nullable();
            $table->enum('barang_status', ['Aktif', 'Tidak Aktif'])->default('Aktif'); //Jika aktif barang akan ditampilkan, sebaliknya akan disembunyikan jika tidak aktif
            $table->timestamps();
        });

        //Set foreign key
        Schema::table('tbl_barang', function(Blueprint $table){
            $table->foreign('kategori_id')
                ->references('id')
                ->on('tbl_kategori')
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
        Schema::table('tbl_barang', function(Blueprint $table){
            $table->dropForeign('tbl_barang_kategori_id_foreign');
        });

        //Drop tbl_barang
        Schema::dropIfExists('tbl_barang');
    }
}
