<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;

class Kasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user_role = Roles::where('peg_id', $user_id)->get();
            foreach($user_role as $role){
                if($role->nama == 'kasir'){
                    return $next($request);
                }
            }
        }

        return redirect('/devs/404');
    }
}
