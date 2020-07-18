<!DOCTYPE html>
<html>
<head>
	<title>Janitorial Coronas LLC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/presentationsheet.css') ?>">
</head>
<body>
	<nav class="navbar navbar-expand-lg nav navbar-light">
	  <a class="navbar-brand" href="#">Janitorial Coronas LLC</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span><i class="fa fa-bars"></i></span>
	  </button>
	  <div class="collapse navbar-collapse">
	    <ul class="navbar-nav">
	      <li class="nav-item active" >
	        <a class="nav-link" href="#banner">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item" >
	        <a class="nav-link" href="#tools">Services</a>
	      </li>
	      <li class="nav-item" >
	        <a class="nav-link" href="#clients">Clients</a>
	      </li>
	      <li class="nav-item" >
	        <a class="nav-link" href="#contact">Contact us</a>
	      </li>
	    </ul>
	  </div>
	</nav>
	<div id="banner">
		<div class="col-md-6 offset-md-6 banner-text">
			<div>
				<div>
					<h1 class="text-danger" id="cov">COVID-19 Desinfecting</h1>
				</div>
				<div>
					<p>
						We are aware of the current situation, that is why we are here to disinfect your establishment and ensure people's health. Quote it with us, we are here to serve you.
					</p>
				</div>
				<div>
					<button class="btn btn-primary btn-lg">Quotation</button>
				</div>
			</div>
		</div>
	</div>
	<div id="tools">
		<div class="container">
			<div class="row">
				<div class="col-md-8 flex tool-img">
					<div>
						<img src="<?= base_url('assets/img/bomb.png') ?>" width="90%"/>
					</div>
				</div>
				<div class="col-md-4 tool-text">
					<div id="text">
						<h2>
							Tools
						</h2>
						<p>
							We have the best equipment to carry out our work and in this way guarantee the satisfaction of our clients.
						</p>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div id="clients">
		<div class="container">
			<div class="slider-client">
				<div><img src="<?= base_url('assets/img/harbor.jpeg'); ?>" height="100px" class="ml-5"/></div>
				<div><img src="<?= base_url('assets/img/24hrs.jpeg'); ?>" height="100px" class="ml-5"/></div>
			</div>
		</div>
	</div>
	<div id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-6 contact-address">
					<div>
						<h2>Contact</h2>
						<ul>
							<li><i class="fas fa-map-marker-alt"></i> 13691 Harbor Blvd, Garden Grove, CA 92843</li>
							<li><i class="fas fa-phone"></i> 305 627 3474</li>
							<li><i class="fas fa-envelope-open"></i> info@janitorialcoronallc.com</li>
							<li><i class="fas fa-clock"></i> Monday to Friday - 07:00am to 14:00pm</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 contact-form">
					<form>
						<div class="form-group">
							<label for="name">Your Name</label>
						    <input type="text" class="form-control" id="name">
						</div>
						<div class="form-group">
							<label for="email">Your Name</label>
						    <input type="email" class="form-control" id="email">
						</div>
						<div class="form-group">
							<label for="textarea">How can we help you?</label>
							<textarea class="form-control" id="textarea" rows="3"></textarea>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-12 contact-map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d204504.2856756582!2d-119.93464568966095!3d36.78545132179245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80945de1549e4e9d%3A0x7b12406449a3b811!2sFresno%2C%20CA%2C%20USA!5e0!3m2!1sen!2smx!4v1595023329162!5m2!1sen!2smx" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<div class="col-12 text-center">
				<ul>
					<li><a href="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="facebook" target="_blank"><i class="fab fa-instagram"></i></a></li>
					<li><a href="facebook" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
					<li><a href="facebook" target="_blank"><i class="fab fa-youtube"></i></a></li>
				</ul>
			</div>
			<div class="col-12 text-center">
				<small>© 2020 - JANITORIAL CORONAS LLC</small>
			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="
sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://kit.fontawesome.com/edd92d8f35.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
	$(".slider-client").slick({
		dots: true,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		centerMode: true,
		variableWidth: true,
		autoplay:true
	});

	// $('.nav-item').on('click', function(){
	// 	$('.nav-item').removeClass('active');
	// 	$(this).addClass('active');
	// });

	var navItems = document.querySelectorAll('.nav-item');

	navItems.forEach((navItem) => {
		navItem.addEventListener('click', () => {
			navItems.forEach(items => items.classList.remove('active'));
			navItem.classList.add('active');
		});
	});

</script>
</html>