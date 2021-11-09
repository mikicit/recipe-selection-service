<?php echo $header; ?>
<!-- <nav class="search-section">
  <div class="container-medium">
    <h2 class="search-section__heading">Search Recipes</h2>
    <form class="mt-3" action="/">
      <input class="" type="search" placeholder="Write name of reciep" name="search">
    </form>
  </div>
</nav> -->
<section class="section container mt-xxl">
  <h1 class="section__heading">Recipes</h1>
  <div class="row">
    <div class="col-3">

    </div>
    <div class="col-9">
      <div class="row vgut">
        <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="col-4">
          <div class="recipe-card">
            <img class="recipe-card__img" src="https://picsum.photos/304/228?random=<?php echo $i; ?>" width="304" height="228" class="card-img-top" alt="">
            <div class="recipe-card__body">
              <h3 class="recipe-card__title">Card title</h3>
              <ul class="recipe-card__tags tags">
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li>
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li> 
                <li class="tags__tag"><a class="tags__link" href="#">dinner</a></li> 
              </ul>
              <a class="recipe-card__btn btn btn--primary" href="/recipe/<?php echo $i; ?>">See recipe</a>
            </div>
          </div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>
<?php echo $footer; ?>