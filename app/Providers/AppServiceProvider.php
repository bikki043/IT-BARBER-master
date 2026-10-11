<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            $host = request()->header('host');

            // เพิ่ม str_contains สำหรับ trycloudflare.com เข้าไป
            $isTunnel = $host && (
                str_contains($host, 'ngrok-free.app') ||
                str_contains($host, 'lhr.life') ||
                str_contains($host, 'trycloudflare.com') // <--- เพิ่มตรงนี้
            );

            if ($isTunnel) {
                URL::forceScheme('https');
            }
        }
    }
}
