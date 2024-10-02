<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()){
            // $status = auth()->user()->status;
            $user = auth()->user();
            if($user->status == 0)
            {
                // session()->flash('error', 'You are banned!');
                flash()->error('You are banned!');
                return redirect('/');
            }
        }
        return $next($request);
    }
}
