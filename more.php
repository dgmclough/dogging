<?php

session_start();

if($_SESSION['id']==''){
	header("location: index.php");
}
?>

<!DOCTYPE html>
<html  >
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/sticon.png" type="image/x-icon">
  <meta name="description" content="">


  <title>Clubhouse</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons-bold/mobirise-icons-bold.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <script src="https://kit.fontawesome.com/aae755a436.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
	<link rel="stylesheet" href="nav.css">
	<link rel="stylesheet" href="mobile.css">

</head>
<body>

<?php require_once 'navbar.php'; ?>
<?php require_once 'mobileheadernoselect.php'; ?>
<?php require_once 'bannernoselect.php';?>

<div class = 'container'>
	<div class='row pt-4 pb-0 mb-0'>
			<div class='col-12'>
					<h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>More </h3>
			</div>
	</div>
</div>


<section class="features1 cid-sdLYjLb4r0 p-0 m-0" id="features1-1d">
    <div class="container m-0 p-0">
        <div class="row m-0 p-0">

										<div class="card col-4 col-md-3 p-0" id='rcorners5' style='margin:5px;'>
												<div class="card-wrapper m-0 p-0">
														<div class="card-box align-center m-0 p-0">
															<a href="userhistory.php">
																<div class="iconfont-wrapper mbr-iconfont m-0 p-3">
																		<span class="mbri-user " style="color: #013369;fill: #013369;"></span>
																</div>
															</a>
															<h5 class="mbr-fonts-style mb-3 display-5 mobile tab" style="color: #013369; fill: #013369; line-height: 0;"><strong><?php echo $_SESSION['name']; ?>'s</strong></h2>
															<h5 class="mbr-fonts-style mb-4 display-5 mobile tab" style="color: #013369; fill: #013369; line-height: 0;"><strong>Picks History</strong></h2>
														</div>
												</div>
										</div>
											<div class="card col-4 col-md-3 p-0" id='rcorners5' style='margin:5px;'>
													<div class="card-wrapper m-0 p-0">
															<div class="card-box align-center m-0 p-0">
																<a href="rules.php">
																	<div class="iconfont-wrapper mbr-iconfont m-0 p-3">
																			<span class="fas fa-balance-scale" style="color: #013369; fill: #013369;"></span>
																	</div>
																</a>
																<h5 class="mbr-fonts-style mb-4 display-5 mobile tab" style="color: #013369; fill: #013369; line-height: 0;"><strong>Dogging Rules</strong></h2>
															</div>
													</div>
											</div>
											<div class="card col-4 col-md-3 p-0" id='rcorners5' style='margin:5px;'>
													<div class="card-wrapper m-0 p-0">
															<div class="card-box align-center m-0 p-0">
																<a href="account.php">
																	<div class="iconfont-wrapper mbr-iconfont m-0 p-3">
																			<span class="mbri-user" style="color: #013369; fill: #013369;"></span>
																	</div>
																</a>
																<h5 class="mbr-fonts-style mb-4 display-5 mobile tab" style="color: #013369; fill: #013369; line-height: 0;"><strong>Account</strong></h2>
															</div>
													</div>
											</div>
											<div class="card col-4 col-md-3 p-0" id='rcorners5' style='margin:5px;'>
													<div class="card-wrapper m-0 p-0">
															<div class="card-box align-center m-0 p-0">
																<a href="contact.php">
																	<div class="iconfont-wrapper mbr-iconfont m-0 p-3">
																			<span class="mbri-help" style="color: #013369; fill: #013369;"></span>
																	</div>
																</a>
																<h5 class="mbr-fonts-style mb-4 display-5 mobile tab" style="color: #013369; fill: #013369; line-height: 0;"><strong>Contact Us</strong></h2>
															</div>
													</div>
											</div>
        </div>
    </div>
</section>

<div class='d-xl-none'>
 <nav class='mobilenav'>
	 <a href='dashboard.php' class='mobilenav__link'>
		 <i class='material-icons mobilenav__icon'>home</i>
		 <span class='nav__text'>Clubhouse</span>
	 </a>
	 <a href='week.php' class='mobilenav__link'>
		 <i class='material-icons mobilenav__icon'>sports_football</i>
		 <span class='nav__text'>Week <?php echo $_SESSION['gameWeek'];?></span>
	 </a>
	 <a href='banter.php' class='mobilenav__link'>
		<i class='material-icons mobilenav__icon'>question_answer</i>
		<span class='nav__text'>Bantz</span>
	 </a>
	 <a href='more.php' class='mobilenav__link'>
		 <i class='material-icons mobilenav__icon  mobilenav__link--active'>add</i>
		 <span class='nav__text'>More</span>
	 </a>
 </nav>
</div>


<section style="d-none" style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>

   <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
  </body>
</html>
