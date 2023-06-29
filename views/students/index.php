<?php include "templates/header.php"; ?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include "templates/nav.php"; ?>
        <div class="col py-3 right-side-container">
            <div class="container">
                <?php if (isset($_SESSION["alert"]["message"])) { ?>
                    <div class="alert alert-<?=$_SESSION["alert"]["type"]?> d-flex align-items-center" role="alert">
                        <div>
                            <?= $_SESSION["alert"]["message"]?>
                        </div>
                    </div>
                    <?php unset($_SESSION["alert"]) ?>
                <?php } ?>
             
                <?php include "templates/" . $template; ?>

            </div>
        </div>
    </div>
    <?php include "templates/footer.php"; ?>