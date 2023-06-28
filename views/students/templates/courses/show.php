
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
                <?php if (isset($course["student_id"])) { ?>
                    <div class="m-2">

                        <button class="btn btn-primary disabled" type="submit">Already Enrolled</button>
                    </div>

                <?php } else { ?>
                    <form method="POST" action="/enrollments">
                        <input type="hidden" name="teacher_id" value=<?= $course["teacher_id"] ?> />
                        <input type="hidden" name="course_id" value=<?= $course["course_id"] ?> />
                        <input type="hidden" name="classroom_name" value="New Classroom">
                        <button class="btn btn-primary" type="submit">Enroll</button>
                    </form>
                <?php } ?>
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
