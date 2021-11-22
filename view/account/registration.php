<?php echo $header; ?>
<main class="container-fluid auth">
  <div class="auth__block">
    <h1 class="auth__heading">Registration</h1>
    <form class="form" action="" method="POST" id="registration-form">
      <?php if (isset($form_error)): ?>
      <div class="mb-m">
        <p class="form-error"><?php echo $form_error; ?></p>
      </div>
      <?php endif; ?>
      <div class="mt-s">
        <label class="form-label" for="firstname">Firstname</label>
        <input class="form-input <?php echo isset($form_validation['firstname']) ? 'is-invalid' : ''; ?>" type="text" name="firstname" id="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>">
        <?php if (isset($form_validation['firstname'])): ?>
        <p class="input-error"><?php echo $form_validation['firstname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="lastname">Lastname</label>
        <input class="form-input <?php echo isset($form_validation['lastname']) ? 'is-invalid' : ''; ?>" type="text" name="lastname" id="lastname" value="<?php echo isset($_POST['firstname']) ? $_POST['lastname'] : '' ?>">
        <?php if (isset($form_validation['lastname'])): ?>
        <p class="input-error"><?php echo $form_validation['lastname']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="email">Email</label>
        <input class="form-input <?php echo isset($form_validation['email']) ? 'is-invalid' : ''; ?>" type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <?php if (isset($form_validation['email'])): ?>
        <p class="input-error"><?php echo $form_validation['email']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="password">Password</label>
        <input class="form-input <?php echo isset($form_validation['password']) ? 'is-invalid' : ''; ?>" type="password" name="password" id="password">
        <?php if (isset($form_validation['password'])): ?>
        <p class="input-error"><?php echo $form_validation['password']; ?></p>
        <?php endif; ?>
      </div>
      <button class="btn btn--primary w-100 mt-s" type="submit">Register</button>
    </form>
  </div>
</main>
<?php echo $footer; ?>