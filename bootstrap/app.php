<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 2FA
use App\Http\Middleware\EnsureTwoFactorCodeIsVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    // 有効にしたいミドルウェアは以下の設定内に記載する
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 【構文】
        // $middleware->alias([
        //     'エイリアス名'=>ミドルウェア名::class,
        //     'エイリアス名'=>ミドルウェア名::class,
        //     'エイリアス名'=>ミドルウェア名::class,
        //     ※使用するだけ追加
        // ]);

        // RoleMiddlewareを有効にして呼び出し時のエイリアス（admin）を設定する
        $middleware->alias([
            'admin'=>RoleMiddleware::class
        ]);

        // 2FA
        $middleware->appendToGroup('web', EnsureTwoFactorCodeIsVerified::class);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
