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
			$com=mysql_real_escape_string(htmlspecialchars($_REQUEST['q'],ENT_QUOTES));
			if ($com=="") {
				header("location:main.php");
			}
			else {
				$sql2="SELECT * FROM yspost WHERE postid='$com'";
				$retval2=mysql_query($sql2);
				$num2=mysql_num_rows($retval2);
				if ($num2<1) {
					header("location:main.php");
				}
				else {
					$sql3="SELECT * FROM yscomment WHERE postid='$com' ORDER BY id DESC LIMIT 10";
					$retval3=mysql_query($sql3);
					$num3=mysql_num_rows($retval3);
					$row2=mysql_fetch_array($retval2);
					$poster=$row2['who'];
					$media=$row2['media'];
					$media_type=$row2['mediatype'];
					$post_body=$row2['body'];
					if ($num3<1) {
						$comment_name="NO comment";
					}
					else {
						$comment_name="All comments";
					}
					$sql4="SELECT who,name,dp FROM ysuser WHERE who='$poster'";
					$retval4=mysql_query($sql4);
					$row4=mysql_fetch_array($retval4);
					$poster_name=$row4['name'];
					$poster_dp=$row4['dp'];
					mysql_free_result($retval4);
					if ($media!="") {
						if ($media_type=="image") {
							$comment_type='
							<img class="comment-media" src="'.$media.'">
							';
							$btn='
							<button class="right pad border" onclick="javascript: location.href=\'misc.php?q='.$media.'&t=image\';">
							<i class="fa fa-save big-text blue"></i>
							</button>
							';
						}
						else {
							$comment_type='
							<video class="comment-media" src="'.$media.'"></video>
							';
							$btn='
							<button class="right pad border" onclick="javascript: location.href=\'misc.php?q='.$media.'&t=video\';">
							<i class="fa fa-save big-text blue"></i>
							</button>
							';
						}
					}
					else {
						$comment_type='
						<div class="pad-plus sixty border">'.$post_body.'
						</div>
						';
						$btn="";
					}
					echo '<div class="seventy right">'.$btn.'
					<br><br><br><br>
					<button class="right border pad blue" onclick="javascript: location.href=\'alllike.php?q='.$com.'&ref_id=dhhd24bbsdj\';">
					All likes
					</button>
					</div>
					<span class="medium-text blue bold uppercase">'.$poster_name.'\'s Posts</span>
					<br><br>'.$comment_type.'
					<br><br><span class="bold">'.$comment_name.'</span><br><br><br><br>
					';
					while ($row3=mysql_fetch_array($retval3)) {
						$commenter=$row3['commenter'];
						$bod=str_replace("&#039;", "'", $row3['body']);
						$body=ys_hash(ys_web(ys_at($bod)));
						$sql5="SELECT who,name,dp FROM ysuser WHERE who='$commenter'";
						$retval5=mysql_query($sql5);
						$row5=mysql_fetch_array($retval5);
						$commenter_name=$row5['name'];
						$commenter_dp=$row5['dp'];
						echo '
						<div class="border-bottom">
						<img class="small-img pad-right left" src="'.$commenter_dp.'" onclick="javascript: location.href=\'search.php?s='.$commenter_name.'\';">
						<span class="bold uppercase blue">'.$commenter_name.'</span>
						<br>'.$body.'
						</div>
						'.'<br><br>';
					mysql_free_result($retval5);
					}
					if (isset($_POST['savecomment'])) {
						$subj=mysql_real_escape_string(htmlspecialchars($_POST['newcomment'],ENT_QUOTES));
						if ($subj!="") {
							$sql9="DELETE FROM ysevent WHERE who='$poster' AND notifier='$id' AND body='c'";
							mysql_query($sql9);
							$sql6="INSERT INTO yscomment (postid,body,commenter) VALUES ('$com','$subj','$id')";
							$retval6=mysql_query($sql6);
							if ($retval6) {
								if ($id!=$poster) {
									$time=date("G:i, d M Y");
									$sql7="UPDATE ysuser SET notification='yes' WHERE who='$poster'";
									mysql_query($sql7);
									$sql8="INSERT INTO ysevent (who,notifier,postid,body,time) VALUES ('$poster','$id','$com','c','$time')";
									mysql_query($sql8);
								}
								echo '
								<script>
								location.replace("comment.php?q='.$com.'&ref_id=ggdfgg3452fv");
								</script>
								';
							}
						}
					}
					mysql_free_result($retval3);
				}
				if ($num3>9) {
					echo '
						<br>
						<form method="POST" action="comment.php">
							<button name="more" class="border blue pad">
								<i class="fa fa-plus big-text blue pad-right"></i>
								More
							</button>
						</form>
						'.'<br><br><br>';
						}
				mysql_free_result($retval2);
			}
		}
	?>
	<br>
	<div class="comment-area">
		<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="newcomment" class="pad pad-right border seventy" placeholder="Comment">
			<button class="pad border" name="savecomment">
				<i class="fa fa-send big-text blue"></i>
			</button>
		</form>
	</div>
	<?php
	mysql_free_result($retval);
	mysql_close($conn);
	?>
</body>
</html>