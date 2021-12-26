<?= $header; ?>
<main class="page__main container-medium pt-xxl pb-xxl">
  <h1 class="page-heading">Add Recipe</h1>
  <div class="box">
    <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="form-review" enctype='multipart/form-data' novalidate>
      <?php if (isset($form_data['success'])): ?>
      <div class="mb-m">
        <p class="alert alert--success"><?= $form_data['success']; ?></p>
      </div>
      <?php endif; ?>
      <?php if (isset($form_data['error'])): ?>
      <div class="mb-m">
        <p class="alert alert--error"><?= $form_data['success']; ?></p>
      </div>
      <?php endif; ?>
      <div>
        <label class="form-label" for="form-title">Title</label>
        <input id="form-title" class="form-input <?= isset($form_data['validation']['title']) ? 'is-invalid' : ''; ?>" type="text" name="title" value="<?= isset($form_data['title']) ? $form_data['title'] : ''; ?>" pattern=".{2, }" required>
        <?php if (isset($form_data['validation']['title'])): ?>
        <p class="input-error"><?= $form_data['validation']['title']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="form-description">Description</label>
        <textarea class="form-textarea <?= isset($form_data['validation']['description']) ? 'is-invalid' : ''; ?>" name="description" cols="30" rows="4" id="form-description" required><?= isset($form_data['description']) ? $form_data['description'] : ''; ?></textarea>
        <?php if (isset($form_data['validation']['description'])): ?>
        <p class="input-error"><?= $form_data['validation']['description']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <p class="form-label">Ingredients:</p>
        <?php foreach ($ingredients as $ingredient): $checked = isset($form_data['ingredients']) && in_array($ingredient['ingredient_id'], $form_data['ingredients']) ? 'checked' : ''; ?>
        <div class="form-checkbox">
          <input class="form-checkbox__control" type="checkbox" name="ingredients[]" value="<?= $ingredient['ingredient_id']; ?>" id="form-ingredient-<?= $ingredient['ingredient_id']; ?>" <?= $checked; ?>>
          <label class="form-checkbox__label" for="form-ingredient-<?= $ingredient['ingredient_id']; ?>"><?= $ingredient['name']; ?></label>
        </div>
        <?php endforeach; ?>
        <?php if (isset($form_data['validation']['ingredients'])): ?>
        <p class="input-error"><?= $form_data['validation']['ingredients']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <p class="form-label">Categories:</p>
        <?php foreach ($categories as $category): $checked = isset($form_data['categories']) && in_array($category['category_id'], $form_data['categories']) ? 'checked' : ''; ?>
        <div class="form-checkbox">
          <input class="form-checkbox__control" type="checkbox" name="categories[]" value="<?= $category['category_id']; ?>" id="form-category-<?= $category['category_id']; ?>" <?= $checked; ?>>
          <label class="form-checkbox__label" for="form-category-<?= $category['category_id']; ?>"><?= $category['name']; ?></label>
        </div>
        <?php endforeach; ?>
        <?php if (isset($form_data['validation']['categories'])): ?>
        <p class="input-error"><?= $form_data['validation']['categories']; ?></p>
        <?php endif; ?>
      </div>
      <div class="mt-s">
        <label class="form-label" for="form-images">Images</label>
        <input id="form-images" class="form-file" type="file" name="images[]" multiple>
        <?php if (isset($form_data['validation']['images'])): ?>
        <p class="input-error"><?= $form_data['validation']['images']; ?></p>
        <?php endif; ?>
      </div>
      <input type="hidden" name="add-recipe">
      <button class="btn btn--primary w-100 mt-s">Puplish</button>
    </form>
  </div>
</main>
<?= $footer; ?>