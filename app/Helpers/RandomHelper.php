<?php
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\File;

if (! function_exists('isNull')) {
    function isNull($var)
    {
        if ($var && $var != '-')
            return false;

        return true;
    }
}

if (! function_exists('namaGelar')) {
    function namaGelar($namanya, $gelarDepan = null, $gelarBelakang = null)
    {
        if (is_string($namanya)) {
            $nama = $namanya;
        } else {
            $nama = $namanya->pegawai_nama;
            $gelarDepan = $namanya->pegawai_gelardepan;
            $gelarBelakang = $namanya->pegawai_gelarbelakang;
        }
        if (! isNull($gelarDepan))
            $nama =  $gelarDepan . ' ' . $nama;
        if (! isNull($gelarBelakang))
            $nama = $nama . ', ' . $gelarBelakang;
        return $nama;
    }
}

if (! function_exists('formatRupiah')) {
    function formatRupiah($angka, $kata = '')
	{
		return $kata . strrev(implode('.',str_split(strrev(strval($angka)),3)));
	}
}

if (! function_exists('namaGelarKontrak')) {
    function namaGelarKontrak($namanya, $gelarDepan = null, $gelarBelakang = null)
    {
        if (is_string($namanya)) {
            $nama = $namanya;
        } else {
            $nama = $namanya->pegawaikontrak_nama;
            $gelarDepan = $namanya->pegawaikontrak_gelardepan;
            $gelarBelakang = $namanya->pegawaikontrak_gelarbelakang;
        }
        if (! isNull($gelarDepan))
            $nama =  $gelarDepan . ' ' . $nama;
        if (! isNull($gelarBelakang))
            $nama = $nama . ', ' . $gelarBelakang;
        return $nama;
    }
}

if (! function_exists('roleKata')) {
    function roleKata($var)
    {
        return preg_replace('/\_/i', ' ', title_case($var));
    }
}


if (! function_exists('penyebut')) {
    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}
}


if (! function_exists('terbilang')) {
    function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}
}
?>
