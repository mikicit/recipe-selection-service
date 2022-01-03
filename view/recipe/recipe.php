<?= $header; ?>
<div class="page__main pb-xxl pt-xxl">
  <div class="container-medium">
    <article class="recipe">
      <header class="recipe-header">
        <h1 class="recipe-header__heading"><?= $recipe['title']; ?></h1>
        <div class="recipe-header__meta">
          <div class="rating recipe-header__rating">
            <p class="rating__info"><span class="rating__text">Rating: </span><span class="rating__number"><?= $recipe['rating']; ?></span></p>
            <div class="rating__stars star-rating">
              <?php for ($i = 0; $i < $recipe['rounded_rating']; $i++): ?>
              <i class="is-active fas fa-star"></i>
              <?php endfor; ?>
              <?php for ($i = 0; $i < 5 - $recipe['rounded_rating']; $i++): ?>
              <i class="fas fa-star"></i>
              <?php endfor; ?>
            </div>
          </div>
          <a class="recipe-header__reviews" href="#reviews"><?= $recipe['quantity']; ?> reviews</a>
        </div>
      </header>
      <?php if (!empty($recipe['images'])): ?>
      <div class="recipe__image">
        <img src="<?= Helper::getImage($recipe['images'][0], 976, 420);?>" alt="<?= $recipe['title']; ?>">
      </div>
      <?php if (count($recipe['images']) > 1): ?>
      <div class="recipe-images">
        <div class="row-2 vgut-2">
          <?php for($i = 1; $i < count($recipe['images']); $i++): ?>
          <div class="col-3">
            <a class="recipe-images__link" href="<?= Helper::getImage($recipe['images'][$i]); ?>" target="_blank">
              <img src="<?= Helper::getImage($recipe['images'][$i], 220, 126);?>" alt="<?= $recipe['title']; ?>">
            </a>
          </div>
          <?php endfor; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php endif; ?>
      <div class="recipe-section">
        <h2 class="recipe-section__heading">Characteristic</h2>
        <div class="row-2 vgut-2">
          <?php if ($ingredients): ?>
          <div class="col">
            <div class="recipe-characteristic">
              <h3 class="recipe-characteristic__heading">Ingredients</h3>
              <ul class="tags">
                <?php foreach ($ingredients as $ingredient): ?>
                <li class="tags__tag"><a class="tags__link" href="#"><?= $ingredient['name']; ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($categories): ?>
          <div class="col">
            <div class="recipe-characteristic">
              <h3 class="recipe-characteristic__heading">Categories</h3>
                <ul class="tags">
                  <?php foreach ($categories as $category): ?>
                  <li class="tags__tag"><a class="tags__link" href="#"><?= $category['name']; ?></a></li>
                  <?php endforeach; ?>
                </ul>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <section class="recipe-section">
        <h2 class="recipe-section__heading">How To Cook?</h2>
        <div class="recipe-section__main">
          <?= $recipe['description']; ?>
        </div>
      </section>
    </article>
    <section class="section-small mt-xl" id="review-section">
      <h2 class="section-small__heading">Add Review</h2>
      <?php if ($user): ?>
      <div class="box">
        <form class="form" action="<?= Url::getCurrentUrl(); ?>" method="post" id="form-review">
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
            <label class="form-label is-required" for="form-comment-review">Review</label>
            <textarea class="form-textarea <?= isset($form_data['validation']['review']) ? 'is-invalid' : ''; ?>" name="review" cols="30" rows="4" id="form-comment-review" minlength="2" maxlength="500" required><?= isset($form_data['review']) ? $form_data['review'] : ''; ?></textarea>
            <?php if (isset($form_data['validation']['review'])): ?>
            <p class="input-error"><?= $form_data['validation']['review']; ?></p>
            <?php endif; ?>
          </div>
          <div class="mt-s">
            <p class="form-label is-required">Please, select rating:</p>
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
          <input type="hidden" name="add-review">
          <button class="btn btn--primary mt-s w-100" type="submit">Send</button>
        </form>
      </div>
      <?php else: ?>
      <p class="no-margin">Please log in to leave reviews.</p>
      <?php endif; ?>
    </section>
    <section class="section-small mt-xl" id="reviews">
      <h2 class="section-small__heading">Reviews</h2>
      <div class="reviews">
        <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
        <article class="review-card" id="review-<?= $review['review_id']; ?>">
          <div class="review-card__avatar review-card__avatar--no-avatar">
            <p aria-hidden="true"><?= substr($review['firstname'], 0, 1); ?></p>
          </div>
          <div class="review-card__body">
            <h3 class="review-card__heading"><?= $review['firstname'] . ' ' . $review['lastname']; ?></h3>
            <p class="review-card__date"><time datetime="<?= $review['date_added']; ?>"><?= date("d F Y", strtotime($review['date_added'])); ?></time></p>
            <p class="review-card__review"><?= $review['description']; ?></p>
            <div class="rating review-card__rating">
              <p class="rating__info"><span class="rating__text">Rating: </span><span class="rating__number"><?= $review['rating']; ?></span></p>
              <div class="rating__stars star-rating">
                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                <i class="is-active fas fa-star"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - $review['rating']; $i++): ?>
                <i class="fas fa-star"></i>
                <?php endfor; ?>
              </div>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="no-margin">No reviews.</p>
        <?php endif; ?>
      </div>
      <?php if ($next_reviews): ?>
      <a href="<?= $next_reviews; ?>" class="btn btn--primary w-100 mt-m">More Reviews</a>
      <?php endif; ?>
    </section>
  </div>
</div>
<?= $footer; ?>