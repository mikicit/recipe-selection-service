<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/public/css/main.css" rel="stylesheet">
  <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
  <title>Document</title>
</head>
<body>
  <header class="page-header container-fluid">
    <nav class="header-nav">
      <ul class="header-nav__list">
        <li class="header-nav__item"><a class="header-nav__link" href="/">Home</a></li>
        <li class="header-nav__item"><a class="header-nav__link" href="/recipes">Recipes</a></li>
      </ul>
    </nav>
    <div class="page-header__search">
      <form class="header-search" action="/recipes" method="GET">
        <input class="header-search__input" type="search" placeholder="Search recipe..." name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="header-search__btn btn btn--primary" type="submit">Search</button>
      </form>
    </div>
    <div>
      <div class="header-user">

      </div>
      <div class="header-auth">
        <a class="btn btn--secondary" href="/login">Login</a>
        <a class="btn btn--secondary ml-s" href="/registration">Registration</a>
      </div>
    </div>
  </header>