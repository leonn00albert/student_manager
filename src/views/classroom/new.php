<?php include "src/views/components/header.php"; ?>

<body>
    <div class="container">
        <div class="card text-white bg-secondary m-3">
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
    </div>

    <script>
        function handle_add() {

            const input = {

                name: document.getElementById('name').value,
    

            }
            var nameInput = document.getElementById("name");

    
          
            fetch('/api/classrooms', {  
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