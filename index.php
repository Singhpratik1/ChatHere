<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<title>Swipe – The Simplest Chat Platform</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
    <title>Document</title>
</head>
<script>
$(document).ready(function () {
    $("#button").click(function () {
        // Load messages from "from.php"
        $("#contacts").load("demo1.php", function () {
            // Messages have been loaded
            // You can perform additional actions here if needed
        });
    });
});
</script>
	<body>
		<main>
			<div class="layout">
				<!-- Start of Navigation -->
				<div class="navigation">
					<div class="container">
						<div class="inside">
							<div class="nav nav-tab menu">
							<?php
							$aa=$_SESSION['message_id'];
							$q="SELECT Photo FROM user1 WHERE user_id='$aa'";
							$conn=mysqli_connect("localhost","root","","chat");
							$result=mysqli_query($conn,$q);
							
							if($result){
								$row=mysqli_fetch_assoc($result);	
							?>
								<button class="btn"><img class="avatar-xl" src="<?php echo $row['Photo'];?>" alt="avatar"></button>
							<?php
							}
							?>
							<a href="#members" data-toggle="tab"><i class="material-icons">account_circle</i></a>
							<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
							<a href="#notifications" data-toggle="tab" class="f-grow1"><i class="material-icons">notifications_none</i></a>
							<button class="btn mode"><i class="material-icons">brightness_2</i></button>
							<a href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
							<form method="post">
							<button name="logout1" class="btn power"><i class="material-icons">power_settings_new</i></button>
							<?php
							if(isset($_POST['logout1'])){
								$status ="offline"; 
							    setcookie("status", $status);
								$query="UPDATE user1 SET status='$status' WHERE user_id='$aa'";
								$result=mysqli_query($conn,$query);
								if($result){
									?>
									<script>
									window.location.href = "sign-in.php"
									</script>
									<?php
										}
									}
									?>
							/form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Navigation -->
				<!-- Start of Sidebar -->
				<div class="sidebar" id="sidebar">
				
					<div class="container">
						<div class="col-md-12">
							<div class="tab-content">
								<!-- Start of Contacts -->
								<div class="tab-pane fade" id="members">
									<div class="search">
										<form class="form-inline position-relative">
											<input name="search" type="search" class="form-control" id="people" placeholder="Search for people...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
											<?php
											if(isset($_POST['search'])){
												$name=$_POST['search'];
												$me=$_SESSION['message_id'];
												$from="";
												$message="";
												date_default_timezone_set('Asia/Kolkata');
											    $date = date('h:i:s');
												$qq="SELECT user_id from user1 WHERE Name='$name'";
												$result=mysqli_query($conn,$qq);
												if($result){
													$row=mysqli_fetch_assoc($result);
													$from=$row['messange_id'];
												}
												$q="INSERT INTO all_message(Name,messange_id,message_id_from,message,date) VALUES ('$name','$me','$from','$message','$date')";
												$result=mysqli_query($conn,$q);
												if($result){
												}
											}
											?>
										</form>
										<button class="btn create" data-toggle="modal" data-target="#exampleModalCenter"><i class="material-icons">person_add</i></button>
									</div>
									<div class="list-group sort">
										<button class="btn filterMembersBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterMembersBtn" data-toggle="list" data-filter="online">Online</button>
										<button class="btn filterMembersBtn" data-toggle="list" data-filter="offline">Offline</button>
									</div>						
									<div class="contacts">
										<h1>Contacts</h1>
										<div class="list-group contact1" id="contacts" role="tablist">
										<?php
										$conn=mysqli_connect("localhost","root","","chat");
									if(!$conn){
									}
									?>
									<?php
									$aa=$_SESSION['message_id'];
									$q="SELECT *FROM user1";
									$result=mysqli_query($conn,$q);								
									if($result){
										while($row=mysqli_fetch_assoc($result)){																						
										?>	
											<a id="button" href="#" class="filterMembers all <?php echo $row['status'];?> contact" data-toggle="list" data-name="<?php echo $row['Name']; ?>" data-contact-id="<?php echo $row['user_id']; ?>">
												<img class="avatar-md" src="<?php echo $row['Photo'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['Name'];?>" alt="avatar">
												<div class="status">
													<i class="material-icons <?php echo $row['status'];?>">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5 class="contact11" data-id="<?php echo $row['user_id'];?>"><?php echo $row['Name'];?></h5>
													<p>Sofia, Bulgaria</p>
												</div>
												<div class="person-add">
													<i class="material-icons">person</i>
												</div>
											</a>
										<?php
										}
											}
										?>

										<?php
										if(isset($_COOKIE['ss'])){
											$messageId = $_COOKIE['ss'];
										}
										
										
										?>	
										<script>
										function setCookie(name, value) {
										    document.cookie = `${name}=${value}; path=/`;
										}
										
										// Attach a click event listener to each contact
										const contactList = document.getElementById('contacts');
										const contacts = contactList.getElementsByClassName('contact11');
										
										for (const contact of contacts) {
										    contact.addEventListener('click', function() {
										        const idName = this.getAttribute('data-id');
										        setCookie('ss', idName);
										        
										    });
										}
										</script>
							</div>
									</div>
								</div>
								<!-- End of Contacts -->
								<!-- Start of Discussions -->
								<div id="discussions" class="tab-pane fade active show">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
										<button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="material-icons">create</i></button>
									</div>
									<div class="list-group sort">
										<button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="read">Read</button>
										<button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="unread">Unread</button>
									</div>						
									<div class="discussions">
										<h1>Discussions</h1>
										<div class="list-group" id="chats" role="tablist">
										<?php
										$rr=$_SESSION['message_id'];
										$query="SELECT name,message,date,message_id_from FROM all_message WHERE messange_id='$rr'";
										$result=mysqli_query($conn,$query);
										while($row=mysqli_fetch_assoc($result)){
											$rr=$row['message_id_from'];
										$q="SELECT Name,Photo FROM user1 WHERE user_id='$rr'";
										$r=mysqli_query($conn,$q);
										if($r){
											$row1=mysqli_fetch_assoc($r);    
															    
										?>
											<a href="#list-empty" class="filterDiscussions all unread single" id="list-empty-list" data-toggle="list" role="tab">
												<img class="avatar-md" src="<?php echo $row1['Photo'];?>" data-toggle="tooltip" data-placement="top" title="Michael" alt="avatar">
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="new bg-pink">
													<span>+1</span>
												</div>
												<div class="data">
													<h5><?php echo $row['name'];?></h5>
													<span><?php echo $row['date'];?></span>
													<p><?php echo $row['message'];?></p>
												</div>
											</a>
											<?php
										}
										}?>									
							
										</div>
									</div>
								</div>
								<!-- End of Discussions -->
								<!-- Start of Notifications -->
								<div id="notifications" class="tab-pane fade">
									<div class="search">
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="notice" placeholder="Filter notifications...">
											<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
										</form>
									</div>
									<div class="list-group sort">
										<button class="btn filterNotificationsBtn active show" data-toggle="list" data-filter="all">All</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="latest">Latest</button>
										<button class="btn filterNotificationsBtn" data-toggle="list" data-filter="oldest">Oldest</button>
									</div>						
									<div class="notifications">
										<h1>Notifications</h1>
										<div class="list-group" id="alerts" role="tablist">
										<?php
										$rr=$_SESSION['message_id'];
										$query="SELECT  *FROM notification WHERE message_id='$rr'";
										$result=mysqli_query($conn,$query);
										while($row=mysqli_fetch_assoc($result)){
											$rr=$row['message_id_from'];
										$q="SELECT Name,Photo,user_id,status FROM user1 WHERE user_id='$rr'";
										$arr=array("pp");
										$rrr=$row['message_id_from'];
										$result1=mysqli_query($conn,$q);
										
										if($row > 0){    
											$ph="logo.png";
											if(isset($_SESSION['noti']) || isset($_SESSION['noti'])){
											$vv=$_SESSION['noti'];
											$vvv=$_SESSION['noti1'];
											}
											if(isset($vv) && $row['notification']!==$vv){
												$ph=$row1['Photo'];
												
											}
											elseif(isset($vvv) && $row['notification']!==$vvv){
												$ph=$row1['Photo'];
											}
										?>
											<a href="#" class="filterNotifications all latest notification" data-toggle="list">
												<img class="avatar-md" src="<?php echo $ph;?>" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons <?php echo $row1['status'];?>">fiber_manual_record</i>
												</div>
												<div class="data">
													<p><?php echo $row['notification'];?></p>
													<span><?php echo $row['date'];?></span>
												</div>
											</a>
											<?php
										
										}
										
										}?>
										</div>
									</div>
								</div>
								<!-- End of Notifications -->
								<!-- Start of Settings -->
								<div class="tab-pane fade" id="settings">			
									<div class="settings">
										<div class="profile">
										<?php
										$rr=$_SESSION['message_id'];
										$about="";
										$query="SELECT Name,Photo,about FROM user1 WHERE user_id='$rr'";
										$result=mysqli_query($conn,$query);
										if($result){
											$row=mysqli_fetch_assoc($result); 
											$about=$row['about']; 
											if($row==0){
												?>
												<img class="avatar-xl" src="user.png" alt="avatar">
												<h1><a href="#"></a></h1>
												<?php
											}  
											if($row>0){
										?>
											<img class="avatar-xl" src="<?php echo $row['Photo'];?>" alt="avatar">
											<h1><a href="#"><?php echo $row['Name'];?></a></h1>
											<?php
															}
														}
											?>
											<?php
											$rr=$_SESSION['message_id'];
											$q="SELECT *FROM user1";
											$q1="SELECT *FROM all_message WHERE message_id_from='$rr'";
											$q2="SELECT *FROM notification WHERE message_id='$rr'";
											$result1=mysqli_query($conn,$q1);
											$result=mysqli_query($conn,$q);
											$result2=mysqli_query($conn,$q2);
											$rowq=0;
											$row1q=0;
											$row2q=0;
											if($result){
												while($row=mysqli_fetch_assoc($result)){
													$rowq+=1;
												}
												while($row1=mysqli_fetch_assoc($result1)){
													$row1q+=1;
												}
												while($row2=mysqli_fetch_assoc($result2)){
													$row2q+=1;
												}
											?>
											<span><?php echo $about;?></span>
											<div class="stats">
												<div class="item">
													<h2><?php echo $rowq;?></h2>
													<h3>Contact</h3>
												</div>
												<div class="item">
													<h2><?php echo $row1q;?></h2>
													<h3>Chats</h3>
												</div>
												<div class="item">
													<h2><?php echo $row2q;?></h2>
													<h3>Notifiacation</h3>
												</div>
											</div>
											<?php
															}
															?>
										</div>
										<div class="categories" id="accordionSettings">
											<h1>Settings</h1>
											<!-- Start of My Account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<i class="material-icons md-30 online">person_outline</i>
													<div class="data">
														<h5>My Account</h5>
														<p>Update your profile details</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
													<div class="content">
														<div class="upload">
															<div class="data">
															<?php
															$rr=$_SESSION['message_id'];
											
															$query="SELECT Photo FROM user1 WHERE user_id='$rr'";
															$result=mysqli_query($conn,$query);
															if($result){
																$row=mysqli_fetch_assoc($result);    
															?>
																<img class="avatar-xl" src="<?php echo $row['Photo'];?>" alt="image">
																<?php
																}
																?>
																<form action="" method="post" enctype="multipart/form-data">
																<label>
																	<input name="image" type="file">
																	<span class="btn button">Upload avatar</span>
																	<button name="ss">ok</button>
																</label>
																<?php
																if(isset($_POST['ss'])){
																	$rr=$_SESSION['message_id'];
																	$files=$_FILES['image']['name'];
																	$tmpname=$_FILES['image']['tmp_name'];
																	$folder="./avatars/".$files;
																	move_uploaded_file($tmpname,$folder);
																	$query="UPDATE user1 SET Photo='$folder' WHERE user_id='$rr'";
																	$result=mysqli_query($conn,$query);
																	
																}
																?>
																
																<form>
															</div>
															<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
														</div>
														<form method="post">
															<?php 
															$rr=$_SESSION['message_id'];
															$q="SELECT *FROM user1 WHERE user_id='$rr'";
															$result=mysqli_query($conn,$q);
															if($result){
																$row=mysqli_fetch_assoc($result);
																?>

															<div class="field">
																<label for="Name">Enter Your name <span>*</span></label>
																<input name="name" type="text" class="form-control" id="lastName" placeholder="Last name" value="<?php echo $row['Name'];?>" required>
															</div>
															
															<div class="field">
																<label for="email">Email <span>*</span></label>
																<input name="email" type="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo $row['Email'];?>" required>
															</div>
															<div class="field">
																<label for="password">Password</label>
																<input name="password" type="password" class="form-control" id="password" placeholder="Enter a new password" value="<?php echo $row['password'];?>" required>
															</div>
															<div class="field">
																<label for="about">About</label>
																<input name="about" type="text" class="form-control" id="location" placeholder="Enter your location" value="<?php echo $row['about'];?>" required>
															</div>
															<button name="submit" type="submit" class="btn button w-100">Apply</button>
															
															
															<?php
															}
															?>
															<?php
							
															if(isset($_POST['submit'])){
																$rr=$_SESSION['message_id'];
																$n=$_POST['name'];
																$email=$_POST['email'];
																$pass=md5($_POST['password']);
																$about=$_POST['about'];
																$q="UPDATE user1 SET Name='$n',Email='$email',password='$pass',about='$about' WHERE user_id='$rr'";
																$result=mysqli_query($conn,$q);
															}
															?>
															</form>
															<form action="" method="post">
															<button name="delete" class="btn btn-link w-100">Delete Account</button>
															<?php
															if(isset($_POST['delete'])){
																$rr=$_SESSION['message_id'];
																$q="DELETE FROM user1 WHERE user_id='$rr'";
																$result=mysqli_query($conn,$q);
																if($result){
																	$confirm="Your account has successfully Deleted";
																}	
															}
															?>
														</form>
													</div>
												</div>
											</div>
											<!-- End of My Account -->
											<!-- Start of Chat History -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
													<i class="material-icons md-30 online">mail_outline</i>
													<div class="data">
														<h5>Chats</h5>
														<p>Check your chat history</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="history">
															<p>When you clear your conversation history, the messages will be deleted from your own device.</p>
															<p>The messages won't be deleted or cleared on the devices of the people you chatted with.</p>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="same-address">
																<label class="custom-control-label" for="same-address">Hide will remove your chat history from the recent list.</label>
															</div>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="save-info">
																<label class="custom-control-label" for="save-info">Delete will remove your chat history from the device.</label>
															</div>
															<button type="submit" class="btn button w-100">Clear blah-blah</button>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Chat History -->
											<!-- Start of Notifications Settings -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
													<i class="material-icons md-30 online">notifications_none</i>
													<div class="data">
														<h5>Notifications</h5>
														<p>Turn notifications on or off</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Desktop Notifications</h5>
																<p>You can set up Swipe to receive notifications when you have new messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Unread Message Badge</h5>
																<p>If enabled shows a red badge on the Swipe app icon when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Taskbar Flashing</h5>
																<p>Flashes the Swipe app on mobile in your taskbar when you have new notifications.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Notification Sound</h5>
																<p>Set the app to alert you via notification sound when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Vibrate</h5>
																<p>Vibrate when receiving new messages (Ensure system vibration is also enabled).</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Turn On Lights</h5>
																<p>When someone send you a text message you will receive alert via notification light.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Notifications Settings -->
											<!-- Start of Connections -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
													<i class="material-icons md-30 online">sync</i>
													<div class="data">
														<h5>Connections</h5>
														<p>Sync your social accounts</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionSettings">
													<div class="content">
														<div class="app">
															<img src="dist/img/integrations/slack.svg" alt="app">
															<div class="permissions">
																<h5>Skrill</h5>
																<p>Read, Write, Comment</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/dropbox.svg" alt="app">
															<div class="permissions">
																<h5>Dropbox</h5>
																<p>Read, Write, Upload</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/drive.svg" alt="app">
															<div class="permissions">
																<h5>Google Drive</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/trello.svg" alt="app">
															<div class="permissions">
																<h5>Trello</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Connections -->
											<!-- Start of Appearance Settings -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
													<i class="material-icons md-30 online">colorize</i>
													<div class="data">
														<h5>Appearance</h5>
														<p>Customize the look of Swipe</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Turn Off Lights</h5>
																<p>The dark mode is applied to core areas of the app that are normally displayed as light.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round mode"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Appearance Settings -->
											<!-- Start of Language -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
													<i class="material-icons md-30 online">language</i>
													<div class="data">
														<h5>Language</h5>
														<p>Select preferred language</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="language">
															<label for="country">Language</label>
															<select class="custom-select" id="country" required>
																<option value="">Select an language...</option>
																<option>English, UK</option>
																<option>English, US</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Language -->
											<!-- Start of Privacy & Safety -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
													<i class="material-icons md-30 online">lock_outline</i>
													<div class="data">
														<h5>Privacy & Safety</h5>
														<p>Control your privacy settings</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseSeven" aria-labelledby="headingSeven" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Keep Me Safe</h5>
																<p>Automatically scan and delete direct messages you receive from everyone that contain explict content.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>My Friends Are Nice</h5>
																<p>If enabled scans direct messages from everyone unless they are listed as your friend.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Everyone can add me</h5>
																<p>If enabled anyone in or out your friends of friends list can send you a friend request.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Friends of Friends</h5>
																<p>Only your friends or your mutual friends will be able to send you a friend reuqest.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Data to Improve</h5>
																<p>This settings allows us to use and process information for analytical purposes.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Data to Customize</h5>
																<p>This settings allows us to use your information to customize Swipe for you.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Privacy & Safety -->
											<!-- Start of Logout -->
											<div class="category">
												<form action="" method="post">
												<a name="logout" href="sign-in.php" class="title collapsed">
													<i class="material-icons md-30 online">power_settings_new</i>
													<div class="data">
														<h5>Power Off</h5>
														<p>Log out of your account</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												
												</form>
											</div>
											<!-- End of Logout -->
										</div>
									</div>
								</div>
								<!-- End of Settings -->
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
				<!-- Start of Add Friends -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Add your friends</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="user">UserId:</label>
										<input name="recepient1" type="text" class="form-control" id="user" placeholder="Add recipient..." required>
										<div class="user" id="contact">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="welcome">Message:</label>
										<textarea class="text-control" id="welcome" placeholder="Send your welcome message...">Hi Keith, I'd like to add you as a contact.</textarea>
									</div>
									<button type="submit" class="btn button w-100">Send Friend Request</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Add Friends -->
				<!-- Start of Create Chat -->
				<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Start new chat</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form method="post">
									<div class="form-group">
										<label for="participant">Recipient-Id:</label>
										<input name="recepient" type="text" class="form-control" id="participant" placeholder="Add recipient..." required>
										<div class="user" id="recipient">
											<img class="avatar-sm" src="" alt="avatar">
											<h5></h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="topic">Topic:</label>
										<input type="text" class="form-control" id="topic" placeholder="What's the topic?" required>
									</div>
									<div class="form-group">
										<label for="message">Message:</label>
										<textarea name="message" class="text-control" id="message" placeholder="Send your welcome message...">Hmm, are you friendly?</textarea>
									</div>
									<button type="submit" class="btn button w-100">Start New Chat</button>
									<?php
									
									?>
									<?php
									$name="pppp";
									if(isset($_POST['recepient'])){
										$rec=$_POST['recepient'];
										$q="SELECT Name,user_id FROM user1 WHERE user_id='$rec'";
										$result=mysqli_query($conn,$q);
										if($result){
											$row=mysqli_fetch_assoc($result);
											if($row){
												$name=$row['Name'];
											
											}
										}
										if(isset($_POST['message']) && isset($name)){
											$mess=$_POST['message'];
											$me=$_SESSION['message_id'];
											date_default_timezone_set('Asia/Kolkata');
											$date = date('h:i:s');
											$q="INSERT INTO all_message(name, messange_id, message_id_from, message, date) VALUES ('$name','$rec','$me','$mess','$date')";
											$result=mysqli_query($conn,$q);
											if($result){
												
											}
										}
									}
									?>
								</form>
							</div>
						</div>
					</div>
				</div>
				
				<!-- End of Create Chat -->
				<div class="main">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
						<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat1">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
											<?php
											$rr=$messageId;
							
											$query="SELECT Name,Photo,status FROM user1 WHERE user_id='$rr'";
											$result=mysqli_query($conn,$query);
											if($result){
											
											$row=mysqli_fetch_assoc($result);
											if($row==0){    
										         ?>
											<div class="status">
											</div>
											<div class="data">
											<h5><a href="#"></a></h5>
											<span></span>
											<?php
											}
										         ?>
											<?php

											if($row>0){
												?>
												<a href="#"><img class="avatar-md" src="<?php echo $row['Photo'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['Name'];?>" alt="avatar"></a>
												
												<div class="status">
													<i class="material-icons <?php echo $row['status'];?>">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#"><?php echo $row['Name'];?></a></h5>
													<span><?php echo $row['status'];?></span>
													<?php
															}
															}
															?>
												</div>
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="1"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="1"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<form class="position-relative w-100" method="post">
								<?php
								if(isset($_POST['typing'])){
									$con=1;
									$messa=$_POST['typing'];
									$from=$_SESSION['message_id'];
									$name1=$_SESSION['name'];
								
									date_default_timezone_set('Asia/Kolkata');
								$date = date('h:i:s');
									if($con===1){
										$notification=$name1." have just sent you a new message";
										$qqqq="INSERT INTO notification(message_id,message_id_from,notification,date) VALUES ('$messageId','$from','$notification','$date')";
										$result2=mysqli_query($conn,$qqqq);
									}
									$con+=1;
									$q="INSERT INTO all_message(name,messange_id,message_id_from,message,date) VALUES ('$name1','$from','$messageId','$messa','$date')";
									$result=mysqli_query($conn,$q);
									if($result){

									}
								}
								?>
								<div class="content" id="content">
									<div class="container" id="mess">
										<div class="col-md-12">
											<div class="date">
												<hr>
												<span>Yesterday</span>
												<hr>
											</div>
											<?php
											if(isset($_POST['typing']) || isset($messageId)){
											$qq=$_SESSION['message_id'];
											$qqq=$messageId;
									
											$conn=mysqli_connect("localhost","root","","chat");
											$q = "SELECT name, message, date, message_id_from, messange_id FROM all_message";
											$result = mysqli_query($conn, $q);

											if ($result) {
												while ($row = mysqli_fetch_assoc($result)) {
													
													if ($row['message'] != "" && ($row['messange_id'] === $qqq && $row['message_id_from']=== $qq)) {
														// Start the message container

														?>
														<?php
															$rr=$_SESSION['message_id'];
											
															$query="SELECT Name,Photo FROM user1 WHERE user_id='$qqq'";
															$result1=mysqli_query($conn,$query);
															if($result1){
																$row1=mysqli_fetch_assoc($result1);    
															?>
														<div class="message">
												<img class="avatar-md" src="<?php echo $row1['Photo'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row1['Name'];?>" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text">
														<p><?php echo $row['message'];?></p>
														</div>
													</div>
													<span><?php echo $row['date'];?></span>
												</div>
											</div>
											<?php
											}
												}
											?>		
											<?php
											if ($row['message'] != "" && ($row['messange_id'] === $qq && $row['message_id_from']=== $qqq)) {
												// Start the message container
											?>
														<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p><?php echo $row['message'];?></p>
														</div>
													</div>
													<span><?php echo $row['date'];?></span>
												</div>
											</div>
											<?php
													}
													?>
													<?php
												}
											}
											
											}

											?>
											<div class="message">
											<?php
											$query="SELECT Name,Photo FROM user1 WHERE user_id='$qqq'";
											$result=mysqli_query($conn,$query);
											if($result){
												$row=mysqli_fetch_assoc($result);    
											?>
												<img class="avatar-md" src="<?php echo $row['Photo'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['Name'];?>" alt="avatar">
												<?php
												}
												?>
												<div class="text-main">
													<div class="text-group">
														<div class="text typing">
															<div class="wave">
																<span class="dot"></span>
																<span class="dot"></span>
																<span class="dot"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
												<textarea name="typing" class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<button class="btn send"><i class="material-icons">send</i></button>											
											</form>
											<label>
												<input type="file">
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call1">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="1"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat2">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Lean Avent</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="2"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="2"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages">
												<i class="material-icons md-48">forum</i>
												<p>Seems people are shy to start the chat. Break the ice send the first message.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<button type="submit" class="btn send"><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call2">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-2.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="2"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-request" role="tabpanel" aria-labelledby="list-request-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat3">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#"><?php echo $_SESSION['name'];?></a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages request">
												<a href="#"><img class="avatar-xl" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<h5>Louis Martinez would like to add you as a contact. <span>Hi Keith, I'd like to add you as a contact.</span></h5>
												<div class="options">
													<button class="btn button"><i class="material-icons">check</i></button>
													<button class="btn button"><i class="material-icons">close</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Messaging unavailable" rows="1" disabled></textarea>
												<button class="btn emoticons disabled" disabled><i class="material-icons">insert_emoticon</i></button>
												<button class="btn send disabled" disabled><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file" disabled>
												<span class="btn attach disabled d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						</div>
						<!-- End of Babble -->
					</div>
				</div>
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/swipe.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
		
		<script>
			function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
			scrollToBottom(document.getElementById('content'));
		</script>
		
	</body>
<?php
if(isset($confirm)){
?>
<script>
Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: '<?php echo $confirm;?>',
  showConfirmButton: false,
  timer: 1500
}).then(function () {
  // This function will be executed after the timer (1500 ms) expires
  window.location.href = 'sign-up.php'; // Replace 'new_page.html' with the URL you want to redirect to
});
</script>
<?php
}

?></html>
