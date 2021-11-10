<?php

$routes = [
    '/profile$/' => 'Profile/index',
    '/profile\/(\d+)$/' => 'Profile/show/id:$1',
    '/recipes$/' => 'RecipeRecipes/index',
    '/recipe\/(\d+)$/' => 'RecipeRecipes/show/id:$1',
    '/login$/' => 'AccountLogin/index',
    '/registration$/' => 'AccountRegistration/index',
    '/404$/' => 'ErrorNotfound/index',
];