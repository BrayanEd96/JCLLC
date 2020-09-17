<!-- General Container -->
<div class="container">
	<div class="row ">
		<!-- Title of Section -->
		<div class="col col-xl-6 col-lg-8 col-md-10" id="title">
			<h2>Vendors</h2>
			<!-- Buttons for different actions from module -->
			<div id="headerButtons" class="row">
				<div class="col-md-4 mb-3">
					<button class="btn btn-primary mx-2" id="newRegistry" data-toggle="modal" data-target="#modalVendor">Add Vendor</button>
				</div>
				<div class="col-md-8 mb-3">
					<button class="btn btn-primary mx-2" id="viewGeneral">View General</button>
					<button class="btn btn-primary mx-2" id="viewCanceled">View Canceled</button>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive-xl" id="table-section">
		<!-- The table for show the results -->
		<table class="table table-striped table table-bordered" id="tableVendors">
			<thead class="thead-light" id="thead">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Company Name</th>
					<th scope="col">Address</th>
					<th scope="col">Phone Number</th>
					<th scope="col">State</th>
					<th scope="col">City</th>
					<th scope="col">Status</th>
				</tr>
			</thead>
			<tbody id="tbody">
				
			</tbody>
		</table>
	</div>
	<!-- The Modal to register a vendor-->
	<div class="modal fade" id="modalVendor" data-backdrop="static" tabindex="-1" aria-labelledby="titleVendor" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
	    	<div class="modal-content">
	    		<div class="modal-header">
	        		<h5 class="modal-title" id="titleVendor">Add a new vendor</h5>
	      		</div>
			    <div class="modal-body">
			    	<div class="form-row">
						<div class="form-group col-md-6">
							<label for="VName">Company Name</label>
						    <input type="text" class="form-control" id="VName">
						    <div class="invalid-feedback" id="validVName">
	        					This field cannot be empty
	        				</div>
						</div>
						<div class="form-group col-md-6">
							<label for="VAddress">Address</label>
						    <input type="text" class="form-control" id="VAddress">
						    <div class="invalid-feedback" id="validVAddress">
	        					This field cannot be empty
	        				</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="VPhone">Phone Number</label>
						    <input type="text" class="form-control" id="VPhone">
						    <div class="invalid-feedback" id="validVPhone">
	        					This field cannot be empty
	        				</div>
						</div>
						<div class="form-group col-md-6">
							<label for="VEmail">E-mail</label>
						    <input type="text" class="form-control" id="VEmail">
						    <div class="invalid-feedback" id="validVEmail">
	        					This field cannot be empty
	        				</div>
	        				<small>Optional</small>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="VContact">Contact</label>
						    <input type="text" class="form-control" id="VContact">
						    <div class="invalid-feedback" id="validVContact">
	        					This field cannot be empty
	        				</div>
						</div>
						<div class="form-group col-md-6">
							<label for="VTax">Tax Id</label>
						    <input type="text" class="form-control" id="VTax">
						    <div class="invalid-feedback" id="validVTax">
	        					This field cannot be empty
	        				</div>
	        				<small>Optional</small>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="VState">State</label>
						    <select class="custom-select" id="VState">
						    	<option value=0>Select State</option>
						    </select>
						    <div class="invalid-feedback" id="validVState">
	        					This field cannot be empty
	        				</div>
						</div>
						<div class="form-group col-md-6">
							<label for="VCity">City</label>
						    <select class="custom-select" id="VCity" disabled="true">
						    	<option value=0>Select City</option>
						    </select>
						    <div class="invalid-feedback" id="validVCity">
	        					This field cannot be empty
	        				</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="VServices">Type of Services</label>
						    <textarea class="form-control" id="VServices"></textarea>
						    <div class="invalid-feedback" id="validVServices">
	        					This field cannot be empty
	        				</div>
	        				<small>Services separated by commas</small>
						</div>
						<div class="form-group col-md-6">
							<label for="VPlacesCovered">Places Covered</label>
						    <textarea class="form-control" id="VPlacesCovered"></textarea>
						    <div class="invalid-feedback" id="validVPlacesCovered">
	        					This field cannot be empty
	        				</div>
	        				<small>State or State/City  separated by commas</small>
						</div>
					</div>
			    </div>
	    		<div class="modal-footer">
	        		<button type="button" class="btn btn-primary" id="saveVendor">Save</button>
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalVendor">Close</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- The Modal to view the vendor information -->
	<div class="modal fade" id="viewInfo" tabindex="-1" aria-labelledby="viewInfoTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewInfoTitle">About them</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
        			</button>
    			</div>
    			<div class="modal-body">
    				<div class="container">
    					<div class="row">
    						<div class="col-md-6">
    							<div class="mb-4">
	    							<label class="font-weight-bold">E-mail</label>
				        			<div id="email"></div>
    							</div>
    							<div class="mb-4">
    								<label class="font-weight-bold">Contact info</label>
				        			<div id="contact"></div>
    							</div>
    						</div>
    						<div class="col-md-6">
    							<div class="mb-4">
    								<label class="font-weight-bold">Services provided</label>
				        			<div id="services"></div>
    							</div>
    							<div class="mb-4">
	    							<label class="font-weight-bold">Places covered</label>
				        			<div id="places"></div>
    							</div>
    							<div class="mb-4">
    								<label class="font-weight-bold">Tax Id</label>
			        				<div id="taxId"></div>
    							</div>
    						</div>
    					</div>
    				</div>
      			</div>
    			<div class="modal-footer">
    				<div id="footerButtons" class="w-100 d-flex">
				        <button type="button" class="btn btn-primary mr-3" id="restore">Restore</button>
				        <button type="button" class="btn btn-primary mr-auto" id="edit">Edit</button>
				        <button type="button" class="btn btn-primary ml-auto" id="accept">Accept</button>
				        <button type="button" class="btn btn-danger ml-3" id="deny">Deny</button>
	    			</div>		
    			</div>
    		</div>
		</div>
	</div>
