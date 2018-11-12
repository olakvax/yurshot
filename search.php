<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
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


	<form method="GET">
		<input type="search" name="s" class="sixty-plus pad pad-right border" placeholder="Search">
		<button class="border pad">
			<i class="fa fa-search medium-text blue"></i>
		</button>
	</form>
	<br><br>
	<?php
		if (isset($_REQUEST['s'])) {
			$s=mysql_real_escape_string(htmlspecialchars($_REQUEST['s'],ENT_QUOTES));
			$word="/#+([a-zA-Z0-9_]+)/";
			if ($s=="") {
				echo '
				<br><br>
				<div class="border pad-plus sixty-plus">
					<i class="left fa fa-male extreme-text blue pad-right-short"></i>
					The Username requested contains an empty<br>
					Thread Kindly Insert a valid username.
				</div>
				'.'<br><br><br><br>';
			}
			else if(preg_match($word, $s)) {
				$s1=strpos($s, "#")+1;
				$s2=strlen($s);
				$sf=substr($s, $s1, $s2);
				header("location:search.php?q=".$sf."&ref_id=gsgsw53hsh");
			}
			else {
				$sql2="SELECT * FROM ysuser WHERE name LIKE '%$s%' ORDER BY list DESC LIMIT 50";
				$retval2=mysql_query($sql2);
				$num2=mysql_num_rows($retval2);
				if ($num2<1) {
				echo '
				<br><br>
				<div class="border pad-plus sixty-plus">
					<i class="left fa fa-male extreme-text blue pad-right-short"></i>
					The Username requested does not match<br>
					Any user.
				</div>
				'.'<br><br><br><br>';
				}
				else {
					if ($num2==1) {
						$result=" Result";
					}
					else {
						$result=" Results";
					}
				echo $num2.$result.' Found'.'<br><br><br>';
				while ($row2=mysql_fetch_array($retval2)) {
					$who=$row2['who'];
					$search_name=$row2['name'];
					$search_dp=$row2['dp'];
					$sql3="SELECT * FROM ysfollower WHERE who='$who'";
					$retval3=mysql_query($sql3);
					$num3=mysql_num_rows($retval3);
					$follow_len=strlen($num3);
			if ($follow_len==4) {
				$follow_no=substr($num3, 0,1)."K";
			}
			else if ($follow_len==5) {
				$follow_no=substr($num3, 0,2)."K";
			}
			else if ($follow_len==6) {
				$like_no=substr($num3, 0,3)."K";
			}
			else if ($follow_len==7) {
				$follow_no=substr($num3, 0,1)."M";
			}
			else if ($follow_len==8) {
				$follow_no=substr($num3, 0,2)."M";
			}
			else if ($follow_len==9) {
				$follow_no=substr($num3, 0,3)."M";
			}
			else if ($follow_len==10) {
				$follow_no=substr($num3, 0,1)."B";
			}
			else {
				$follow_no=$num3;
			}
					mysql_free_result($retval3);
					$sql4="SELECT * FROM ysfollowing WHERE who='$id' AND following='$who'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					if ($who==$id) {
						$btn='
						<button class="pad-plus full border" onclick="javascript: location.href=\'me.php\'">
						<i class="fa fa-user blue pad-right-short"></i>
						MySelf
						</button>
						';
					}
					else if ($num4<1) {
						$btn='
				<button class="pad-plus full border" value="'.$who.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'follow.php\',{\'follow\':stuff});">
				<i class="fa fa-user blue pad-right-short"></i> Follow <span class="pad-left-long">'.$follow_no.'</span></button>
				';
					}
					else {
						$btn='
				<button class="pad-plus full border" value="'.$who.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'follow.php\',{\'unfollow\':stuff});">
				<i class="fa fa-user green pad-right-short"></i> <span class="bold">UnFollow</span> <span class="bold pad-left-long">'.$follow_no.'</span></button>
				';
					}
					mysql_free_result($retval4);
					echo '
					<div class="border center pad-plus search-width pad-right-short inl pad-bottom">
				<button class="pad-plus border bold thirty small-text right" onclick="javascript: location.href=\'view.php?q='.$who.'&ref_id=25y23vdh\';">View</button>
					<span class="bold blue uppercase">
					@'.$search_name.'</span>
					<br><br>
						<img class="search-img" src="'.$search_dp.'">
						<br><br>'.$btn.'
					</div>
					';
				}
				echo '<br><br><br><br><br>';
				mysql_free_result($retval2);
			}
		}
	}
	else if (isset($_REQUEST['q'])) {
		$q=mysql_real_escape_string(htmlspecialchars($_REQUEST['q']));
		if ($q=="") {
				echo '
				<br><br>
				<div class="border pad-plus sixty-plus">
					<i class="left fa fa-male extreme-text blue pad-right-short"></i>
					The Trend requested contains an empty<br>
					Thread Kindly Insert a valid hash_tag.
				</div>
				'.'<br><br><br><br>';
		}
		else {
			$sq="#".$q;
			$sql2="SELECT * FROM yspost WHERE body LIKE '%$sq%' LIMIT 50";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			if ($num2<1) {
				echo '
				<br><br>
				<div class="border pad-plus sixty-plus">
					<i class="left fa fa-male extreme-text blue pad-right-short"></i>
					The Trend requested was not found<br>
					Kindly search for a valid hash_tag.
				</div>
				'.'<br><br><br><br>';
			}
			else {
					if ($num2==1) {
						$result=" Result";
					}
					else {
						$result=" Results";
					}
				echo $num2.$result.' Found'.'<br><br><br>';
				while ($row2=mysql_fetch_array($retval2)) {
					$who=$row2['who'];
					$media=$row2['media'];
					$media_type=$row2['mediatype'];
					$body=$row2['body'];
					$sql3="SELECT who,name,dp FROM ysuser WHERE who='$who'";
					$retval3=mysql_query($sql3);
					$row3=mysql_fetch_array($retval3);
					$trend_name=$row3['name'];
					$trend_dp=$row3['dp'];
					if ($media!="") {
						if ($media_type=="image") {
					echo '
					<div class="border center pad-plus search-width pad-right-short inl pad-bottom">
						<img class="small-img twenty left pad-right" src="'.$trend_dp.'">
				<button class="pad-plus border bold small-text right" onclick="javascript: location.href=\'search.php?s='.$trend_name.'&ref_id=25y23vdh\';">Find</button>
					<span class="bold blue uppercase">
					@'.$trend_name.'</span>
					<br><br><br><br>
						<img class="search-img" src="'.$media.'" onclick="javascript: location.href=\'misc.php?q='.$media.'&t=image\';">
					</div>
					';
						}
						else {
					echo '
					<div class="border center pad-plus search-width pad-right-short inl pad-bottom">
						<img class="small-img pad-right twenty" src="'.$trend_dp.'">
				<button class="pad-plus border small-text right" onclick="javascript: location.href=\'search.php?s='.$trend_name.'&ref_id=25y23vdh\';">Find</button>
					<span class="bold blue">
					@'.$trend_name.'</span>
					<br><br>
						<video class="search-img" src="'.$media.'"></video>
					</div>
					';
						}
					}
					else {
					echo '
					<div class="border center pad-plus search-width pad-right-short inl pad-bottom">
						<img class="small-img pad-right twenty" src="'.$trend_dp.'">
				<button class="pad-plus border small-text right" onclick="javascript: location.href=\'search.php?s='.$trend_name.'&ref_id=25y23vdh\';">Find</button>
					<span class="bold blue">
					@'.$trend_name.'</span>
					<br><br>'.$body.'
						<br><br>
					</div>
					';
					}
					mysql_free_result($retval3);
				}

			}
			mysql_free_result($retval2);
		}
	}
	?>
	<div class="center bold">
		&copy; Angel Works <?php echo date("Y"); ?>
	</div>
	<?php
		mysql_free_result($retval);
		mysql_close($conn);
	?>
</body>
</html>