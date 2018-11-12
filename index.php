<?php
	session_start();
	if(isset($_SESSION['ysagent'])) {
		header("location:main.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>YUrShot</title>
	<meta name="viewport" content="width=device-width,user-scalable=no">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/ysfirst.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/ys.js"></script>
</head>
<body>
	<div class="mod" id="mod">
		<div class="modal center pad-plus" id="modal">
		<button class="no-style right pad" id="clmodal">
			<i class="fa fa-arrow-right blue big-text"></i>
		</button>
			<span class="big-text blue bold">
				Sign up
			</span>
			<br><br><br><br><br><br>


			<div>
			<form method ="POST" action="success.php" enctype="multipart/form-data">

			<div class="ys-hide padder">
			</div>


			<button class="pad-right no-style" id="name-loader" type="button">
			<i class="fa fa-male big-text"></i>
			</button>
			<input type="text" name="user" placeholder="Username" class="pad border thirty" required oninput="javascript: var name=$(this).val();$('#name-loader').load('uti.php',{'checkname':name});">

			<i class="fa fa-lock big-text pad-right pad-left-long"></i>
			<input type="password" name="pass" placeholder="Passcode" class="pad border thirty" required>

			<br><br><br><br><br>


			<div class="ys-hide padder">
			</div>


			<button class="pad-right no-style" id="mail-loader" type="button">
			<i class="fa fa-envelope"></i>
			</button>
			<input type="email" name="mail" placeholder="Email" class="pad border thirty" required oninput="javascript: var mail=$(this).val();$('#mail-loader').load('uti.php',{'checkmail':mail});">

			<i class="fa fa-camera pad-right pad-left-long"></i>
			<input type="file" name="dp" class="hidden hide" hidden>
			<button class="no-style thirty-plus border pad" id="choose" type="button">
				Photo
			</button>


			<br><br><br><br><br>


			<div class="ys-hide padder"></div>
			<i class="fa fa-heart blue big-text pad-right"></i>
			<button class="no-style half border black pad-plus bold" name="save">
				Save
			</button>
			</form>
			</div>
		</div>
	</div>



	<div class="pad">
		<span class="huge-text bold">
			YUr Shot
		</span>

		<button class="no-style right black pad bold pad-left-long ten-plus nav-icon" id="signup">
			<i class="fa fa-male big-text blue pad-right"></i>
			Sign Up
		</button>
		<button class="no-style right black pad bold pad-right-long ten-plus nav-icon">
			<i class="fa fa-rss big-text blue pad-right"></i>
			Blog
		</button>
	</div>
	<br><br>
	<br><br><br>


	<div class="pad">
	<div class="forty right center ys-show">
		<div class="cover-img">
			<br><br><br><br><br><br><br><br><br><br><br>
			<button class="cover-text bold no-style">
				+Photos
			</button>
		</div>
		<br>
		<span class="bold">
			&copy; Angel Works <?php echo date("Y"); ?>
		</span>
	</div>



	<div class="sixty cents">
	<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
			<i class="fa fa-male big-text pad-right"></i>
			<input type="text" name="myname" placeholder="Username" class="black pad-plus border sixty" required>

			<br><br><br><br>

			<i class="fa fa-lock big-text pad-right"></i>
			<input type="password" name="mypasscode" placeholder="Passcode" class="black pad-plus border sixty" required>

			<br><br><br><br>


			<i class="fa fa-heart big-text pad-right blue"></i>
			<button class="pad-plus bold border sixty-plus black" name="login">
				Log in
			</button>
	</form>

	<div class="ys-hide">
	<br><br><br>


	<button class="bold border sixty-plus blue" onclick="javascript: location.href='forgot.php';">
		<i class="fa fa-user blue bold pad-right-short big-text"></i>
		Forgot Password?
	</button>
	<br><br><br><br><br>
	<div class="center bold">
		&copy; Angel Works <?php echo Date("Y"); ?>
	</div>
	</div>
	<?php
			include("db.php");
			if (isset($_POST['login'])) {
				$user=mysql_real_escape_string(htmlspecialchars($_POST['myname'],ENT_QUOTES));
				$pas=mysql_real_escape_string(htmlspecialchars($_POST['mypasscode'],ENT_QUOTES));
				$pass=md5($pas);
				if ($user!="" && $pass!="") {
					$sql="SELECT who,name,passcode FROM ysuser WHERE name='$user' AND passcode='$pass'";
					$retval=mysql_query($sql);
					$num=mysql_num_rows($retval);
					if ($num<1) {
						echo '
						<br><br>
						<div>
							<i class="fa fa-bell-o blue big-text pad-right"></i>
							User details provided was not found Kindly Signup.
						</div>
						';
					}
					else {
						$row=mysql_fetch_array($retval);
						$_SESSION['ysagent']=$row['who'];
						$_SESSION['ysmore']=0;
						$id=$row['who'];
						$sql="UPDATE ysuser SET status='Online' WHERE who='$id'";
						$retval=mysql_query($sql);
						header("location:main.php");
					}
					mysql_free_result($retval);
					mysql_close($conn);
				}
				else {
					echo '
					<br><br>
					<div>
						<i class="fa fa-bell-o blue big-text pad-right"></i>
						Some input field was left Empty.
					</div>
					';
				}
			}
	?>
	</div>
	</div>
</body>
</html>