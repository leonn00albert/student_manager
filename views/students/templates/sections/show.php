<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Module: <?= $section["section_name"] ?></div>
            <div class="card-body">
            <?php echo  $section["section_content"] ?>
       
            </div>
        </div>
        <div class="card m-3">
            <div class="card-header">Assignment</div>
            <div class="card-body">
                <?php echo  $section["assignment"] ?>
                <hr>
                <?php if (isset($grades["grade_status"])) { ?>
                    <p>You have already submmited this assignment. </p>
                    <div class="container">
                        <button class="btn btn-primary" onclick="window.history.back()">Go Back</button>
                    </div>
                <?php } else {  ?>
                    <form method="POST" action="/grades">
                        <div class="form-group">
                            <label for="grade_answer">Answer</label>
                            <textarea class="form-control" id="grade_answer" name="grade_answer"> </textarea>
                        </div>
                        <div class="form-group d-none">
                            <input type="hidden" class="form-control" name="section_id" value=<?= $section["section_id"] ?>>
                        </div>
                        <div class="form-group d-none">
                            <input type="hidden" class="form-control" name="assignment" value=<?= $section["assignment"] ?>>
                            <input type="hidden" class="form-control" name="module_id" value=<?= $section["module_id"] ?>>  
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                <?php } ?>


            </div>
        </div>
    </div>
</div>

