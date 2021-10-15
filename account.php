<?php
session_start();

if($_SESSION['id']==''){
 	header("location: index.php");
}

include 'db.php';
$error = '';
$success = '';

if(isset($_POST['save'])){

   if(empty($_POST["username"])|| empty($_POST["password"])|| empty($_POST["name"])){
		$error = "Display Name & Password  are required!";
   }
   else{
		$newname = $_POST["username"];
		$newpassword = $_POST["password"];
		$updatepass = 'UPDATE `users` SET `password` = ?, `name` = ? WHERE `users`.`id` = ?';
		$updatepass = $conn->prepare($updatepass);
		$updatepass -> bind_param("ssi", $newpassword, $newname, $_SESSION['id']);
		$updatepass -> execute();

		$_SESSION['name'] = $newname;
		$_SESSION['password'] = $newpassword;
		$success = "Changes made successfully!";
   }
}

if(isset($_POST['submit'])){
	$file = $_FILES['file'];
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'png', 'pdf');

	if(in_array($fileActualExt, $allowed)){
		if($fileError === 0){
			if($fileSize < 2000000){
				$fileNameNew = uniqid('', true).".".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$uploadimage = 'UPDATE `users` SET `image` = ? WHERE id = ?';
				$uploadimage = $conn->prepare($uploadimage);
				$uploadimage -> bind_param("si", $fileNameNew, $_SESSION['id']);
				$uploadimage -> execute();
				$success = "Upload was successsful";
			}
			else{
				$error = "Image size is too big";
			}
		}
		else{
			$error = "Error Uploading File!";
		}
	}
	else{
		$error = "Incorrect file type!";
	}
}

if(isset($_POST['delete'])){
	header("location: index.php");
	mysqli_query($conn, "DELETE from users WHERE `id` = '" . $_SESSION['id'] . "'");
	mysqli_query($conn, "DELETE from picks WHERE `id` = '" . $_SESSION['id'] . "'");
	mysqli_query($conn, "DELETE from comments WHERE `id` = '" . $_SESSION['id'] . "'");
}

	mysqli_close($conn);
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


  <title>Account</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons-bold/mobirise-icons-bold.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/formstyler/jquery.formstyler.css">
  <link rel="stylesheet" href="assets/formstyler/jquery.formstyler.theme.css">
  <link rel="stylesheet" href="assets/datepicker/jquery.datetimepicker.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
	<script src="https://kit.fontawesome.com/aae755a436.js" crossorigin="anonymous"></script>
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
	<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
	<link rel="stylesheet" href="nav.css">
	<link rel="stylesheet" href="mobile.css">

</head>

<body>

<?php require_once 'navbar.php'; ?>
<?php require_once 'mobileheadernoselect.php'; ?>
<?php require_once 'bannernoselect.php';?>

<section class="info3 cid-sdMFL7YqeV pt-0" id="info3-1u"  style='background-color: #013369;'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-12 col-lg-10">
                <div class="card-wrapper">
                    <div class="card-box align-center">
                        <h4 class="card-title mbr-fonts-style align-center mb-4 display-1 mobile"><strong>Account Settings</strong></h4>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div>
	<ul class="sticky nav nav-tabs mt-4">
		<li><a href="#zero" data-toggle="tab" class="mobile tabs menu display-7 active"><strong>User Details</strong></a></li>
		<li><a href="#one" data-toggle="tab" class="mobile tabs menu display-7"><strong>Profile Picture</strong></a></li>
		<li><a href="#two" data-toggle="tab" class="mobile tabs menu display-7"><strong>Account Removal</strong></a></li>
	</ul>
</div>

<div class="tab-content">
	<div class="tab-pane active" id="zero">
			<div class="namedesig">
				<section class="features1 cid-sdLYjLb4r0" id="features1-1d">
					<div class="p-8 container">

						<div class="row">
							<div class = 'container'>
								<div class='row pt-4 pb-0 mb-0'>
										<div class='col-12'>
												<h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>User Details </h3>
										</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 mbr-fonts-style display-7">
								<form  action = "" method = "post" name ="account form" id="accountform" >
									<div class="form-group row">
										<label for="id" class="col-4 col-lg-3 col-form-label">Username</label>
										<div class="col-6 col-lg-8">
											<input type="text" class="form-control" readonly name="username" id="username" value="<?php echo $_SESSION['username'];?> ">
										</div>
									</div>
									<div class="form-group row">
										<label for="id" class="col-4 col-lg-3 col-form-label">Name</label>
										<div class="col-6 col-lg-8">
											<input type="text" class="form-control" name="name" id="name" maxlength="20" value="<?php echo $_SESSION['name']; ?> ">
										</div>
									</div>
									<div class="form-group row">
										<label for="id" class="col-4 col-lg-3  col-form-label">Password</label>
										<div class="col-6 col-lg-8">
											<input type="password" class="form-control" name="password" id="password" minlength="6" value="<?php echo $_SESSION['password']; ?>">
										</div>
									</div>
									<div class="p-4 form-group row col-12">
										<button form = "accountform" type="submit" class="btn" name="save"  style='background-color: #013369; color:white;'>SAVE CHANGES</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>

		<div class="tab-pane" id="one">
				<div class="namedesig">
					<div class = 'container'>
						<div class='row pt-4 pb-0 mb-0'>
								<div class='col-12'>
										<h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>Profile Picture </h3>
								</div>
						</div>
						<div class='row pt-4 pb-0 mb-0' style="justify-content:center;">
							<div>
									<img src='uploads/<?php echo $_SESSION['image']; ?>' class='img-circle avatar' alt='user profile image' style='max-height:100px; max-width: 100px;';>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 mbr-fonts-style display-7 mt-4">
						<form action = "" method = "POST" enctype="multipart/form-data">
							<div class="form-group row"  style="justify-content:center;">

								<div class="col-7 col-lg-8">
									<input type="file" class="form-control-file" name="file">
								</div>
								<div class="p-4 form-group row col-12" style="justify-content:center;">
									<small>Crop the image to a square shape for best quality</small>
								</div>
								<div class="p-4 form-group row col-12" style="justify-content:center;">
									<button type="submit" class="btn" style='background-color: #013369; color:white;' name="submit">UPLOAD</button>
								</div>

							</div>
						</form>
					</div>
				</div>
		</div>

		<div class="tab-pane" id="two">
				<div class="namedesig">
					<div class="container">
					 <div class="row">
						 <div class = 'container'>
							 <div class='row pt-4 pb-0 mb-0'>
									 <div class='col-12'>
											 <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>Account Removal</h3>
									 </div>
							 </div>
						 </div>
						 <div class="col-12 col-lg-6 mbr-fonts-style display-7" >
							 <form action = "" method = "POST" enctype="multipart/form-data">
								 <div class="p-4 form-group row col-12" style="justify-content:center;">
									 <button type="submit" class="btn btn-primary" name="delete"  onclick="return confirm('Are you sure? This will delete your entire account');">DELETE ACCOUNT</button>
								 </div>
							 </form>
						 </div>
					 </div>
					</div>
				</div>
		</div>

</div>


<div class="p-4 container">
	<div class="row">
		<div class="col-4">

		</div>
		<div class="col-12 text-center">
			<?php
				if ($error != ""){
					echo
					"<div class='col-md-auto alert alert-danger mbr-fonts-style display-7' role='alert'>
					$error
					</div>";
				}
				elseif ($success != ""){
					echo
					"<div class='col-md-auto alert alert-success mbr-fonts-style display-7' role='alert'>
					$success
					</div>";
				}

				?>
		</div>
		<div class="col-4">
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


 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
  </body>
</html>
