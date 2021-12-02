<?php echo $header; ?>
<main class="container-fluid auth">
  <div class="auth__block">
    <h1 class="auth__heading">Login</h1>
    <form class="form" action="<?= Helper::getCurrentUrl(); ?>" method="post" id="login-form">
      <?php if (isset($form_error)): ?>
      <div class="mb-m">
        <p class="alert alert--error"><?php echo $form_error; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
      </div>
      <div class="mt-s">
        <label class="form-label" for="password">Password</label>
        <input class="form-input" type="password" name="password" id="password" value="" required>
      </div>
      <button class="btn btn--primary w-100 mt-s" type="submit">Login</button>
    </form>
  </div>
</main>
<?php echo $footer; ?>