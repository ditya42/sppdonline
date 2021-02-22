<?php

namespace App\Http\Controllers\AdminSKPD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotaDinasController extends Controller
{
    public function index()
    {
        return view('admin_skpd.surat.notadinas.notadinas_index');
    }
}
