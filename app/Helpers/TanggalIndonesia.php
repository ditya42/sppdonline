<?php

use Illuminate\Support\Debug\Dumper;

function tanggal_indonesia($tgl, $tampil_hari=true){
   $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
   $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

   $tahun = substr($tgl,0,4);
//    $bulan = $nama_bulan[(int)substr($tgl,5,2)];
   $bulan = substr($tgl, 5, 2);
   $tanggal = substr($tgl,8,2);

   $text = "";

   if($tampil_hari){
      $urutan_hari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
      $hari = $nama_hari[$urutan_hari];
    //   $text .= $hari.", ";
   }

   $text .= $tanggal ."-". $bulan ."-". $tahun;

   return $text;
}

function tanggal_indonesia_huruf($tgl, $tampil_hari=true){
    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
    $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($tgl,0,4);
    $bulan = $nama_bulan[(int)substr($tgl,5,2)];
    $tanggal = substr($tgl,8,2);

    $text = "";

    if($tampil_hari){
       $urutan_hari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
       $hari = $nama_hari[$urutan_hari];
     //   $text .= $hari.", ";
    }

    $text .= $tanggal ." ". $bulan ." ". $tahun;

    return $text;
 }

 function tanggal_indonesia_bulan($tgl, $tampil_hari=true){
    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
    $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($tgl,0,4);
    $bulan = $nama_bulan[(int)substr($tgl,5,2)];
    $tanggal = substr($tgl,8,2);

    $text = "";

    if($tampil_hari){
       $urutan_hari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
       $hari = $nama_hari[$urutan_hari];
     //   $text .= $hari.", ";
    }

    $text .= $bulan ." ". $tahun;

    return $text;
 }

if (! function_exists('dnd')) {
  /**
   * Dump the passed variables and end the script.
   *
   * @param  mixed  $args
   * @return void
   */
  function dnd(...$args)
  {
      http_response_code(500);

      foreach ($args as $x) {
          (new Dumper())->dump($x);
      }

  }
}