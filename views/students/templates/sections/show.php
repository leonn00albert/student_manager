<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Module: <?= $section["section_name"] ?></div>
            <div class="card-body">
                <?= $section["section_content"] ?>
            </div>
        </div>
        <div class="card m-3">
            <div class="card-header">Assignment</div>
            <div class="card-body">
                <?= $section["assignment"] ?>
                <hr>
                <form method="POST" action="/grades">
                    <div class="form-group">
                        <label for="grade_answer">Answer</label>
                        <textarea  class="form-control" id="grade_answer" name="grade_answer"> </textarea>
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

            </div>
        </div>
    </div>
</div>