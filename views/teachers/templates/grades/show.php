<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Grade: <?= $grade["section_name"] ?></div>
            <div class="card-body">
                <?= $grade["section_name"] ?>: <?= $grade["first_name"] ?> <?= $grade["last_name"] ?>
                <?= $grade["assignment"] ?>
            </div>
        </div>
        <div class="card m-3">
            <div class="card-header">Assignment</div>
            <div class="card-body">
                Assignment:
                <br>
                <?= $grade["assignment"] ?>
                <hr>
                Answer:
                <br>
                <?= $grade["grade_answer"] ?>
                <form id="myForm">
                    <div class="form-group">
                        <label for="score">Score:</label>
                        <select id="score" name="score" class="form-control">
                            <?php
                            for ($score = 0; $score <= 10; $score++) {
                                echo '<option value="' . $score . '">' . $score . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" id="grade_id" name="grade_id" value=<?=$grade["grade_id"]?> >
                    <input type="hidden" id="classroom_id" name="classroom_id" value=<?=$grade["classroom_id"]?> >

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("myForm").addEventListener("submit", function(event) {
  event.preventDefault();
  var formData = new FormData(event.target);
  var jsonData = {};
  for (var entry of formData.entries()) {
    jsonData[entry[0]] = entry[1];
  }
  var jsonPayload = JSON.stringify(jsonData);

  fetch("/grades/<?=$grade["grade_id"]?>", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: jsonPayload
    })
    .then(response =>  window.history.back())
    .catch(error => {
      console.error(error);
    });
});
</script>