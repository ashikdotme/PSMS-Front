<?php 
require_once('config.php');
session_start();

if(isset($_POST['st_login_btn'])){
	$st_username = $_POST['st_username']; 
	$st_password = $_POST['st_password'];
 
	if(empty($st_username)){
		$error = "Email or Mobile is Required!";
	} 
	else if(empty($st_password)){
        $error = "Password is Required!";
    } 
	else{
		
		$st_password = SHA1($st_password);
		// Find Login User 
		$stCount = $pdo->prepare("SELECT id,email,mobile FROM students WHERE (email=? OR mobile=?) AND password=?");
		$stCount->execute(array($st_username,$st_username,$st_password));
		$loginCount = $stCount->rowCount(); 
		if($loginCount == 1){
			$stData = $stCount->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION['st_loggedin'] = $stData;
			header('location:dashboard/index.php');
		}
		else{
			$error = "Username or Password is Wrong!";
		} 
	} 
}

if(isset($_SESSION['st_loggedin'])){
	header('location:dashboard/index.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	
	<!-- DESCRIPTION -->
	<meta name="description" content="PSMS - Student Login" />
	
	<!-- OG -->
	<meta property="og:title" content="PSMS - Student Login" />
	<meta property="og:description" content="PSMS - Student Login" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>PSMS - Student Login</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	
</head>
<body id="bg">
<div class="page-wraper">
	<div id="loading-icon-bx"></div>
	<div class="account-form">
		<div class="account-head" style="background-image:url(assets/images/background/bg2.jpg);">
			<a href="index.php"><img src="assets/images/logo-white-2.png" alt=""></a>
		</div>
		<div class="account-form-inner">
			<div class="account-container">
				<div class="heading-bx left">
					<h2 class="title-head">Student <span>Login</span></h2>
					<p>Don't have an account? <a href="registration.php">Registration Now</a></p>
				</div>	
				<form class="contact-bx" method="POST" action="">
					<?php if(isset($error)) :?>
					<div class="alert alert-danger">
						<?php echo $error;?>
					</div>
					<?php endif;?>

					<div class="row placeani">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label>Email or Mobile Number</label>
									<input name="st_username" type="text"  class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group"> 
									<label>Password</label>
									<input name="st_password" type="password" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group form-forget">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
									<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
								</div>
								<a href="forget-password.php" class="ml-auto">Forgot Password?</a>
							</div>
						</div>
						<div class="col-lg-12 m-b30">
							<button name="st_login_btn" type="submit" value="Submit" class="btn button-md">Login</button>
						</div>
					 
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/contact.js"></script> 
</body>

</html>
