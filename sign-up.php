<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Sign Up – Swipe</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	</head>
	<body class="start">
		<main>
			<div class="layout">
				<!-- Start of Sign Up -->
				<div class="main order-md-2">
					<div class="start">
						<div class="container">
							<div class="col-md-12">
								<div class="content">
									<h1>Create Account</h1>
									<div class="third-party">
										<button class="btn item bg-blue">
											<i class="material-icons">pages</i>
										</button>
										<button class="btn item bg-teal">
											<i class="material-icons">party_mode</i>
										</button>
										<button class="btn item bg-purple">
											<i class="material-icons">whatshot</i>
										</button>
									</div>
									<p>or use your email for registration:</p>
									<form class="signup" method="post">
										<?php
										$conn=mysqli_connect("localhost","root","","chat");
										if(!$conn){
											echo $conn;
										}
										?>
										<div class="form-parent">
											<div class="form-group">
												<input name="name" type="text" id="inputName" class="form-control" placeholder="Username" required>
												<button class="btn icon"><i class="material-icons">person_outline</i></button>
											</div>
											<div class="form-group">
												<input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email Address" required>
												<button class="btn icon"><i class="material-icons">mail_outline</i></button>
											</div>
										</div>
										<div class="form-group">
											<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
											<button class="btn icon"><i class="material-icons">lock_outline</i></button>
										</div>
										<button type="submit" class="btn button" formaction="">Sign Up</button>
										<div class="callout">
											<span>Already a member? <a href="sign-in.php">Sign In</a></span>
										</div>
										<?php
										try{
											if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
												$name=$_POST['name'];
												$_SESSION['name']=$name;
												//$name=$name.trim();
												if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
													$message = "Invalid email format";
												}
												$n=explode(" ",$name);
												$email=$_POST['email'];
												$password=md5($_POST['password']);
												$message_id=$n[0].random_int(11111,99999);
											
												$_SESSION['message_id']=$message_id;
												$photo="user.png";
												$status ="online"; 
												$about="Hey there! I am using ChatHere.";
												setcookie("status", $status);
												$query="insert into user1(Name,Email,Password,Photo,user_id,about,status) values ('$name','$email','$password','$photo','$message_id','$about','$status')";
												$result=mysqli_query($conn,$query);
												if($result){
													date_default_timezone_set('Asia/Kolkata');
											        $date = date('h:i:s');
													$notification="Welcome to our website! ".$name." This is your first visit.";
													$qqqq="INSERT INTO notification(message_id,notification,date) VALUES ('$message_id','$notification','$date')";
													$result2=mysqli_query($conn,$qqqq);
													$_SESSION['noti']=$notification;
													if($result2){
														$success="Successfully Registered";
													}
												}
												else{
													$message="Please check your credientials";
												}
								
											}
										}
										catch(mysqli_sql_exception){
								        ?>
										<script>
										Swal.fire({
										icon: 'warning',
										title: 'Oops...',
										text: '<?php echo "Username Already Exists";?>',
										footer: '<a href="">Already have an account?</a>'
										})
										</script>	
                                        <?php
										
									    }
										?>
								
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sign Up -->
				<!-- Start of Sidebar -->
				<div class="aside order-md-1">
					<div class="container">
						<div class="col-md-12">
							<div class="preference">
								<h2>Welcome Back!</h2>
								<p>To keep connected with your friends please login with your personal info.</p>
								<a href="sign-in.php" class="btn button">Sign In</a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
	</body>
<?php
if(isset($message)){
	?>
<script>
    Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?php echo $message;?>',
  footer: '<a href="">Why do I have this issue?</a>'
})
</script>	
<?php	
}
?>
<?php
if(isset($success)){
	?>
<script>
	Swal.fire({
  title: '<?php echo $success;?><?php echo " ".$name;?>',
  showClass: {
    popup: 'animate__animated animate__fadeInDown'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
}).then(function(){
	window.location="index.php";
})
</script>	
<?php	
}
?>

</html>