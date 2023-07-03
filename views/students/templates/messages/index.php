<div class="card">
<div class="card-header"><i class="fa fa-address-book" aria-hidden="true"></i>
    Contacts</div>
    <div class="card-body">
        <div class="list-group">
            <?php foreach ($students as $student) : ?>
                <?php if (isset($_GET["to"]) && $_GET["to"] == $student["user_id"]) { ?>
                    <a href="?from=<?= $_SESSION["user_id"] ?>&to=<?= $student["user_id"] ?>" class="list-group-item list-group-item-action active">

                    <?php } else { ?>
                        <a href="?from=<?= $_SESSION["user_id"] ?>&to=<?= $student["user_id"] ?>" class="list-group-item list-group-item-action">

                        <?php } ?>
                        <img src="<?= $student["avatar"] ?>.svg" alt="hugenerd" width="30" height="30" class="me-1 rounded-circle">
                        <?= $student["first_name"] ?>
                        </a>
                    <?php endforeach; ?>
        </div>
    </div>
</div>