<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg nav navbar-light">
        <a class="navbar-brand" href="<?php echo base_url() ?>">Janitorial Coronas LLC</a>
        <!-- If the user is login in the system the rest of the navbar shows, else not -->
        <?php
        if (!isset($noLog)) {
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSes" aria-controls="navbarSes" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fa fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSes">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('supervision') ?>">Supervision</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('work') ?>">Check</a>
                </li>
                <?php
                if ($userKind == 1) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('vendors') ?>">Vendors</a>
                </li>
                <?php
                }
                ?>
            </ul>
            <div class="btn-group">
                <div class="container" style="color: #e6e6e6; ">
                    <label><?php echo $userName." ".$lastName."  " ?></label>
                </div>
                <a class="dropdown-toggle" role="button" id="bOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog" style="font-size: 1.2em;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="bOptions">
                    <a class="dropdown-item" href="<?php echo site_url('log') ?>">Log-out</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#mOptions">Change Password</a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </nav>
    <!-- -- -->

    <!-- Modal options -->
    <div class="modal fade" id="mOptions" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="nPass">Write the new password</label>
                            <div class="input-group" >
                                <input class="form-control" type="password" name="newPassword" id="nPass">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="vNewPass" ><i id="ivNPass" class="fa fa-eye-slash icon"></i></span>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="validNPassword">
                                This field cannot be empty
                            </div>
                            <small id="passwordHelp" class="form-text text-muted">Your password must contain at least one uppercase, one lowercase, and one number, at least 6 characters long</small>
                        </div>
                        <div class="form-group">
                            <label for="cPass">Confirm your new password</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="confirmPassword" id="cPass">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="vConfirmPass" ><i id="ivCPass" class="fa fa-eye-slash icon"></i></span>
                                </div>
                            </div>
                            <div class="invalid-feedback" id="validCPassword">
                                This field cannot be empty
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="savePassword" type="button" class="btn btn-primary" >Save</button>
                    <button id="closeModal" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

    <script type="text/javascript">
        //Declaration of constants as user id and regular expressions
        const userId = <?php echo (isset($idUser) ? $idUser : "") ?>;
        const numbers = /\d/;
        const upper = /[a-z]/;
        const lower = /[A-Z]/;

        //The close button is selected and it is added the function for cleaning the form
        var closeModal = document.getElementById("closeModal");
        closeModal.addEventListener('click', function(){
            newPass.className = "form-control";
            newPass.parentElement.className = "input-group";
            confirmPass.className = "form-control";
            confirmPass.parentElement.className = "input-group";
            newPass.value = "";
            confirmPass.value = "";
        });

        //The buttons are selected as a view password buttons and become from input password to input text and vice versa
        var vNPass = document.getElementById('vNewPass');
        var vCPass = document.getElementById('vConfirmPass');
        vNPass.addEventListener('click', function(){
            showPassword("newPass");
        });
        vCPass.addEventListener('click', function(){
            showPassword("confirmPass");
        });

        function showPassword(argument){
            if (argument == "newPass") {
                var input = document.getElementById("nPass");
                var icon = document.getElementById('ivNPass');
            }else if (argument == "confirmPass") {
                var input = document.getElementById("cPass");
                var icon = document.getElementById('ivCPass');
            }

            if(input.type == "password"){
                icon.className = "fa fa-eye icon";
                input.type = "text";
            }else{
                icon.className = "fa fa-eye-slash icon";
                input.type = "password";
            }
        }
        
        //The save button is selected and added the function to validate the input content
        var bSavePass = document.getElementById("savePassword");
        bSavePass.addEventListener('click', function(){
            validPass();
        });

        //This function validate the content and then callback the function to change password
        function validPass(){

            newPass = document.getElementById("nPass");
            confirmPass = document.getElementById("cPass");

            validNPass = document.getElementById("validNPassword");
            validCPass = document.getElementById("validCPassword");


            newPass.className = "form-control";
            newPass.parentElement.className = "input-group";
            confirmPass.className = "form-control";
            confirmPass.parentElement.className = "input-group";

            if (newPass.value == "") {

                validNPass.innerHTML = "This field cannot be empty";
                newPass.parentElement.className = "input-group is-invalid";
                newPass.className = "form-control is-invalid";
                return false;

            }else if(confirmPass.value == ""){

                validCPass.innerHTML = "This field cannot be empty";
                confirmPass.parentElement.className = "input-group is-invalid";
                confirmPass.className = "form-control is-invalid";
                return false;

            }else if (newPass.value.length < 6) {

                validNPass.innerHTML = "This password does not meet with the length required";
                newPass.parentElement.className = "input-group is-invalid";
                newPass.className = "form-control is-invalid";
                return false;

            }else if (!numbers.test(newPass.value) || !upper.test(newPass.value) || !lower.test(newPass.value)) {

                validNPass.innerHTML = "This password does not meet with the characters required";
                newPass.parentElement.className = "input-group is-invalid";
                newPass.className = "form-control is-invalid";
                return false;

            }else if (newPass.value != confirmPass.value) {

                validCPass.innerHTML = "The passwords do not match";
                confirmPass.parentElement.className = "input-group is-invalid";
                confirmPass.className = "form-control is-invalid";
                return false;

            }else{

                newPass.className = "form-control";
                newPass.parentElement.className = "input-group";
                confirmPass.className = "form-control";
                confirmPass.parentElement.className = "input-group";

                var objPass = {
                    id: userId,
                    newPassword: newPass.value
                }

                changePass(objPass);
            }
        }

        //This function do a request to change the password
        function changePass(obj){
            axios.post("<?php echo site_url('changePassword') ?>", obj
            ).then(function(res){

                if (res.data) {
                    swal({
                        text: "Password changed, the next time that you log-in you must to use the new password",
                        icon: "success",
                    });

                    $("#mOptions").modal("hide");

                    newPass.value = "";
                    confirmPass.value = "";
                }

            }).catch(function(err){

                swal({
                    text: "Something went wrong please try again or later",
                    icon: "error",
                });
                
                console.log(err);
            });
        }
    </script>
