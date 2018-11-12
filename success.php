<?php
	if (!isset($_POST['save'])) {
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>YUrShot</title>
	<meta name="viewport" content="width=device-width,user-scalable=no">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/ysfirst.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/ys.js"></script>
</head>
<body>
	<div class="pad">
		<span class="huge-text bold">
			YUr Shot
		</span>

		<a class="no-style right black pad bold center ten-plus nav-icon" href="index.php">
			<i class="fa fa-home big-text blue pad-right"></i>
			Home
		</a>
	</div>
	<br><br>

	<div class="main">
	<span class="medium-text black bold">
		Signup Details
	</span>
	<br><br><br><br><br>

		<?php
			if (isset($_POST['save'])) {
				$user=mysql_real_escape_string(htmlspecialchars($_POST['user'],ENT_QUOTES));
				$pass=mysql_real_escape_string(htmlspecialchars($_POST['pass'],ENT_QUOTES));
				$mail=mysql_real_escape_string(htmlspecialchars($_POST['mail'],ENT_QUOTES));
				$dp=$_FILES['dp']['name'];
				$dp_size=$_FILES['dp']['size'];
				$dp_type=$_FILES['dp']['type'];
				if ($user!="" && $pass!="" && $mail!="" && $dp!="") {
					if ($dp_type!="image/jpg" && $dp_type!="image/png" && $dp_type!="image/gif" && $dp_type!="image/jpeg" || $dp_size>5000000) {
					echo '
					<div class="border pad-plus">
						<i class="fa fa-bell-o extreme-text left blue pad-right"></i>
						<div class="pad-short-left seventy">
						The image uploaded is of an unsupported format
						<br>
						Kindly upload jpg,jpeg,gif or png format images
						<br>
						Or image size exceeds limit of 5mb.
						</div>
					</div>
					';
					}
					else {
						if (preg_match("/[^a-zA-Z0-9_]/", $user) || strlen($user)>20) {
					echo '
					<div class="border pad-plus">
						<i class="fa fa-bell-o extreme-text left blue pad-right"></i>
						<div class="pad-short-left seventy">
						The username used contains unsupported characters
						<br>
						Kindly use "_" underscore for seperators
						<br>
						Or the username characters are too long.
						</div>
					</div>
					';
					}
					else {
						include("db.php");
						$sql="SELECT name FROM ysuser WHERE name='$user'";
						$retval=mysql_query($sql);
						$num=mysql_num_rows($retval);
						mysql_free_result($retval);
						$sql2="SELECT mail FROM ysuser WHERE mail='$mail'";
						$retval2=mysql_query($sql2);
						$num2=mysql_num_rows($retval2);
						mysql_free_result($retval2);
						if ($num>0) {
						echo '
						<div class="border pad-plus">
							<i class="fa fa-bell-o extreme-text left blue pad-right"></i>
							<div class="pad-short-left seventy">
							The username used is already in use by another user
							<br>
							Kindly use another name such as "'.str_shuffle($user).'".
							</div>
						</div>
						';
						}
						elseif ($num2>0) {
						echo '
						<div class="border pad-plus">
							<i class="fa fa-bell-o extreme-text left blue pad-right"></i>
							<div class="pad-short-left seventy">
							The email used is already in use by another user
							<br>
							Kindly use another email.
							</div>
						</div>
						';
						}
						else {
							$id="YS".str_shuffle(1357181).time();
							$pas=md5($pass);
							move_uploaded_file($_FILES['dp']['tmp_name'], "upload/dp/".$dp);
							$path="upload/dp/".$dp;
							$shuff="upload/dp/"."YS_IMG_".time().str_shuffle("asdfghjklqwertyzxcvbn").".jpg";
							$img=rename($path, $shuff);
							$sql="INSERT INTO ysuser(who,name,passcode,mail,dp,status,notification) VALUES ('$id','$user','$pas','$mail','$shuff','Offline','no')";
							$retval=mysql_query($sql);
							if ($retval) {
								echo '
								<span class="medium-text bold">
								successful
								</span>
								<br><br>

								<div>
									<img src="'.$shuff.'" class="signup-img">
									<br><br><br>

									<span class="bold black">
									Username:
									</span>'.$user.'
									<br>
									<span class="bold black">
									Email:
									</span>'.$mail.'
									<br><br><br><br>

									<i class="left fa fa-bell-o extreme-text blue pad-right"></i>
									<div class="pad-short-left seventy left">
										You can edit your profile in the profile page and also<br>
										upload images according to the weeks trend. Also check<br>
										news in the events page. You can login into your account. 
									</div>
									<br><br><br><br><br><br><br>

									<div class="center full">
										<button class="no-style border black pad bold forty" onclick="javascript: location.href=\'index.php\'">
											<i class="fa fa-heart big-text blue pad-right"></i>
											Log in
										</button>
									</div>
								</div>
								';
							}
						}
						mysql_close($conn);
					}
					}
				}
				else {
					echo '
					<div class="border pad-plus">
						<i class="fa fa-bell-o extreme-text left blue pad-right"></i>
						<div class="pad-short-left seventy">
						Some input fields where left empty
						<br>
						Kindly fill in empty fields.
						</div>
					</div>
					';
				}
			}
		?>
		<br><br><br><br><br><br>

		<div class="center bold">
		&copy; Angel Works <?php echo date("Y"); ?>
		</div>
		</div>
</body>
</html>