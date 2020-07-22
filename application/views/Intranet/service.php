<body>
	<div class="container">
		<div class="row" id="title">
			<div class="col d-flex">
				<h1>Start to work</h1>
			</div>
		</div>
		<div class="container">
			<div id="main" class="container-fluid">
				<form id="formCheck">
					<div class="form-group">
						<label for="uName">User Name</label>
						<input type="text" class="form-control" name="userName" id="uName" placeholder="Name">
					</div>
					<div class="form-group">
						<label for="nEst">Establishment</label>
						<select name="location" class="form-control" id="nEst">
						</select>
					</div>
					<div class="form-group">
						<label for="nSup">Supervisor</label>
						<select name="supervisor" class="form-control" id="nSup">
						</select>
					</div>
				</form>
				<div id="stopWatch">
					<div id="contStopWatch"> 00 : 00 : 00 </div>
				</div>
				<div id="buttonsContainer">
					<button type="button" class="btn btn-success" id="bCheckIn">Check In</button>
					<button type="button" class="btn btn-danger" id="bCheckOut">Check Out</button>
					<button type="button" class="btn btn-primary" id="bBack">Back</button>
				</div>
			</div>
		</div>
		<div id="contentMessages">
			<div id="message" class="alert alert-warning">Something...</div>
			<div id="loading" class="alert alert-primary">Loading...</div>
		</div>
		<div id="registryContent">
			<div id="rName"></div>
			<div id="rLocation"></div>
			<div id="rdCheckIn"></div>
			<div id="rdCheckOut"></div>
			<div id="rTotalTime"></div>
		</div>
	</div>
</body>
<style type="text/css">
	#loading, #message, #stopWatch, #bBack, #registryContent{
    	display: none;
	}
</style>
<script type="text/javascript">

	window.onload = function() {

		axios.get("<?php echo site_url('location') ?>",{
			responseType: 'json'
		}).then(function(res) {
			if (res.status == 200) {
				var cont = "<option value=0>Select Establishment</option>";
				for(var obj of res.data) {
					cont += "<option value="+obj.n_IdEstablishment+">"+obj.t_NameEst+"</option>";
				}
				document.getElementById('nEst').innerHTML = cont;
			}

		}).catch(function(err) {
			console.log(err);
		});

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
			console.log(err);
		});

    }

    var message = document.getElementById('message');	
    var button = document.getElementById('bCheckIn');
    var loading = document.getElementById('loading');

    var name;
	var estab;
    
    button.addEventListener('click', function() {

    	name = document.getElementById('uName').value;
		estab = document.getElementById('nEst').value;
		sup = document.getElementById('nSup').value;
		
		if (validation()) {
    		geo("In");
       	}

    });	

    function validation(){

    	if (name == "") {
    		message.innerHTML = "Insert your name";
    		message.style.display = 'block';
    		setTimeout(function() {
    			message.style.display = 'none';
    		}, 2000);
			return false;
		}else if (estab == 0) {
			message.innerHTML = "Select a Establishment";
    		document.getElementById('nEst').value = 0;
			message.style.display = 'block';
			setTimeout(function() {
    			message.style.display = 'none';
    		}, 2000);
			return false;
		}else if (sup == 0) {
			message.innerHTML = "Select a Supervisor";
    		document.getElementById('nSup').value = 0;
			message.style.display = 'block';
			setTimeout(function() {
    			message.style.display = 'none';
    		}, 2000);
			return false;
		}else{
			return true;
		}
    }


	var stopwatch = document.getElementById('stopWatch');
    var bodyForm = document.getElementById('formCheck');
    var buttonStop = document.getElementById('bCheckOut');
    var buttonBack = document.getElementById('bBack');
    var chronometer;
    var initialTime;
    var idService;

    function request(lati,long){

    	var data = {
			UName: name,
          	NEst: estab,
          	NSup: sup,
          	Lati: lati,
          	Long: long
		}

      	axios.post("<?php echo site_url('checkIn') ?>", data
	  	).then(function(res) {
	  		
	  		if (res.data) {

	  			stopwatch.style.display = 'flex';
	  			bodyForm.style.display = 'none';
	  			button.disabled = true;

	  			initialTime = Date.now();
	  			chronometer = setInterval('start()', 1000);

	  			idService = res.data;
	  			
	  			document.getElementById('uName').value = "";
				document.getElementById('nEst').value = 0;
				document.getElementById('nSup').value = 0;

	  		}else{
	  			message.innerHTML = "Something with the establishment was wrong";
	  		}

	  	}).catch(function(err) {

	      	console.log(err);

	  	}).then(function() {

	      	loading.style.display = 'none';

	    });
    }

    var HH = 0;
	var mm = 0;
	var ss = 0;
	var difference = 0;
	var time = 0;
	var currentTime;
	var totalHours;

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

	buttonStop.addEventListener('click', function(){

		geo("Out");
		
		clearInterval(chronometer);
	});

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

				document.getElementById('rLocation').innerHTML = "Establishment : "+res.data[0].t_NameEst;

				document.getElementById('rdCheckIn').innerHTML = "Check In : "+res.data[0].dt_CheckIn;
				
				document.getElementById('rdCheckOut').innerHTML = "Check Out : "+res.data[0].dt_CheckOut;
				
				document.getElementById('rTotalTime').innerHTML = "Total time : "+res.data[0].ti_TotalHours;

			}else{
				swal({
					text: "Something went wrong",
					icon: "error",
				});
			}

		}).catch(function(err){

			console.log(err);

		}).then(function(){

			loading.style.display = 'none';
		});
	}

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

	buttonBack.addEventListener('click', function() {
		document.getElementById('registryContent').style.display = 'none';
		button.disabled = false;
		buttonStop.disabled = false;
		buttonBack.style.display = 'none';
		stopwatch.style.display = 'none';
		document.getElementById('contStopWatch').innerHTML = " 00 : 00 : 00 ";
		bodyForm.style.display = 'block';
	});

</script>