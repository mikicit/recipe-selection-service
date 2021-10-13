<?php echo $header; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HRECEPT</a>
        </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Recieps</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
        </ul>
    </div>
</nav>
<section class="pt-5 pb-5">
    <div class="container">
        <h2>Search Recieps</h2>
        <form action="">
            <input type="search" placeholder="Write name of reciep">
        </form>
    </div>
</section>
<section class="container mt-5">
    <h2>Futured Recieps</h2>
    <div class="row g-3 mt-3">
        <?php for ($i = 0; $i < 5; $i++): ?>
        <div class="col-3">
            <div class="card">
                <img src="https://picsum.photos/286/180" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</section>
<?php echo $footer; ?>