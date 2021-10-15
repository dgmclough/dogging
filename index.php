<?php
session_start();
include 'functions.php';
$error = "";

require_once 'db.php';

if(isset($_POST ['enter'])){

   if(empty($_POST["username"])|| empty($_POST["password"])){
		$error = "Username and Password required";
   }

   else{

		$username=$_POST['username'];
		$password=$_POST['password'];
    $user = 'SELECT * FROM users WHERE username = ? AND password = ?';
		$user = $conn->prepare($user);
    $user -> bind_param("ss", $username, $password);
    $user -> execute();
    $user = $user->get_result();
		$rows = mysqli_num_rows($user);

		if($rows == 1){
			$row = mysqli_fetch_assoc($user);
			$_SESSION['id'] = $row['id'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
      $_SESSION['image'] = $row['image'];
      $_SESSION['latestPicks'] = array();
      setSession();
      loginSession();
      header("Location: dashboard.php");

		}
		else
		{
		$error = "Invalid User Credentials";
		}
		mysqli_close($conn); // Closing connection
	}

}

?>
<!DOCTYPE html>
<html style="height: 100vh;" lang="en">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/sticon.png" type="image/x-icon">
  <link rel="canonical" href="https://stringtheory.ie/">
  <meta name="description" content="Fantasy NFL Game. Put your American Football knowledge to the test and play against NFL fans worldwide!">


  <title>Dogging: Fantasy NFL App</title>

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
  <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="mobile.css">
    <style>
        link {
          padding:10px;
        }
    </style>

</head>
<body style="padding:100px; height: 100vh;">

<section class="header18 cid-sdMJBeCO7u" id="header18-1y" style="height: 100vh;">
  <div class='mbr-overlay' style='opacity: 0.5; background-color: #013369;'></div>
<section class="header18 d-none d-sm-block bg-transparent" id="header18-1y">
    <div class="align-center container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <h2 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-1"><strong><i class="fas fa-dog"></i> Dogging </strong></h2>
				        <h1 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-7"><strong>NFL Fantasy Pick'em: Underdogs Edition</strong></h1>
            </div>
        </div>
    </div>
</section>

<div class='d-block d-sm-none'>
  <nav class='navbar fixed-top' style ='background-color: #013369; fill: #013369;'>
    <h3 class='navbar-brand navbar-caption-wrap navbar-caption text-white display-7 text-white display-7' href='clubhouse.php'><strong> <i class='fas fa-dog'></i> Dogging </strong> </br><small>NFL Fantasy Pick'em: Underdogs Edition</small></h3>
  </nav>
</div>

<section class="form6 cid-sdLZzCp5L8 bg-transparent p-0" id="form6-1i">
    <div class="container bg-transparent">
        <div class="mbr-section-head pt-1">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Sign In</strong></h3>

        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-6 col-lg-8 mx-auto mbr-form">
                <form action="" method="POST" class="mbr-form form-with-styler mx-auto">
                    <div class="">
						<?php
						if ($error != ""){
							echo
							"<div class='col alert alert-danger mbr-fonts-style mb-3 display-7' role='alert'>$error
							</div>";
						}?>
                    </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <input type="text" name="username" placeholder="Username"  class="form-control">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <input type="password" name="password" placeholder="Password" class="form-control">
                        </div>

                        <div class="col-auto mbr-section-btn align-center">
                            <button type="submit" class="btn btn-dark display-4" name="enter">ENTER</button>
                        </div>
                        <div class="row m-3 p-2" style="opacity: 0.8; background-color: #013369; height:50px; border-radius: 4px; ">
                        <?php
                        if(1==0){
                          echo"
                        <div class='card col-4 m-0 p-0'>
                            <div class='card-wrapper m-0 p-0'>
                                <div class='card-box align-center m-0 p-0'>
                                  <a href='enter-email.php'>
                                    <div class='iconfont-wrapper mbr-iconfont m-0 p-0'>
                                        <strong><span class='mbri-unlock' style='color: white; font-size:15px;''></span></strong>
                                    </div>
                                  </a>
                                  <h5 class='mbr-fonts-style mb-4 display-5 mobile' style='color: white; font-size:10px;'><strong>Password Reset</strong></h2>
                                </div>
                            </div>
                        </div>";}?>
                          <div class="card col-4 m-0 p-0">
                              <div class="card-wrapper m-0 p-0">
                                  <div class="card-box align-center m-0 p-0">
                                    <a href="register.php">
                                      <div class="iconfont-wrapper mbr-iconfont m-0 p-0">
                                          <strong><span class="mbri-login" style="color: white; font-size:15px;"></span></strong>
                                      </div>
                                    </a>
                                    <h5 class="mbr-fonts-style mb-4 display-5 mobile" style="color: white; font-size:10px;"><strong>Sign Up</strong></h2>
                                  </div>
                              </div>
                          </div>
                          <div class="card col-4 m-0 p-0">
                              <div class="card-wrapper m-0 p-0">
                                <div class="card-box align-center m-0 p-0">
                                  <a href=".php">
                                    <div class="iconfont-wrapper mbr-iconfont m-0 p-0">
                                        <strong><span class="mbri-help" style="color: white; font-size:15px;"></span></strong>
                                    </div>
                                  </a>
                                <h5 class="mbr-fonts-style mb-4 display-5 mobile" style="color: white; font-size:10px;"><strong>Contact Us</strong></h2>
                                </div>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  </section>
</section>

<section class= "d-none" style="background-color: #013369; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>


  </body>
 </html>
