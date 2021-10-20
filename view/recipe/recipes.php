<?php echo $header; ?>
<section class="pt-5 pb-5 bg-success">
    <div class="container">
        <h2 class="text-white">Search Recipes</h2>
        <form class="mt-3" action="/search">
            <input class="form-control form-control-lg" type="search" placeholder="Write name of reciep">
        </form>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row g-5">
        <div class="col-3">
            <nav style="height: 100%;" class="bg-white">

            </nav>
        </div>
        <main class="col-9">
            <h2>Recipes</h2>
            <div class="row g-3 mt-3">
                <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="col-4">
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
            <nav class="mt-3" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="/?page=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="/?page=1">2</a></li>
                    <li class="page-item"><a class="page-link" href="/?page=1#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </main>
    </div>
</div>
<?php echo $footer; ?>