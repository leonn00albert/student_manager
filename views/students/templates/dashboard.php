<div class="row">
    <?php foreach ($progress as $prog) : ?>
        <div class="col">
            <div class="card border-secondary card-shadow" style="width: 18rem;">
            <div class="card-header">Progress</div>
                <div class="card-body">
                    <?= $prog["course_name"] ?>
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="<?= $prog["graded"] ?>" aria-valuemax="<?= $prog["sections"] ?>">
                        <div class="progress-bar" style="width: <?=$prog["percentage"]?>%"><?= $prog["percentage"] ?>%</div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

</div>
<div class="card m-5 card-shadow">
    <div class="card-body">
        <?php foreach ($_SESSION["notifications"] as $notification) : ?>
            <?php if (!$notification["is_read"]) { ?>
                <div class="alert alert-light alert-dismissible fade show" role="alert">
                    <a href=<?= $notification["link"] ?>><i class="fa fa-bell" aria-hidden="true"></i> <?= $notification["message"] ?></a>
                    <button type="button" class="btn-close" aria-label="Close" onclick="updateNotification(<?= $notification['notification_id'] ?>)"></button>
                </div>
            <?php } ?>
        <?php endforeach; ?>

    </div>
</div>

<script>
    function updateNotification(notificationId) {
        fetch('/notifications/' + notificationId, {
                method: 'PUT',
                body: JSON.stringify({
                    id: notificationId
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                location.reload();

            })
            .catch(error => {
                console.log('Error occurred while updating notification:', error);
            });
    }
</script>