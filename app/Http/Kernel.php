<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'admin' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\admin::class,
        ],
        'student' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\Student::class,
        ],
        'editor' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\Editor::class,
        ],

        'reviewer' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\Reviewer::class,
        ],
        'public' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\General::class,
        ], 'langReviewer' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\LangReviewer::class,
        ], 'publisher' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\Publisher::class,
        ], 'questionEditor' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\QuestionsEditor::class,
        ], 'questionReviewer' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\QuestionsReviwer::class,
        ],
        'schoolsAdmin' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\SchoolAdmin::class,
        ],
        'createContent' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\CreateContent::class,
        ],


        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'schoolsAdmins' => \App\Http\Middleware\SchoolAdmin::class,
        'questionEditorRoutes' => \App\Http\Middleware\QuestionsEditor::class,

        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        "Permissions" => \App\Http\Middleware\AppPermissions::class,
    ];
}
