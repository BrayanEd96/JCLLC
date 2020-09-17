<!-- General Container -->
<div class="container">
	<div class="row ">
		<!-- Title of Section -->
		<div class="col col-md-4" id="title">
			<h2>Checks</h2>
			<!-- Buttons for different actions from module -->
			<button class="btn btn-primary mx-2" id="allRegistry">All</button>
			<button class="btn btn-primary mx-2" id="todayRegistry">Today</button>
			<button class="btn btn-primary mx-2" id="yesterdayRegistry">Yesterday</button>
		</div>
	</div>
	<div class="table-responsive-md" id="table-section">
		<!-- The table for show the results -->
		<table class="table table-striped table table-bordered" id="tableChecks">
			<thead class="thead-light" id="thead">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Employee Name</th>
					<th scope="col">Supervisor</th>
					<th scope="col">Establishment</th>
					<th scope="col">Check In</th>
					<th scope="col">Coords</th>
					<th scope="col">Check Out</th>
					<th scope="col">Coords</th>
					<th scope="col">Total Hours</th>
				</tr>
			</thead>
			<tbody id="tbody">
				
			</tbody>
		</table>
	</div>
	<!-- The Modal to edit check information-->
	<div class="modal fade" id="editInfo" tabindex="-1" aria-labelledby="editInfo" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit the Information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
        			</button>
    			</div>
    			<div class="modal-body">
    				<div class="container">
    					<div class="row">
    						<div class="col-md-6">
			        			<div class="form-group">
			        				<label for="eName">Employee</label>
			        				<input class="form-control" type="text" name="employeName" id="eName">
			        				<div class="invalid-feedback" id="validName">
			        					This field cannot be empty
			        				</div>
			        			</div>
			        			<div class="form-group">
			        				<label for="sName">Supervisor</label>
			        				<select class="custom-select" name="supervisorName" id="sName"></select>
			        				<div class="invalid-feedback" id="validSup">
			        					You must select a supervisor
			        				</div>
			        			</div>
			        			<div class="form-group">
			        				<label for="estab">Establishment</label>
			        				<input class="form-control" type="text" name="establishment" id="estab">
			        				<div class="invalid-feedback" id="validEstab">
			        					This field cannot be empty
			        				</div>
			        			</div>
    						</div>
    						<div class="col-md-6">
    							<div class="form-group">
			        				<label for="inCoords">Check In Coords</label>
			        				<input class="form-control" type="text" name="checkInCoords" id="inCoords" readonly="true">
			        			</div>
			        			<div class="form-group">
			        				<label for="outCoords">Check Out Coords</label>
			        				<input class="form-control" type="text" name="checkOutCoords" id="outCoords" readonly="true">
			        			</div>
			        			<div class="d-flex">
			        				<button id="viewMap" type="button" class="btn btn-primary m-auto" data-dismiss="modal" data-toggle="modal" data-target="#modalMap">
				        				View Map
				        			</button>
			        			</div>
    						</div>
    					</div>
    					<div class="row" id="onlyAdmin">
	        				<div class="col-md-6">
	        					<div class="form-group">
			        				<label for="eCheckIn">Check In</label>
			        				<input class="form-control" type="text" name="employeCheckIn" id="eCheckIn">
			        				<div class="invalid-feedback" id="validCheckIn">
			        					This field cannot be empty
			        				</div>
			        			</div>
	        				</div>
	        				<div class="col-md-6">
	        					<div class="form-group">
			        				<label for="eCheckOut">Check Out</label>
			        				<input class="form-control" type="text" name="employeCheckOut" id="eCheckOut">
			        				<div class="invalid-feedback" id="validCheckOut">
			        					This field cannot be empty
			        				</div>
			        			</div>
	        				</div>
	        			</div>
    				</div>
      			</div>
    			<div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" id="saveChanges">Save</button>
    			</div>
    		</div>
		</div>
	</div>
	<!-- The Modal to show cheks in the map-->
	<div class="modal fade" id="modalMap" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
    			<div class="modal-header">
       				<h5 class="modal-title">Map</h5>
      			</div>
			    <div class="modal-body">
			    	<div id="map" class="mx-auto" style='width: 400px; height: 300px;'></div>
			    </div>
	    		<div class="modal-footer">
			        <button id="hideMap" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	    		</div>
	    	</div>
		</div>
	</div>
