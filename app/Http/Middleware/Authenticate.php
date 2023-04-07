<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if( $request->is('api/*')) {
                return response()->json(msg(not_authoize(), trans('lang.not_authorize')));
            }else{
                return route('admin.login_view');
            }
        }
    }
}
