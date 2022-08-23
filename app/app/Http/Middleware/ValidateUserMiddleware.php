<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidateUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  User $user
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $alldata = $request->all();
        $user=auth()->user();
        $validator = Validator::make($alldata, [
            'screen_name'   => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'name'          => ['required', 'string', 'max:20'],
            'profileImage' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        return $next($request);
    }
}