</div>
<!-- -- -->

<script type="text/javascript">

	//The function that is made when the window is load
	window.onload = function(){

		userKind = <?php echo $userKind ?>;
		if (userKind != 1) {
			document.getElementById('onlyAdmin').hidden = true;
		}

		postRequest(moment(new Date()).format("YYYY-MM-DD"));
	}

	//General Variables
	var kindRegistry = 'today';
	var table;
	var existTable = false;
	var userKind;

	//The initialization of map
	mapboxgl.accessToken = 'pk.eyJ1IjoiYnJheWFuZSIsImEiOiJja2UzZDdoOWowZXJ3MnJwYnQ3N2NtemNoIn0.Ht6vI7yMoIx19pIKCl7NgA';
	var map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: [-119.122085, 35.312933],
		zoom: 13
	});


	//The save button is selectd and is added an event to save changes
	var changesButton = document.getElementById('saveChanges');
	changesButton.addEventListener('click', validateChanges);
	var dataIdService;


	//The view button is selected and is added an event to shows the map with markers, and some variables for this function 
	var viewButton = document.getElementById('viewMap');
	viewButton.addEventListener('click', addMarkers);
	var dataLatIn;
	var dataLngIn;
	var dataLatOut;
	var dataLngOut;


	//This function is to get and show the supervisors
	function loadSupervisors(idSup){
		axios.get("<?php echo site_url('supervisor') ?>",{
			responseType: 'json'
		}).then(function(res) {
			if (res.status == 200) {
				var cont = "<option value=0>Select Supervisor</option>";
				for(var obj of res.data) {
					if (obj.n_IdUser != idSup) {
						cont += "<option value="+obj.n_IdUser+">"+obj.t_Name+"</option>";
					}else{
						cont += "<option value="+obj.n_IdUser+" selected>"+obj.t_Name+"</option>";
					}
				}
				document.getElementById('sName').innerHTML = cont;
			}

		}).catch(function(err) {

			swal({
	  			text: "Something went wrong with the supervisors please reload the page",
				icon: "error",
			});
			console.log(err);
		});
	}


	//This variables are declared to add marks to the map
	var mIn = null;
	var mOut = null;


	//The function to draws the map with their content
	function addMarkers(){
		let latIn = dataLatIn;
		let lngIn = dataLngIn;
		let latOut = dataLatOut;
		let lngOut = dataLngOut;

		if (isNaN(latIn) == false && isNaN(lngIn) == false) {
			mIn = new mapboxgl.Marker({
				color: '#28a745',
				scale: 0.8
			}).setLngLat([parseFloat(lngIn), parseFloat(latIn)]).addTo(map);
			map.setCenter([parseFloat(lngIn), parseFloat(latIn)]);
		}
		if (isNaN(latOut) == false && isNaN(lngOut) == false) {
			mOut = new mapboxgl.Marker({
				color: '#dc3545',
				scale: 0.8
			}).setLngLat([parseFloat(lngOut), parseFloat(latOut)]).addTo(map);	
		}
	}


	//To this button is added an event to close the modal map and cleans it
	var closeMap = document.getElementById('hideMap');
	closeMap.addEventListener('click', function(){
		deleteMarks();
	});


	//The function to delete marks
	function deleteMarks(){
		if (mIn != null) {
			mIn.remove();
			mIn = null;
		}
		if (mOut != null) {
			mOut.remove();
			mOut = null;
		}
	}	


	//Here the registers are obtained and showed
	function postRequest(param) {
		axios.post("<?php echo site_url('checks') ?>",{
			Date: param
		}).then(function(res) {
			
			if (res.status == 200) {
				loadTable(res.data);
			}

		}).catch(function(err) {

			swal({
	  			text: "Something went wrong with the checks please reload the page",
				icon: "error",
			});
			console.log(err);
		});
	}


	//Here are selected a button to add an event to show all the registers today
	var buttonAll = document.getElementById('allRegistry');
	buttonAll.addEventListener('click', function(){
		kindRegistry = 'all';
		getRequest();
	});


	//This function get and show the registers
	function getRequest(){
		axios.get("<?php echo site_url('checks') ?>",{
			responseType: 'json'
		}).then(function(res) {
			
			if (res.status == 200) {
				loadTable(res.data);
			}

		}).catch(function(err){

			swal({
	  			text: "Something went wrong with the checks please reload the page",
				icon: "error",
			});
			console.log(err);
		});
	}


	//Here are selected a button to add an event to show all today registers
	var buttonToday = document.getElementById('todayRegistry');
	buttonToday.addEventListener('click', function(){
		kindRegistry = 'today';
		postRequest(moment(new Date()).format("YYYY-MM-DD"));
	});


	//Here are selected a button to add an event to show all yesterday registers
	var buttonYesterday = document.getElementById('yesterdayRegistry');
	buttonYesterday.addEventListener('click', function(){
		kindRegistry = 'yesterday';
		postRequest(moment(new Date()).subtract(1,'d').format("YYYY-MM-DD"));
	})


	//This function is calls when the regiters are obtained and it must to load in the table and the rows events
	function loadTable(reg){
		var registry = null;
		if (reg != false) {
			for(var obj of reg) {
				let checki = obj.dt_CheckIn;
				let checko = obj.dt_CheckOut;
				obj.dt_CheckIn = (obj.dt_CheckIn!=null ? moment(obj.dt_CheckIn, "YYYY-MM-DD HH:mm:ss").format("MMMM DD YYYY, hh:mm:ss a") : "No Date");
				obj.dt_CheckOut = (obj.dt_CheckOut!=null ? moment(obj.dt_CheckOut, "YYYY-MM-DD HH:mm:ss").format("MMMM DD YYYY, hh:mm:ss a") : "No Date");

				obj.de_LatitudeCheckIn = (obj.de_LatitudeCheckIn!=null ? obj.de_LatitudeCheckIn : "Empty");
				obj.de_LongitudeCheckIn = (obj.de_LongitudeCheckIn!=null ? obj.de_LongitudeCheckIn : "Empty");
				obj.de_LatitudeCheckOut = (obj.de_LatitudeCheckOut!=null ? obj.de_LatitudeCheckOut : "Empty");
				obj.de_LongitudeCheckOut = (obj.de_LongitudeCheckOut!=null ? obj.de_LongitudeCheckOut : "Empty");

				obj.ti_TotalHours = (obj.ti_TotalHours!=null ? obj.ti_TotalHours : "Empty");
				var coords = {
					in_Coords: obj.de_LatitudeCheckIn+", "+obj.de_LongitudeCheckIn,
					out_Coords: obj.de_LatitudeCheckOut+", "+obj.de_LongitudeCheckOut,
					CheckIn: checki,
					CheckOut: checko
				}

				obj = Object.assign(obj,coords);
			}
			registry = reg;
		}

		if (existTable != false) {
			table.destroy();
			document.getElementById('tbody').innerHTML = "";
		}

		table = $('#tableChecks').DataTable({
			data: registry,
			columns: [
		        { data: 'n_IdService' },
		        { data: 't_UserName' },
		        { data: 't_Name' },
		        { data: 't_Establishment' },
		        { data: 'dt_CheckIn' },
		        { data: 'in_Coords' },
		        { data: 'dt_CheckOut' },
		        { data: 'out_Coords' },
		        { data: 'ti_TotalHours' }
		    ],
		    "order": [[ 0, 'desc' ]]
		});

		$('#tableChecks tbody').on('click', 'tr', function () {
			var data = table.row(this).data();
			let eName = document.getElementById('eName');
			let estab = document.getElementById('estab');
			let iCoords = document.getElementById('inCoords');
			let oCoords = document.getElementById('outCoords');
			let checkI = document.getElementById('eCheckIn');
			let checkO = document.getElementById('eCheckOut');


			loadSupervisors(data['n_IdSupervisor']);

			eName.value = data['t_UserName'];
			eName.className = "form-control";
			estab.value = data['t_Establishment'];
			estab.className = "form-control";
			checkI.value = data['CheckIn'];
			checkI.className = "form-control";
			checkO.value = data['CheckOut'];
			checkO.className = "form-control";


			iCoords.value = data["de_LatitudeCheckIn"]+", "+data["de_LongitudeCheckIn"];
			oCoords.value = data["de_LatitudeCheckOut"]+", "+data["de_LongitudeCheckOut"];
			$('#editInfo').modal('show');

			dataIdService = data['n_IdService'];
			dataLatIn = data["de_LatitudeCheckIn"];
			dataLngIn = data["de_LongitudeCheckIn"];
			dataLatOut = data["de_LatitudeCheckOut"];
			dataLngOut = data["de_LongitudeCheckOut"];
		});


		existTable = true;

	}


	//Here the changes of checks are saved
	function changes(obj){
		axios.post("<?php echo site_url('change') ?>", obj
		).then(function(res){

			if (res.status == 200) {
				if (res.data) {
					swal({
			  			text: "Changes were saved successfully",
						icon: "success",
					});

					$('#editInfo').modal('hide');

					switch(kindRegistry){
						case 'all':
							getRequest();
							break;

						case 'today':
							postRequest(moment(new Date()).format("YYYY-MM-DD"));
							break;

						case 'yesterday':
							postRequest(moment(new Date()).subtract(1,'d').format("YYYY-MM-DD"));
							break;
					}

					
				}else{

					swal({
			  			text: "Something went wrong with the changes please try again",
						icon: "error",
					});	
				}
			}

		}).catch(function(err){

			swal({
	  			text: "Something went wrong with the changes please try again",
				icon: "error",
			});
			console.log(err);

		});
		
	}


	//In this function the new content to register are validated to save it
	function validateChanges(){
		let id = dataIdService;
		let eName  = document.getElementById('eName');
		let sName  = document.getElementById('sName');
		let estab = document.getElementById('estab');
		let eCheckIn = document.getElementById('eCheckIn');
		let eCheckOut = document.getElementById('eCheckOut');
		let totalHours = null;
		let checkOut = null;

		eName.className = "form-control";
		sName.className = "custom-select";
		estab.className = "form-control";
		eCheckIn.className = "form-control";

    	if (eName.value == "") {

    		eName.className = "form-control is-invalid";

			return false;

		}else if (sName.value == 0) {

			sName.className = "custom-select is-invalid";
			
			return false;

		}else if (estab.value == "") {

			estab.className = "form-control is-invalid";
			
			return false;

		}else if(userKind == 1){
			if (eCheckIn.value == "") {

				eCheckIn.className = "form-control is-invalid";
				return false;

			}else{

				eName.className = "form-control";
				sName.className = "custom-select";
				estab.className = "form-control";
				eCheckIn.className = "form-control";

				if (eCheckOut.value != "") {
					totalHours = calculateHours(eCheckIn.value, eCheckOut.value);
					checkOut = eCheckOut.value;
				}
				
				var employeObject = {
					Id: id,
					Employee: eName.value,
					Sup: sName.value,
					Estab: estab.value,
					CheckIn: eCheckIn.value,
					CheckOut: checkOut,
					TotalHours: totalHours
				}

				changes(employeObject);
			}
		}else{

			eName.className = "form-control";
			sName.className = "custom-select";
			estab.className = "form-control";

			if (eCheckOut.value != "") {
					totalHours = calculateHours(eCheckIn.value, eCheckOut.value);
					checkOut = eCheckOut.value;
				}
			
			var employeObject = {
				Id: id,
				Employee: eName.value,
				Sup: sName.value,
				Estab: estab.value,
				CheckIn: eCheckIn.value,
				CheckOut: checkOut,
				TotalHours: totalHours
			}

			changes(employeObject);
		}
	}


	//This funnction calculate the hours to the new values of registers
	function calculateHours(checkI, checkO){
		let CheckI = new Date(checkI);
		let CheckO = new Date(checkO);
		let difference = CheckO - CheckI;
		let time = new Date(difference);
		let total = time.getUTCHours() + ":" + time.getUTCMinutes() + ":" + time.getUTCSeconds();

		return total;
	}

</script>