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


	<?php
		if (isset($_REQUEST['q'])) {
			$q=mysql_real_escape_string(htmlspecialchars($_REQUEST['q'],ENT_QUOTES));
			if ($q=="") {
				header("location:main.php");
				exit();
			}
			else {
				$sqlx="SELECT * FROM ysuser WHERE who='$q'";
				$retvalx=mysql_query($sqlx);
				$numx=mysql_num_rows($retvalx);
				if ($numx<1) {
					echo '
					<br><br><br>
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue extreme-text left pad-right-short"></i>
						You are trying to access an unauthorised page<br>
						Kindly go back please.
					</div>
					'.'<br><br><br>';
				}
				else {
					$rowx=mysql_fetch_array($retvalx);
					$q_name=$rowx['name'];
					$q_dp=$rowx['dp'];
					$q_mail=$rowx['mail'];
					$p_contact=$rowx['contact'];
					$q_status=$rowx['status'];
					$p_upto=$rowx['upto'];
					$q_contact=$rowx['contact'];
					$q_upto=$rowx['upto'];
					if ($p_upto=="") {
						$q_upto="No Stuff about me.";
					}
					if ($p_contact=="") {
						$q_contact="Private";
					}
					if ($id!=$q) {
						$chat='
						<button class="border pad bold thirty pad-right" onclick="javascript: location.href=\'chatbody.php?c='.$q.'&ref_id=hhhsdhd25\';">
						<i class="fa fa-send pad-right-long blue"></i>
						Message
						</button>';
					}
					else {
						$chat="";
					}
					echo '
					<div>
						<span class="big-text blue uppercase bold">'.$q_name.'\'s Page</span>
						<br><br><br><br>
						<div>
						<img class="comment-media border left pad-right" src="'.$q_dp.'">
						<span class="bold blue">
						Email:
						</span>
						<br>'.$q_mail.'
						<br><br>
						<span class="bold blue">
						Contact:
						</span>
						<br>'.$q_contact.'
						<br><br>
						<span class="bold blue">
						Status:
						</span>
						<br>'.$q_status.'
						<br><br>
						<span class="bold blue">
						Whats Up With Me:
						</span>
						<br>'.$q_upto.'
						</div>
						<br><br><br><br>
						<div class="center">'.$chat.'
						<button class="border pad bold thirty pad-right" onclick="javascript: location.href=\'viewfollower.php?f='.$q.'\';">
						<i class="fa fa-male pad-right-long blue medium-text"></i>
						Followers
						</button>
						<button class="border pad bold thirty" onclick="javascript: location.href=\'viewfollowing.php?f='.$q.'\';">
						<i class="fa fa-male pad-right-long blue medium-text"></i>
						Following
						</button>
						</div><br><br><br>
						<span class="bold">All Recent Shots</span>
					</div>
					'.'<br><br><br>';
					$sql2="SELECT * FROM yspost WHERE who='$q' ORDER BY id DESC LIMIT 20";
					include("getpost.php");
				}
				mysql_free_result($retvalx);
			}
		}
	?>
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