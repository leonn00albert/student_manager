<div class="card m-3">
    <div class="card-header">Add new Classroom</div>
    <div class="card-body">
        <form id="createClassroomForm" method="post" action="/classrooms">
            <div class="form-group">
                <label for="classroomName">Classroom Name</label>
                <input type="text" class="form-control" id="classroomName" name="classroom_name" required>
            </div>
            <div class="form-group">
                <label for="teacherID">Teacher</label>
                <select class="form-control" id="teacherID" name="teacher_id" required>
                    <?php foreach ($teachers as $teacher) : ?>
                        <option value=<?=$teacher["teacher_id"] ?>>
                        <?=$teacher["first_name"] ?> <?=$teacher["last_name"] ?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="courseID">Course</label>
                <select class="form-control" id="courseID" name="course_id" required>
                       <?php foreach ($courses as $course) : ?>
                        <option value=<?=$course["course_id"] ?>>
                        <?=$course["course_name"] ?> 
                        </option>
                    <?php endforeach;?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Classroom</button>
        </form>

    </div>
</div>