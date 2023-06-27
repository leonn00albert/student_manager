<div class="row row-cols-2">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($students as $student) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $student["student_id"] ?>: <?= $student["first_name"] ?> <?= $student["last_name"] ?>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Grades</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($grades as $grade) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $grade["section_name"] ?>: <?= $grade["first_name"] ?> <?= $grade["last_name"] ?>
                            <a href="/teachers/grades/<?= $grade["grade_id"] ?>" class="btn btn-primary">Grade</a>
                        </li>
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
                            <span class="badge bg-<?= $bulletin["type"] ?> rounded-pill"><i class="fa fa-<?= $bulletin["type"] ?>" ></i></span>
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