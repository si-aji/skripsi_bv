<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblToko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_toko', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('toko_tipe', ['Online', 'Offline'])->default('Offline');
            $table->string('toko_nama');
            $table->string('toko_alamat')->nullable();
            $table->string('toko_link')->nullable();
            $table->string('toko_kontak')->nullable();
            $table->enum('toko_status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_toko');
    }
}
