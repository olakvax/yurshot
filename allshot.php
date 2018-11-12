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
		<img src="<?php echo $dp; ?>" class="small-img left pad-right">
		<span class="bold uppercase">
			<?php echo $name; ?>
		</span>
		<br>
		My Page
	</div>



		<br>
				<span class="blue medium-text bold">
					My Shots
				</span>
				<br><br><br>

		<button class="right twenty pad border bold pad-left" id="delete" value="" onclick='javascript: var dat=$(this).val();if(dat==""){alert("PLEASE SELECT AN IMAGE!!!");}else{$.ajax({type:"POST",url:"misc.php",data:"d="+dat,success:function(){location.replace("allshot.php");}});}'>
			<i class="fa fa-trash-o big-text red pad-right"></i>
			Remove
		</button>
		You can remove one shot at a time by clicking on the image and clicking delete button.
		<br><br><br><br>

		<?php
			$sql2="SELECT * FROM yspost WHERE who='$id' ORDER BY id DESC LIMIT 50";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			echo '
				<span class="blue bold">
				Total Shots : '.number_format($num2).'
				</span>
				<br><br><br>
			';
			if ($num2<1) {
					echo '
					<div class="sixty-plus border pad-plus">
						<i class="fa fa-bell-o blue left extreme-text pad-right-short"></i>
						You dont have any shot available<br>
						Kindly upload a shot to begin with.
					</div>
					'.'<br><br><br>';
			}
			else {
				while ($row2=mysql_fetch_array($retval2)) {
					$media=$row2['media'];
					$body=$row2['body'];
					$postid=$row2['postid'];
					$mediatype=$row2['mediatype'];
					if ($media != "") {
						if ($mediatype=="image") {
							echo '<img class="edit-img-small" src="'.$media.'" data="yes" onclick=\'javascript: var data=$(this).attr("data");if(data=="yes"){$("#delete").val("'.$postid.'");$(this).addClass("opace");$(this).attr("data","no");}else{$("#delete").val("");$(this).removeClass("opace");$(this).attr("data","yes");}\'>';
						}
						else {
							echo '<video class="edit-img-small" src="'.$media.'" data="yes" onclick=\'javascript: var data=$(this).attr("data");if(data=="yes"){$("#delete").val("'.$postid.'");$(this).addClass("opace");$(this).attr("data","no");}else{$("#delete").val("");$(this).removeClass("opace");$(this).attr("data","yes");}\'></video>';
						}
					}
					else {
						echo '
						<span class="edit-img-small border inl" data="yes" onclick=\'javascript: var data=$(this).attr("data");if(data=="yes"){$("#delete").val("'.$postid.'");$(this).addClass("opace");$(this).attr("data","no");}else{$("#delete").val("");$(this).removeClass("opace");$(this).attr("data","yes");}\'>'.$body.'
						</span>';
					}
				}
			}
			mysql_free_result($retval2);
		?>
		<br><br>
		<br><br>
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