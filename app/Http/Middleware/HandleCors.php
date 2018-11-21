<?php

namespace App\Http\Middleware;

class HandleCors extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $middleware = [
        // ...
        \Barryvdh\Cors\HandleCors::class,
    ];
}