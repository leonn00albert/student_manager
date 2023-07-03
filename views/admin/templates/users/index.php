<div class="card m-3">
    <div class="card-header">Users</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="userCount"></span></h4>

        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Registration number
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=user_id&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Country
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=country&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Email
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=contact_email&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Phone
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=contact_phone&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            Name
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=first_name&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col">
                            type
                            <?php
                            $sortDirection = isset($_GET["direction"]) && strtoupper($_GET["direction"]) === "ASC" ? "DESC" : "ASC";
                            ?>
                            <a href="/admin/users?sort=type&direction=<?php echo $sortDirection; ?>">
                                <i class="fa fa-sort"></i>
                            </a>
                        </th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td>
                                <?= $user["user_id"] ?>
                            </td>
                            <td>
                                <?= $user["country"] ?>
                            </td>
                            <td>
                                <?= $user["contact_email"] ?>
                            </td>
                            <td>
                                <?= $user["contact_phone"] ?>
                            </td>
                            <td>
                                <?= $user["first_name"] ?> <?= $user["last_name"] ?>
                            </td>
                            <td>
                                <?= $user["type"] ?>
                            </td>
                            <td>
                                <a href="/admin/users/<?= $user["user_id"] ?>/edit" class="btn btn-info text-white">Update</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav  style="display: flex;">
                        <?= $pagination ?>
            </nav>
        </div>

    </div>