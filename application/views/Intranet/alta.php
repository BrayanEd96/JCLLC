<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg nav navbar-light">
    <a class="navbar-brand" href="<?php echo base_url() ?>">Janitorial Coronas LLC</a>
  </nav>
  <!-- -- -->

  <!-- Genaral Container -->
  <div class="container">

    <!-- Title -->
    <div class="row" id="title">
      <div class="col d-flex">
        <h1>Sign Up</h1>
      </div>
    </div>

    <div class="container">
      <div id="main" class="container-fluid">

        <!-- Form -->
        <div id="formCheck">
          <div class="form-group">
            <label for="nUser">User</label>
            <select name="user" class="custom-select" id="nUser">
            </select>
            <div class="invalid-feedback" id="messageUser">
                Select a user
            </div>
          </div>
          <div class="form-group">
            <label for="pUser">Set the password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="passwordUser" id="pUser" />
              <div class="input-group-append">
                <span class="input-group-text" id="vPass" ><i id="ivPass" class="fa fa-eye-slash icon"></i></span>
              </div>
            </div>
            <div class="invalid-feedback" id="messagePas">
                This field cannot be empty
            </div>
            <small id="passwordHelp" class="form-text text-muted">Your password must contain at least one uppercase, one lowercase, and one number, at least 6 characters long</small>
          </div>
        </div>

        <!-- Buttons section -->
        <div>
          <button type="button" class="btn btn-primary ml-3" id="bSign">Sign Up</button>
          <button type="button" class="btn btn-secondary ml-3" id="bBack">Back</button>
        </div>
      </div>
    </div>

    <!-- the load message -->
    <div id="contentMessages">
      <div id="loading" class="alert alert-primary">Loading...</div>
    </div>
  </div>
  <!-- -- -->

  <style type="text/css">
    #loading {
        display: none;
    }
  </style>

  <script type="text/javascript">
    
    //The function that is made when the window is load
    window.onload = function() {

      getUsers();

    }

    //The users are obtained
    function getUsers(){

      axios.get("<?php echo site_url('users') ?>",{
        responseType: 'json'
      }).then(function(res) {
        if (res.status == 200) {
          var cont = "<option value=0>Select User</option>";
          for(var obj of res.data) {
            if (obj.t_Password == "") {
              cont += "<option value="+obj.n_IdUser+">"+obj.t_Name+"</option>";
            }
          }
          document.getElementById('nUser').innerHTML = cont;
        }

      }).catch(function(err) {

        swal({
          text: "Something went wrong with users please reload the page",
          icon: "error",
        });

        console.log(err);

      });
    }


    //The button is selected as a view password button and become from input password to input text and vice versa
    var vPass = document.getElementById('vPass');
    vPass.addEventListener('click', showPassword);

    function showPassword(){
        var input = document.getElementById("pUser");
        var icon = document.getElementById('ivPass');

        if(input.type == "password"){
          icon.className = "fa fa-eye icon";
          input.type = "text";
        }else{
          icon.className = "fa fa-eye-slash icon";
          input.type = "password";
        }
    }


    //There are selected the buttons for save and come back to index, and the div for load message
    var buttonS = document.getElementById('bSign');
    var buttonB = document.getElementById('bBack');
    var loading = document.getElementById('loading');

    var user;
    
    //The event is added to the save button
    buttonS.addEventListener('click', function() {
      
      validation();

    });

    //The event is added to the back button
    buttonB.addEventListener('click', function(){
      window.location = "<?php echo site_url('log') ?>";
    });


    //This function validate the input content
    function validation(){

      const numbers = /\d/;
      const upper = /[a-z]/;
      const lower = /[A-Z]/;

      let user = document.getElementById('nUser');
      let pas = document.getElementById('pUser');

      messagePas = document.getElementById('messagePas');

      user.className = "custom-select";
      pas.className = "form-control";
      pas.parentElement.className = "input-group";

      if (user.value == 0) {

        user.className = "custom-select is-invalid";
        
        return false;

      }else if (pas.value == "") {

        pas.className = "form-control is-invalid";
        pas.parentElement.className = "input-group is-invalid";

        return false;

      }else if(pas.value.length < 6){

        messagePas.innerHTML = "Your password doesn't contain at least 6 characters";
        pas.className = "form-control is-invalid";
        pas.parentElement.className = "input-group is-invalid";

        return false;

      }else if(!numbers.test(pas.value) || !upper.test(pas.value) || !lower.test(pas.value)){

        messagePas.innerHTML = "Your password doesn't have what is required";
        pas.className = "form-control is-invalid";
        pas.parentElement.className = "input-group is-invalid";

        return false;

      }else{

        user.className = "custom-select";

        messagePas.innerHTML = "This field cannot be empty";
        pas.className = "form-control";
        pas.parentElement.className = "input-group";

        var objRequest = {
          User: user.value,
          PUser: pas.value
        }

        request(objRequest);

      }
    }


    //With this function the password is registered
    function request(data){

      axios.post("<?php echo site_url('signUp') ?>", data
      ).then(function(res) {
        
        if (res.data) {

          swal({
            text: "The password settings were successful",
            icon: "success",
          }).then(() => {
              window.location = "<?php echo site_url('log') ?>";
          });

          document.getElementById('nUser').value = 0;
          document.getElementById('pUser').value = "";

        }else {

          swal({
            text: "The password settings failed",
            icon: "error",
          });

        }

      }).catch(function(err) {

        swal({
          text: "Something went wrong please try again or later",
          icon: "error",
        });
        
        console.log(err);

      }).then(function() {

          loading.style.display = 'none';

      });
    }

  </script>