<div class="row">
    <div class="col">
    <div class="card m-3">
    <img src="<?= $course["course_image"] ?>" class="card-img-top" alt="...">
            <div class="card-header">Course: <?= $course["course_name"] ?></div>
            <div class="card-body">
            <?= $course["course_description"] ?>
<p>
<?= $course["start_date"] ?>
</p>
         <a class="btn btn-primary" href="">Enroll</a>  
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card m-3">
            <div class="card-header">Topics</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($modules as $module) : ?>
                        <li class="list-group-item"><?= $module["module_id"] ?>: <?= $module["module_name"] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>