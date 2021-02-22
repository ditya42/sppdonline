<?php

namespace App\Helpers;

use Illuminate\Support\Collection as LC;

class Collection extends LC
{
    public function __get($key) {
        //  Jika tidak ada return null
        if (! $this->has($key)) {
            return null;
        }

        return $this->get($key);
    }
    public function __set($key, $value) {
        $this->put($key, $value);
    }

    public static function fromJson($jsonstring) {
        return new static(json_decode($jsonstring));
    }
}