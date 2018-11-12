<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	$id=$_SESSION['ysagent'];
	include("db.php");
	$sql="SELECT * FROM ysuser WHERE who='$id'";
	$retval=mysql_query($sql);
	$row=mysql_fetch_array($retval);
	$name=$row['name'];
	$dps=$row['dp'];
	$event=$row['notification'];
	if ($event == "yes") {
		$event_show="<span class='pad-left red bold big-text'>*</span>";
	}
	else {
		$event_show="";
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>YUrShot</title>
	<meta name="viewport" content="width=device-width,user-scalable=no">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/ys.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/ys.js"></script>
</head>
<body>
	<div class="large-head ys-none">
		<img src="<?php echo $dps; ?>" class="nav-img">
		<br><br>

		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='event.php'">
			<i class="fa fa-bell-o huge-text left blue pad-right-long"></i>
			<span class="bold blue">
				Events <?php echo $event_show; ?>
			</span>
			<br>
			check notifications.
		</button>
		<br><br>



		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='me.php'">
			<i class="fa fa-male huge-text left blue pad-right-long"></i>
			<span class="bold blue pad-left uppercase">
				<?php echo $name; ?>
			</span>
			<br>
			<span class="pad-left">
			check your profile.
			</span>
		</button>
		<br><br>

		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='main.php'">
			<i class="fa fa-home huge-text left blue pad-right-long"></i>
			<span class="bold blue">
				Home
			</span>
			<br>
			go back to home page
		</button>
	</div>
	<div class="small-head ys-not-none">
	<div class="seventy right">
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='main.php';">
			<i class="fa fa-home medium-text"></i>
		</button>
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='me.php';">
			<i class="fa fa-user medium-text"></i>
		</button>
		<button class="right thirty trans pad" onclick="javascript: location.href='event.php';">
			<i class="fa fa-bell-o medium-text"></i> <?php echo $event_show; ?>
		</button>
	</div>
		<img src="<?php echo $dps; ?>" class="small-img left pad-right">
		<span class="bold uppercase">
			<?php echo $name; ?>
		</span>
		<br>
		My Page
	</div>



		<br>
		<?php
			if (isset($_POST['savedp'])) {
				$dp=$_FILES['dp']['name'];
				$dp_size=$_FILES['dp']['size'];
				$dp_type=$_FILES['dp']['type'];
				if ($dp=="") {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue extreme-text left pad-right-short"></i>
						The image content is empty<br>
						Kindly upload a valid photo.
					</div>
					'.'<br><br><br>';
				}
				else {
					if ($dp_type!="image/jpg" && $dp_type!="image/png" && $dp_type!="image/gif" && $dp_type!="image/jpeg" || $dp_size>5000000) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The image uploaded is of an unsupported format<br>
						Or the image exceeds maximum limit of 5mb<br>
						Kindly upload a valid photo.
					</div>
					'.'<br><br><br>';
					}
					else {
							unlink($dps);
							move_uploaded_file($_FILES['dp']['tmp_name'], "upload/dp/".$dp);
							$path="upload/dp/".$dp;
							$shuff="upload/dp/"."YS_IMG_".time().str_shuffle("asdfghjklqwertyzxcvbn").".jpg";
							$img=rename($path, $shuff);
							$sql2="UPDATE ysuser SET dp='$shuff' WHERE who='$id'";
							$retval2=mysql_query($sql2);
							if ($retval2) {
								header("location:edit.php");
							}
					}
				}
			}
			else if (isset($_POST['saveupto'])) {
				$upto=mysql_real_escape_string(htmlspecialchars($_POST['upto'],ENT_QUOTES));
				if ($upto=="") {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Status uploaded contains an empty thread<br>
						Kindly upload a valid status.
					</div>
					'.'<br><br><br>';
				}
				else {
					$sql2="UPDATE ysuser SET upto='$upto' WHERE who='$id'";
					$retval2=mysql_query($sql2);
					if ($retval2) {
						header("location:me.php");
					}
				}
			}
			else if (isset($_POST['saveuser'])) {
				$user=mysql_real_escape_string(htmlspecialchars($_POST['user'],ENT_QUOTES));
				if (empty($user)) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Username uploaded contains an empty thread<br>
						Kindly upload a valid username.
					</div>
					'.'<br><br><br>';
				}
				else {
						if (preg_match("/[^a-zA-Z0-9_]/", $user) || strlen($user)>20) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o extreme-text left blue pad-right-short"></i>
						The username used contains unsupported characters
						<br>
						Kindly use "_" underscore for seperators
						<br>
						Or the username characters are too long.
					</div>
					'.'<br><br><br>';
					}
					else {
						$sql2="SELECT name FROM ysuser WHERE name='$user'";
						$retval2=mysql_query($sql2);
						$num2=mysql_num_rows($retval2);
						mysql_free_result($retval2);
						if ($num2>0) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Username uploaded as been used by another user<br>
						Kindly upload another username or use '.str_shuffle($user).'
					</div>
					'.'<br><br><br>';
						}
						else {
							$sql3="UPDATE ysuser SET name='$user' WHERE who='$id'";
							$retval3=mysql_query($sql3);
							if ($retval3) {
								header("location:me.php");
							}
						}
					}
				}
			}
			else if (isset($_POST['savepass'])) {
				$oldpass=mysql_real_escape_string(htmlspecialchars($_POST['oldpass'],ENT_QUOTES));
				$newpass=mysql_real_escape_string(htmlspecialchars($_POST['newpass'],ENT_QUOTES));
				if ($oldpass=="" || $newpass=="") {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						Some Password field was left empty<br>
						Kindly fill in all password field<br>
						To implement a change.
					</div>
					'.'<br><br><br>';
				}
				else {
					$opass=md5($oldpass);
					$npass=md5($newpass);
					$sql2="SELECT who,passcode FROM ysuser WHERE who='$id'";
					$retval2=mysql_query($sql2);
					$row2=mysql_fetch_array($retval2);
					$pass=$row2['passcode'];
					if ($pass!=$opass) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Old password provided cannot be accepted<br>
						It is incorrect.
					</div>
					'.'<br><br><br>';
					}
					else {
						$sql3="UPDATE ysuser SET passcode='$npass' WHERE who='$id'";
						$retval3=mysql_query($sql3);
						if ($retval3) {
							echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-male blue left extreme-text pad-right"></i>
						Password has been succesfully changed<br>
						Now try new password.
						<br><br><br>
						<form method="GET" action="me.php">
							<button class="border bold pad left thirty left blue" name="logout">
								Try New Password?
							</button>
							<button class="border bold pad right thirty right blue" type="button" onclick="javascript: location.replace(\'main.php\');">
								Ignore
							</button>
						</form>
					</div>
					'.'<br><br><br>';
						}
						mysql_free_result($retval2);
					}
				}
			}
			else if (isset($_POST['savecontact'])) {
				$contact=mysql_real_escape_string(htmlspecialchars($_POST['contact'],ENT_QUOTES));
				if ($contact=="") {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Contact uploaded contains an empty thread<br>
						Kindly upload a valid Contact.
					</div>
					'.'<br><br><br>';
				}
				else {
					if (preg_match("/[^0-9+]/", $contact) || strlen($contact)>15) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Contact uploaded contains unsupported characters<br>
						Or the contact length exceeds maximum length<br>
						Kindly upload a valid Contact.
					</div>
					'.'<br><br><br>';
					}
					else {
					$sql2="UPDATE ysuser SET contact='$contact' WHERE who='$id'";
					$retval2=mysql_query($sql2);
					if ($retval2) {
						header("location:me.php");
					}
				}
				}
			}
			else if (isset($_POST['savemail'])) {
				$mail=mysql_real_escape_string(htmlspecialchars($_POST['mail'],ENT_QUOTES));
				if (empty($mail)) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Email uploaded contains an empty thread<br>
						Kindly upload a valid Email.
					</div>
					'.'<br><br><br>';
				}
				else {
						if (preg_match("/[^a-zA-Z0-9_.@]/", $mail) || strlen($mail)>50) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o extreme-text left blue pad-right-short"></i>
						The Email used contains unsupported characters
						<br>
						Kindly use "_" underscore for seperators
						<br>
						Or the Email characters are too long.
					</div>
					'.'<br><br><br>';
					}
					else {
						$sql2="SELECT mail FROM ysuser WHERE mail='$mail'";
						$retval2=mysql_query($sql2);
						$num2=mysql_num_rows($retval2);
						mysql_free_result($retval2);
						if ($num2>0) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						The Email uploaded as been used by another user<br>
						Kindly upload another Email.
					</div>
					'.'<br><br><br>';
						}
						else {
							$sql3="UPDATE ysuser SET mail='$mail' WHERE who='$id'";
							$retval3=mysql_query($sql3);
							if ($retval3) {
								header("location:me.php");
							}
						}
					}
				}
			}
		?>
		<span class="blue bold">Change Dp</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" accept="image/*">
			<input type="file" name="dp" class="hidden hide" hidden>
			<button class="no-style sixty-plus border pad" id="choose" type="button">
			<i class="fa fa-camera blue pad-right"></i>
				Photo
			</button>
			<br><br>
			<button class="pad border thirty" name="savedp">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br><br>




		<span class="blue bold">Change Status</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
		<textarea name="upto" class="border sixty-plus pad" placeholder="What are you upto?" required></textarea>
			<br><br>
			<button class="pad border thirty" name="saveupto">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br><br>


		<span class="blue bold">Change Username</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="text" name="user" placeholder="New Username" class="pad border sixty-plus" required oninput="javascript: var name=$(this).val();$('#name-loader').load('uti.php',{'checkname':name});">
			<button class="pad-left no-style" id="name-loader" type="button">
			<i class="fa fa-male big-text"></i>
			</button>
			<br><br>
			<button class="pad border thirty" name="saveuser">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br><br>


		<span class="blue bold">Change Password</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="password" placeholder="Old Password" name="oldpass" class="pad sixty-plus border" required>
			<br><br><br>
			<input type="password" placeholder="New Password" name="newpass" class="pad sixty-plus border" required>
			<br><br>
			<button class="pad border thirty" name="savepass">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br><br>


		<span class="blue bold">Add Contact</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="tel" placeholder="Contact" name="contact" class="pad sixty-plus border" required>
			<br><br>
			<button class="pad border thirty" name="savecontact">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br><br>


		<span class="blue bold">Change Email</span>
		<br><br><br>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="email" placeholder="Email" name="mail" class="pad sixty-plus border" required>
			<br><br>
			<button class="pad border thirty" name="savemail">
				<i class="fa fa-save blue big-text pad-right-long"></i>
			</button>
		</form>
		<br><br><br>
		<br><br>
		<div class="center bold">
			&copy; Angel Works <?php echo date("Y"); ?>
		</div>
	<?php
		mysql_free_result($retval);
		mysql_close($conn);
	?>
</body>
</html>