<div class="row row-cols-2">
    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class="fa fa-bullhorn" aria-hidden="true"></i>
classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
                <h4>Students</h4>
                <hr>
                <ul class="list-group">
                <?php foreach ($students as $student) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $student["first_name"]?>  <?= $student["last_name"] ?>
                            <a href="/students/messages" class="badge bg-primary rounded-pill"><i class='fa fa-comment'></i></a>
                        </li>
                    <?php endforeach; ?>

                </ul>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Grades: Submitted and Pending for Review </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($grades as $grade) : ?>
                        <?php if ($grade["grade_status"] === "Pending") {?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $grade["section_name"] ?>: <?= $grade["first_name"] ?> <?= $grade["last_name"] ?>
                            <a href="/teachers/grades/<?= $grade["grade_id"] ?>" class="btn btn-primary">Grade</a>
                        </li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
                <h4>Students Progress</h4>
                <hr>
              
                <ul class="list-group">
                    <?php foreach ($progress as $student) : ?>
               
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $student["student_name"] ?> 
                   
                        </li>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow=<?= $student["graded"] ?> aria-valuemin="0" aria-valuemax=<?= $student["sections"] ?>>
                    <div class="progress-bar" style="width: <?= (int) $student["percentage"]  ?>%"><?= (int) $student["percentage"] ?>%</div>
                </div>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
   

    <div class="col">
        <div class="card m-3">
            <div class="card-header">Grades: Submitted and Graded</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($grades as $grade) : ?>
                        <?php if ($grade["grade_status"] === "Graded") {?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $grade["section_name"] ?>: <?= $grade["first_name"] ?> <?= $grade["last_name"] ?>
                            <a href="/teachers/grades/<?= $grade["grade_id"] ?>" class="btn btn-primary">Grade</a>
                        </li>
                        <?php } ?>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Bulletin board</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($bulletins as $bulletin) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold"> <?= $bulletin["title"] ?></div>
                                <?= $bulletin["message"] ?>

                            </div>
                            <a href="/bulletins/<?= $bulletin["id"] ?>/delete" class="badge m-1 bg-danger rounded-pill"><i class="fa fa-trash" ></i></a>

                            <span class="badge m-1  bg-<?= $bulletin["type"] ?> rounded-pill"><i class="fa fa-<?= $bulletin["type"] ?>" ></i></span>
                        </li>


                    <?php endforeach; ?>
                </ul>
                <hr>
                <h4>New Bulletin <?= $classroom["classroom_id"] ?> </h4>
                <form action="/bulletins" method="POST">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control" id="type" name="type">
                            <option value="warning">Warning</option>
                            <option value="info">Info</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <input type="hidden" name="classroom_id" value=<?= $classroom["classroom_id"] ?> />
                    <button type="submit" class="btn btn-primary">Create Bulletin</button>
                </form>

            </div>
        </div>
    </div>
</div>