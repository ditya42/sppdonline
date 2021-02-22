<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Satuankuantitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_kuantitas', function (Blueprint $table) {
            $table->increments('kuantitas_id');
            $table->string('kuantitas_nama');
            $table->enum('kuantitas_status', ['Aktif', 'Tidak']);
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
        Schema::dropIfExists('kinerja_kuantitas');
    }
}
