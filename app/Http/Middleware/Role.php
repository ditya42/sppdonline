<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class Role
{

    public function handle($request, Closure $next, $routeRoles)
    {
        $nameArray = explode('|', $routeRoles);

        if (Auth::check() == false) {
            return redirect()->guest('login');
        }
        $pegawai_id = auth()->id();
        $app_id = config('app.id');
        $data = auth()->user()->pegawaiRole($pegawai_id,$app_id);
        if (!in_array($data->role_name,$nameArray)) {
            abort(401,'NO PERMISSION');
        }

        $request->session()->put('role_name',$data->role_name);
        return $next($request);
    }
}
