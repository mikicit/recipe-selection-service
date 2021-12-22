<?= $header; ?>
<div class="page__main">
  <section class="hero">
    <div class="hero__main container-small">
      <h1 class="hero__heading">Search for recipes, leave reviews and enjoy the food! ;)</h1>
      <a class="btn btn--light btn--lg mt-l" href="<?= Url::getUrl('/recipes'); ?>">Find a recipe</a>
    </div>
  </section>
  <section class="section container pt-xxl pb-xxl">
    <h2 class="section__heading">Featured Recipes</h2>
    <div class="row vgut">
      <?php foreach ($featured_recipes as $recipe): ?>
      <div class="col-3">
        <div class="recipe-card">
          <img class="recipe-card__img" src="<?= !empty($recipe['images']) ? Helper::getImage($recipe['images'][0], 304, 228) : Url::getUrl('/public/images/card-placeholder.jpg'); ?>" width="304" height="228" alt="<?= $recipe['title']; ?>">
          <div class="recipe-card__body">
            <h3 class="recipe-card__title"><?= $recipe['title']; ?></h3>
            <div class="recipe-card__stars star-rating">
              <?php for ($i = 0; $i < $recipe['rating']; $i++): ?>
              <i class="is-active fas fa-star"></i>
              <?php endfor; ?>
              <?php for ($i = 0; $i < 5 - $recipe['rating']; $i++): ?>
              <i class="fas fa-star"></i>
              <?php endfor; ?>
            </div>
            <?php if (!empty($recipe['categories'])): ?>
            <ul class="recipe-card__tags tags">
              <?php foreach($recipe['categories'] as $category): ?>
              <li class="tags__tag"><a class="tags__link" href="#"><?= $category['name']; ?></a></li>
              <?php endforeach; ?>
            </ul>
            <?php endif;?>
            <a class="recipe-card__btn btn btn--primary w-100" href="<?= Url::getUrl('/recipe/' . $recipe['recipe_id']); ?>">See recipe</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="section__footer">
      <a class="btn btn--lg btn--primary" href="<?= Url::getUrl('/recipes'); ?>">More Recipes</a>
    </div>
  </section>
</div>
<?= $footer; ?>