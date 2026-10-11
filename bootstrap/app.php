<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 1. CSRF (คงเดิมของคุณ)
        $middleware->validateCsrfTokens(except: [
            'booking/store',
            'book/store',
            '/booking/store',
            'checkout/payment*',
            'checkout/process-payment',
        ]);

        // 2. บังคับจุด Redirect (คงเดิมของคุณ)
        $middleware->redirectTo(
            guests: function (Request $request) {
                if ($request->is('admin') || $request->is('admin/*')) {
                    return '/login';
                }
                return '/';
            },
            users: function () {
                $user = Auth::user();
                if ($user && $user->role === 'admin') {
                    return '/admin/dashboard';
                }
                return '/';
            }
        );

        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 419 Page Expired: อย่าให้ขึ้นหน้าขาว
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() !== 419) {
                return null;
            }

            // กด Log Out แล้ว token ไม่ผ่าน -> ออกจากระบบให้เลย แล้วไปหน้า login แอดมิน
            if ($request->is('logout')) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->with('status', 'คุณออกจากระบบเรียบร้อยแล้ว');
            }

            // ฟอร์มอื่นๆ หมดอายุ -> กลับหน้าเดิมพร้อมข้อความ (ไม่เด้งข้ามไปหน้า login ของอีกฝั่ง)
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation', '_token'))
                ->with('status', 'หน้านี้หมดอายุ กรุณาลองอีกครั้ง');
        });
    })->create();