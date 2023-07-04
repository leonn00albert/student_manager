

<?php if(count($progress) == 0) {?>

    <div class="card m-3">
        <div class="card-header"></div>
        <div class="card-body">
            No reports yet please grade some student assigments first
        </div>
    </div>
    <?php } ?>

<?php
$classrooms = array_unique(array_map(function ($e) {

    return $e["classroom_name"];
}, $progress));



foreach ($classrooms as $classroom) : ?>
    <div class="card m-3">
        <div class="card-header"> <?= $classroom ?></div>
        <div class="card-body">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                            Name
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/teachers/reports?sort=student_name&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">

                        Assignments submitted
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/teachers/reports?sort=graded&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">

                        Total score
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/teachers/reports?sort=total_score&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">Max Score</th>
                        <th scope="col">            
                            Progress
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/teachers/reports?sort=percentage&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a></th>
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

<?php endforeach; ?>