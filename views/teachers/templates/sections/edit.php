<div class="card m-3">
    <div class="card-header">Edit section</div>
    <div class="card-body">
    <form>
            <div class="form-group">
                <label for="sectionName">Section Name:</label>
                <input type="text" class="form-control" id="sectionName" name="section_name" value=<?=$section["section_name"] ?>equired>
            </div>
            <div class="form-group">
                <label for="sectionContent">Section Content:</label>
                <textarea class="form-control" id="editor" name="section_content" rows="4" required><?=$section["section_content"] ?></textarea>
            </div>
            <div class="form-group">
                <label for="sectionResources">Section Resources:</label>
                <textarea class="form-control" id="editor2"  name="section_resources" rows="4" required><?=$section["section_resources"] ?></textarea>
            </div>
            <div class="form-group">
                <label for="moduleId">Module ID:</label>
                <input type="number" class="form-control" id="moduleId" name="module_id"value=<?=$section["module_id"] ?> required>
            </div>
            <div class="form-group">
                <label for="assignment">Assignment:</label>
                <textarea class="form-control" id="editor3"  name="assignment" rows="4" required ><?= $section["assignment"] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
<script>
    document.querySelector("form").addEventListener("submit", function(event) {
  event.preventDefault(); 


  const formData = {
    section_name: document.getElementById("sectionName").value,
    section_content: document.getElementById("sectionContent").value,
    section_resources: document.getElementById("sectionResources").value,
    module_id: document.getElementById("moduleId").value,
    assignment: document.getElementById("assignment").value
  };
  fetch("/sections/<?= $section["section_id"]?>", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(formData)
  })
    .then(response => {
      if (response.ok) {
        console.log("Section created successfully");
      } else {
        console.log("Error creating section");
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
});
</script>