<div class="row">

    <?php
    $classrooms = array_unique(array_map(function ($e) {
        return $e["classroom_name"];
    }, $progress));

    foreach ($classrooms as $classroom) : ?>

        <div class="col">
            <div class="card">
                <div class="card-header"> <?= $classroom ?></div>
                <div class="card-body">
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
                                <?php if ($student["classroom_name"] == $classroom) { ?>


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
                                <?php    } ?>
                            <?php endforeach ?>

                        </tbody>
                </table>
            </div>
        </div>
</div>

<?php endforeach; ?>


</div>