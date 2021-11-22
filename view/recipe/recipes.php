<?php echo $header; ?>
<main class="section container mt-xxl">
  <h1 class="section__heading">Recipes</h1>
  <div class="row">
    <div class="col-3">
      <div class="sidebar">
        <div class="sidebar-filter">
          <h3 class="sidebar-filter__heading">Filter</h3>
          <form action="" method="GET" id="sidebar-filter">
            <fieldset class="sidebar-filter__block">
              <legend class="sidebar-filter__block-heading">Ingredients</legend>
              <?php foreach($ingredients as $ingredient): $checked = ''; ?>
              <div class="form-checkbox">
                  <input class="form-checkbox__control" type="checkbox" name="ingredient-<?php echo $ingredient['ingredient_id']; ?>" id="sidebar-filter-checkbox-<?php echo $ingredient['ingredient_id']; ?>" <?php echo $checked; ?>>
                  <label class="form-checkbox__label" for="sidebar-filter-checkbox-<?php echo $ingredient['ingredient_id']; ?>"><?php echo $ingredient['name']; ?></label>
              </div>
              <?php endforeach; ?>
            </fieldset>
            <fieldset class="sidebar-filter__block">
              <legend class="sidebar-filter__block-heading">Tags</legend>
              <?php for ($i = 11; $i <= 20; $i++): $checked = isset($_GET["ingredient$i"]) && $_GET["ingredient$i"] == 'on' ? 'checked' : ''; ?>
              <div class="form-checkbox">
                  <input class="form-checkbox__control" type="checkbox" name="ingredient<?php echo $i; ?>" id="sidebar-filter-checkbox<?php echo $i; ?>" <?php echo $checked; ?>>
                  <label class="form-checkbox__label" for="sidebar-filter-checkbox<?php echo $i; ?>">Input</label>
              </div>
              <?php endfor; ?>
            </fieldset>
            <button class="btn btn--primary w-100 mt-s" type="submit">Submit Filter</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-9">
      <div class="row vgut">
        <?php foreach ($recipes as $recipe): ?>
        <div class="col-4">
          <div class="recipe-card">
            <img class="recipe-card__img" src="https://picsum.photos/304/228?random=<?php echo $i; ?>" width="304" height="228" class="card-img-top" alt="">
            <div class="recipe-card__body">
              <h3 class="recipe-card__title"><?php echo $recipe['title']; ?></h3>
              <div class="recipe-card__stars star-rating">
                <?php for ($i = 0; $i < $recipe['rating']; $i++): ?>
                <i class="is-active fas fa-star"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - $recipe['rating']; $i++): ?>
                <i class="fas fa-star"></i>
                <?php endfor; ?>
              </div>
              <ul class="recipe-card__tags tags">
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li>
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li> 
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li> 
              </ul>
              <a class="recipe-card__btn btn btn--primary w-100" href="/recipe/<?php echo $recipe['recipe_id']; ?>">See recipe</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="pagination mt-l">
        <ul class="pagination__list">
          <li class="pagination__item"><a class="pagination__link" href="#">Prev</a></li>
          <?php for ($i = 1; $i < 7; $i++): ?>
          <?php if ($i == 3): ?>
          <li class="pagination__item"><span class="pagination__link is-active" href="#"><?php echo $i; ?></span></li>
          <?php else: ?>
          <li class="pagination__item"><a class="pagination__link" href="#"><?php echo $i; ?></a></li>
          <?php endif; ?>
          <?php endfor; ?>
          <li class="pagination__item"><a class="pagination__link" href="#">Next</a></li>
        </ul>
      </div>
    </div>
  </div>
</main>
<?php echo $footer; ?>