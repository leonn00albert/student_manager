<div class="row row-cols-2">
    <div class="col">
        <div class="card m-3">
            <img src="<?= $classroom["course_image"] ?>" class="card-img-top" alt="...">
            <div class="card-header">classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
                <p>
                    <?= $classroom["start_date"] ?>
                </p>
                <hr>
                <p>Class Teacher: </p>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                             <?= $classroom["first_name"] ?>    <?= $classroom["last_name"] ?>
                            <a href="/students/messages" class="badge bg-primary rounded-pill"><i class='fa fa-comment'></i></a>
                        </li>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card m-3">
            <div class="card-header">Topics</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($modules as $module) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $module["module_id"] ?>: <?= $module["module_name"] ?>
                            <a href="/students/modules/<?= $module["module_id"] ?>" class="btn btn-primary">Go to Module</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Your Classmates:</div>
            <div class="card-body">
                <ul class="list-group">
                <?php foreach ($students as $student) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                             <?= $student["first_name"] ?>
                            <a href="/students/messages" class="badge bg-primary rounded-pill"><i class='fa fa-comment'></i></a>
                        </li>
                    <?php endforeach; ?>
    
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Message board</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($modules as $module) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $module["module_id"] ?>: <?= $module["module_name"] ?>
                            <a href="/students/modules/<?= $module["module_id"] ?>" class="btn btn-primary">Go to Module</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>