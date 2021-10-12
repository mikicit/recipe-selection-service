<?php

$route = isset($_GET['route']) ? $_GET['route'] : 'home';

$routes = [
    'home' => 'view/home.php',
    'profile' => 'view/profile.php'
];

include_once($routes[$route]);