<div class="card m-3">
    <div class="card-header">Module</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">

        <div class="table-responsive-md">
            <table class="table">
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
                       
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-header">Sections</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Name<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="coursesTable">
                    <?php foreach ($sections as $section) : ?>
                        <tr>
                            <td><b class="ms-3"><?= $section["section_id"] ?></b></td>
                            <td><?= $section["section_name"] ?></td>
                            <td><a href="/teachers/sections/<?= $section["section_id"] ?>/edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Section</a></td>

                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
        <a href="/teachers/sections/new?module_id=<?= $module["module_id"] ?>" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add Section</a>
    </div>
</div>