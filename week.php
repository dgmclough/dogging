<?php
include 'functions.php';
session_start();

if($_SESSION['id']==''){
 	header("location: index.php");
}

setSession();
$picks = retrievePicks();
$remainingPicks = calculateRemainingPicks($picks);
$matches = getMatches();
$matches = markSelections($matches, $picks);
$fieldPicks = getWeeksPicks();

if(isset($_POST['submitPicksButton'])){
  $picks = array();

  if(isset($_POST['picks'])){
    submitSelection($_POST['picks']);
  }
  $_SESSION['edit'] = FALSE;
  header("Location: week.php");
}

if(isset($_POST['clearSelection'])){
  deletePicks();
  $_SESSION['edit'] = TRUE;
  header("Location: week.php");
}


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


  <title>Week </title>
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
  <script src="js.js"></script>
	<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
	<link rel="stylesheet" href="nav.css">
	<link rel="stylesheet" href="mobile.css">

  <style>

    .custom-control-label::before{
      width: 25px;
      height: 25px;
    }

    .custom-control-label::after{
      width: 25px;
      height: 25px;
    }
  </style>

</head>
<body>

<?php require_once 'navbar.php'; ?>
<?php require_once 'mobileheadernoselect.php'; ?>
<?php require_once 'bannernoselect.php';?>

<section class="info3 cid-sdMFL7YqeV pt-0 m-0" id="info3-1u"  style='background-color: #013369;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-12 col-lg-10">
                <div class="card-wrapper">
                    <div class="card-box align-center">
                        <h4 class="card-title mbr-fonts-style align-center mb-4 display-1 mobile"><strong><?php echo 'Week ' . $_SESSION['gameWeek']; ?></strong></h4>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div>
	<ul class="sticky nav nav-tabs mt-4">
		<li><a href="#zero" data-toggle="tab" class="mobile tabs menu display-7 active"><strong> Submit Picks </strong></a></li>
		<li><a href="#one" data-toggle="tab" class="mobile tabs menu display-7"><strong> Week Summary </strong></a></li>
	</ul>
</div>

