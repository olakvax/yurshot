<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	if (!isset($_REQUEST['c'])) {
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
	<script type="text/javascript">
		$(document).ready(function(){
			var a=$(document).height()
			$("html, body").animate({scrollTop:a},0)
		})
	</script>
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
			Go to Home page.
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



	
		<div class="center">
			<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
				<button name="clr" class="pad border bold thirty">
					<i class="fa fa-trash-o red pad-right"></i>
					Clear All Chats
				</button>
			</form>
		</div>
		<br><br>
		<?php
			if (isset($_REQUEST['c']) && $_REQUEST['c']!="") {
				$c=mysql_real_escape_string(htmlspecialchars($_REQUEST['c'],ENT_QUOTES));
				if ($c==$id) {
					header("location:main.php");
					exit();
				}
				else {
				$sql2="SELECT who,name,dp,status FROM ysuser WHERE who='$c'";
				$retval2=mysql_query($sql2);
				$num2=mysql_num_rows($retval2);
				if ($num2<1) {
					header("location:main.php");
					exit();
				}
				else {
					include("function.php");
					$sql4="SELECT who,following FROM ysfollowing WHERE who='$id' AND following='$c'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$sql5="SELECT who,following FROM ysfollowing WHERE who='$c' AND following='$id'";
					$retval5=mysql_query($sql5);
					$num5=mysql_num_rows($retval5);
					if ($num4>0 && $num5>0) {
					$row2=mysql_fetch_array($retval2);
					$c_name=$row2['name'];
					$c_dp=$row2['dp'];
					$c_status=$row2['status'];
					$sql3="SELECT * FROM yschat WHERE who='$id' AND chat='$c' ORDER BY id LIMIT 50";
					$retval3=mysql_query($sql3);
					while ($row3=mysql_fetch_array($retval3)) {
						$c_body=ys_decrypt($row3['body']);
						$c_time=$row3['time'];
						$type=$row3['type'];
						if ($type=="M") {
							echo '
							<div class="border pad forty right">
							<span class="blue bold">
							Me : 
							</span>
							<br>'.$c_body.'
							<br>
							<span class="right">
							'.$c_time.'
							</span>
							</div>
							'.'<br><br><br><br><br><br>';
						}
						else {
							echo '
							<div class="border m-body pad forty left">
							<span class="blue bold uppercase">'.$c_name.' : 
							</span>
							<br>'.$c_body.'
							<br>
							<span class="right">
							'.$c_time.'
							</span>
							</div>
							'.'<br><br><br><br><br><br>';
						}
					}
				}
				else {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue extreme-text left pad-right-short"></i>
						You are either not following this user<br>
						Or the user is not following you.<br>
						To start a conversation both users must be
						Following each other.
					</div>
					'.'<br><br><br>';
					exit();
				mysql_free_result($retval4);
				mysql_free_result($retval5);
				}
				mysql_free_result($retval4);
				mysql_free_result($retval5);
			}
				mysql_free_result($retval2);
			}
		}
			else {
				header("location:main.php");
				exit();
			}
		?>
		<br><br><br><br><br><br>
	<div class="comment-area">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="right sixty-plus chat-width">
		<input type="text" name="newchat" placeholder="Chat" class="pad-plus sixty-plus pad-right border">
		<button name="savechat" class="pad-plus border">
			<i class="fa fa-send big-text blue"></i>
		</button>
	</form>
		<img class="small-img left pad-right" src="<?php echo $c_dp; ?>">
		<span class="uppercase bold blue"><?php echo $c_name; ?></span>
		<br>
		<?php echo $c_status; ?>
	</div>
	<?php
		if (isset($_POST['savechat']) && $_POST['newchat']!="" && $_REQUEST['c']!="") {
				$c=mysql_real_escape_string(htmlspecialchars($_REQUEST['c'],ENT_QUOTES));
							$nc=mysql_real_escape_string(htmlspecialchars($_POST['newchat'],ENT_QUOTES));
							$enc=ys_encrypt($nc);
							$time=date(" @G:i, D d M Y");
							$sql6="INSERT INTO yschat (who,chat,body,time,type) VALUES ('$c','$id','$enc','$time','Y')";
							$retval6=mysql_query($sql6);
							$sql8="INSERT INTO yschat (who,chat,body,time,type) VALUES ('$id','$c','$enc','$time','M')";
							$retval8=mysql_query($sql8);
							$sql9="DELETE FROM ysevent WHERE who='$c' AND notifier='$id' AND body='ch'";
							$retval9=mysql_query($sql9);
							$sql7="INSERT INTO ysevent (who,notifier,body,time) VALUES ('$c','$id','ch','$time')";
							$retval7=mysql_query($sql7);
							if ($retval6 && $retval8 && $retval9 && $retval7) {
									$sql8="UPDATE ysuser SET notification='yes' WHERE who='$c'";
									mysql_query($sql8);
								echo '
								<script>
									location.href="chatbody.php?c='.$c.'&ref_id=hd5gg2gf";
								</script>
								';
							}
						}
	?>
	<?php
		if (isset($_POST['clr'])) {
			$c=mysql_real_escape_string(htmlspecialchars($_REQUEST['c'],ENT_QUOTES));
			$sql10="DELETE FROM yschat WHERE who='$id' AND chat='$c'";
			$retval10=mysql_query($sql10);
			$sql11="DELETE FROM ysevent WHERE who='$id' AND notifier='$c' AND body='ch'";
			$retval11=mysql_query($sql11);
			if ($retval10 && $retval11) {
				header("location:chat.php");
			}
		}
	?>
		<?php
			mysql_free_result($retval);
			mysql_close($conn);
		?>
</body>
</html>