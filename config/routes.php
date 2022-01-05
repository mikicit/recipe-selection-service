<?php

/**
 * List of routes.
 *
 * This file contains a list of possible routes. 
 * Routes work on the basis of simple regular expressions, 
 * if any get request matches a regular expression, 
 * the request is passed to the appropriate controller.
 * 
 * The key of the $routes array is a regular expression, 
 * and its value is the name of the controller, 
 * its method, and possible request variables.
 * 
 * This array is loaded into an instance of the Router class when it is created.
 */

$routes = [
    '/^profile$/' => 'AccountProfile/index',
    '/^profile\/(\d+)$/' => 'Profile/show/id:$1',
    '/^recipes$/' => 'RecipeRecipe/index',
    '/^recipe\/add$/' => 'RecipeRecipe/add',
    '/^recipe\/(\d+)$/' => 'RecipeRecipe/show/id:$1',
    '/^login$/' => 'AccountLogin/index',
    '/^registration$/' => 'AccountRegistration/index',
    '/^logout$/' => 'AccountLogin/logout',
    '/^404$/' => 'ErrorNotfound/index',
];