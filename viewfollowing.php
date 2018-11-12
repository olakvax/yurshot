<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	if (!isset($_REQUEST['f'])) {
		header("location:main.php");
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
		<?php
		if (isset($_REQUEST['f'])) {
			$f=mysql_real_escape_string(htmlspecialchars($_REQUEST['f'],ENT_QUOTES));
			if ($f=="") {
				header("location:main.php");
				exit();
			}
			else {
				$sql5="SELECT who,name FROM ysuser WHERE who='$f'";
				$retval5=mysql_query($sql5);
				$num5=mysql_num_rows($retval5);
				if ($num5<1) {
					header("location:main.php");
					exit();
				}
				else {
					$row5=mysql_fetch_array($retval5);
					$f_name=$row5['name'];
			$sql2="SELECT * FROM ysfollowing WHERE who='$f' ORDER BY id DESC LIMIT 50";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			echo '
				<span class="blue uppercase bold medium-text pad-right">People '.$f_name.' is Following : '.number_format($num2).'</span><br><br><br>';
			if ($num2<1) {
				echo '
				<div class="sixty-plus border pad-plus">
					<i class="fa fa-bell-o extreme-text blue left pad-right"></i>'.$f_name.' is not following anybody.<br>
				</div>
				'.'<br><br><br><br>';
			}
			else {
			while ($row2=mysql_fetch_array($retval2)) {
				$following=$row2['following'];
				$time=$row2['time'];
				$sql3="SELECT who,name,dp FROM ysuser WHERE who='$following'";
				$retval3=mysql_query($sql3);
				$row3=mysql_fetch_array($retval3);
				$following_name=$row3['name'];
				$following_dp=$row3['dp'];
				$sql6="SELECT * FROM ysfollowing WHERE who='$id' AND following='$following'";
				$retval6=mysql_query($sql6);
				$num6=mysql_num_rows($retval6);
				mysql_free_result($retval6);
				if ($num6>0) {
					$btn='<button class="pad right border twenty" value="'.$following.'" onclick="javascript: var stuff=$(this).val();$.ajax({type:\'POST\',url:\'follow.php\',data:\'unfollow=\'+stuff,success:function(){location.replace(\'viewfollowing.php?f='.$f.'\');}});">
				<i class="fa fa-user green pad-right"></i> UnFollow</button>';
			}
			else {
					$btn='<button class="pad right border twenty" value="'.$following.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'follow.php\',{\'follow\':stuff});">
				<i class="fa fa-user blue pad-right"></i> Follow</button>';
			}
				if ($id==$following) {
					$btn="";
				echo '
					<div class="full border pad-plus">'.$btn.'
						<img class="small-img left pad-right" src="'.$following_dp.'" onclick="javascript: location.href=\'search.php?s='.$following_name.'&ref_id=dsgg36636vb\';">
						<span class="blue bold uppercase">Me</span>
						<br>
						Started following @'.$time.'
					</div>
				'.'<br><br>';
			}
			else {
				echo '
					<div class="full border pad-plus">'.$btn.'
						<img class="small-img left pad-right" src="'.$following_dp.'" onclick="javascript: location.href=\'search.php?s='.$following_name.'&ref_id=dsgg36636vb\';">
						<span class="blue bold uppercase">'.$following_name.'</span>
						<br>
						Started following @'.$time.'
					</div>
				'.'<br><br>';
			}
			}
			mysql_free_result($retval3);
		}
		mysql_free_result($retval2);
		}
		mysql_free_result($retval5);
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