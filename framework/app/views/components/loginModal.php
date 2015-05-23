<script type="text/javascript">
    $(function () {
        $('#signupUsernameError').hide();
        $('#signupEmailError').hide();
        $('#confirmError').hide();
        $('#passwordError').hide();

        $('#signupButton').click(function (event) {
            event.preventDefault(); //stop default action

            var usernameField = $('#signupUsername').val();
            var usernamePattern = /[a-zA-Z0-9]{1,}/;
            var emailField = $('#signupEmail').val();
            var emailPattern = /[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
            var passwordPattern = /.{6,}/;
            // do preliminary verifcation of the username and email here
            // usermane.length > 0 , etc..

            // DON'T SEND THE PASSWORD - only use the "pattern" attribute of the password input element to verify the password is of appropriate length and chars

            if (usernameField.length < 1 || !usernamePattern.test(usernameField)) {
                return false;
            }

            if (emailField.length < 1 || !emailPattern.test(emailField)) {
                $('#signupEmailError').show();
                $('#signupEmailError').html("Invalid email format");
                return false;
            }

            if (!passwordPattern.test($('#password1'))) {
                return false;
            }

            var signupData = {
                username: usernameField,
                email: emailField
            };
            // Check with server to see if the signupData is valid
            $.ajax({
                url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/checkSignupData',
                type: "POST",
                data: signupData,
                success: function (response) {// controller checkSignUpData() has done its thing and sends back a response
                    response = JSON.parse(response);

                    // A new user can be created with the information currently in the signup form
                    console.log("Reponse from signup");
                    console.log(response.status);
                    if (response.status != undefined && response.status == 1) {
                        // make sure "terms" checkbox is checked
                            var checked = $('#termsCheckbox').is(':checked');
                            console.log(checked);
                        // if terms is checked, submit the form, if not, give the checkbox focus and display a message to the user instead of submitting the form
                        if (checked) {
                            $('#signupForm').submit();
                        }
                    } else if (response.status != undefined && response.status == 0) {
                        // Show the user the error message sent by the server
                        if (response.errorCode != undefined) {
                            switch (response.errorCode) {
                                case 1:
                                    $('#signupUsernameError').show();
                                    $('#signupUsernameError').html("Invalid username");
                                    break;
                                case 2:
                                    $('#signupUsernameError').show();
                                    $('#signupUsernameError').html("Username is already taken");
                                    break;
                                case 3:
                                    $('#signupEmailError').show();
                                    $('#signupEmailError').html("Invalid Email");
                                    break;
                                case 4:
                                    $('#signupEmailError').show();
                                    $('#signupEmailError').html("Email is already in use");
                                    break;
                                default:
                                    break;
                                    //throw "Unrecognized error code " + response.errorCode;
                            }
                        } else {
                            //throw "Malformed server response data, response.errorCode undefined! ";
                        }
                    } else {
                        //throw "Malformed server response data, response.status undefined! ";
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {  // see jQuery $.ajax documentation 
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert(errorThrown);
                }
            });
        });

        $('#password2').keyup(function () {
            if ($('#password1').val() !== $('#password2').val()) {
                $('#confirmError').show();
                $('#confirmError').html("Passwords do not match");
            } else {
                $('#confirmError').hide();
            }
        });

        $('#signupUsername').keyup(function () {
            var allowedChars = new RegExp("^[a-zA-Z0-9.]+$");
            if (!$('#signupUsername').val().match(allowedChars) && $('#signupUsername').val() !== '') {
                $('#signupUsernameError').show();
                $('#signupUsernameError').html("Invalid character entered");
            } else {
                $('#signupUsernameError').hide();
            }
        });

        $('#loginButton').click(function () {
            event.preventDefault();

            var usernameField = $('#loginUsername').val();
            var passwordField = $('#loginPassword').val();

            if (usernameField.length < 1) {
                $('#loginUsernameError').show();
                $('#loginUsernameError').html("Login cannot be blank");
                return false;
            }

            if (passwordField.length < 1) {
                $('#loginPasswordError').show();
                $('#loginPasswordError').html("Password cannot be blank");
                return false;
            }

            var loginData = {
                username: usernameField,
                password: passwordField
            };

            $.ajax({
                url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/checkLogin',
                type: "POST",
                data: loginData,
                success: function (response) {
                    response = JSON.parse(response);

                    console.log("Reponse from login");
                    console.log(response.status);
                    if (response.status != undefined && response.status == 1) {
                        $('#loginForm').submit();
                    } else if (response.status != undefined && response.status == 0) {
                    // Show the user the error message sent by the server
                        if (response.errorCode != undefined) {
                            switch (response.errorCode) {
                            case 1:
                                $('#loginUsernameError').show();
                                $('#loginUsernameError').html("Invalid username");
                                break;
                            case 2:
                                $('#loginPasswordError').show();
                                $('#loginPasswordError').html("Invalid password");
                                break;
                            case 3:
                                
                                //throw "User is already logged in";
                                break;
                            default:
                                //throw "Unrecognized error code " + response.errorCode;
                            }
                        } else {
                            //throw "Malformed server response data, response.errorCode undefined! ";
                        }
                    } else {
                        //throw "Malformed server response data, response.status undefined! ";
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {  // see jQuery $.ajax documentation 
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert(errorThrown);
                }
            });
        });
    });
</script>
<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="padding: 5px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalHeader">Login to PetBasket.com</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="modal-title">Already a member?</h4>
                        <div class="tab-pane fade active in" id="log-in">
                            <form class="form-horizontal" id="loginForm" method="post" action="/~<?php echo USER; ?>/index.php/PetBasket/login">
                                <fieldset>
                                    <input type="hidden" name="referrer" value="<?php echo $page; ?>">
                                    <div class="control-group">
                                        <label class="control-label" for="username">Email or Username: </label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="loginUsername" name="username" required>
                                            <p id="loginUsernameError"></p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="password">Password: </label>
                                        <div class="controls">
                                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="********" required>
                                            <p id="loginPasswordError"></p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="btn btn-success loginSubmit" id="loginButton" type="submit" name="login" value="Login" />
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 modalSeperator">
                        <h4 class="modal-title">Not a member yet?</h4>
                        <div class="tab-pane fade in" id="signup">
                            <form class="form-horizontal" id="signupForm" action="/~<?php echo USER; ?>/index.php/PetBasket/signup" method="post" onsubmit="">
                                <fieldset> 
                                    <input type="hidden" name="referrer" value="<?php echo isset($page) ? $page : 'home'; ?>" form="signupForm">
                                    <div class="control-group">
                                        <label class="control-label" for="username">Username: </label>
                                        <em class="control-label" style="float:right;">Alphanumeric characters only</em>
                                        <input type="text" id="signupUsername" class="form-control" name="username" pattern="[a-zA-Z0-9]{1,}" required>
                                        <p id="signupUsernameError"></p>
                                        <br>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="email">Email: </label>
                                        <em class="control-label" style="float:right;">example@gmail.com</em>
                                        <input type="text" class="form-control" id="signupEmail" name="email" pattern="[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="example@email.com" required>
                                        <p id="signupEmailError"></p>
                                        <br>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="password">Password: </label>
                                        <em class="control-label" style="float:right;">At least six characters</em>
                                        <input type="password" class="form-control" name="password1" id="password1" pattern=".{6,}" placeholder="********" required>
                                        <p id="passwordError"></p>
                                        <br>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="passwordConfirmation">Confirm Password: </label>
                                        <input type="password" class="form-control" name="password2" id="password2" pattern=".{6,}" placeholder="********" required>
                                        <p id="confirmError" style="font-weight: bold;"></p>
                                        <br> 
                                    </div>
                                    <div class="control-group">
                                        <input id="termsCheckbox" type="checkbox" name="terms" value="Terms" required> I am at least 18 years old and I agree to the <a href="#terms" data-toggle="modal">Terms and Conditions</a>.
                                    </div>
                                    <div class="control-group">
                                        <br>
                                        <input class="btn loginSubmit signupSubmit" id="signupButton" type="submit" name="signup" value="Register" />
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/terms.php';
?>
