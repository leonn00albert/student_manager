<div class="card m-3">
    <div class="card-header">courses</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table ">
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
                    <?php foreach ($courses as $course) : ?>
                        <tr>
                            <td>
                               <b class="ms-3"><?= $course["course_id"] ?></b>
                            </td>
                            <td>
                                <?= $course["course_name"] ?>
                            </td>
                        
                            <td>
                                <img src=<?= $course["course_image"] ?>  width="50="/>
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
                              <a class="btn btn-primary" href="/teachers/courses/<?=$course["course_id"]?>/edit"><i class="fas fa-edit"></i> Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>