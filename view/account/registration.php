<?= $header; ?>
<main class="page__main page-auth container-fluid pt-xxl pb-xxl">
  <div class="auth box">
    <h1 class="auth__heading">Registration</h1>
    <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="registration-form">
      <?php if (isset($form_data['error'])): ?>
      <div class="mb-m">
        <p class="alert alert--error"><?= $form_data['error']; ?></p>
      </div>
      <?php endif; ?>
      <div class="mt-s">
        <label class="form-label is-required" for="firstname">Firstname</label>
        <input class="form-input <?= isset($form_data['validation']['firstname']) ? 'is-invalid' : ''; ?>" type="text" name="firstname" id="firstname" value="<?= isset($form_data['firstname']) ? $form_data['firstname'] : '' ?>" pattern="[a-zA-Z]{2,50}" title="2 to 50 only letters" required>
        <?php if (isset($form_data['validation']['firstname'])): ?>
        <p class="input-error"><?= $form_data['validation']['firstname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label is-required" for="lastname">Lastname</label>
        <input class="form-input <?= isset($form_data['validation']['lastname']) ? 'is-invalid' : ''; ?>" type="text" name="lastname" id="lastname" value="<?= isset($form_data['firstname']) ? $form_data['lastname'] : '' ?>" pattern="[a-zA-Z]{2,50}" title="2 to 50 only letters" required>
        <?php if (isset($form_data['validation']['lastname'])): ?>
        <p class="input-error"><?= $form_data['validation']['lastname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label is-required" for="email">Email</label>
        <input class="form-input <?= isset($form_data['validation']['email']) ? 'is-invalid' : ''; ?>" type="email" name="email" id="email" value="<?= isset($form_data['email']) ? $form_data['email'] : '' ?>" required>
        <?php if (isset($form_data['validation']['email'])): ?>
        <p class="input-error"><?= $form_data['validation']['email']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label is-required" for="password">Password</label>
        <input class="form-input <?= isset($form_data['validation']['password']) ? 'is-invalid' : ''; ?>" type="password" name="password" id="password" value="" pattern=".{8,}" title="at least 8 characters" autocomplete="new-password" required>
        <?php if (isset($form_data['validation']['password'])): ?>
        <p class="input-error"><?= $form_data['validation']['password']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label is-required" for="password-repeat">Password Repeat</label>
        <input class="form-input <?= isset($form_data['validation']['password_repeat']) ? 'is-invalid' : ''; ?>" type="password" name="password_repeat" id="password-repeat" value="" pattern=".{8,}" title="at least 8 characters" autocomplete="new-password" required>
        <?php if (isset($form_data['validation']['password_repeat'])): ?>
        <p class="input-error"><?= $form_data['validation']['password_repeat']; ?></p>
        <?php endif; ?>
      </div>
      <input type="hidden" name="registration">
      <input type="hidden" name="token" value="<?= $token; ?>">
      <button class="btn btn--primary w-100 mt-s" type="submit">Register</button>
    </form>
  </div>
</main>
<?= $footer; ?>