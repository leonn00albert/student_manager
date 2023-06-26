<div class="card m-3">
    <div class="card-header">Create a new section</div>
    <div class="card-body">
    <form method="POST" action="/sections">
            <div class="form-group">
                <label for="sectionName">Section Name:</label>
                <input type="text" class="form-control" id="sectionName" name="section_name" required>
            </div>
            <div class="form-group">
                <label for="sectionContent">Section Content:</label>
                <textarea class="form-control" id="sectionContent" name="section_content" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="sectionResources">Section Resources:</label>
                <textarea class="form-control" id="sectionResources" name="section_resources" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="moduleId">Module ID:</label>
                <input type="number" class="form-control" id="moduleId" name="module_id" required>
            </div>
            <div class="form-group">
                <label for="assignment">Assignment:</label>
                <textarea class="form-control" id="assignment" name="assignment" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>