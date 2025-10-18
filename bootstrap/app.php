<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        // Muat file route tambahan untuk area admin
        then: function () {
            require __DIR__ . '/../routes/admin.php';
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan alias middleware supaya bisa dipakai di route: ->middleware('admin')
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // (Opsional) kalau mau menempel middleware ke semua route web/api:
        // $middleware->web(append: [ /* ... */ ]);
        // $middleware->api(append: [ /* ... */ ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
