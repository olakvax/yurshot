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
	$dp=$row['dp'];
	$event=$row['notification'];
	if ($event == "yes") {
		$event_show="<span class='red bold big-text'>*</span>";
	}
	else {
		$event_show="";
	}
	if (isset($_GET['logout'])) {
		$what="Last seen ".date("D d M Y, @G:i");
		$sqllog="UPDATE ysuser SET status='$what' WHERE who='$id'";
		$retvallog=mysql_query($sqllog);
		if ($retvallog) {
			unset($_SESSION['ysagent']);
			unset($_SESSION['ysmore']);
			session_destroy();
			header("location:index.php");
			exit();
		}
	}
	$sql2="SELECT * FROM ysfollower WHERE who='$id'";
	$retval2=mysql_query($sql2);
	$num2=mysql_num_rows($retval2);
	$follower_len=strlen($num2);
					if ($follower_len==4) {
						$follower=substr($num2, 0,1)."K";
					}
					else if ($follower_len==5) {
						$follower=substr($num2, 0,2)."K";
					}
					else if ($follower_len==6) {
						$follower=substr($num2, 0,3)."K";
					}
					else if ($follower_len==7) {
						$follower=substr($num2, 0,1)."M";
					}
					else if ($follower_len==8) {
						$follower=substr($num2, 0,2)."M";
					}
					else if ($follower_len==9) {
						$follower=substr($num2, 0,3)."M";
					}
					else if ($follower_len==10) {
						$follower=substr($num2, 0,1)."B";
					}
					else {
						$follower=$num2;
					}
	mysql_free_result($retval2);
	$sql3="SELECT * FROM ysfollowing WHERE who='$id'";
	$retval3=mysql_query($sql3);
	$num3=mysql_num_rows($retval3);
	$following_len=strlen($num3);
					if ($following_len==4) {
						$following=substr($num3, 0,1)."K";
					}
					else if ($following_len==5) {
						$following=substr($num3, 0,2)."K";
					}
					else if ($following_len==6) {
						$following=substr($num3, 0,3)."K";
					}
					else if ($following_len==7) {
						$following=substr($num3, 0,1)."M";
					}
					else if ($following_len==8) {
						$following=substr($num3, 0,2)."M";
					}
					else if ($following_len==9) {
						$following=substr($num3, 0,3)."M";
					}
					else if ($following_len==10) {
						$following=substr($num3, 0,1)."B";
					}
					else {
						$following=$num3;
					}
					mysql_free_result($retval3);
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
		<img src="<?php echo $dp; ?>" class="nav-img">
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



		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='main.php'">
			<i class="fa fa-home huge-text left blue pad-right-long"></i>
			<span class="bold blue">
			Home
			</span>
			<br>
			go back to main page.
		</button>
		<br><br>

		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='buy.php'">
			<i class="fa fa-shopping-cart huge-text left blue pad-right-long"></i>
			<span class="bold blue">
				Buy
			</span>
			<br>
			get apps and musics.
		</button>
	</div>
	<div class="small-head ys-not-none">
	<div class="seventy right">
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='main.php';">
			<i class="fa fa-home medium-text"></i>
		</button>
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='buy.php';">
			<i class="fa fa-shopping-cart medium-text"></i>
		</button>
		<button class="right thirty trans pad" onclick="javascript: location.href='event.php';">
			<i class="fa fa-bell-o medium-text"></i> <?php echo $event_show; ?>
		</button>
	</div>
		<img src="<?php echo $dp; ?>" class="small-img left pad-right">
		<span class="bold uppercase">
			<?php echo $name; ?>
		</span>
		<br>
		My Page
	</div>



	<br>
		<div>
		<img src="<?php echo $dp; ?>" class="profile-img">


		<button class="border pad right twenty bold black block small-text" onclick="javascript: location.href='post.php'">
			<i class="fa fa-camera blue pad-right"></i>
			Add Shot
		</button>
		</div>
		<br><br>


		<div>
			<button onclick="javascript: location.href='chat.php'" class="no-style black bold border thirty-plus center pad pad-right-short">
				<i class="fa fa-inbox big-text blue pad-right"></i>
				Chats
			</button>

			<button onclick="javascript: location.href='follower.php'" class="no-style  black bold border thirty-plus center pad">
				<i class="fa fa-male big-text blue pad-right"></i>
				Followers
				<span class="blue bold pad-left">
				<?php echo $follower; ?>
				</span>
			</button>
			<br><br><br>


			<button onclick="javascript: location.href='following.php'" class="no-style black bold border thirty-plus center pad pad-right-short">
				<i class="fa fa-male big-text blue pad-right"></i>
				Following
				<span class="blue bold pad-left">
				<?php echo $following; ?>
				</span>
			</button>

			<button onclick="javascript: location.href='edit.php'" class="no-style  black bold border thirty-plus center pad">
				<i class="fa fa-gear big-text blue pad-right"></i>
				Edit
			</button>
			<br><br><br>

			<form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>">
			<button class="no-style  black bold border eighty pad-plus" name="logout">
				<i class="fa fa-user medium-text blue pad-right"></i>
				Logout
			</button>
			</form>
		</div>
		<br><br><br>


		<div class="center bold">
			&copy; Angel Works <?php echo date("Y"); ?>
		</div>
	<?php
		mysql_free_result($retval);
		mysql_close($conn);
	?>
</body>
</html>