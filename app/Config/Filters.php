<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'login' => \App\Filters\LoginFilter::class, //filtro de login
        'admin' => \App\Filters\AdminFilter::class, //filtro de admin
        'visitante' => \App\Filters\VisitanteFilter::class, //filtro de visitantes
        'throttle' =>\App\Filters\ThrottleFilter::class, // filtro que ajuda a prevenir ataques de força bruta
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
             'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [
        'post' => ['throttle',]
    ];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
/* Descomentar essa parte quando resolver problema de login
        'login' => [
            'before' => [
                'admin/*', // Todos os controller que estão dentro do namespace 'Admin' só serão acessados após o login
            ]
        ],

        'admin' => [
            'before' => [
                'admin/*', // Todos os controller que estão dentro do namespace 'Admin' só serão acessados por um administrador
            ]
        ] */
    ];
}
