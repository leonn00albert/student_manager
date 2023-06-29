<div class="card m-3">
    <div class="card-header">courses</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Name<i onclick="handleSort('country')" class="fa fa-sort"></i></th>

                        <th scope="col">Image<i onclick="handleSort('name')" class="fa fa-sort"></i></th>
                        <th scope="col">Teacher<i onclick="handleSort('grade')" class="fa fa-sort"></i></th>
                        <th scope="col">Status <i onclick="handleSort('class')" class="fa fa-sort"></i></th>
                        <th scope="col">Starting Date<i onclick="handleSort('grade')" class="fa fa-sort"></i></th>
                        <th scope="col">End Date <i onclick="handleSort('class')" class="fa fa-sort"></i></th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="coursesTable">

                    <tr>
                        <td>
                            <?= $course["course_id"] ?>
                        </td>
                        <td>
                            <?= $course["course_name"] ?>
                        </td>

                        <td>
                            <img src=<?= $course["course_image"] ?> width="50=" />
                        </td>
                        <td>
                            <?= $course["teacher_id"] ?>
                        </td>
                        <td>
                            <?= $course["course_status"] ?>
                        </td>
                        <td>
                            <?= $course["start_date"] ?>
                        </td>
                        <td>
                            <?= $course["end_date"] ?>
                        </td>
                        <td>
                            <a class="btn btn-info" href="/teachers/courses/<?= $course["course_id"] ?>/edit">Edit</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-header">Modules</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Name<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="coursesTable">
           
                    <?php foreach ($modules as $module) : ?>
                        <tr>
                        <td><?= $module["module_id"] ?></td>
                        <td><?= $module["module_name"] ?></td>
                        <td><a href="/teachers/modules/<?= $module["module_id"] ?>/edit" class="btn btn-primary">Edit Module</a></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
        <a href="/teachers/modules/new?course_id=<?= $course["course_id"] ?>" class="btn btn-primary">Add Module</a>
    </div>
</div>