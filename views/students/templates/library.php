<div class="row row-cols-4">
    <?php foreach ($books as $book) : ?>
        <div class="col">
            <div class="card m-3">
                <img src=<?= $book["book_image"] ?> class="card-img-top" alt=<?= $book["book_title"] ?>>
           
                <div class="card-body">
                    <a class="btn btn-primary" href="<?= $book["book_url"] ?>">Download </a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>