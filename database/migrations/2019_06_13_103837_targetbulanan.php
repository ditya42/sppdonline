<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Targetbulanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_targetbulanan', function (Blueprint $table) {
            $table->increments('targetbulanan_id'); // id
            $table->integer('pegawai_id'); // relasi pegawai id
            $table->string('targetbulanan_bulan'); // bulan
            $table->string('targetbulanan_tahun'); // tahun
            $table->float('targetbulanan_nilaiskp'); // nilai skp
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
        Schem::dropIfExists('kinerja_targetbulanan');
    }
}
