<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	if (!isset($_REQUEST['q'])) {
		header("location:main.php");
		exit();
	}
	$id=$_SESSION['ysagent'];
	include("db.php");
	include("function.php");
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
		<img src="<?php echo $dp; ?>" class="small-img left pad-right">
		<span class="bold uppercase">
			<?php echo $name; ?>
		</span>
		<br>
		My Page
	</div>


	<br>
	<span class="big-text bold blue">
		All Likes
	</span>
	<br><br>

	<?php
		if (isset($_GET['q'])) {
			$likers=mysql_real_escape_string(htmlspecialchars($_GET['q'],ENT_QUOTES));
			if (empty($likers)) {
				header("location:main.php");
			}
			else {
				$sql2="SELECT postid FROM yspost WHERE postid='$likers'";
				$retval2=mysql_query($sql2);
				$num2=mysql_num_rows($retval2);
				if ($num2<1) {
					header("location:main.php");
				}
				else {
					$sql3="SELECT * FROM yslike WHERE postid='$likers' ORDER BY id DESC LIMIT 50";
					$retval3=mysql_query($sql3);
					$num3=mysql_num_rows($retval3);
					echo '
					<span class="blue bold pad-right">Total likes :</span> '.number_format($num3).'<br><brr><br>';
					while ($row3=mysql_fetch_array($retval3)) {
						$liker_id=$row3['liker'];
						$sql4="SELECT who,name,dp FROM ysuser WHERE who='$liker_id'";
						$retval4=mysql_query($sql4);
						$row4=mysql_fetch_array($retval4);
						$liker_name=$row4['name'];
						$liker_dp=$row4['dp'];
						echo '
						<div class="full pad border" onclick="javascript: location.href=\'search.php?s='.$liker_name.'&ref_id=hddgd5325vd\';">
						<img class="small-img pad-right" src="'.$liker_dp.'">
						<span class="uppercase blue bold">'.$liker_name.'<span>
						</div>
						'.'<br><br>';
						mysql_free_result($retval4);
					}
					mysql_free_result($retval3);
				}
				mysql_free_result($retval2);
			}
		}
	?>
	<br>
	<div class="center bold">
		&copy; Angel Works <?php echo date("Y"); ?>
	</div>
	<?php
		mysql_free_result($retval);
		mysql_close($conn);
	?>
</body>
</html>