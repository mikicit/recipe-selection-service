<?= $header; ?>
<main class="page__main container pt-xxl pb-xxl">
  <h1 class="page-heading">Recipes</h1>
  <div class="row vgut">
    <div class="col col-sm-4 col-lg-3">
      <div class="sidebar">
        <div class="sidebar-filter">
          <h3 class="sidebar-filter__heading">Filter</h3>
          <form class="sidebar-filter__form" action="<?= Url::getCurrentUrl(); ?>" method="get" id="sidebar-filter">
            <fieldset class="sidebar-filter__block">
              <legend class="sidebar-filter__block-heading">Ingredients</legend>
              <?php foreach($ingredients as $ingredient): $checked = isset($query_vars['ingredients']) && in_array($ingredient['ingredient_id'], $query_vars['ingredients']) ? 'checked' : ''; ?>
              <div class="form-checkbox">
                <input class="form-checkbox__control" type="checkbox" name="ingredients[]" id="sidebar-filter-ingredient-<?= $ingredient['ingredient_id']; ?>" <?= $checked; ?> value="<?= $ingredient['ingredient_id']; ?>">
                <label class="form-checkbox__label" for="sidebar-filter-ingredient-<?= $ingredient['ingredient_id']; ?>"><?= $ingredient['name']; ?></label>
              </div>
              <?php endforeach; ?>
            </fieldset>
            <fieldset class="sidebar-filter__block">
              <legend class="sidebar-filter__block-heading">Categories</legend>
              <?php foreach($categories as $category): $checked = isset($query_vars['categories']) && in_array($category['category_id'], $query_vars['categories']) ? 'checked' : ''; ?>
              <div class="form-checkbox">
                <input class="form-checkbox__control" type="checkbox" name="categories[]" id="sidebar-filter-category-<?= $category['category_id']; ?>" <?= $checked; ?> value="<?= $category['category_id']; ?>">
                <label class="form-checkbox__label" for="sidebar-filter-category-<?= $category['category_id']; ?>"><?= $category['name']; ?></label>
              </div>
              <?php endforeach; ?>
            </fieldset>
            <button class="btn btn--primary w-100 mt-s" type="submit">Submit Filter</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col col-sm-8 col-lg-9">
      <?php if (isset($sorting_links)) : ?>
      <div class="sorting mb-l">
        <h3 class="sorting__heading">Sort by:</h3>
        <ul class="sorting__list tags">
          <?php foreach($sorting_links as $sorting) : ?>
          <?php if ($sorting['active']): ?>
          <li class="sorting__item"><span class="sorting__link is-active"><?= $sorting['name']; ?></span></li>
          <?php else: ?>
          <li class="sorting__item"><a class="sorting__link" href="<?= $sorting['href']; ?>"><?= $sorting['name']; ?></a></li>
          <?php endif; endforeach; ?>
        </ul>     
      </div>
      <?php endif; ?>
      <div class="row vgut">
        <?php foreach ($recipes as $recipe): ?>
        <div class="col col-md-6 col-lg-4">
          <article class="recipe-card">
            <img class="recipe-card__img" src="<?= !empty($recipe['images']) ? Image::getImage($recipe['images'][0], 304, 228) : Url::getUrl('/public/images/card-placeholder.jpg'); ?>" width="304" height="228" alt="<?= $recipe['title']; ?>">
            <div class="recipe-card__body">
              <h3 class="recipe-card__title"><?= $recipe['title']; ?></h3>
              <div class="rating recipe-card__rating">
                <p class="rating__info"><span class="rating__text">Rating: </span><span class="rating__number"><?= $recipe['rating']; ?></span></p>
                <div class="rating__stars star-rating">
                  <?php for ($i = 0; $i < $recipe['rounded_rating']; $i++): ?>
                  <i class="is-active fas fa-star"><span hidden>star</span></i>
                  <?php endfor; ?>
                  <?php for ($i = 0; $i < 5 - $recipe['rounded_rating']; $i++): ?>
                  <i class="fas fa-star"><span hidden>star</span></i>
                  <?php endfor; ?>
                </div>
              </div>
              <?php if (!empty($recipe['categories'])): ?>
              <ul class="recipe-card__tags tags">
                <?php foreach($recipe['categories'] as $category): ?>
                <li class="tags__tag"><a class="tags__link" href="#"><?= $category['name']; ?></a></li>
                <?php endforeach; ?>
              </ul>
              <?php endif;?>
              <a class="recipe-card__btn btn btn--primary w-100" href="/recipe/<?= $recipe['recipe_id']; ?>">See recipe</a>
            </div>
          </article>
        </div>
        <?php endforeach; ?>
      </div>
      <?php if ($pagination): ?>
      <div class="pagination mt-l">
        <ul class="pagination__list">
          <?php if (isset($pagination['prev'])): ?>
          <li class="pagination__item"><a class="pagination__link" href="<?= $pagination['prev']; ?>">Prev</a></li>
          <?php endif; ?>
          <?php foreach ($pagination['items'] as $item): ?>
          <?php if ($item['current']): ?>
          <li class="pagination__item"><span class="pagination__link is-active"><?= $item['page']; ?></span></li>
          <?php else: ?>
          <li class="pagination__item"><a class="pagination__link" href="<?= $item['link']; ?>"><?= $item['page']; ?></a></li>
          <?php endif; ?>
          <?php endforeach; ?>
          <?php if (isset($pagination['next'])): ?>
          <li class="pagination__item"><a class="pagination__link" href="<?= $pagination['next']; ?>">Next</a></li>
          <?php endif; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
</main>
<?= $footer; ?>