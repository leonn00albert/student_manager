<div class="card m-3">
    <div class="card-header">Users</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="userCount"></span></h4>
     
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

    </div>