</div>
<!-- -- -->

<script type="text/javascript">

	//The function that is made when the window is load
	window.onload = function(){

		postRequest("firstValidating");

		loadStates();
	}


	//Some general variables are declared
	var table;
	var existTable = false;
	var idVendor;
	var objVendor;
	var typeSave = "new";
	var editing = false;


	//The different inputs from the vendors form are obtained for later use
	var vname = document.getElementById('VName');
	var vaddress = document.getElementById('VAddress');
	var vphone = document.getElementById('VPhone');
	var vemail = document.getElementById('VEmail');
	var vcontact =  document.getElementById('VContact');
	var vtax =  document.getElementById('VTax');
	var vstate =  document.getElementById('VState');
	var vcity = document.getElementById('VCity');
	var vservices = document.getElementById('VServices');
	var vplaces = document.getElementById('VPlacesCovered');


	//This function is to get an load the states in the form
	function loadStates(){
		axios.get("<?php echo site_url('states') ?>",{
			responseType: 'json'
		}).then(function(res) {
			
			if (res.data) {
				var cont = "<option value=0>Select State</option>";
				for(var obj of res.data) {
					cont += "<option value="+obj.ID+">"+obj.STATE_NAME+"</option>";
				}
				document.getElementById('VState').innerHTML = cont;

				setEventState();
			}

		}).catch(function(err) {

			swal({
	  			text: "Something went wrong with the states",
				icon: "error",
			});
			console.log(err);
		});
	}


	//Here the change event is assigned to input select when change between states for load the cities
	function setEventState(){
		var state = document.getElementById("VState");
		state.addEventListener('change', function(){
			if (state.value != 0) {
				cityRequest(state.value);
			}
		});
    }


    //The cities are obtained and load in the form
    function cityRequest(idState){
    	axios.post("<?php echo site_url('cities') ?>",{
    		IdState: idState
    	}).then(function(res){

    		if (res.data) {
    			var city = document.getElementById('VCity');
    			city.disabled = false;

				var cont = "<option value=0>Select City</option>";
				for(var obj of res.data) {
					cont += "<option value="+obj.ID+">"+obj.CITY+"</option>";
				}
				city.innerHTML = cont;
			}
    	}).catch(function(err){

    		swal({
	  			text: "Something went wrong with the cities",
				icon: "error",
			});
			console.log(err);
    	});
    }


    //This function is to get and load the vendors
	function postRequest(info){
		axios.post("<?php echo site_url('vendorsQuery') ?>",{
			param: info
		}).then(function(res){

			if(res.status == 200){

				loadTable(res.data);
			}

		}).catch(function(err){

			swal({
	  			text: "Something went wrong with the vendors please reload the page",
				icon: "error",
			});
			console.log(err);

		});
	}


	//Here the table is initialized and click event is added to each one of rows
	function loadTable(obj){
		let registry = null;

		if (obj != false) {
			registry = obj;
		}

		if (existTable != false) {
			table.destroy();
			document.getElementById('tbody').innerHTML = "";
		}


		table = $('#tableVendors').DataTable({
			data: registry,
			columns: [
		        { data: 'n_IdVendor' },
		        { data: 't_VName' },
		        { data: 't_VAddress' },
		        { data: 'n_VPhone' },
		        { data: 't_StateName' },
		        { data: 't_CityName' },
		        { data: 't_Status' }
		    ],
		    "order": [[ 6, 'desc' ],[ 0, 'desc' ]],
		    rowCallback: function(row, data){

		    	if (data.n_Status == 1) {
		    		$('td:eq(6)', row).attr('class','table-primary');
		    	}else if (data.n_Status == 2) {
		    		$('td:eq(6)', row).attr('class','table-warning');
		    	}else if (data.n_Status == 3) {
		    		$('td:eq(6)', row).attr('class','table-danger');
		    	}
		    }

		});

		    
		$('#tableVendors tbody').on('click', 'tr', function () {
	        let data = table.row(this).data();
	        let services = document.getElementById("services");
    		let places = document.getElementById("places");
    		let tax = document.getElementById("taxId");
    		let email = document.getElementById("email");
    		let contactInfo = document.getElementById("contact");
    		let acceptButton = document.getElementById("accept");
    		let denyButton = document.getElementById("deny");
    		let editButton = document.getElementById("edit");
    		let restoreButton = document.getElementById("restore");

    		if (data.n_Status == 1) {
    			cityRequest(data.n_IdState);
    			acceptButton.hidden = true;
    			denyButton.hidden = true;
    			restoreButton.hidden = true;
    			editButton.hidden = false;
    		}else if (data.n_Status == 2) {
    			acceptButton.hidden = false;
    			denyButton.hidden = false;
    			restoreButton.hidden = true;
    			editButton.hidden = true;
    		}else{
    			acceptButton.hidden = false;
    			acceptButton.className = "btn btn-primary mr-auto";
    			denyButton.hidden = true;
    			editButton.hidden = true;
    			restoreButton.hidden = false;
    		}

    		services.innerHTML = data.t_VServices;
    		places.innerHTML = data.t_VPlaces;
    		tax.innerHTML = (data.t_TaxId!=null ? data.t_TaxId : "Empty");
    		email.innerHTML = data.t_VEmail;
    		contactInfo.innerHTML = data.t_VContact;

    		idVendor = data.n_IdVendor;
    		objVendor = data;

    		$('#viewInfo').modal('show');
	    });

		existTable = true;
	}


	//This button is for accept the vendor application
	var buttonAccept = document.getElementById("accept");
	buttonAccept.addEventListener('click', function(){
		validateVendor("accept");
	});

	//This button is for dany the vendor application
	var buttonDeny = document.getElementById("deny");
	buttonDeny.addEventListener('click', function(){
		validateVendor("deny");
	});

	//This button is for restore the vendor application
	var buttonRestore = document.getElementById("restore");
	buttonRestore.addEventListener('click', function(){
		validateVendor("restore");
	});


	//This function is to carry out the different status from vendor application
	function validateVendor(action) {
		let id = idVendor;
		let act = action;
		axios.post("<?php echo site_url('valVendor') ?>",{
			Id: id,
			Action: act
		}).then(function(res){

			if (res.data != false) {

				swal({
		  			text: "The vendor went update successfully",
					icon: "success",
				});

				postRequest("firstValidating");
				$('#viewInfo').modal('hide');

			}else{

				swal({
		  			text: "The vendor doesnt went accepted correctly, try again",
					icon: "warning",
				});
			}

		}).catch(function(err){

			swal({
	  			text: "Something went wrong with the validation please try again",
				icon: "error",
			});
			console.log(err);

		});
	}

	//The click event si added to this button to can edit the different registers from vendors
	var buttonEdit = document.getElementById("edit");
	buttonEdit.addEventListener('click', function(){
		document.getElementById("titleVendor").innerHTML = "Edit vendor";
		editing = true;
		$('#viewInfo').modal('hide');
		$('#viewInfo').on('hidden.bs.modal', function () {
			if (editing == true) {
				editVendor();
				editing = false;
			}
		})
	});


	//This is for add the information to the form and it can edited
	function editVendor(){

		vname.value = objVendor.t_VName
		vaddress.value = objVendor.t_VAddress
		vphone.value = objVendor.n_VPhone
		vemail.value = objVendor.t_VEmail
		vcontact.value =  objVendor.t_VContact
		vtax.value =  objVendor.t_TaxId
		vstate.value =  objVendor.n_IdState
		vcity.value = objVendor.n_IdCity
		vservices.value = objVendor.t_VServices
		vplaces.value = objVendor.t_VPlaces

		typeSave = "update";

		$('#modalVendor').modal('show');
	}


	//Here se event is added to te button to save the changes
	var bSaveVendor = document.getElementById("saveVendor");
	bSaveVendor.addEventListener('click', function(){
		valInfoVendor();
	});


	//This is to validate the form content
	function valInfoVendor(type){

		vname.className = "form-control";
		vaddress.className = "form-control";
		vphone.className = "form-control";
		vcontact.className = "form-control";
		vstate.className = "custom-select";
		vcity.className = "custom-select";
		vservices.className = "form-control";
		vplaces.className = "form-control";

		if (vname.value == "") {

			vname.className = "form-control is-invalid";
			return false;

		}else if (vaddress.value == "") {

			vaddress.className = "form-control is-invalid";
			return false;

		}else if (vphone.value == "") {

			vphone.className = "form-control is-invalid";
			return false;
			
		}else if (vcontact.value == "") {

			vcontact.className = "form-control is-invalid";
			return false;
			
		}else if (vstate.value == 0) {

			vstate.className = "custom-select is-invalid";
			return false;
			
		}else if (vcity.value == 0) {

			vcity.className = "custom-select is-invalid";
			return false;
			
		}else if (vservices.value == "") {

			vservices.className = "form-control is-invalid";
			return false;
			
		}else if (vplaces.value == "") {

			vplaces.className = "form-control is-invalid";
			return false;
			
		}else{

			vname.className = "form-control";
			vaddress.className = "form-control";
			vphone.className = "form-control";
			vcontact.className = "form-control";
			vstate.className = "custom-select";
			vcity.className = "custom-select";
			vservices.className = "form-control";
			vplaces.className = "form-control";

			var objVend = {
	    		vName : vname.value,
				vAddress : vaddress.value,
				vPhone : vphone.value,
				vEmail : vemail.value,
				vContact : vcontact.value,
				vTax : vtax.value,
				vState : vstate.value,
				vCity : vcity.value,
				vServices : vservices.value,
				vPlaces : vplaces.value,
				idVendor : idVendor,
				direct: true
	    	}
			
			if (typeSave == "new") {
				registerVendor(objVend);
			}else if(typeSave == "update"){
				changesVendor(objVend);
			}
		}
    }


    //This function is to register the vendor
    function registerVendor(obj){

    	axios.post("<?php echo site_url('registerVendor') ?>", obj
		).then(function(res){

    		if (res.data) {
    			swal({
		  			text: "Vendor registered",
					icon: "success",
				});

				postRequest("firstValidating");

				$("#modalVendor").modal("hide");

				cleanForm();
    		}

    	}).catch(function(err){
    		swal({
	  			text: "Something went wrong please try again or later",
				icon: "error",
			});
			
	      	console.log(err);
    	});
    }


    //This function is to update the vendor
    function changesVendor(obj){

    	axios.post("<?php echo site_url('updateVendor') ?>", obj
		).then(function(res){

    		if (res.data) {
    			swal({
		  			text: "Changes saved",
					icon: "success",
				});

				postRequest("firstValidating");

				$("#modalVendor").modal("hide");

				cleanForm();
    		}

    	}).catch(function(err){
    		swal({
	  			text: "Something went wrong please try again or later",
				icon: "error",
			});
			
	      	console.log(err);
    	});
    }


    //Here the event is added to clean the form when the buttons is clicked
    var buttonClose = document.getElementById('closeModalVendor');
    buttonClose.addEventListener('click', function(){
    	document.getElementById("titleVendor").innerHTML = "Add a new vendor";
    	cleanForm();
    });


    //The function clean the form content
    function cleanForm(){
    	typeSave = "new";

    	vname.value = "";
		vaddress.value = "";
		vphone.value = "";
		vemail.value = "";
		vcontact.value = "";
		vtax.value = "";
		vstate.value = 0;
		vcity.value = 0;
		vservices.value = "";
		vplaces.value = "";

		vname.className = "form-control";
		vaddress.className = "form-control";
		vphone.className = "form-control";
		vcontact.className = "form-control";
		vstate.className = "custom-select";
		vcity.className = "custom-select";
		vservices.className = "form-control";
		vplaces.className = "form-control";
    }


    //To this button is added the event to view canceled vendors
    var buttonViewCanceled = document.getElementById('viewCanceled');
    buttonViewCanceled.addEventListener('click', function(){
    	postRequest("canceled");
    });


    //To this button is added the event to view genera vendors again
    var buttonViewGeneral = document.getElementById('viewGeneral');
    buttonViewGeneral.addEventListener('click', function(){
    	postRequest("firstValidating");
    });
</script>