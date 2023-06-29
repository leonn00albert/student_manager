<div class="card m-3">
    <div class="card-header">Create a new Module</div>
    <div class="card-body">
        <form action="/modules" method="POST">
            <div class="form-group">
                <label for="moduleName">Module Name:</label>
                <input type="text" class="form-control" id="moduleName" name="module_name" required>
            </div>
            <input type="hidden" name="course_id" value=<?= $course_id ?>> 
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i><i class="fas fa-check"></i>  Submit</button>
        </form>
    </div>
</div>