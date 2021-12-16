<?= $header; ?>
<main class="container-fluid auth">
  <div class="auth__block">
    <h1 class="auth__heading">Login</h1>
    <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="login-form" novalidate>
      <?php if (isset($form_data['error'])): ?>
      <div class="mb-m">
        <p class="alert alert--error"><?= $form_data['error']; ?></p>
      </div>
      <?php endif; ?>
      <?php if (isset($form_data['registration_success'])): ?>
      <div class="mb-m">
        <p class="alert alert--success"><?= $form_data['registration_success']; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" name="email" id="email" value="" required>
      </div>
      <div class="mt-s">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" name="password" id="password" value="" required>
      </div>
      <button class="btn btn--primary w-100 mt-s" type="submit">Login</button>
    </form>
  </div>
</main>
<?= $footer; ?>