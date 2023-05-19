<?php include "src/views/components/header.php"; ?>

    <div class="container">
        <div class="card text-white bg-secondary m-3">
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
                    <select required class="form-control" id="classroom">
                        <option value="A">Class A</option>
                        <option value="B">Class B</option>
                        <option value="C">Class C</option>
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
    </div>

    <script>
     window.onload = function () {
               fetch('/api/classrooms')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    return response.json();
                }).then(data => {
                    let classSelect = document.getElementById("classroom");
                    data.forEach((e) => {
                        var option = document.createElement("option");
                        option.value = e.name;
                        option.text = e.name;
                        classSelect.appendChild(option);
                    })
                    

                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        };
        function handle_add() {

            const input = {

                name: document.getElementById('name').value,
                grade: document.getElementById('selectGrade').value,
                class: document.getElementById('classroom').value,

            }
            var nameInput = document.getElementById("name");
            var gradeInput = document.getElementById("selectGrade");
            var classroomInput = document.getElementById("classroom");
            
            if (nameInput.value.trim() === "") {
                nameInput.classList.add("is-invalid");
                document.getElementById("nameFeedbackInvalid").style.display = 'block';
                return;
            } else {
                nameInput.classList.remove("is-invalid");

            }
     
            fetch('/api/students', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(input)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    return response.json();
                }).then(data => {

                    window.location = '/';

                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        };



    </script>
</body>

</html>