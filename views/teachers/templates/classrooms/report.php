<div class="card m-3">
    <div class="card-header"><i class="fas fa-chart-line"></i> Classroom Report </div>
    <div class="card-body">
        <h4 class="card-title"><span class="badge bg-primary m-1" id="classroomCount"></span><?= $classroom["classroom_name"] ?></h4>
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Name<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                    <th scope="col">Assignments submitted</th>
                    <th scope="col">Total score</th>
                    <th scope="col">Max Score</th>
                    <th scope="col">Progress</th>
                    <th scope="col">Grade</th>
                </tr>
            </thead>
            <tbody id="coursesTable">
                <?php foreach ($progress as $student) : ?>
                    <tr>
                        <td><b class="ms-3"><?= $student["progress_id"] ?></b></td>
                        <td><?= $student["student_name"] ?></td>
                        <td>
                            <?= $student["graded"] ?>
                        </td>
                        <td>
                            <?= $student["total_score"] ?>
                        </td>
                        <td>
                            <?= $student["max_score"] ?>
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= $student["percentage"] ?>%;" aria-valuenow="25" aria-valuemin="<?= $student["graded"] ?>" aria-valuemax="<?= $student["sections"] ?>"><?= $student["percentage"] ?>%</div>
                            </div>
                        </td>
                        <td>
                            <?= $student["grade"] ?>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
        <a onclick="window.history.back()" class="btn btn-primary">Back</a>
    </div>
</div>