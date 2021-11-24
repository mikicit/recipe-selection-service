<?php echo $header; ?>
<section class="hero">
  <div class="hero__cover" style="background-image: url('/public/images/home-cover2.jpg')"></div>
  <div class="hero__main container-small">
    <h1 class="hero__heading">Search for recipes, leave reviews and enjoy the food! ;)</h1>
    <a class="btn btn--lg btn--primary mt-l" href="/recipes">Find a recipe</a>
  </div>
</section>
<section class="section container mt-xxl">
  <h2 class="section__heading">Featured Recipes</h2>
  <div class="row vgut">
    <?php foreach ($featured_recipes as $key => $recipe): ?>
    <div class="col-3">
      <div class="recipe-card">
        <img class="recipe-card__img" src="https://picsum.photos/304/228?random=<?php echo $key; ?>" width="304" height="228" class="card-img-top" alt="">
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
  <div class="section__footer">
    <a class="btn btn--lg btn--primary" href="/recipes">More Recipes</a>
  </div>
</section>
<?php echo $footer; ?>