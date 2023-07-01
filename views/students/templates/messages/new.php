<div class="card">
    <div class="card-body">
        <div id="chat-window" class="mb-3">
            <?php
            if (isset($messages)) {
                foreach ($messages as $message) : ?>
                    <p>
                        <?php if ($message["sender_id"] == $_SESSION["user_id"]) { ?>
                    <div class="chat-bubble chat-bubble-sender">
                        <?= $message["message"] ?>
                    </div>
                    <br>
                <?php } else { ?>
                    <div class="chat-bubble chat-bubble-recipient">
                        <?= $message["message"] ?>
                    </div>
                <?php } ?>
                </p>
        <?php endforeach;
            } ?>
        </div>
        <?php if (isset($_GET["from"]) && isset($_GET["to"])) { ?>
            <form action="/messages" method="POST">
                <div class="input-group mb-3">
                    <input type="hidden" id="sender-id" name="sender_id" value="<?= $_GET["from"] ?>">
                    <input type="hidden" id="recipient-id" name="recipient_id" value="<?= $_GET["to"] ?>">
                    <input type="text" id="message-input" class="form-control" name="message" placeholder="Type your message...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" type="button" id="send-button">Send</button>
                    </div>
                </div>
            </form>
        <?php } ?>


    </div>

</div>