<?php

session_start();

if($_SESSION['id']==''){
	header("location: index.php");
}

require_once 'db.php';

$userid = $_SESSION['id'];

$comments = mysqli_query($conn, "SELECT users.name, users.image, comments.comment, comments.time FROM users JOIN comments ON users.id = comments.id ORDER BY comments.time DESC");

if(isset($_POST['comment'])){
	if(isset($_POST['commentArea'])){
		$comment = $_POST['commentArea'];
        mysqli_query($conn, "INSERT INTO comments (id, comment, time) VALUES ('$userid', '$comment', now())");
		header("location: banter.php#commentArea");
	}
}

 mysqli_close($conn);
 ?>

 <!DOCTYPE html>
 <html  >
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="generator" content="Mobirise v5.2.0, mobirise.com">
   <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
   <link rel="shortcut icon" href="assets/images/sticon.png" type="image/x-icon">
   <meta name="description" content="">


   <title>Banter</title>
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
 	<link rel="stylesheet" href="flag-icon.css">

 </head>
 <body>

 <?php require_once 'navbar.php'; ?>
 <?php require_once 'mobileheadernoselect.php'; ?>
 <?php require_once 'bannernoselect.php';?>

 <div class = 'container d-block d-sm-none'>
   <div class='row pt-4 pb-0 mb-0'>
       <div class='col-12'>
           <h3 class='plan-title mbr-fonts-style mb-3 display-2 text-center text-muted' style='font-size:20px;'>Dogging Banter</h3>
       </div>
   </div>
 </div>

 <section class="collapse show features1 cid-sdLYjLb4r0 p-0" id="banter">
 	<div class="p-8 container">
 		<div class="row">
 			<div class="col-12 col-lg-8 mbr-fonts-style display-7">
 				<form action = "" method = "post" name ="comment" id="commentform" >
 					<div class="form-group row">
 						<div class="col-12 col-lg-8">
 							<textarea class="form-control" id="commentArea" name="commentArea" rows="2" maxlength="1000" placeholder='Add some banter...' required></textarea>
 						</div>
 						<div class="p-4 form-group row col-12 col-lg-3">
 							<button form = "commentform" type="submit" class="btn"  style='background-color: #013369; color:white;' name="comment">BANT</button>
 						</div>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
 </div>

 <?php
 foreach($comments as $c){
 $image = $c['image'];
 $name = $c['name'];
 $comment = $c['comment'];
 $time =  date('M j g:i', strtotime($c['time']));
 echo"
  <div class='p-1 container'>
     <div class='row'>
         <div class='col-12 text-center'>
             <div class='card card-white post border'>
                 <div class='post-heading'>
                     <div class='float-left image'>
                         <img src='uploads/$image' class='img-circle avatar' alt='user profile image' style='max-height:50px; max-width: 50px;';>
                     </div>
                     <div class='float-left meta'>
                         <div class='title h5'>
                             <a><b>$name</b></a>
                             made a post.
                         </div>
                         <h6 class='text-muted time'>$time</h6>
                     </div>
                 </div>
                 <div class='post-description'>
                     <p class = 'mbr-fonts-style mb-4 display-7'>$comment</p>

                 </div>
             </div>
         </div>

     </div>
 </div>";}
 ?>
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
 	 	 <i class='material-icons mobilenav__icon   mobilenav__link--active'>question_answer</i>
 	 	 <span class='nav__text'>Bantz</span>
 	  </a>
 		<a href='more.php' class='mobilenav__link'>
 			<i class='material-icons mobilenav__icon'>add</i>
 			<span class='nav__text'>More</span>
 		</a>
 	</nav>
 </div>

 <section class="d-none" style="background-color: rgb(34, 153, 170); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif; color:#aaa; font-size:12px; padding: 0; align-items: center; display: flex;"><a href="https://mobirise.site/h" onclick="return false;" style="flex: 1 1; height: 3rem; padding-left: 1rem;"></a><a href="policy.html"><p style="color: rgb(255, 255, 255); fill: rgb(255, 255, 255);">Privacy Policy</p></a></section><script src="assets/web/assets/jquery/jquery.min.js"></script>  <script src="assets/popper/popper.min.js"></script>  <script src="assets/tether/tether.min.js"></script>  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/dropdown/js/nav-dropdown.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>  <script src="assets/theme/js/script.js"></script>

    <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a></div>
   </body>
 </html>
