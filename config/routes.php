<?php

$routes = [
    '/profile$/' => 'Profile',
    '/profile\/(\d+)$/' => 'Profile/show',
    '/recipes$/' => 'Recipes',
    '/recipe\/(\d+)$/' => 'Recipes/show',
    '/login$/' => 'Login',
    '/registration$/' => 'Registration',
    '/404$/' => 'NotFound',
];
