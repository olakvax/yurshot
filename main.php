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
		<button class="right pad-left thirty trans pad" onclick="javascript: location.href='buy.php';">
			<i class="fa fa-shopping-cart medium-text"></i>
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


	<span class="none" id="loader"></span>
		<div>
		<button class="pad right border" onclick="javascript: location.href='post.php';">
			<i class="fa fa-camera blue pad-left"></i>
		</button>
		<form action="search.php" method="GET">
		<input type="text" placeholder="Find user or trend" name="s" class="sixty pad border">
		<button class="no-style pad pad-left border">
		<i class="fa fa-search blue medium-text pad-left"></i>
		</button>
		</form>

		</div>
		<br><br><br>

		<span>
			Todays Shots <?php echo date("D d M Y"); ?>
		</span>
		<br><br><br><br>

		<div id="main">
		<?php
			$start=$_SESSION['ysmore'];
			include("function.php");
			$sql2="SELECT * FROM yspost ORDER BY id DESC LIMIT $start,5";
			include("getpost.php");
		?>
		</div>


		<div class="center bold">
		<?php
			$sql3="SELECT * FROM yspost";
			$retval3=mysql_query($sql3);
			$num3=mysql_num_rows($retval3);
			if ($num3<6) {
				$loader='';
			}
			else {
				if ($_SESSION['ysmore']<1) {
					$loader='
			<button class="thirty pad border bold black right" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'start\':\'\'});">
				More
				<i class="fa fa-arrow-right blue medium-text pad-left"></i>
			</button>
			';
				}
				else if($_SESSION['ysmore']>$num3 || $_SESSION['ysmore']==$num3) {
					$loader='
			<button class="thirty pad border bold black left pad-right" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'prev\':\'\'});">
				<i class="fa fa-arrow-left blue medium-text pad-right"></i>
				Prev
			</button>
		<div class="center bold">
			<button class="thirty pad border bold black left" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'refresh\':\'\'});">
				<i class="fa fa-refresh blue medium-text pad-right"></i>
				Recent
			</button>
			';
				}
				else {
					$loader='
			<button class="thirty pad border bold black left pad-right" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'prev\':\'\'});">
				<i class="fa fa-arrow-left blue medium-text pad-right"></i>
				Prev
			</button>
		<div class="center bold">
			<button class="thirty pad border bold black left pad-right" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'refresh\':\'\'});">
				<i class="fa fa-refresh blue medium-text pad-right"></i>
				Recent
			</button>
					<div class="center bold">
			<button class="thirty pad border bold black left pad-right-short" onclick="javascript: $(\'#loader\').load(\'misc.php\',{\'start\':\'\'});">
				More
				<i class="fa fa-arrow-right blue medium-text pad-left"></i>
			</button>
			';
				}
				echo $loader;
			}
			mysql_free_result($retval3);
			?>
			<br><br><br><br>
			<br><br><br><br>
			&copy; Angel Works <?php echo date("Y"); ?>
		</div>
	<?php
		mysql_free_result($retval);
		mysql_close($conn);
	?>
</body>
</html>