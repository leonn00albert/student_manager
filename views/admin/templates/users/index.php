<div class="card m-3">
    <div class="card-header">Users</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="userCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Country<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone<i onclick="handleSort('name')" class="fa fa-sort"></i></th>
                        <th scope="col">Name<i onclick="handleSort('grade')" class="fa fa-sort"></i></th>
                        <th scope="col">type <i onclick="handleSort('class')" class="fa fa-sort"></i></th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    <?php foreach($users as $user): ?>
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
                            <?= $user["first_name"] ?>   <?= $user["last_name"] ?>
                        </td>
                        <td>
                            <?= $user["type"] ?>
                        </td>
                        <td>
                            <a href="/admin/users/<?=$user["user_id"]?>/edit" class="btn btn-info text-white">Update</a>
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
                    <a href="users/new" class="dropdown-item">user</a>
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