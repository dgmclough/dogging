<?php
include 'functions.php';
session_start();

if($_SESSION['id']==''){
 	header("location: index.php");
}

setSession();
allUserPicks();


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
  if(empty($_SESSION['userHistoricalPicks'])){
    echo"
    <div class='col-12'>
        <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>No Picks have been submitted yet!</h3>
    </div>";

  }
  else{
    echo"
    <div class = 'container pt-3'>
      <div class='row'>
        <div class='col-12 col-lg-12 align-center'>
            <div class='plan'>
                <div class='plan-body mbr-fonts-style table-responsive-sm p-2'>
                  <table class='table table-sm'>
                    <thead class= 'title'>
                    <tr>
                      <th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-IntlCodePointBreakIterator titlel' style='width:auto;' nowrap='nowrap'><strong>Week</strong></th>
                      <th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-left title' style='width:auto;' nowrap='nowrap'><strong>Team</strong></td>
                      <th scope='col' class='price-term mbr-fonts-style mb-3 display-4 mobile text-center titler' style='width:auto;' nowrap='nowrap'><strong>Result</strong></td>
                    </tr>
                    </thead>
                    <tbody>";

                          foreach($_SESSION['userHistoricalPicks'] as $u){

                          echo"
                          <tr>
                            <td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-center'>{$u['week']}</td>
                            <td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-left'>{$u['underdog']}</td>
                            <td scope='col' class = 'price-term mbr-fonts-style mb-3 display-4 mobile text-center'>{$u['result']}</td>
                          </tr>";}
                    echo"
                    </tbody>
                  </table>
              </div>
            </div>
        </div>
      </div>
    </div>";}?>


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


    <section class="d-none" style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>

      </body>
</html>
