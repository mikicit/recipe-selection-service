<?= $header; ?>
<main class="container-fluid auth">
  <div class="auth__block">
    <h1 class="auth__heading">Registration</h1>
    <form class="form" action="<?= Helper::getCurrentUrl(); ?>" method="post" id="registration-form">
      <?php if (isset($form_error)): ?>
      <div class="mb-m">
        <p class="alert alert--error"><?= $form_error; ?></p>
      </div>
      <?php endif; ?>
      <div class="mt-s">
        <label class="form-label" for="firstname">Firstname</label>
        <input class="form-input <?= isset($form_validation['firstname']) ? 'is-invalid' : ''; ?>" type="text" name="firstname" id="firstname" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" pattern="[a-zA-Z]{2, }" required>
        <?php if (isset($form_validation['firstname'])): ?>
        <p class="input-error"><?= $form_validation['firstname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="lastname">Lastname</label>
        <input class="form-input <?= isset($form_validation['lastname']) ? 'is-invalid' : ''; ?>" type="text" name="lastname" id="lastname" value="<?= isset($_POST['firstname']) ? $_POST['lastname'] : '' ?>" pattern="[a-zA-Z]{2, }" required>
        <?php if (isset($form_validation['lastname'])): ?>
        <p class="input-error"><?= $form_validation['lastname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="email">Email</label>
        <input class="form-input <?php echo isset($form_validation['email']) ? 'is-invalid' : ''; ?>" type="email" name="email" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
        <?php if (isset($form_validation['email'])): ?>
        <p class="input-error"><?php echo $form_validation['email']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="password">Password</label>
        <input class="form-input <?php echo isset($form_validation['password']) ? 'is-invalid' : ''; ?>" type="password" name="password" id="password" value="" pattern=".{8,}" required>
        <?php if (isset($form_validation['password'])): ?>
        <p class="input-error"><?php echo $form_validation['password']; ?></p>
        <?php endif; ?>
      </div>
      <button class="btn btn--primary w-100 mt-s" type="submit">Register</button>
    </form>
  </div>
</main>
<?= $footer; ?>