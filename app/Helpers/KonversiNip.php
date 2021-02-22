<?php
function konversi_nip($nip, $batas = " ") {
	$nip = trim($nip," ");
	$panjang = strlen($nip);
	
	if($panjang == 18) {
		$sub[] = substr($nip, 0, 8); // tanggal lahir
		$sub[] = substr($nip, 8, 6); // tanggal pengangkatan
		$sub[] = substr($nip, 14, 1); // jenis kelamin
		$sub[] = substr($nip, 15, 3); // nomor urut
		
		return $sub[0].$batas.$sub[1].$batas.$sub[2].$batas.$sub[3];
	} elseif($panjang == 15) {
		$sub[] = substr($nip, 0, 8); // tanggal lahir
		$sub[] = substr($nip, 8, 6); // tanggal pengangkatan
		$sub[] = substr($nip, 14, 1); // jenis kelamin
		
		return $sub[0].$batas.$sub[1].$batas.$sub[2];
	} elseif($panjang == 9) {
		$sub = str_split($nip,3);
		
		return $sub[0].$batas.$sub[1].$batas.$sub[2];
	} else {
		return $nip;
	}
}

function kemosPegawaiGelarAuto($pegawai)
{
    $pegawai->pegawai_gelardepan == "-"? $gelarDepan = "": $gelarDepan = $pegawai->pegawai_gelardepan;
    $pegawai->pegawai_gelarbelakang== "-"? $gelarBelakang = "": $gelarBelakang = $pegawai->pegawai_gelarbelakang;
    $pegawai->pegawai_gelarbelakang== "-"? $separator = "": $separator = ",";
    return $gelarDepan.' '.$pegawai->pegawai_nama.$separator.$gelarBelakang;
}

// Contoh penggunaan fungsi
// konversi nip 18 digit
// hasil: 19700518 200503 1 005
// echo konversi_nip("197005182005031004");
// echo "<br/>";

// konversi nip 15 digit
// hasil: 19780418 200509 2
// echo konversi_nip("197804182005092");
// echo "<br/>";

// konversi nip 9 digit
// hasil: 320 007 497
// echo konversi_nip("320007497");
// echo "<br/>";

// konversi nip 18 digit dengan pemisah "."
// hasil: 19700518.200503.1.005
// echo konversi_nip("197005182005031004",".");
// echo "<br/>";

// konversi nip 15 digit dengan pemisah "-"
// 19780418-200509-2
// echo konversi_nip("197804182005092","-");
// echo "<br/>";

// konversi nip 9 digit dengan pemisah "."
// 320.007.497
// echo konversi_nip("320007497",".");
// echo "<br/>";
?>