<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $isServerless = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL');

        if ($isServerless) {
            $tmp = sys_get_temp_dir() . '/laravel';
            $dirs = [
                $tmp . '/framework/views',
                $tmp . '/framework/sessions',
                $tmp . '/framework/cache',
                $tmp . '/logs',
            ];
            foreach ($dirs as $dir) {
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
            }

            config([
                'view.compiled' => $tmp . '/framework/views',
                'session.files' => $tmp . '/framework/sessions',
                'cache.stores.file.path' => $tmp . '/framework/cache',
                'log.channels.single.path' => $tmp . '/logs/laravel.log',
                'log.channels.daily.path' => $tmp . '/logs/laravel',
            ]);
        }
    }
}
