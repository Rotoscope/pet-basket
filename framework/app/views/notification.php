<?php
$get = Core\Input::get();
$post = Core\Input::post();
if(!isset($_SESSION["user"]))
    header("Location: http://sfsuswe.com/~" . USER . "/index.php/PetBasket/home");
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $page = "notification";
    require_once __DIR__ . '/components/head.php';
    require_once __DIR__ . '/components/header.php';
    ?>
    <body>
    <div class="container">
        <div class="row contactTitleBox">
            <div class="col-md-4">
                <h4><strong>Manage Your Account</strong></h4>
            </div>
            <div class="col-md-8">
                <ul class="nav nav-tabs navbar-right">
                    <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/contactUpdate">Update Info</a></li>
                    <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/myPets">My Pets</a></li>
                    <li role="presentation" class="active"><a href="#">Notification</a></li>
                    <?php if (isset($user) && $user->getIsAdmin()) { ?>
                        <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/admin">Admin</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="mainContent">
            <div class="row">
                <h4 class="text-center">Find your notifications here</h4>
                <p class="text-center">You can manage your messages from others in this page.</p>
                <br>
                <br>
            </div>
                <?php
                if (isset($passedToView['threadedMessages']) && is_array($passedToView['threadedMessages'])) {
                    if (empty($passedToView['threadedMessages'])) {
                        echo <<< msg
                <div class="text-center"><h3>"You have no new messages"</h3></div>
msg;
                    } else {
                        foreach ($passedToView['threadedMessages'] as $threadedMessage) {
                            if (isset($threadedMessage) && $threadedMessages !== null) {
                                $senderName = $threadedMessage->getSenderName();
                                $message = $threadedMessage->getMessage();
                                $threadId = $threadedMessage->getThreadId();
                                $userId = $_SESSION["user"];
                                $senderId = $threadedMessage->getSenderId();
                                $recipientId = $threadedMessage->getRecipientId();
                                $sendTo = ($userId == $recipientId) ? $senderId : $recipientId;
                                $remove = '/~' . USER . '/index.php/PetBasket/removeThread';
                                $reply = '/~' . USER . '/index.php/PetBasket/replyThread';
                                echo <<< img
                <div class="container" style="margin: 0 auto;">        
                    <div class="colmd-12 row browsePageBodyRow">
                        <div class="col-md-7 waterFallColumn bodyRowBox navigationRowOverride" style="border: 2px solid black; padding: 10px; margin:0 auto">
                            <div class = "row">
                                <div class="col-md-2">
                                    <!--FROM---------------->
                                    <label style="float: left;" for="post">From:</label>
                                </div>
                                <div class="col-md-4">
                                    <p>$senderName</p>
                                </div>
                                <div class="col-md-3" style="float:right;">
                                    <form action="$remove" method="get">
                                        <input type="hidden" name="threadId" value="$threadId">
                                        <input class="btn btn-md" type="submit" value="Remove">
                                    </form>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-md-2">
                                    <!--MESSAGE---------------->
                                    <label style="float: left;" for="post">Message:</label>
                                </div>
                                <div class="form-group col-md-8 replyBox">
                                    <textarea readonly class="form-control" rows="10" id="message" name="message" form="postForm">
                                        $message
                                    </textarea>
                                </div>
                            </div>
                            <form id="from-reply" action="$reply" method="post">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!--REPLY---------------->
                                        <label style="float: left;" for="post">Reply:</label>
                                    </div>
                                    <div class="col-md-8 replyBox">
                                        <textarea class="form-control" rows="5" id="reply" name="reply"></textarea>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="col-md-3" style="float: right;">
                                        <input type="hidden" name="threadId" value="$threadId">
                                        <input type="hidden" name="senderId" value="$userId">
                                        <input type="hidden" name="recipientId" value="$sendTo">
                                        <input class="btn btn-md" type="submit" value="Reply">
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
                </br></br>
img;
                            }
                        }
                    }
                }
                ?>
            </div><!-- /.mainContent -->
            <?php require_once(VIEWS_PATH . "/components/footer.php"); ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <?php require_once(VIEWS_PATH . "/components/commonsJsForOther.php"); ?>
        </div><!-- /.container -->
    </body>
</html>