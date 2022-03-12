<?php

namespace App\Providers;
use App\Models\Admin;
use App\Models\User;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['auth']->viaRequest('passport', function ($request) 
{
    if ($request->header('Authorization')) {
        $key = explode(' ', $request->header('Authorization'))[1];

        if ($request->is('admin/*')) {
            return Admin::where('api_token', $key)->first();
        } else {
            return User::where('api_token', $key)->first();
        }
    }
});
    }
}
