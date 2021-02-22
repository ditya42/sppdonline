<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Targetskpbulanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_targetskpbulanan', function (Blueprint $table) {
            $table->increments('targetskpbulanan_id'); // id
            $table->text('targetskpbulanan_nama'); // Nama bulanan skp
            $table->integer('targetbulanan_id'); // foreign dari kinerja_targetbulanan
            // $table->integer('pegawai_id'); // pegawai_id;
            $table->integer('targetskptahunan_id'); // Dari skp tahunan
            $table->integer('targetskpbulanan_kuantitas'); // kuanttias skp
            $table->integer('kuantitas_id'); // Foreign dari kinerja_kuantitas
            $table->integer('targetskpbulanan_kualitas'); // Target kualitas
            $table->integer('targetskpbulanan_waktu'); // Waktu target skp
            $table->float('targetskptahunan_biaya'); // Biaya
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
        Schem::dropIfExists('kinerja_targetskpbulanan');
    }
}
