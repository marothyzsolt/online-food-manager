<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserTypeChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        /** @var User $user */
        if (! ($user = auth()->user())) {
            redirect('/login');
        }

        if($user->type === $type) {
            return $next($request);
        }

        return redirect('/');
    }
}
