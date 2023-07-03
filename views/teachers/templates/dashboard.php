<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class="fas fa-bell"></i> Notifications </div>
            <div class="card-body">

                <?php foreach ($_SESSION["notifications"] as $notification) : ?>
                    <?php if ($notification["is_read"] === 0) { ?>
                        <div class="alert alert-light alert-dismissible fade show" role="alert">
                            <a href=<?= $notification["link"] ?>><i class="fa fa-bell" aria-hidden="true"></i> <?= $notification["message"] ?></a>
                            <button type="button" class="btn-close" aria-label="Close" onclick="updateNotification(<?= $notification['notification_id'] ?>)"></button>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>

            </div>
        </div>
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