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
                    </tr>
                </thead>
                <tbody id="coursesTable">

                    <tr>
                        <td>
                            <?= $module["module_id"] ?>
                        </td>
                        <td>
                            <?= $module["module_name"] ?>
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
                    <?php foreach ($sections as $section) : ?>
                        <td><?= $section["section_id"] ?></td>
                        <td><?= $section["section_name"] ?></td>
                        <td><a href="/teachers/sections/<?= $section["section_id"] ?>/edit" class="btn btn-primary">Edit Section</a></td>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
        <a href="/teachers/sections/new?module_id=<?= $module["module_id"] ?>" class="btn btn-primary">Add Section</a>
    </div>
</div>