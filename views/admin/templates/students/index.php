<div class="card m-3">
    <div class="card-header">Students</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="studentCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                    <th scope="col">Registration number
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=student_id&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Country
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=country&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Email
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=contact_email&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Phone
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=contact_phone&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Name
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=users.first_name&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            type
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/students?sort=type&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th> 
                    </tr>
                </thead>
                <tbody id="studentsTable">
                    <?php foreach($students as $student): ?>
                        <tr>
                        <td>
                            <?= $student["user_id"] ?>
                        </td>
                        <td>
                            <?= $student["country"] ?>
                        </td>
                        <td>
                            <?= $student["contact_email"] ?>  
                        </td>
                        <td>
                            <?= $student["contact_phone"] ?> 
                        </td>
                        <td>
                            <?= $student["first_name"] ?>   <?= $student["last_name"] ?>
                        </td>
                        <td>
                            <?= $student["type"] ?>
                        </td>
                    </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="paginationContainer">
            <ul class="pagination" id="pagination">

            </ul>
        </div>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a href="students/new" class="dropdown-item">Student</a>
                    <a class="dropdown-item" href="classroom/new">Classroom</a>
                </div>
            </div>
        </div>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tools</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                    <a href="api/report" class="dropdown-item">Create PDF file</a>
                    <a href="logs" class="dropdown-item" href="#">Logs</a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Seed Data
                    </a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#DeleteModal">
                        Delete All Data
                    </a>
                </div>
            </div>
        </div>
        </p>
    </div>