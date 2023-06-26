<div class="card m-3">
    <div class="card-header">Classroom</div>
    <div class="card-body">
        <form id="updateClassroomForm">
            <div class="form-group">
                <label for="classroomName">Classroom Name</label>
                <input type="text" class="form-control" id="classroomName" name="classroom_name" value=<?= $classroom["classroom_name"] ?> required>
            </div>
            <div class="form-group">
                <label for="teacherID">Teacher</label>
                <select class="form-control" id="teacherID" name="teacher_id" required>
                    <?php foreach ($teachers as $teacher) : ?>
                        <?php $selected = ($teacher['teacher_id'] == $classroom["teacher_id"]) ? 'selected' : ''; ?>
                        <option value="<?= $teacher['teacher_id'] ?>" <?= $selected ?>>
                            <?= $teacher['first_name'] ?>   <?= $teacher['last_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="courseID">Course</label>
                <select class="form-control" id="courseID" name="course_id" required>
                    <?php foreach ($courses as $course) : ?>
                        <?php $selected = ($course['course_id'] == $classroom["course_id"]) ? 'selected' : ''; ?>
                        <option value="<?= $course['course_id'] ?>" <?= $selected ?>>
                            <?= $course['course_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

          
        </form>

    </div>
</div>
<script>
    document.getElementById('updateClassroomForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        const classroomId = <?= $classroom['classroom_id'] ?>; // Assuming you have access to the classroom ID

        fetch(`/classrooms/${classroomId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => {
            if (response.ok) {
                console.log('Classroom updated successfully');
                } else {
                console.error('Classroom update failed');
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
    });
</script>