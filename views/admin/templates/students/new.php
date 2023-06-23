<div class="card m-3">
    <div class="card-header">Add new student</div>
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
        <div class="form-group">
            <label for="grade">Grade</label>
            <select required class="form-select" id="selectGrade">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
            </select>
            <div class="valid-feedback" id="GradeFeedbackValid">
                Correct Input!
            </div>
        </div>
        <div class="form-group">
            <label for="classroom">Classroom</label>
            <select required class="form-select" id="classroom">

            </select>
            <div class="valid-feedback" id="ClassFeedbackValid">
                Correct Input!
            </div>
        </div>
        <div class="mt-2">
            <a onclick="handle_add()" class="btn btn-primary">Add Student</a>
            <a href="/" class="btn btn-secondary">Back</a>
        </div>
        </p>
    </div>
</div>