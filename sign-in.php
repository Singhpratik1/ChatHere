<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Sign In – Swipe</title>
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
				<!-- Start of Sign In -->
				<div class="main order-md-1">
					<div class="start">
						<div class="container">
							<div class="col-md-12">
								<div class="content">
									<h1>Sign in to ChatHere</h1>
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
									<p>or use your email account:</p>
									<form method="post">
										<div class="form-group">
											<input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email Address" required>
											<button class="btn icon"><i class="material-icons">mail_outline</i></button>
										</div>
										<div class="form-group">
											<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
											<button class="btn icon"><i class="material-icons">lock_outline</i></button>
										</div>
										<button type="submit" class="btn button" formaction="">Sign In</button>
										<div class="callout">
											<span>Don't have account? <a href="sign-up.php">Create Account</a></span>
										</div>
										<?php
										$conn=mysqli_connect("localhost","root","","chat");
										if(isset($_POST['email']) && isset($_POST['password'])){
											$email=$_POST['email'];
											$q="SELECT Name,Email,password,user_id FROM user1 WHERE Email='$email'";
											$result=mysqli_query($conn,$q);
											
											if($result){
												
												$row=mysqli_fetch_assoc($result);
												if($row==0){
													$reg="Email not found. Please sign-up to get started.";
												}
												if($row>0){
												$_SESSION['message_id']=$row['user_id'];
												$_SESSION['name']=$row['Name'];
												$ps=$_POST['password'];
												if($row['Email']===$_POST['email']){
													if($row['password']===md5($ps)){
													$id=$row['user_id'];
													$status ="online"; 
												    setcookie("status", $status);
													$qq="UPDATE user1 SET status='$status' WHERE user_id='$id'";
													$result1=mysqli_query($conn,$qq);
													date_default_timezone_set('Asia/Kolkata');
											        $date = date('h:i:s');
													$notification=$row['Name'];
													$notification.=" you have log-in successfully.";
													$_SESSION['noti1']=$notification;
													$qqqq="INSERT INTO notification(message_id,notification,date) VALUES ('$id','$notification','$date')";
													$result2=mysqli_query($conn,$qqqq);
													
													if($result1){
													$message="Successfully log in";
													}
												}
												else{
													$error="Incorrect Password";
												}
											}
											else{
												$error="Please check your email";
											}
										}
											}
											else{
												$message1="Please check your credientials";
											}
										}
										?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sign In -->
				<!-- Start of Sidebar -->
				<div class="aside order-md-2">
					<div class="container">
						<div class="col-md-12">
							<div class="preference">
								<h2>Hello, Friend!</h2>
								<p>Enter your personal details and start your journey with ChatHere today.</p>
								<a href="sign-up.php" class="btn button">Sign Up</a>
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
if(isset($message1)){
	?>
<script>
    Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?php echo $message1;?>',
  footer: '<a href="">Why do I have this issue?</a>'
})
</script>	
<?php	
}
?>
<?php
if(isset($message)){
	?>
<script>
	Swal.fire({
  title: '<?php echo $message;?>',
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
<?php  
if(isset($error)){
	?>
	<script>
	Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?php echo $error;?>',
  footer: '<a href="">Why do I have this issue?</a>'
})
	</script>
	<?php
}
?>
<?php  
if(isset($reg)){
	?>
	<script>
	Swal.fire({
  title: '<?php echo $reg;?>',
  showClass: {
    popup: 'animate__animated animate__fadeInDown'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
})

	</script>
	<?php
}
?>
</html>