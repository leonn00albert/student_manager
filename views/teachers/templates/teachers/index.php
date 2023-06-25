<div class="card m-3">
    <div class="card-header">teachers</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="teacherCount"></span></h4>
     
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Country<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone<i onclick="handleSort('name')" class="fa fa-sort"></i></th>
                        <th scope="col">Name<i onclick="handleSort('grade')" class="fa fa-sort"></i></th>
                        <th scope="col">type <i onclick="handleSort('class')" class="fa fa-sort"></i></th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="teachersTable">
                    <?php foreach($teachers as $teacher): ?>
                        <tr>
                        <td>
                            <?= $teacher["teacher_id"] ?>
                        </td>
                        <td>
                            <?= $teacher["country"] ?>
                        </td>
                        <td>
                            <?= $teacher["contact_email"] ?>  
                        </td>
                        <td>
                            <?= $teacher["contact_phone"] ?> 
                        </td>
                        <td>
                            <?= $teacher["first_name"] ?>   <?= $teacher["last_name"] ?>
                        </td>
                        <td>
                            <?= $teacher["type"] ?>
                        </td>
                        <td>
                            <a href="/admin/teachers/<?=$teacher["teacher_id"]?>/edit" class="btn btn-info text-white">Update</a>
                        </td>
                    </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>