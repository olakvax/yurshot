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
			Go to Home page
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
		<span class="medium-text blue bold">
			My Chat
		</span>
		<br><br><br>
		<?php
			include("function.php");
			$sql2="SELECT * FROM yschat WHERE who='$id' GROUP BY chat ASC LIMIT 50";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			if ($num2<1) {
				echo '
				<div class="sixty-plus border pad-plus">
					<i class="fa fa-bell-o extreme-text blue left pad-right"></i>
					You dont have any Conversations<br>
					Kindly tap on chat button on followers<br>
					Page to start a chat.
				</div>
				'.'<br><br><br><br>';
			}
			else {
				while ($row2=mysql_fetch_array($retval2)) {
					$c_id=$row2['chat'];
					$c_time=$row2['time'];
					$c_body=ys_decrypt($row2['body']);
					if (strlen($c_body)>30) {
						$body=substr($c_body, 0, 30)."....";
					}
					else {
						$body=$c_body;
					}
					$sql3="SELECT who,name,dp FROM ysuser WHERE who='$c_id'";
					$retval3=mysql_query($sql3);
					$row3=mysql_fetch_array($retval3);
					$c_name=$row3['name'];
					$c_dp=$row3['dp'];
					mysql_free_result($retval3);
					echo '
				<div class="border pad-plus full">
					<button class="right pad black bold border twenty" onclick="javascript: location.href=\'chatbody.php?c='.$c_id.'&ref_id=fsefffs4fsgg\'">
					<i class="fa fa-inbox blue big-text pad-right"></i>
					Reply
					</button>
					<img class="small-img left pad-right" src="'.$c_dp.'" onclick="javascript: location.href=\'search.php?s='.$c_name.'&ref_id=dwwg3v3vshsisi\'">
					<span class="bold uppercase blue">'.$c_name.'</span>
					<br>
					Sent you a message '.$c_time.'
				</div>
				'.'<br><br>';
				}
			}
			mysql_free_result($retval2);
		?>
		<br><br><br><br>
		<div class="center bold">
			&copy; Angel Works <?php echo date("Y"); ?>
		</div>
		<?php
			mysql_free_result($retval);
			mysql_close($conn);
		?>
</body>
</html>