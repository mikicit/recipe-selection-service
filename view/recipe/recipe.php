<?= $header; ?>
<article class="recipe">
  <header class="recipe-header">
    <div class="recipe-header__main container-medium">
      <h1 class="recipe-header__title"><?= $recipe['title']; ?></h1>
      <div class="recipe-header__stars star-rating star-rating--lg">
        <?php for ($i = 0; $i < $recipe['rating']; $i++): ?>
        <i class="is-active fas fa-star"></i>
        <?php endfor; ?>
        <?php for ($i = 0; $i < 5 - $recipe['rating']; $i++): ?>
        <i class="fas fa-star"></i>
        <?php endfor; ?>
      </div>
      <a class="recipe-header__reviews" href="#reviews"><?= $recipe['quantity']; ?> reviews</a>
    </div>
  </header>
  <?php if (!empty($recipe['images'])): ?>
    <div class="container mt-xl">
      <div class="row vgut">
        <?php foreach ($recipe['images'] as $image): ?>
          <div class="col-3">
            <a href="<?= Helper::getImage($image);?>" target="_blank">
              <img src="<?= Helper::getImage($image, 292, 204);?>" alt="<?= $recipe['title']; ?>" width="294" height="204">
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
  <div class="container-medium">
    <div class="recipe__content">
      <h2>Ingredients</h2>
      <ul class="tags">
        <?php foreach ($ingredients as $ingredient): ?>
        <li class="tags__tag">
          <a class="tags__link" href="#"><?= $ingredient['name']; ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
      <h2>Categories</h2>
      <ul class="tags">
        <?php foreach ($categories as $category): ?>
        <li class="tags__tag">
          <a class="tags__link" href="#"><?= $category['name']; ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
      <h2>How to cook</h2>
      <?= $recipe['description']; ?>
    </div>
    <section class="adding-review mt-xl">
      <h2 class="adding-review__heading">Add Review</h2>
      <?php if (isset($_SESSION['user'])): ?>
      <div class="adding-review__main">
        <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="form-review" novalidate>
          <?php if (isset($form_data['success'])): ?>
          <div class="mb-m">
            <p class="alert alert--success"><?= $form_data['success']; ?></p>
          </div>
          <?php endif; ?>
          <?php if (isset($form_data['error'])): ?>
          <div class="mb-m">
            <p class="alert alert--error"><?= $form_data['error']; ?></p>
          </div>
          <?php endif; ?>
          <div>
            <label class="form-label" for="form-comment-review">Review</label>
            <textarea class="form-textarea <?= isset($form_data['validation']['review']) ? 'is-invalid' : ''; ?>" name="review" cols="30" rows="4" id="form-comment-review" required><?= isset($form_data['review']) ? $form_data['review'] : ''; ?></textarea>
            <?php if (isset($form_data['validation']['review'])): ?>
            <p class="input-error"><?= $form_data['validation']['review']; ?></p>
            <?php endif; ?>
          </div>
          <div class="mt-s">
            <p class="form-label">Please, select rating:</p>
            <div class="form-radio-row">
              <?php for ($i = 1; $i <= 5; $i++): ?>
              <div class="form-radio">
                <input class="form-radio__control" type="radio" name="rating" value="<?= $i; ?>" id="form-comment-rating<?= $i; ?>" <?= isset($form_data['rating']) && $form_data['rating'] == $i ? 'checked' : ''; ?>>
                <label class="form-radio__label" for="form-comment-rating<?= $i; ?>"><?= $i; ?></label>
              </div>
              <?php endfor; ?>
            </div>
            <?php if (isset($form_data['validation']['rating'])): ?>
            <p class="input-error"><?= $form_data['validation']['rating']; ?></p>
            <?php endif; ?>
          </div>
          <input type="hidden" name="recipe_id" id="form-recipe-id" value="<?= $recipe['recipe_id']; ?>">
          <button class="btn btn--primary mt-s w-100" type="submit">Send</button>
        </form>
      </div>
      <?php else: ?>
      <p class="reviews__empty">Please log in to leave reviews.</p>
      <?php endif; ?>
    </section>
    <section class="reviews mt-xl" id="reviews">
      <h2 class="reviews__heading">Reviews</h2>
      <div class="reviews__main">
        <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
        <article class="review-card">
          <div class="review-card__avatar review-card__avatar--no-avatar">
            <p aria-hidden="true"><?= substr($review['firstname'], 0, 1); ?></p>
          </div>
          <div class="review-card__body">
            <h3 class="review-card__heading"><?= $review['firstname'] . ' ' . $review['lastname']; ?></h3>
            <p class="review-card__date"><time datetime="<?= $review['date_added']; ?>"><?= date("d F Y", strtotime($review['date_added'])); ?></time></p>
            <p class="review-card__review"><?= $review['description']; ?></p>
            <div class="review-card__stars star-rating">
              <?php for ($i = 0; $i < $review['rating']; $i++): ?>
              <i class="is-active fas fa-star"></i>
              <?php endfor; ?>
              <?php for ($i = 0; $i < 5 - $review['rating']; $i++): ?>
              <i class="fas fa-star"></i>
              <?php endfor; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="reviews__empty">No reviews.</p>
        <?php endif; ?>
      </div>
      <?php if (!empty($reviews)): ?>
      <a href="#" class="btn btn--primary w-100 mt-m">More Reviews</a>
      <?php endif; ?>
    </section>
  </div>
</article>
<?= $footer; ?>