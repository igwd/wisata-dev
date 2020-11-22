<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if(!empty($request->session()->get('user'))){
            $check = $this->hasRole($request->session()->get('roles'),$role);
            if($check===TRUE){
                return $next($request);
            }else{
                return redirect('/home');
            }
        }else{
            return $next($request);
        }
    }

    protected function hasRole($user_roles,$role_id){
        foreach ($user_roles as $key => $value) {
            if($value->role_id == $role_id){
                return TRUE;
                break;
            }else{
                return FALSE;
            }
        }
    }
}
