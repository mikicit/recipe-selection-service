<?= $header; ?>
<main class="page__main page-auth container-fluid pt-xxl pb-xxl">
  <div class="auth box">
    <h1 class="auth__heading">Login</h1>
    <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="login-form" novalidate>
      <div class="mb-m" <?= isset($form_data['error']) ? '' : 'hidden'; ?>>
        <p class="alert alert--error"><?= isset($form_data['error']) ? $form_data['error'] : ''; ?></p>
      </div>
      <?php if (isset($form_data['registration_success'])): ?>
      <div class="mb-m">
        <p class="alert alert--success"><?= $form_data['registration_success']; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label is-required" for="email">Email</label>
        <input class="form-input" type="email" name="email" id="email" value="<?= isset($form_data['email']) ? $form_data['email'] : ''; ?>" required>
      </div>
      <div class="mt-s">
        <label class="form-label is-required" for="password">Password</label>
        <input class="form-input" type="password" name="password" id="password" value="" autocomplete="current-password" required>
      </div>
      <input type="hidden" name="login">
      <button class="btn btn--primary w-100 mt-s" type="submit">Login</button>
    </form>
  </div>
</main>
<?= $footer; ?>