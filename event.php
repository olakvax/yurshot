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
	$sql4="UPDATE ysuser SET notification='no' WHERE who='$id'";
	mysql_query($sql4);
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

		<button class="border ninety pad-plus left-align nav-button" onclick="javascript: location.href='main.php'">
			<i class="fa fa-home huge-text left blue pad-right-long"></i>
			<span class="bold blue">
				Home
			</span>
			<br>
			go back to home page.
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
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='me.php';">
			<i class="fa fa-user medium-text"></i>
		</button>
		<button class="right thirty trans pad" onclick="javascript: location.href='buy.php';">
			<i class="fa fa-shopping-cart medium-text"></i> 
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
	<span class="medium-text bold blue">My Events</span>
	<br><br>
	<div class="full pad-plus border">
		<img src="img/ads.jpg" class="small-post-img left pad-right">
		<a class="uppercase blue bold" href="http://microsoft.com">
			Windows v10.1
		</a>
		<br><br>
		New windows 10 available for download. Comes with new ui graphics
		<br>
		Free download at <a href="http://microsoft.com" class="pad-left blue bold">http://microsoft.com/windows10</a>
		<br>
		TRending 3days at #windows_10.
	</div>
	<br><br><br><br>
	<?php
		$sql2="SELECT * FROM ysevent WHERE who='$id' ORDER BY id DESC LIMIT 20";
		$retval2=mysql_query($sql2);
		$num2=mysql_num_rows($retval2);
		if ($num2<1) {
			echo '
			<div class="pad-plus border full">
				<i class="fa fa-bell-o huge-text blue left pad-right"></i>
				No Events Available for you.
				<br>
				You can check around our suggested posts.
			</div>
			'.'<br><br><br>';
		}
		else {
		while ($row2=mysql_fetch_array($retval2)) {
			$notifier=$row2['notifier'];
			$postid=$row2['postid'];
			$body=$row2['body'];
			$time=$row2['time'];
			$sql3="SELECT who,name,dp FROM ysuser WHERE who='$notifier'";
			$retval3=mysql_query($sql3);
			$row3=mysql_fetch_array($retval3);
			$notifier_name=$row3['name'];
			$notifier_dp=$row3['dp'];
			if ($body=="c") {
				echo '
				<div class="border pad-plus full">
					<button class="right pad black bold border twenty" onclick="javascript: location.href=\'comment.php?q='.$postid.'&ref_id=fsefffs4fsgg\'">
					<i class="fa fa-inbox blue big-text pad-right"></i>
					Respond
					</button>
					<img class="small-img left pad-right" src="'.$notifier_dp.'" onclick="javascript: location.href=\'search.php?s='.$notifier_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$notifier_name.'</span>
					<br>
					Commented on your shot @'.$time.'
				</div>
				'.'<br><br>';
			}
			else if ($body=="ch") {
				echo '
				<div class="border pad-plus full">
					<button class="right pad black bold border twenty" onclick="javascript: location.href=\'chatbody.php?c='.$notifier.'&ref_id=fsefffs4fsgg\'">
					<i class="fa fa-send blue pad-right"></i>
					Chat
					</button>
					<img class="small-img left pad-right" src="'.$notifier_dp.'" onclick="javascript: location.href=\'search.php?s='.$notifier_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$notifier_name.'</span>
					<br>
					Sent you a message '.$time.'
				</div>
				'.'<br><br>';
			}
			else if ($body=="l") {
				echo '
				<div class="border pad-plus full">
					<img class="small-img left pad-right" src="'.$notifier_dp.'" onclick="javascript: location.href=\'search.php?s='.$notifier_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$notifier_name.'</span>
					<br>
					Liked your shot @'.$time.'
				</div>
				'.'<br><br>';
			}
			else {
				$sql5="SELECT * FROM ysfollowing WHERE who='$id' AND following='$notifier'";
				$retval5=mysql_query($sql5);
				$num5=mysql_num_rows($retval5);
				if ($num5<1) {
				echo '
				<div class="border pad-plus full">
				<button class="pad right border twenty" value="'.$notifier.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'follow.php\',{\'follow\':stuff});">
				<i class="fa fa-user blue pad-right"></i> Follow</button>
					<img class="small-img left pad-right" src="'.$notifier_dp.'" onclick="javascript: location.href=\'search.php?s='.$notifier_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$notifier_name.'</span>
					<br>
					Started Following you @'.$time.'
				</div>
				'.'<br><br>';
				}
				else {
				echo '
				<div class="border pad-plus full">
				<button class="pad right border twenty" value="'.$notifier.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'follow.php\',{\'unfollow\':stuff});">
				<i class="fa fa-user green pad-right"></i> UnFollow</button>
					<img class="small-img left pad-right" src="'.$notifier_dp.'" onclick="javascript: location.href=\'search.php?s='.$notifier_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$notifier_name.'</span>
					<br>
					Started Following you @'.$time.'
				</div>
				'.'<br><br>';
				}
				mysql_free_result($retval5);
			}
			mysql_free_result($retval3);
		}
		mysql_free_result($retval2);
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