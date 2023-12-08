
<!DOCTYPE html>
<html>
<head>
	<title>Lite Tech Info</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_menu.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_index.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/script.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/script_connexion.js"></script>
	
</head>
<body id="body">
<header>
	<section>
	<!--MENU 1-->
    <?php $this->view("include/menu-1.php"); ?>
	<!--MENU 2-->
	</section>
	<section>
        <?php $this->view("include/menu-2.php"); ?>
	</section>
</header>
<section>
	<!--SLIDE 1-->
	<div class="bd-example">
		<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
				<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active" style="height: 554.05px">
					<img class="card-img" src="img/slide/slide21.jpg" class="d-block w-100" alt="...">
					<div class="card-img-overlay">
						<div class="row">
							<div class="col-lg-8">
								<h1 class="text-white font-weight-bold text-success">Fournisseur des matériels et composants informatiques</h1>
								<div class="font-weight-bold text-white" style="padding: 20px 0 0 30px; font-size: 25px;">
									<p>Matériel garantie<p>
									<p>Service après vente<p>
								</div>
							</div>
							<div class="col-lg-4"></div>
						</div>
					</div>
				</div>
				<div class="carousel-item" style="height: 554.05px">
					<img src="img/slide/slidetest1.jpg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
						<h5  style="color: black;">Matériel garentie</h5>
						<p></p>
					</div>
				</div>
				<div class="carousel-item" style="height: 554.05px">
					<img src="img/slide/slide3.png" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
						<h5>Service apres vente</h5>
						<p></p>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<!--SLIDE 2-->
</section>
<!--TOP VENTE NOUVEAUTE-->
<section id="sct_tpnv">
	<div id="div_tpnv">
		<!--TOP VENTE-->
		<div>
			<h4 class="h_title">TOP DES VENTES</h4>
			<div class="row"><!--list produit-->
				
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p1.jpg"/></div>
					<div><h6 class="h_name_vn">ASRock Phantom Gaming D Radeon RX580 8G OC</h6></div>
					<div class="row">
						<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">250 000 Ar</h6></div></div>
						<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>
						
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p2.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC Aurore NI5R-16-S5</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">2 020 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p3.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC PC Bazooka</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">2 250 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p4.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC 15.6" LED Tactile - Pro Touch 15.6</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">520 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
			</div>
		</div>
		<!--TOP NOUVEAUTE-->
		<div>
		<h4 class="h_title">NOUVEAUTÉ</h4>
		<div class="row"><!--list produit-->
			<div class="col-md-3">
				<div class="div_img"><img class="img_fch_pdt" src="img/produit/p5.jpg"/></div>
					<div><h6 class="h_name_vn">ASRock Phantom Gaming D Radeon RX580 8G OC</h6></div>
					<div class="row">
						<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">250 000 Ar</h6></div></div>
						<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>
						
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p6.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC Aurore NI5R-16-S5</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">2 020 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p7.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC PC Bazooka</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">2 250 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
				<div class="col-md-3">
					<div class="div_img"><img class="img_fch_pdt" src="img/produit/p8.jpg"/></div>
						<div><h6 class="h_name_vn">LDLC 15.6" LED Tactile - Pro Touch 15.6</h6></div>
						<div class="row">
							<div class="col-lg-8"><div class="div_price_vn"><h6 class="h_price">520 000 Ar</h6></div></div>
							<div class="col-lg-4 div_bag"><a href="#"><i class="fas fa-shopping-basket fa-lg"></i></a></div>		
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--TOP VENTE NOUVEAUTE-->
<section>
		<!--FOOTER 1-->
        <?php $this->view("include/footer.php"); ?>
		<!--FOOTER 2-->
</section>

</body>
</html> 
<!--FONT AWESOME STYLING
	sizing icons
	<i class="fas fa-camera fa-xs"></i>
	<i class="fas fa-camera fa-sm"></i>
	<i class="fas fa-camera fa-lg"></i>
	<i class="fas fa-camera fa-2x"></i>
	<i class="fas fa-camera fa-3x"></i>
	<i class="fas fa-camera fa-5x"></i>
	<i class="fas fa-camera fa-7x"></i>
	<i class="fas fa-camera fa-10x"></i>
	rotating icons
	 <i class="fas fa-snowboarding"></i>
  <i class="fas fa-snowboarding fa-rotate-90"></i>
  <i class="fas fa-snowboarding fa-rotate-180"></i>
  <i class="fas fa-snowboarding fa-rotate-270"></i>
  <i class="fas fa-snowboarding fa-flip-horizontal"></i>
  <i class="fas fa-snowboarding fa-flip-vertical"></i>
  <i class="fas fa-snowboarding fa-flip-both"></i>
-->

