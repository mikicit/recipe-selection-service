<?php

$routes = [
    '/profile$/' => 'Profile/index',
    '/profile\/(\d+)$/' => 'Profile/show/id:$1',
    '/recipes$/' => 'Recipes/index',
    '/recipe\/(\d+)$/' => 'Recipes/show/id:$1',
    '/login$/' => 'Login/index',
    '/registration$/' => 'Registration/index',
    '/404$/' => 'NotFound/index',
];
