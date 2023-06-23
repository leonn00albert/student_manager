<div class="card m-3">
    <div class="card-header">Add new Classroom</div>
    <div class="card-body">
        <h4 class="card-title"></h4>
        <p class="card-text ">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" required class="form-control" id="name" placeholder="Enter name">
            <div class="invalid-feedback" id="nameFeedbackInvalid">
                Please provide a valid name
            </div>
            <div class="valid-feedback" id="nameFeedbackValid">
                Correct Input!
            </div>
        </div>

        <div class="mt-2">
            <a onclick="handle_add()" class="btn btn-primary">Add classroom</a>
            <a href="/" class="btn btn-secondary">Back</a>
        </div>
        </p>
    </div>
</div>