<?php

namespace rest;

class PageRoutes
{
    public static array $unauthenticatedRoutes = [
        '/login',
        '/register'
    ];

    public static string $route404 = '/404';

    public static string $adminOnlyRoutes = [
        'admin'
    ];
}
