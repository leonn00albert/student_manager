<div class="row">
    <?php foreach ($courses as $course) : ?>
        <div class="col">
            <div class="card m-3">
                <img src=<?= $course["course_image"] ?> class="card-img-top" alt=<?= $course["course_name"] ?>>
                <div class="card-header">course</div>
                <div class="card-body">
                    <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span><?= $course["course_name"] ?></h4>
                    <p class="card-text">
                        <?= $course["course_description"] ?>
                    </p>
                    <a class="btn btn-primary" href="/students/courses/<?= $course["course_id"] ?>">Check out </a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>