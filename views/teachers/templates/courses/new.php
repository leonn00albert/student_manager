<div class="card m-3">
    <div class="card-header">Create a new course</div>
    <div class="card-body">
        <form action="/courses" method="post">
            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="teacher_id">Teacher ID:</label>
                <input type="text" class="form-control" id="teacher_id" name="teacher_id" required>
            </div>
            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea class="form-control" id="course_description" name="course_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="course_image">Course Image:</label>
                <input type="url" class="form-control" id="course_image" name="course_image">
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="course_status">Course Status:</label>
                <select class="form-control" id="course_status" name="course_status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Completed">Completed</option>
                    <option value="Upcoming">Upcoming</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Archived">Archived</option>
                    <option value="On-hold">On-hold</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Create Course    </button>
        </form>
    </div>
</div>