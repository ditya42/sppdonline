<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Targetskptahunan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_targetskptahunan', function (Blueprint $table) {
            $table->increments('targetskptahunan_id'); // ID Target
            $table->integer('pegawai_id'); // Pegawai ID
            $table->integer('targettahunan_id'); // Foreign dari table kinerja_targettahunan
            $table->text('targetskptahunan_kegiatan'); // Kegiatan skp
            $table->integer('targetskptahunan_ak'); // Angka kredit apabila fungsional
            $table->integer('targetskptahunan_aktotal'); // Angka kredit apabila fungsional total
            $table->integer('targetskptahunan_kuantitas'); // kuanttias skp
            $table->integer('kuantitas_id'); // Foreign dari kinerja_kuantitas
            $table->integer('targetskptahunan_kualitas'); // Target kualitas
            $table->integer('targetskptahunan_waktu'); // Waktu target skp
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
        Schem::dropIfExists('kinerja_targetskptahunan');
    }
}