<div class="tab-content pb-5">
	<div class="tab-pane active" id="zero">
			<div class="namedesig">
				<section class="info3 cid-sdMFL7YqeV" id="info3-1u"  style="background-color: #013369; fill:#013369; color:white;">
						<div class="container">
								<div class="row justify-content-center">
										<div class="card col-12 col-lg-10">
												<div class="card-wrapper">
														<div class="card-box align-center">
																<h4 class="card-title mbr-fonts-style align-center display-1 mobile"><strong> Underdog Selections </strong></h4>
                                <?php
                                if($_SESSION['deadline'] == FALSE){echo"<small  style='font-family:Jost;'> Picks close: "; echo $_SESSION['deadlineTime'] . " " . $_SESSION['timezone']; echo"</small>";}
                                else{echo"<small  style='font-family:Jost;'>"; echo "Picks Closed"; echo"</small>";}?>
														</div>
												</div>
										</div>
								</div>
						</div>
				</section>
        <form action = '' method = 'post' name ='submitpicksform' id='submitpicksform'>
				<div class = 'container'>
					<div class='row'>
						<?php
						foreach($matches as $m){
                echo"
								<div class='col-6 col-md-6 p-0'>
										<div class='card m-3'>

										  <div class='card-header display-7 border "; if($m['picked'] == 'y'){echo 'border-success';} echo" border-bottom-0'  style='border-width:5px !important; "; if($m['active'] == 'n' || $_SESSION['deadline'] == TRUE){echo 'opacity:0.5;';} echo " background-color: {$m['colour']}; fill:{$m['colour']}; color:white; border-radius: 20px 20px 0px 0px; position:relative;'>";
													if($m['picked'] == 'y'){
														echo"
													<i class='fas fa-check-circle fa-2x' style='color:#00FF00; position:absolute;'></i>";}
													if($m['picked'] == 'n' AND $remainingPicks > 0 AND $_SESSION['edit'] == TRUE){
                          echo"
                          <div class='custom-control custom-checkbox image-checkbox'>
                          <input type='checkbox' class='custom-control-input' data-max='"; echo $remainingPicks; echo "' id='{$m['sportRadarId']}' value=\"{$m['sportRadarId']}\" name='picks[]'  style='width: 100px; height: 100px;' "; if(in_array($m['sportRadarId'], $_SESSION['latestPicks'])){echo "checked";} if($m['active'] == 'n'){ echo 'disabled';} echo">
                          <label class='custom-control-label' for='{$m['sportRadarId']}'>";}
                          echo"
													<img src='https://www.thesportsdb.com/images/media/team/badge/{$m['logo']}'>";
                          if($m['picked'] == 'n' AND $remainingPicks > 0 AND $_SESSION['edit'] == TRUE){
                          echo"
                          </label>
                          </div>";}
                          echo"
										  </div>
													<div class='card-block mb-2 border "; if($m['picked'] == 'y'){echo 'border-success';} echo" border-top-0' id='rcorners4' style='border-width:5px !important; "; if($m['active'] == 'n' || $_SESSION['deadline'] == TRUE){echo 'opacity:0.5;';} echo"'>
																<div class='row pt-1'>
																	<div class='col-12' style='display:flex; justify-content:center;'>
																			<small style='font-family:Jost;'><strong> {$m['tag']} </strong></small>
																	</div>
																		<div class='col-12' style='display:flex; justify-content:center;'>
																				<h2 class='tournament' style='font-family:Jost;'> +{$m['spread']} </h1>
																		</div>
																		<div class='col-12' style='display:flex; justify-content:center;'>
																				<small style='font-family:Jost;'> vs {$m['favourite']} </small>
																		</div>
																		<div class='col-12' style='display:flex; justify-content:center;'>
																				<small style='font-family:Jost;'> {$m['time']} </small>
																		</div>
																</div>
													</div>

										</div>
								</div>";}?>
						</div>
					</div>

			</div>


			<div class="container" style="">
					<div class="row">
							<div class="col-12 col-lg-10">
										<div class="p-4 form-group row col-12 justify-content-center">
                      <?php
                      if($_SESSION['deadline'] == TRUE){echo"";}
                      elseif($remainingPicks == 3){echo"<button form = 'submitpicksform' type='submit' class='btn display-4' style='background-color: #013369; fill:#013369; color:white;' name='submitPicksButton'>SUBMIT PICKS</button>";}
                      elseif($remainingPicks < 3 AND $remainingPicks > 0 AND $_SESSION['edit'] == TRUE){echo"<button form = 'submitpicksform' type='submit' class='btn display-4' style='background-color: #013369; fill:#013369; color:white;' name='submitPicksButton'>SUBMIT PICKS</button>";}
                      elseif($remainingPicks < 3 AND $remainingPicks > 0 AND $_SESSION['edit'] == FALSE){echo"<button form = 'submitpicksform' type='submit' class='btn display-4' style='background-color: #d50a0b; fill:#d50a0b; color:white;' name='clearSelection' id='clearSelection'>EDIT PICKS</button>";}
                      elseif($remainingPicks == 0){echo"<button form = 'submitpicksform' type='submit' class='btn display-4' style='background-color: #d50a0b; fill:#d50a0b; color:white;' name='clearSelection' id='clearSelection'>EDIT PICKS</button>";}
                      ?>
										</div>
							</div>
					</div>
			</div>
    </form>
	</div>

		<div class="tab-pane" id="one">
				<div class="namedesig">
					<section class="info3 cid-sdMFL7YqeV" id="info3-1u"  style="background-color: #013369; fill:#013369; color:white;">
							<div class="container">
									<div class="row justify-content-center">
											<div class="card col-12 col-lg-10">
													<div class="card-wrapper">
															<div class="card-box align-center">
																	<h4 class="card-title mbr-fonts-style align-center display-1 mobile"><strong> Your Picks </strong></h4>
                                  <?php
                                  if($_SESSION['deadline'] == FALSE){echo"<small  style='font-family:Jost;'> Picks close: "; echo $_SESSION['deadlineTime'] . " " . $_SESSION['timezone']; echo"</small>";}
                                  else{echo"<small  style='font-family:Jost;'>"; echo "Picks Closed"; echo"</small>";}?>
															</div>
													</div>
											</div>
									</div>
							</div>
					</section>
					<div class = 'container'>
						<div class='row'>
							<?php
              if($remainingPicks < 3){
  							foreach($matches as $m){
  								if($m['picked'] == 'y'){
  							    echo"
  									<div class='col-4 col-md-4 p-0'>
  											<div class='card m-3'>
  												<div class='card-header display-7' style='background-color: {$m['colour']}; fill:{$m['colour']}; color:white; border-radius: 20px 20px 0px 0px; position:relative;'>
  														<img src='https://www.thesportsdb.com/images/media/team/badge/{$m['logo']}'>
  												</div>
  														<div class='card-block mb-2' id='rcorners4' style=''>
  																	<div class='row pt-1'>
  																		<div class='col-12' style='display:flex; justify-content:center;'>
  																				<small style='font-family:Jost;'><strong> {$m['tag']} </strong></small>
  																		</div>
  																			<div class='col-12' style='display:flex; justify-content:center;'>
  																					<small class='tournament' style='font-family:Jost;'> +{$m['spread']} </small>
  																			</div>
  																	</div>
  														</div>
  											</div>
  									</div>";}
                }
              }
              else{
                echo"
                <div class='col-12'>
                    <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>No Picks Submitted yet</h3>
                </div>";
              }
              ?>
							</div>
						</div>


              <section class="info3 cid-sdMFL7YqeV" id="info3-1u"  style="background-color: #013369; fill:#013369; color:white;">
                  <div class="container">
                      <div class="row justify-content-center">
                          <div class="card col-12 col-lg-10">
                              <div class="card-wrapper">
                                  <div class="card-box align-center">
                                      <h4 class="card-title mbr-fonts-style align-center display-1 mobile"><strong> Rest of Field </strong></h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>

              <?php
                if($_SESSION['deadline'] == false){
                  echo"
                  <div class='col-12'>
                      <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>All Picks revealed @ "; echo $_SESSION['deadlineTime']; echo"</h3>
                  </div>";

                }
                else{
                  echo"
                  <div class = 'container pt-3'>
                  	<div class='row'>
                  		<div class='col-12 col-lg-12 align-center'>
                  				<div class='plan'>
                  						<div class='plan-body mbr-fonts-style table-responsive-sm'>
                  							<table class='table table-sm'>
                  								<thead class= 'title'>
                  								<tr>
                  									<th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-center titlel' style='width:auto;' nowrap='nowrap'><strong>Player</strong></th>
                  									<th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-left title' style='width:auto;' nowrap='nowrap'><strong>1</strong></td>
                                    <th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-left title' style='width:auto;' nowrap='nowrap'><strong>2</strong></td>
                  									<th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-left titler' style='width:auto;' nowrap='nowrap'><strong>3</strong></th>
                  								</tr>
                  								</thead>
                  								<tbody>";

                  											foreach($fieldPicks as $f){
                  											echo"
                  											<tr>
                  												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-center' "; if($f['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$f['name']}</td>
                  												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-left' "; if($f['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$f['1']['team']}</td>
                                          <td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-left' "; if($f['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$f['2']['team']}</td>
                  												<td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-left' "; if($f['id'] == $_SESSION['id']){echo "style = 'background-color: #013369; color: white; opacity:0.5;'";} echo">{$f['3']['team']}</td>
                  											</tr>";}
                                  echo"
                  								</tbody>
                  							</table>
                  					</div>
                  				</div>
                  		</div>
                  	</div>
                  </div>";
                }

                ?>

				</div>
		</div>
</div>



<div class='d-xl-none'>

	<nav class='mobilenav'>
		<a href='dashboard.php' class='mobilenav__link'>
			<i class='material-icons mobilenav__icon'>home</i>
			<span class='nav__text'>Clubhouse</span>
		</a>
		<a href='week.php' class='mobilenav__link'>
			<i class='material-icons mobilenav__icon  mobilenav__link--active'>sports_football</i>
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


<section class="d-none" style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>

  </body>
</html>
