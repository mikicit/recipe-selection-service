<?php echo $header; ?>
<section class="pt-5 pb-5 bg-success">
    <div class="container">
        <h2 class="text-white">Search Recipes</h2>
        <form class="mt-3" action="/">
            <input class="form-control form-control-lg" type="search" placeholder="Write name of reciep" name="search">
        </form>
    </div>
</section>
<section class="container mt-5 mb-5">
    <h2>Futured Recipes</h2>
    <div class="row g-3 mt-3">
        <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="col-3">
            <div class="card">
                <img src="" width="286" height="180" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="/recipe/<?php echo $i; ?>" class="btn btn-primary">See recipe</a>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</section>
<?php echo $footer; ?>