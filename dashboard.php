<?php

session_start();
if($_SESSION['id']==''){
	header("location: index.php");
}

include 'functions.php';
setSession();
$leaderboard = getLeaderboard();
?>

<!DOCTYPE html>
<html  >
<head>
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
      <div class='col-12' style="display:inline-flex;">
					<img src='uploads/<?php echo $_SESSION['image']; ?>' style="display:inline-block; max-width:50px; max-height:auto; border-radius: 50%;">
          <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='display:inline-block; font-size:20px;'><?php echo $_SESSION['name']; ?>'s Dashboard </h3>
      </div>
  </div>
</div>

<?php
	if(!empty($_SESSION['gameWeek'])){
		echo"
	<div class = 'container'>
		<div class='row'>
			<div class='col-12'>
				<div class='card m-3'>
					<div class='card-header display-7' style='background-color: #013369; color:white; display:inline-flex;'>
						<span class='material-icons pr-1' style='display: inline-block;'>notifications</span>  Announcements
					</div>
						<div class='card-block' id='rcorners4'>
			            <div class='row pt-1'>
											<div class='col-2' style='display:flex;'>
													<img class='tournament' src='uploads/nfl.png' style='min-width:50px; max-height:auto;'>
											</div>

											<div class='col-8 p-0' style='display:flex;'>
													<h3 class='tournament' style='font-family:Jost;'>Week " . $_SESSION['gameWeek'] ."</h3>
											</div>

									</div>
									<div class='row'>
										<div class='col-12 text-center pt-1'>
											 <small class='tournament' style='font-family:Jost;'><strong>Picks Close: </strong>" . $_SESSION['deadlineTime'] . "</small>
										</div>
									</div>
						</div>

				</div>
			</div>
		</div>
	</div>";}?>

<div class = 'container'>
	<div class='row'>
		<div class='col-6 col-md-6'>
		<div class="card m-3">
		  <div class="card-header display-7" style="background-color: #013369; fill:#013369; color:white; display:inline-flex;">
				<span class="material-icons pr-1" style="display: inline-block;">format_list_numbered_rtl</span>  Rank
		  </div>
					<div class='card-block mb-2' id='rcorners4' style=''>
								<div class='row pt-1'>
										<div class='col-12' style='display:flex; justify-content:center;'>
												<h1 class='tournament' style='font-family:Jost;'> <?php echo $_SESSION['rank'];?> </h1>
										</div>

								</div>
					</div>
		</div>
		</div>
		<div class='col-6 col-md-6'>
		<div class="card m-3">
			<div class="card-header display-7" style="background-color: #013369; fill:#013369; color:white; display:inline-flex;">
				<span class="material-icons pr-1" style="display: inline-block;">numbers</span>  Points
			</div>
					<div class='card-block mb-2' id='rcorners4' style=''>
								<div class='row pt-1'>

										<div class='col-12' style='display:flex; justify-content:center;'>
												<h1 class='tournament' style='font-family:Jost;'> <?php echo $_SESSION['points'];?> </h1>
										</div>

								</div>
					</div>
		</div>
		</div>
	</div>
</div>

<div class = 'container'>
	<div class='row'>
		<div class="col-12 col-lg-12 align-center">
				<div class="plan">
						<div class="plan-header">
								<h6 class="plan-title mbr-fonts-style mb-3 display-5 text-muted"><strong>Current Standings</strong></h6>
						</div>
						<div class="plan-body mbr-fonts-style mb-3 table-responsive-sm">
							<table class="table table-sm">
								<thead class= "title">
								<tr>
									<th scope="col" class='price-term mbr-fonts-style mb-3 display-7 text-center titlel' style='width:auto;' nowrap='nowrap'><strong>Pos</strong></th>
									<th scope="col" class='price-term mbr-fonts-style mb-3 display-7 text-left title' style='width:50%;' nowrap='nowrap'><strong>Team</strong></td>
									<th scope="col" class='price-term mbr-fonts-style mb-3 display-7 text-center titler' nowrap='nowrap'><strong>Pts</strong></th>
								</tr>
								</thead>
								<tbody>
									<?php
											foreach($leaderboard as $l){
											echo"
											<tr>
												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-center' "; if($l['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$l['rank']}</td>
												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-left' "; if($l['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$l['name']}</td>
												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-center' "; if($l['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$l['points']}</td>
											</tr>";}?>
								</tbody>
							</table>
					</div>
				</div>
		</div>
	</div>
</div>

<div class='col-12 d-xl-none mbr-section-btn align-center' style='border-radius:50px;'>
		<button onclick="location.href='logout.php'" class="btn btn-primary display-4" name="enter"><i class="fa fa-sign-out" aria-hidden="true"></i></button>
</div>


	<div class='d-xl-none'>

		<nav class='mobilenav'>
			<a href='dashboard.php' class='mobilenav__link'>
				<i class='material-icons mobilenav__icon  mobilenav__link--active'>home</i>
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
				<i class='material-icons mobilenav__icon'>add</i>
				<span class='nav__text'>More</span>
			</a>
		</nav>
	</div>


<section style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>

  </body>
</html>
