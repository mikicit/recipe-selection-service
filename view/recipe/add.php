<?= $header; ?>
<div class="section container-medium mt-xxl">
  <h1 class="section__heading">Add Recipe</h1>
  <div class="bg-white pt-l pb-l pl-m pr-m">
    <form class="form" action="/recipe/add" method="post" id="form-review" enctype='multipart/form-data'>
      <?php if (isset($_SESSION['recipe_adding_success'])): $msg = $_SESSION['recipe_adding_success']; ?>
      <div class="mb-m">
        <p class="alert alert--success"><?= $msg; ?></p>
      </div>
      <?php unset($_SESSION['recipe_adding_success']); endif; ?>
      <?php if (isset($form_error)): ?>
      <div class="mb-m">
          <p class="alert alert--error"><?= $form_error; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label" for="form-title">Title</label>
        <input class="form-input <?= isset($form_validation['title']) ? 'is-invalid' : ''; ?>" type="text" name="title" value="<?= isset($_POST['title']) ? $_POST['title'] : ''; ?>" pattern=".{2, }" required>
        <?php if (isset($form_validation['title'])): ?>
        <p class="input-error"><?= $form_validation['title']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="form-description">Description</label>
        <textarea class="form-textarea <?= isset($form_validation['description']) ? 'is-invalid' : ''; ?>" name="description" cols="30" rows="4" id="form-description" required><?= isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
        <?php if (isset($form_validation['description'])): ?>
        <p class="input-error"><?= $form_validation['description']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <p class="form-label">Ingredients:</p>
        <?php foreach ($ingredients as $ingredient): $checked = isset($_POST['ingredients']) && in_array($ingredient['ingredient_id'], $_POST['ingredients']) ? 'checked' : ''; ?>
        <div class="form-checkbox">
          <input class="form-checkbox__control" type="checkbox" name="ingredients[]" value="<?= $ingredient['ingredient_id']; ?>" id="form-ingredient-<?= $ingredient['ingredient_id']; ?>" <?= $checked; ?>>
          <label class="form-checkbox__label" for="form-ingredient-<?= $ingredient['ingredient_id']; ?>"><?= $ingredient['name']; ?></label>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="mt-s">
        <p class="form-label">Categories:</p>
        <?php foreach ($categories as $category): $checked = isset($_POST['categories']) && in_array($category['category_id'], $_POST['categories']) ? 'checked' : ''; ?>
        <div class="form-checkbox">
          <input class="form-checkbox__control" type="checkbox" name="categories[]" value="<?= $category['category_id']; ?>" id="form-category-<?= $category['category_id']; ?>" <?= $checked; ?>>
          <label class="form-checkbox__label" for="form-category-<?= $category['category_id']; ?>"><?= $category['name']; ?></label>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="form-images">Images</label>
        <input id="form-images" class="form-file" type="file" name="images[]" multiple>
        <?php if (isset($form_validation['images'])): ?>
        <p class="input-error"><?= $form_validation['images']; ?></p>
        <?php endif; ?>
      </div>
      <button class="btn btn--primary w-100 mt-s">Puplish</button>
    </form>
  </div>
</div>
<?= $footer; ?>