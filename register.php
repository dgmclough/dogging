<?php
session_start();

if(!empty($_SESSION['id'])){
	header("location: index.php");
}

$error = "";
$leagueerror = "";
require_once 'db.php';

$name = '';
$password = '';
$username = '';

if(isset($_POST ['enter'])){
   if(empty($_POST["username"])|| empty($_POST["password"])){
		$error = "Username and Password are required fields";
   }
   else{
    $secretkey = '6LfGClIaAAAAAF_Ai8_O3reb2r4cvuXKyLkmVVNl';
		$responsekey = $_POST['g-recaptcha-response'];
		$userIP = $_SERVER['REMOTE_ADDR'];
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey&remoteip=$userIP";
		$response = file_get_contents($url);
		$response = json_decode($response);
		$response = 'success';

		//if($response == 'success'){
    		$username = $_POST['username'];
    		$password = $_POST['password'];
				$name = $_POST['name'];

				$usernameQuery = 'SELECT username FROM users WHERE username =  ?';
				$usernameQuery = $conn->prepare($usernameQuery);
				$usernameQuery -> bind_param("s", $username);
				$usernameQuery -> execute();
				$usernameQuery = $usernameQuery->get_result();
				$resultCount = mysqli_num_rows($usernameQuery);
				if($resultCount == 0){
					$newuser = 'INSERT INTO users (password, name, username, image) VALUES (?, ?, ?, ?)';
					$newuser = $conn->prepare($newuser);
					$newuser -> bind_param("ssss", $password, $name, $username, $image);
					$newuser -> execute();
					$_SESSION['id'] = $u['id'];
					$_SESSION['name'] = $u['name'];
					$_SESSION['username'] = $u['username'];
					$_SESSION['image'] = 'avatar.png';
					header("Location: dashboard.php");
				}
				else{
					$error = "Username unavailable";
					$usernameWarning = "bg-warning";
				}
    	mysqli_close($conn); // Closing connection
		//}
		//else{
		//	$error = 'Captcha Verification failed!';
		//}
	}
}



if(isset($_POST ['cancel'])){
	header("Location: index.php");
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


  <title>Register</title>

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



</head>
<body>

<section class="header18 cid-sdMJBeCO7u" id="header18-1y">

    <div class="mbr-overlay" style="opacity: 0.3; background-color: #013369;"></div>

    <div class="align-center container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <h1 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-1"><strong>Dogging</strong></h1>
            </div>
        </div>
    </div>
</section>

<section class="form6 cid-sdLZzCp5L8 bg-light" id="form6-1i">
    <div class="container bg-light">
        <div class="mbr-section-head">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Sign Up</strong></h3>

        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-lg-7 mx-auto mbr-form">
                <form action="" method="POST" class="mbr-form form-with-styler mx-auto needs-validation">
                    <div class="">
						<?php
						if ($error != ""){
							echo
							"<div class='col alert alert-danger mbr-fonts-style mb-3 display-7' role='alert'>$error
							</div>";
						}?>
            </div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
                <input type="text" name="username" placeholder="Username for login*" data-toggle='tooltip' title="Your unique login name" class="form-control <?php echo $usernameWarning; ?>" <?php if($username != ''){echo "value = $username";}?> required>
            </div>
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
                <input type="text" name="name"  class="form-control" data-toggle='tooltip' title="Full Name" <?php if($name != ''){echo "value = $name";}?> placeholder = "Full Name*" required>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                <input type="password" name="password" placeholder="Password*"  data-toggle='tooltip' title="Minimum of 4 characters" class="form-control" minlength="4"<?php if($password != ''){echo "value = $username";}?> required>
            </div>
						<div class="g-recaptcha align-center" data-sitekey="6LfGClIaAAAAAENSlsPMpIe7DeBqufKziRdA6Ob3"></div>
            <div class="col-auto mbr-section-btn align-center">
                <button type="submit" class="btn display-4" style="background-color:#013369; color:white;" name="enter">COMPLETE SIGN UP</button>
            </div>
						</form>
						<form action="" method="POST" class="mbr-form form-with-styler mx-auto">
							<div class="col-auto mbr-section-btn align-center mt-2">
								<button type="submit" class="btn btn-primary display-4" name="cancel">CANCEL SIGN UP</button>
							</div>
						</form>
						<script src="https://www.google.com/recaptcha/api.js"></script>
                    </div>
            </div>
        </div>
    </div>

</section>

<section style="background-color: #013369; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>
  <script>

</script>
   <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
  </body>
 </html>
