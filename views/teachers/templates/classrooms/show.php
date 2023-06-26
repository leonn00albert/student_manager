<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">classroom: <?= $classroom["classroom_name"] ?></div>
            <div class="card-body">
            <ul class="list-group">  
                    <?php foreach ($students as $student) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $student["student_id"] ?>: <?= $student["first_name"] ?>  <?= $student["last_name"] ?>
                   
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
                            <?= $grade["section_name"] ?>: <?= $grade["first_name"] ?>  <?= $grade["last_name"] ?>
                        <a href="/students/grades/<?= $grade["grade_id"] ?>" class="btn btn-primary">Grade</a>  
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>