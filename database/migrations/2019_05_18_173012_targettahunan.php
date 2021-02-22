<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Targettahunan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinerja_targettahunan', function (Blueprint $table) {
            $table->increments('targettahunan_id');
            $table->integer('pegawai_id');
            $table->integer('skpd_id');
            $table->integer('subunit_id');
            $table->integer('targettahunan_pejabat1');
            $table->integer('targettahunan_pejabat2');
            $table->date('targettahunan_awal');
            $table->date('targettahunan_akhir');
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
        Schema::dropIfExists('kinerja_targettahunan');
    }
}
