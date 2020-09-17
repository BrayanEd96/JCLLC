<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg nav navbar-light">
    <a class="navbar-brand" href="<?php echo base_url() ?>">Janitorial Coronas LLC</a>
  </nav>
  <!-- -- -->

  <!-- General container -->
  <div class="container">
    <div class="row" id="title">
      <div class="col d-flex">
        <h1>Log-In</h1>
      </div>
    </div>
    <div class="container">
      <div id="main" class="container-fluid">
        <div id="formCheck">
          <div class="form-group">
            <label for="nUser">User</label>
            <select name="user" class="custom-select" id="nUser">
            </select>
            <div id="messageUser"></div>
          </div>
          <div class="form-group">
            <label for="pUser">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="passwordUser" id="pUser" />
              <div class="input-group-append">
                 <span class="input-group-text" id="vPass" ><i id="ivPass" class="fa fa-eye-slash icon"></i></span>
              </div>
            </div>
            <div id="messagePas"></div>
          </div>
        </div>
        <div>
          <button type="button" class="btn btn-primary ml-3" id="bLog">Log-In</button>
          <small class="d-flex"><a class="mr-auto ml-3 mt-3" href="<?php echo site_url('alta') ?>">Don't have a password? Click here!</a></small>
        </div>
      </div>
    </div>
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
            cont += "<option value="+obj.n_IdUser+">"+obj.t_Name+"</option>";
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


    //There are selected the divs for the messages according to the input, and the button for login
    var messageUser = document.getElementById('messageUser');
    var messagePas = document.getElementById('messagePas');
    var button = document.getElementById('bLog');
    var loading = document.getElementById('loading');

    var user;
    

    //The event is added to the login button
    button.addEventListener('click', function() {

      user = document.getElementById('nUser').value;
      pas = document.getElementById('pUser').value;
      
      if (validation()) {
        request();
      }

    }); 


    //This function validate the input content
    function validation(){

      messageUser.innerHTML = "";
      messageUser.className = "";
      document.getElementById('nUser').className = "custom-select";

      messagePas.innerHTML = "";
      messagePas.className = "";
      document.getElementById('pUser').className = "form-control";

      if (user == 0) {

        messageUser.innerHTML = "Select a user";
        messageUser.className = "invalid-feedback";
        document.getElementById('nUser').className = "custom-select is-invalid";
        
        return false;

      }else if (pas == "") {

        messagePas.innerHTML = "Insert your password";
        messagePas.className = "invalid-feedback";
        document.getElementById('pUser').className = "form-control is-invalid";

        return false;

      }else{

        messageUser.innerHTML = "";
        messageUser.className = "";
        document.getElementById('nUser').className = "custom-select";

        messagePas.innerHTML = "";
        messagePas.className = "";
        document.getElementById('pUser').className = "form-control";

        return true;

      }
    }


    //With this function the user can login in the system
    function request(){

      var data = {
        User: user,
        PUser: pas
      }

      axios.post("<?php echo site_url('logIn') ?>", data
      ).then(function(res) {
        console.log(res);
        if (res.data) {

          swal({
            text: "The login went success",
            icon: "success",
          });

          document.getElementById('nUser').value = 0;
          document.getElementById('pUser').value = "";

          window.location = "<?php echo site_url('supervision') ?>";

        }else{

          swal({
            text: "The login went failed",
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