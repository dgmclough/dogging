<?php
session_start();
require_once 'db.php';
$error = "";
$success = "";

if(isset($_POST ['enter'])){

	 if(empty($_POST['email'])){
		 	$error = "Please enter e-mail";
	 }
	 else{
			$email = $_POST['email'];
			// generate a unique random token of length 100
			$token = bin2hex(random_bytes(50));

			// store token in the password-reset database table against the user's email
			$tokenstore = 'INSERT INTO password_resets(email, token) VALUES (?, ?)';
			$tokenstore = $conn->prepare($tokenstore);
			$tokenstore -> bind_param("ss", $email, $token);
			$tokenstore -> execute();
			$tokenstore = $tokenstore->get_result();

			// Send email to user with the token in a link they can click on
			$to = $email;
			$subject = "Reset your password on Dogging";
						$url = "https://www.stringtheory.ie/dogging/newpassword.php?token=";
						$url .= $token;

			$msg = "
			<html>
			<body>
			<p>Reset your Password on String Theory</p>
			<p>Hi,</p>
			<p>Click on this <a href= $url>link</a> to reset your password on our site.</p>
			<p>Thank you,</p>
			<p>String Theory Team</p>
			</body>
			</html>
			";

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <noreply@stringtheory.ie>' . "\r\n";
			mail($to, $subject, $msg, $headers);
			$success = "A reset password link has been sent to your email!";
		}
	}
	mysqli_close($conn); // Closing connection

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


	<title>Password Reset</title>

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

		<div class="mbr-overlay" style="opacity: 0.3; background-color: #013369; fill: #013369;"></div>

		<div class="align-center container">
				<div class="row justify-content-center">
						<div class="col-12 col-lg-6">
								<h1 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-1"><strong>Dogging</strong></h1>
				<h1 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-7"><strong>NFL Fantasy Pick'em: Underdogs Edition</strong></h1>
						</div>
				</div>
		</div>
</section>

<?php
if ($success != ""){
		echo
	"<div class='col alert alert-success mbr-fonts-style mb-3 display-7' role='alert'>$success</div>";
}
else{
echo
"<section class='form6 cid-sdLZzCp5L8 bg-light' id='form6-1i'>
		<div class='container bg-light'>
				<div class='mbr-section-head'>
						<h3 class='mbr-section-title mbr-fonts-style align-center mb-0 display-2'><strong>Password Reset</strong></h3>
						<h3 class='mbr-section-title mbr-fonts-style align-center mb-0 display-7'>Enter the email you registered with to send reset link</h3>
				</div>
				<div class='row justify-content-center mt-4'>
						<div class='col-12 col-lg-8 mx-auto mbr-form'>
								<form action='' method='POST' class='mbr-form form-with-styler mx-auto'>
										<div class=''>";

						if ($error != ''){
							echo
							"<div class='col alert alert-danger mbr-fonts-style mb-3 display-7' role='alert'>$error
							</div>";
						}
					echo"
										</div>

												<div class='col-lg-12 col-md-12 col-sm-12 form-group'>
														<input type='text' name='email' placeholder='Email'  class='form-control'>
												</div>

												<div class='col-auto mbr-section-btn align-center'>
														<button type='submit' class='btn btn-dark display-4' name='enter'>ENTER</button>
												</div>
										</div>
								</form>
						</div>
				</div>
		</div>

</section>";}
?>

<section style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>


	 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
	</body>
 </html>
