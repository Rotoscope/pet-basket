<?php
$get = Core\Input::get();
$post = Core\Input::post();
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $page = "contactUpdate";
    require_once __DIR__ . '/components/head.php';
    require_once __DIR__ . '/components/header.php';
    ?>
    <body>
        <?php
        $username = '';
        $email = '';
        $phone = '';
        if (isset($_SESSION["user"])) {
            $user = User::constructById($_SESSION["user"]);
            if ($user !== null) {
                $username = $user->getUsername();
            }
        }
        ?>
        <div class="container">
            <div class="row contactTitleBox">
                <div class="col-md-4">
                    <h4><strong>Manage Your Account</strong></h4>
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-tabs navbar-right">
                        <li role="presentation" class="active"><a href="#">Update Info</a></li>
                        <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/myPets">My Pets</a></li>
                        <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/notification">Notification</a></li>
                        <?php if (isset($user) && $user->getIsAdmin()) { ?>
                            <li role="presentation"><a href="/~<?php echo USER; ?>/index.php/PetBasket/admin">Admin</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <h4 class="text-center">Update your information here</h4>
                <p class="text-center">Use the form below to identify the personal information.</p>
                <br>
                <br>
            </div>
            <div class="row">
                <!--CONTACT SECTION-->
                <div class="col-md-4 col-md-offset-2">
                    <form id="searchForm" action="/~<?php echo USER; ?>/index.php/PetBasket/updateEmail" method="post" enctype="multipart/form-data">
                        <h4 class="text-center">Contact Information</h4>
                        <br>
                        <div class="form-group">
                            <label for="username">User Name:</label>
                            <p><?php echo $username; ?></p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" name="email" pattern="[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="example@email.com" form="searchForm">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" form="searchForm">
                        </div>
                        <input class="btn btn-primary loginSubmit" type="submit" form="searchForm"/>
                        <span class="emailUpdateMsgSpan"><?php echo (isset($error) && $error['status'] == 0) ? "email updated" : "" ;?></span>
                        
                    <br>
                    <br>
                    </form>
                </div>
                <!--PASSWORD SECTION-->
                <div class="col-md-4 modalSeperator">
                    <form id="updatePasswordForm" action="/~<?php echo USER; ?>/index.php/PetBasket/updatePassword" method="post" enctype="multipart/form-data">
                    <h4 class="text-center">Password</h4>
                    <br>
                    <div class="form-group">
                        <label for="oldPassword">Old Password:</label>
                        <input type="password" id="oldPass" class="form-control" name="password" form="updatePasswordForm" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" id="newPass" class="form-control" name="newPassword" form="updatePasswordForm" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password: </label>
                        <input type="password" id="confirmPass" class="form-control" name="confirmPassword" form="updatePasswordForm" required>
                    </div>
                    <input class="btn btn-primary loginSubmit" type="submit" name="updatePassword" value="Update" />
                    <br>
                    <br>
                    </form>
                </div>
            </div>
           
            
            <?php
            require_once __DIR__ . '/components/footer.php';
            ?>
            <?php require_once(VIEWS_PATH . "/components/commonsJsForOther.php"); ?>
        </div>
    </body>
</html>
