<?php echo $header; ?>
<main class="container-small mt-xxl">
    <div class="bg-white p-xl">
        <h1>Registration</h1>
        <form class="form" action="" method="POST">
            <div class="">

            </div>
            <div>
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email">
            </div>
            <div class="mt-s">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <button class="btn btn--primary mt-m" type="submit">Submit</button>
        </form>
    </div>
</main>
<?php echo $footer; ?>