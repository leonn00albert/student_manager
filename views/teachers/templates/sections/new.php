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
                <textarea class="form-control" id="editor" name="section_content" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="sectionResources">Section Resources:</label>
                <textarea class="form-control" id="editor2" name="section_resources" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="moduleId">Module ID:</label>
                <input type="number" class="form-control" id="moduleId" name="module_id" required>
            </div>
            <div class="form-group">
                <label for="assignment">Assignment:</label>
                <textarea class="form-control" id="editor3"  name="assignment" rows="4" required ></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>  Submit</button>
        </form>
    </div>
</div>

<script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
  var quill2 = new Quill('#editor2', {
    theme: 'snow'
  });
  var quill3 = new Quill('#editor3', {
    theme: 'snow'
  });
</script>