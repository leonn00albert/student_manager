<div class="card m-3">
    <div class="card-header">teachers</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="teacherCount"></span></h4>
     
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                    <th scope="col">Registration number
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=teacher_id&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Country
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=country&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Email
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=contact_email&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Phone
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=contact_phone&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Name
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=users.first_name&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            type
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/teachers?sort=type&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>   
                    </tr>
                </thead>
                <tbody id="teachersTable">
                    <?php foreach($teachers as $teacher): ?>
                        <tr>
                        <td>
                            <?= $teacher["teacher_id"] ?>
                        </td>
                        <td>
                            <?= $teacher["country"] ?>
                        </td>
                        <td>
                            <?= $teacher["contact_email"] ?>  
                        </td>
                        <td>
                            <?= $teacher["contact_phone"] ?> 
                        </td>
                        <td>
                            <?= $teacher["first_name"] ?>   <?= $teacher["last_name"] ?>
                        </td>
                        <td>
                            <?= $teacher["type"] ?>
                        </td>
                        <td>
                            <a href="/admin/teachers/<?=$teacher["teacher_id"]?>/edit" class="btn btn-info text-white">Update</a>
                        </td>
                    </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>