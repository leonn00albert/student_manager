<div class="row">
    <?php foreach ($classrooms as $classroom) : ?>
        <div class="col">
            <div class="card m-3">
                <div class="card-header"><i class="fas fa-chalkboard"></i> Classroom </div>
                <div class="card-body">
                    <h4 class="card-title"><span class="badge bg-primary m-1" id="classroomCount"></span><?= $classroom["classroom_name"] ?></h4>
                    <p class="card-text">
                     
                    </p>

                    <a class="btn btn-primary" href="/teachers/classrooms/<?= $classroom["classroom_id"] ?>"><i class="fas fa-sliders-h"></i> Manage Classroom </a>
                    <a class="btn btn-outline-primary" href="/teachers/classrooms/<?= $classroom["classroom_id"] ?>/report"><i class="fas fa-chart-line"></i> Classroom Report</a>

                    <a class="btn btn-outline-primary" href="/teachers/classrooms/<?= $classroom["classroom_id"] ?>/edit"><i class="fas fa-edit"></i> Edit Classroom </a>

                </div>
            </div>
        </div>
</div>
<?php endforeach; ?>
</div>