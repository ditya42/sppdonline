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

?>