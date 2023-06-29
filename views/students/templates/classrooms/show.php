<div class="row row-cols-2">
    <div class="col">
        <div class="card m-3">
            <img src="<?= $classroom["course_image"] ?>" class="card-img-top" alt="...">
            <div class="card-header"><i class="fas fa-chalkboard"></i> Classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
                <p>
                <i class="fa fa-calendar" aria-hidden="true"></i>   Starting date <?= $classroom["start_date"] ?> 
                </p>
                <hr>
                <?php if(isset($progress["graded"])) {?>
                Progress:
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow=<?= $progress["graded"]?> aria-valuemin="0" aria-valuemax=<?= $progress["sections"]?>>
                    <div class="progress-bar" style="width: <?= (int) $progress["percentage"] ?>%"><?= (int) $percentage ?>%</div>
                </div>
                <hr>
                <?php }?>
                <p><i class="fas fa-chalkboard-teacher"></i> Class Teacher: </p>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $classroom["first_name"] ?> <?= $classroom["last_name"] ?>
                    <a href="/students/messages" class="badge bg-primary rounded-pill"><i class='fa fa-comment'></i></a>
                </li>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class="fa fa-book" aria-hidden="true"></i> Topics</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($modules as $module) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $module["module_id"] ?>: <?= $module["module_name"] ?>
                            <a href="/students/modules/<?= $module["module_id"] ?>" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class='fas fa-user-graduate'></i></i> Classmates:</div>
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
            <div class="card-header"><i class="fa fa-bullhorn" aria-hidden="true"></i> Bulletin board</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($bulletins as $bulletin) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"> <?= $bulletin["title"] ?></div>
                                <?= $bulletin["message"] ?>

                            </div>
                            <span class="badge bg-<?= $bulletin["type"] ?> rounded-pill"><i class="fa fa-<?= $bulletin["type"] ?>"></i></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>