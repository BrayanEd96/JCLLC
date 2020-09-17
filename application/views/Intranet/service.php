	<!-- General Container -->
	<div class="container">
		<!-- Title of Section -->
		<div class="row" id="title">
			<div class="col d-flex">
				<h1>Start to work</h1>
			</div>
		</div>
		<!-- Form and Stopwatch Container -->
		<div class="container">
			<div id="main" class="container-fluid">
				<div id="formCheck">
					<div class="form-group">
						<label for="uName">User Name</label>
						<input type="text" class="form-control" name="userName" id="uName" placeholder="Your Name" />
						<div class="invalid-feedback" id="messageUName">
                			This field cannot be empty
            			</div>
					</div>
					<div class="form-group">
						<label for="nEst">Establishment</label>
						<input type="text" name="location" class="form-control" id="nEst" placeholder="Establishment Name" />
						<div class="invalid-feedback" id="messageNEst">
                			This field cannot be empty
            			</div>
					</div>
					<div class="form-group">
						<label for="nSup">Supervisor</label>
						<select name="supervisor" class="custom-select" id="nSup">
						</select>
						<div class="invalid-feedback" id="messageNSup">
                			You must select a supervisor
            			</div>
					</div>
				</div>
				<div id="stopWatch">
					<div id="contStopWatch"> 00 : 00 : 00 </div>
				</div>
				<div class="d-flex">
					<button type="button" class="btn btn-success" id="bCheckIn">Check In</button>
					<button type="button" class="btn btn-danger" id="bCheckOut" disabled="true">Check Out</button>
					<button type="button" class="btn btn-primary" id="bBack">Back</button>
				</div>
			</div>
		</div>
		<!-- Message Container -->
		<div id="contentMessages">
			<div id="loading" class="alert alert-primary">Loading...</div>
		</div>
		<!-- Registry Content -->
		<div id="registryContent">
			<div id="rName"></div>
			<div id="rLocation"></div>
			<div id="rdCheckIn"></div>
			<div id="rdCheckOut"></div>
			<div id="rTotalTime"></div>
		</div>
	</div>
	<!-- -- -->
	<style type="text/css">
		#loading, #stopWatch, #bBack, #registryContent{
	    	display: none;
		}
	</style>
	<script type="text/javascript">

		//The function that is made when the window is load
		window.onload = function() {

			getSupervisors();
			dataVerification();
			
	    }


	    //The supervisors are obtained
	    function getSupervisors(){

	    	axios.get("<?php echo site_url('supervisor') ?>",{
				responseType: 'json'
			}).then(function(res) {
				if (res.status == 200) {
					var cont = "<option value=0>Select Supervisor</option>";
					for(var obj of res.data) {
						cont += "<option value="+obj.n_IdUser+">"+obj.t_Name+"</option>";
					}
					document.getElementById('nSup').innerHTML = cont;
				}

			}).catch(function(err) {

				swal({
		  			text: "Something went wrong with the supervisors please reload the page",
					icon: "error",
				});
				console.log(err);
			});
	    }


	    //Check if a service is still active, if so, resume the stopwatch with the same service
	    function dataVerification(){

	    	if (window.localStorage.getItem("idService") != null) {

				idService = parseInt(window.localStorage.getItem("idService"), 10);
				stopwatch.style.display = 'flex';
	  			bodyForm.style.display = 'none';
	  			button.disabled = true;
	  			buttonStop.disabled = false;

	  			initialTime = parseInt(window.localStorage.getItem("initialTime"), 10);

		  		chronometer = setInterval('start()', 1000);

				
			}
	    }


	    //There are selected the button for check and the div for load message
	    var button = document.getElementById('bCheckIn');
	    var loading = document.getElementById('loading');

	    var objRequest;
	    
	    button.addEventListener('click', function() {
			
			validation();

	    });	

	    function validation(){

	    	let name = document.getElementById('uName');
			let estab = document.getElementById('nEst');
			let sup = document.getElementById('nSup');

			name.className = "form-control";
			estab.className = "form-control";
			sup.className = "custom-select";

	    	if (name.value == "") {

	    		name.className = "form-control is-invalid";

				return false;

			}else if (estab.value == "") {

				estab.className = "form-control is-invalid";
				
				return false;

			}else if (sup.value == 0) {

				sup.className = "custom-select is-invalid";

				return false;

			}else{

				name.className = "form-control";
				estab.className = "form-control";
				sup.className = "custom-select";

				objRequest = {
					UName: name,
		          	NEst: estab,
		          	NSup: sup
				}

				geo("In");
			}
	    }

	    //There are selectd the stopwatch and the form check for switch between one and other
		var stopwatch = document.getElementById('stopWatch');
	    var bodyForm = document.getElementById('formCheck');
	    var buttonStop = document.getElementById('bCheckOut');
	    var buttonBack = document.getElementById('bBack');
	    var chronometer;
	    var initialTime;
	    var idService;


	    //With this function the check in is registered
	    function request(lati,long){
	    	var coords = {
	    		lati: lati,
	    		long: long
	    	}

	    	data = Object.assign(objRequest, coords);

	      	axios.post("<?php echo site_url('checkIn') ?>", data
		  	).then(function(res) {
		  		
		  		if (res.data) {

		  			stopwatch.style.display = 'flex';
		  			bodyForm.style.display = 'none';
		  			button.disabled = true;
		  			buttonStop.disabled = false;

		  			initialTime = Date.now();
		  			chronometer = setInterval('start()', 1000);

		  			window.localStorage.setItem("idService",`${res.data}`);
		  			window.localStorage.setItem("initialTime", `${initialTime}`);

		  			idService = res.data;
		  			
		  			document.getElementById('uName').value = "";
					document.getElementById('nEst').value = "";
					document.getElementById('nSup').value = 0;

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


	    //This variables are declared for the stopwatch
	    var HH = 0;
		var mm = 0;
		var ss = 0;
		var difference = 0;
		var time = 0;
		var currentTime;
		var totalHours;


		//Here the stopwatch is initialized
		function start(){

			currentTime = Date.now();
			difference = currentTime - initialTime;
			time = new Date(difference);

			HH = time.getUTCHours();
			mm = time.getUTCMinutes();
			ss = time.getUTCSeconds();

			var count = (HH<10 ?  "0"+HH : HH)+" : "+(mm<10 ? "0"+mm : mm)+" : "+(ss<10 ? "0"+ss : ss);

			document.getElementById('contStopWatch').innerHTML = count;

			totalHours = HH+":"+mm+":"+ss;
		}


		//For stop the stopwatch, the event is added to this button for the check out
		buttonStop.addEventListener('click', function(){

			geo("Out");
			
			clearInterval(chronometer);
		});


		//Here the check out is registered
		function stop(lati,long){

			var data = {
				NServ: idService,
				NTotal: totalHours,
				Lati: lati,
	          	Long: long
			}

			axios.post("<?php echo site_url('checkOut') ?>", data
			).then(function(res) {

				if(res.data){
					swal({
						text: "Check Out Successfully",
						icon: "success",
					});
					buttonStop.disabled = true;
					buttonBack.style.display = 'block';


					document.getElementById('registryContent').style.display = 'block';

					document.getElementById('rName').innerHTML = "Name : "+res.data[0].t_UserName;

					document.getElementById('rLocation').innerHTML = "Establishment : "+res.data[0].t_Establishment;

					document.getElementById('rdCheckIn').innerHTML = "Check In : "+moment(res.data[0].dt_CheckIn, "YYYY-MM-DD HH:mm:ss").format("MMMM DD YYYY, h:mm:ss a");
					
					document.getElementById('rdCheckOut').innerHTML = "Check Out : "+moment(res.data[0].dt_CheckOut, "YYYY-MM-DD HH:mm:ss").format("MMMM DD YYYY, h:mm:ss a");
					
					document.getElementById('rTotalTime').innerHTML = "Total time : "+res.data[0].ti_TotalHours;

					window.localStorage.clear();

				}else{
					swal({
						text: "Something went wrong",
						icon: "error",
					});
				}

			}).catch(function(err){

				swal({
		  			text: "Something went wrong please try again or later",
					icon: "error",
				});
				console.log(err);

			}).then(function(){

				loading.style.display = 'none';
			});
		}


		//This function si to get the user coords and call the respective function
		function geo(check){

			if (navigator.geolocation) {
				loading.style.display = 'block';
				navigator.geolocation.getCurrentPosition(function(location){
					var lati = location.coords.latitude;
					var long = location.coords.longitude;

					if (check == "In") {

				    	request(lati,long);

				    }else if (check == "Out") {

				    	stop(lati,long);
				    }
					

				}, function(err){
					swal({
						title: "Error: "+err.code,
						text: err.message,
						icon: "error",
					});
					loading.style.display = 'none';
				});	
			} else {
				swal({
					text: "¡Ups! The API is not supported in this browser, try in another browser",
					icon: "warning",
				});
			}
		}


		//For this case the event is added to this button for clean and come back to the form
		buttonBack.addEventListener('click', function() {
			document.getElementById('registryContent').style.display = 'none';
			button.disabled = false;
			buttonBack.style.display = 'none';
			stopwatch.style.display = 'none';
			document.getElementById('contStopWatch').innerHTML = " 00 : 00 : 00 ";
			bodyForm.style.display = 'block';
		});
	</script>