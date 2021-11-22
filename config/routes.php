<?php

$routes = [
    '/^profile$/' => 'AccountProfile/index',
    '/^profile\/(\d+)$/' => 'Profile/show/id:$1',
    '/^recipes$/' => 'RecipeRecipe/index',
    '/^recipe\/add$/' => 'RecipeRecipe/add',
    '/^recipe\/(\d+)$/' => 'RecipeRecipe/show/id:$1',
    '/^login$/' => 'AccountLogin/index',
    '/^registration$/' => 'AccountRegistration/index',
    '/^404$/' => 'ErrorNotfound/index',
];