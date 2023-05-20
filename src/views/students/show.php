<?php include "src/views/components/header.php"; ?>

<div class="container">
    <div class="card text-white bg-secondary m-3">
        <div class="card-header"></div>
        <div class="card-body" id="cardBody">

            <h4 class="card-title" id="studentName"></h4>
            <p class="card-text">
            <div class="table-responsive-md">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col"></th>

                            <th scope="col">Registration number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Age</th>
                            <th scope="col">Email</th>
                            <th scope="col">Country</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Classroom</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <a href="/" class="btn btn-secondary">Back</a>
            </div>
            </p>
        </div>
    </div>
</div>
<script>
    function renderTable(item) {

        return (
            `       <td><img src=${item.avatar} class="avatar" ></td>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.gender}</td>
                    <td>${item.age}</td>
                    <td>${item.email}</td>
                    <td>${item.country.toUpperCase()} <span class="fi fi-${item.country.toLowerCase()} fis"></span></td>
                    <td>${item.grade}</td>
                    <td>${item.class}</td>
                    <td>
                        <a href="/students/edit/${item.id}" class="btn btn-info btn-sm "><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                        <button onclick="handleDeleteById('${item.id}')" type="button" class="btn btn-danger btn-sm mx-2"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>
            
            `
        )
    }
    window.onload = function() {
        var currentPath = window.location.pathname;
        var id = currentPath.split("/")[2];
        fetch('/api/students/' + id)
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    const dataList = document.getElementById('studentsTable');
                    const listItem = document.createElement('tr');
                    listItem.innerHTML = renderTable(item);
                    dataList.appendChild(listItem);
                    document.getElementById('studentName').innerHTML = item.name

                });
            })
            .catch(error => console.error(error));

    };
</script>
</body>

</html>