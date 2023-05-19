<?php include "src/components/header.php"; ?>

    <div class="container">
        <div class="card text-white bg-secondary m-3">
            <div class="card-header">Edit student</div>
            <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-text">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <select class="form-select" id="selectGrade">
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
                </div>
                <div class="form-group">
                    <label for="classroom">Classroom</label>
                    <select class="form-control" id="classroom">
                        <option value="A">Class A</option>
                        <option value="B">Class B</option>
                        <option value="C">Class C</option>
                    </select>
                </div>
                <div class="mt-2">
                    <button type="submit" onclick="handle_update()" class="btn btn-primary">Update</button>
                    <a href="/" class="btn btn-secondary">Back</a>
                </div>
                </p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            var currentPath = window.location.pathname;
            var id = currentPath.split("/")[3];
            fetch('/students/' + id)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        let select = document.getElementById("selectGrade");
                        let options = Array.from(select.children);
                        options.forEach(e => {
                            if (e.value == item.grade) {
                                e.selected = true;
                            }
                        })
                        document.getElementById('name').value = item.name
                        document.getElementById('selectGrade').value = item.grade;
                        document.getElementById('classroom').value = item.class;

                    });
                })
                .catch(error => console.error(error));

        };
        function handle_update() {
            var currentPath = window.location.pathname;
            var id = currentPath.split("/")[3];
            const input = {

                name: document.getElementById('name').value,
                grade: document.getElementById('selectGrade').value,
                class: document.getElementById('classroom').value,

            }
            fetch('/students/' + id, {
                method: 'PUT',
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