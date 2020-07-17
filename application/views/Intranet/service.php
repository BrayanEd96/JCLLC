<body>
	<div id="container">
		<div id="title">
			<h1>Start to work</h1>
		</div>
		<div id="body">
			<form id="formCheck">
				<div class="row">
					<label for="uName">User Name</label>
					<input type="text" name="userName" id="uName" placeholder="Name">
				</div>
				<div class="row">
					<label for="nEst">Establishment</label>
					<select name="location" id="nEst">
					</select>
				</div>
			</form>
			<div id="stopWatch">
				<div id="contStopWatch"> 00 : 00 : 00 </div>
			</div>
			<div id="buttonsContainer">
				<button type="button" id="bCheckIn">Check In</button>
				<button type="button" id="bCheckOut">Check Out</button>
				<button type="button" id="bBack">Back</button>
			</div>
		</div>
		<div id="contentMessages">
			<div id="message">Mientras tanto aquisdfs	 pasandola relax</div>
			<div id="loading">Cargando...</div>
		</div>
		<div id="registryContent">
			<div id="rName"></div>
			<div id="rLocation"></div>
			<div id="rdCheckIn"></div>
			<div id="rtCheckIn"></div>
			<div id="rdCheckOut"></div>
			<div id="rtCheckOut"></div>
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
    }

    var message = document.getElementById('message');	
    var button = document.getElementById('bCheckIn');

    var name;
	var estab;
    
    button.addEventListener('click', function() {

    	name = document.getElementById('uName').value;
		estab = document.getElementById('nEst').value;

    	if (validation()) {
    		request();
       	}

    });	

    function validation(){

    	if (name == "") {
    		message.innerHTML = "Insert your name";
    		message.style.display = 'block';
    		setTimeout(function() {
    			message.style.display = 'none';
    		}, 3000);
			return false;
		}else if (estab == 0) {
			message.innerHTML = "Select a Establishment";
    		document.getElementById('nEst').value = 0;
			message.style.display = 'block';
			setTimeout(function() {
    			message.style.display = 'none';
    		}, 3000);
			return false;
		}else{
			return true;
		}
    }


	var loading = document.getElementById('loading');
	var stopwatch = document.getElementById('stopWatch');
    var bodyForm = document.getElementById('formCheck');
    var buttonStop = document.getElementById('bCheckOut');
    var buttonBack = document.getElementById('bBack');
    var chronometer;
    var initialTime;
    var idService;

    function request(){
    	var data = {
			UName: name,
          	NEst: estab
		}
    	
      	loading.style.display = 'block';

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

		stop();
		clearInterval(chronometer);
	});

	function stop(){
		var data = {
			NServ: idService,
			NTotal: totalHours
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

				var tIn = new Date(res.data[0].dt_CheckIn.replace(/\s/, 'T'));
				var tOut = new Date(res.data[0].dt_CheckOut.replace(/\s/, 'T'));
				var iH = tIn.getHours();
				var iM = tIn.getMinutes();
				var iS = tIn.getSeconds();
				var oH = tOut.getHours();
				var oH = tOut.getMinutes();
				var oH = tOut.getSeconds();

				document.getElementById('registryContent').style.display = 'block';

				document.getElementById('rName').innerHTML = "Name : "+res.data[0].t_UserName;

				document.getElementById('rLocation').innerHTML = "Establishment : "+res.data[0].t_NameEst;

				document.getElementById('rdCheckIn').innerHTML = "Check In : "+tIn;
				
				document.getElementById('rdCheckOut').innerHTML = "Check Out : "+tOut;
				
				document.getElementById('rTotalTime').innerHTML = "Total time : "+res.data[0].ti_TotalHours;

			}else{
				swal({
					text: "Something went wrong",
					icon: "error",
				});
			}

		}).catch(function(err){
			console.log(err);
		});
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