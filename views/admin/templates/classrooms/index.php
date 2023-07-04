<div class="card m-3">
    <div class="card-header">Classrooms</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="classroomCount"></span></h4>
        <div class="table-responsive-md">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Name<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Course</th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="classroomsTable">
                    <?php foreach ($classrooms as $classroom) : ?>
                        <tr>
                            <td>
                                <?= $classroom["classroom_id"] ?>
                            </td>
                            <td>
                            <?= $classroom["classroom_name"] ?>
                            </td>
                            <td>
                             <?php
                                $foundTeacher = null;
                                foreach ($teachers as $teacher) {
                                    if ($teacher['teacher_id'] == $classroom["teacher_id"]) {
                                        $foundTeacher = $teacher;
                                        break;
                                    }
                                }
                                if ($foundTeacher) {
                                    echo $foundTeacher['first_name'] . " " . $foundTeacher['last_name'];
                                } else {
                                    echo "Teacher not found.";
                                }
                                ?>
                            </td>
                            <td>
                             <?php
                                $foundCourse = null;
                                foreach ($courses as $course) {
                                    if ($course['course_id'] == $classroom["course_id"]) {
                                        $foundCourse = $course;
                                        break;
                                    }
                                }
                                if ($foundCourse) {
                                    echo $foundCourse['course_name'];
                                } else {
                                    echo "Course not found.";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="/admin/classrooms/<?= $classroom["classroom_id"] ?>/edit" class="btn btn-info text-white">Update</a>

                            </td>
                            <td>
                            <a href="/admin/classrooms/<?= $classroom["classroom_id"] ?>/delete" class="btn btn-warning text-white" onclick="return confirm('Are you sure you want to archive this classroom?')">Archive</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>