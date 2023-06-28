<div class="row">
    <div class="col">
        <div class="card text-white bg-info card-shadow" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <h1><?= 0 ?></h1>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-warning card-shadow" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Cars</h5>

                <h1><?= 0 ?></h1>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-primary card-shadow" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Slots</h5>

                <h1><?= 0 ?></h1>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card text-white bg-success card-shadow" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Bookings</h5>

                <h1><?= 0 ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="card m-5 card-shadow">
    <div class="card-body">
    <?php foreach ($_SESSION["notifications"] as $notification) : ?>
    <?php if(!$notification["is_read"]) { ?>
        <div class="alert alert-light alert-dismissible fade show" role="alert">
        <?= $notification["message"] ?>
        <a href=<?= $notification["link"] ?> class="btn btn-dark"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        <button type="button" class="btn-close" aria-label="Close" onclick="updateNotification(<?= $notification['notification_id'] ?>)"></button>
    </div>
    <?php } ?>
<?php endforeach; ?>

    </div>
</div>

<script>

function updateNotification(notificationId) {
  fetch('/notifications/'+ notificationId , {
    method: 'PUT',
    body: JSON.stringify({ id: notificationId }),
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