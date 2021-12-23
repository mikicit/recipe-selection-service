<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/public/css/main.css" rel="stylesheet">
  <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
  <title><?= $title; ?></title>
</head>
<body class="page">
  <header class="page-header">
    <nav class="page-header__inner container-fluid">
      <a href="/" class="logo">
        <img src="/public/images/logo.svg" alt="Hrecept.cz logotype" width="160" height="40">
      </a>
      <div class="header-nav">
        <ul class="header-nav__list">
          <li class="header-nav__item"><a class="header-nav__link" href="<?= Url::getUrl(); ?>">Home</a></li>
          <li class="header-nav__item"><a class="header-nav__link" href="<?= Url::getUrl('/recipes'); ?>">Recipes</a></li>
        </ul>
      </div>
      <div class="page-header__search">
        <form class="header-search" action="<?= Url::getUrl('/recipes'); ?>" method="GET">
          <input class="header-search__input" type="search" placeholder="Search recipe..." name="search" value="<?= isset($query_vars['search']) ? $query_vars['search'] : ''; ?>">
          <button class="header-search__btn btn btn--primary" type="submit">Search</button>
        </form>
      </div>
      <div>
        <?php if ($user): ?>
        <div class="header-auth">
          <a class="btn btn--secondary" href="/profile"><?= $user['firstname'] . ' ' . $user['lastname']; ?></a>
          <?php if ($user['user_group_id'] == 1): ?>
          <a class="btn btn--secondary ml-s" href="<?= Url::getUrl('/recipe/add'); ?>">Add Recipe</a>
          <?php endif; ?>
          <a class="btn btn--secondary ml-s" href="<?= Url::getUrl('/logout'); ?>">Logout</a>
        </div>
        <?php else: ?>
        <div class="header-auth">
          <a class="btn btn--secondary" href="<?= Url::getUrl('/login'); ?>">Login</a>
          <a class="btn btn--secondary ml-s" href="<?= Url::getUrl('/registration'); ?>">Registration</a>
        </div>
        <?php endif; ?>
      </div>
    </nav>
  </header>