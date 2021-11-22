<?php echo $header; ?>
<main class="container-fluid auth">
  <div class="auth__block">
    <h1 class="auth__heading">Login</h1>
    <form class="form" action="" method="POST" id="login-form">
      <?php if (isset($form_error)): ?>
      <div class="mb-m">
        <p class="form-error"><?php echo $form_error; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label" for="email">Email</label>
        <input class="form-input <?php echo isset($form_validation['email']) ? 'is-invalid' : ''; ?>" type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($form_validation['email'])): ?>
        <p class="input-error"><?php echo $form_validation['email']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" name="password" id="password">
      </div>
      <button class="btn btn--primary w-100 mt-s" type="submit">Login</button>
    </form>
  </div>
</main>
<?php echo $footer; ?>