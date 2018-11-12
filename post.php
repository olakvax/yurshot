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
		Add new image or video
		<button class="twenty right border bold black pad" onclick="javascript: location.href='allshot.php'">
			<i class="fa fa-camera small-text pad-right blue"></i>
			Edit Shots
		</button>

		<br><br><br><br>

		<div>
		<?php
			if(isset($_POST['save'])) {
				$posttext=mysql_real_escape_string(htmlspecialchars($_POST['posttext'],ENT_QUOTES));
				$media=$_FILES['dp']['name'];
				$media_size=$_FILES['dp']['size'];
				$media_type=$_FILES['dp']['type'];
				if ($posttext!="" && $media!="") {
					if ($media_type=="image/jpeg" OR $media_type=="image/png" OR $media_type=="image/gif" AND $media_size<5000000) {
						include("db.php");
						$time=date("D d M Y, @G:i");
						$postid=str_shuffle("asdfghjklqwertyzxcvbn").time();
						$type="image";
						move_uploaded_file($_FILES['dp']['tmp_name'], "upload/post/".$media);
						$path="upload/post/".$media;
						$shuff="upload/post/"."YS_IMG_".str_shuffle("asdfghjklqwertyzxcvbn").".jpg";
						$img=rename($path, $shuff);
						$sql="INSERT INTO yspost (who,postid,media,mediatype,body,time) VALUES ('$id','$postid','$shuff','$type','$posttext','$time')";
						$retval=mysql_query($sql);
						if ($retval) {
							header("location:main.php");
						}
					}
					else if ($media_type=="video/mp4" OR $media_type=="video/3gpp" AND $media_size<5000000) {
						include("db.php");
						$time=date("D d M Y, @G:i");
						$postid=str_shuffle("asdfghjklqwertyzxcvbn").time();
						$type="video";
						move_uploaded_file($_FILES['dp']['tmp_name'], "upload/post/".$media);
						$path="upload/post/".$media;
						$shuff="upload/post/"."YS_VID_".str_shuffle("asdfghjklqwertyzxcvbn").".mp4";
						$img=rename($path, $shuff);
						$sql="INSERT INTO yspost (who,postid,media,mediatype,body,time) VALUES ('$id','$postid','$shuff','$type','$posttext','$time')";
						$retval=mysql_query($sql);
						if ($retval) {
							header("location:main.php");
						}
					}
					else {
						echo '
						<div class="sixty border pad-plus">
						<i class="fa fa-bell-o huge-text blue left pad-right-long"></i>
						<div class="pad-left-long seventy">
							The media uploaded is not supported. 
							video should be of mp4 or 3gp format
							<br>
							Image should be of jpg,jpeg,png, or gif format. 
							Or the media size exceeds limit of 5mb
						</div>
						</div>'.'
						<br><br><br>
						';
					}
				}
				else if ($posttext=="" && $media!="") {
					if ($media_type=="image/jpg" OR $media_type=="image/png" OR $media_type=="image/gif" OR $media_type=="image/jpeg" AND $media_size<5000000) {
						include("db.php");
						$time=date("D d M Y, @G:i");
						$postid=str_shuffle("asdfghjklqwertyzxcvbn").time();
						$type="image";
						move_uploaded_file($_FILES['dp']['tmp_name'], "upload/post/".$media);
						$path="upload/post/".$media;
						$shuff="upload/post/"."YS_IMG_".str_shuffle("asdfghjklqwertyzxcvbn").".jpg";
						$img=rename($path, $shuff);
						$sql="INSERT INTO yspost (who,postid,media,mediatype,time) VALUES ('$id','$postid','$shuff','$type','$time')";
						$retval=mysql_query($sql);
						if ($retval) {
							header("location:main.php");
						}
					}
					else if ($media_type=="video/mp4" OR $media_type=="video/3gpp" AND $media_size<5000000) {
						include("db.php");
						$time=date("D d M Y, @G:i");
						$postid=str_shuffle("asdfghjklqwertyzxcvbn").time();
						$type="video";
						move_uploaded_file($_FILES['dp']['tmp_name'], "upload/post/".$media);
						$path="upload/post/".$media;
						$shuff="upload/post/"."YS_VID_".str_shuffle("asdfghjklqwertyzxcvbn").".mp4";
						$img=rename($path, $shuff);
						$sql="INSERT INTO yspost (who,postid,media,mediatype,body,time) VALUES ('$id','$postid','$shuff','$type','$posttext','$time')";
						$retval=mysql_query($sql);
						if ($retval) {
							header("location:main.php");
						}
					}
					else {
						echo '
						<div class="sixty border pad-plus">
						<i class="fa fa-bell-o huge-text blue left pad-right-long"></i>
						<div class="pad-left-long">
							The media uploaded is not supported.
							video should be of mp4 or 3gp format
							<br>
							Image should be of jpg,jpeg,png, or gif format.
							Or the media size exceeds limit of 5mb
						</div>
						</div>'.'
						<br><br><br>
						';
					}
				}
				else if ($posttext!="" && $media=="") {
						include("db.php");
						$time=date("D d M Y, @G:i");
						$postid=str_shuffle("asdfghjklqwertyzxcvbn").time();
						$sql="INSERT INTO yspost (who,postid,body,time) VALUES ('$id','$postid','$posttext','$time')";
						$retval=mysql_query($sql);
						if ($retval) {
							header("location:main.php");
						}
				}
				else {
					echo '
						<div class="sixty border pad-plus">
						<i class="fa fa-bell-o huge-text blue left pad-right-short"></i>
						<div class="pad-left-long">
							Some input fields where left empty
							<br>
							Kindly upload a media file or post text.
						</div>
						</div>
						<br><br><br>
					';
				}
			}
		?>
		<form accept="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
			<input type="file" name="dp" class="hidden hide" hidden>
			<button id="choose" type="button" class="pad black">
				<i class="fa fa-camera blue extreme-text"></i>
				<br><br>
				Add Media
			</button>
			<br><br><br>

			<textarea name="posttext" placeholder="Whats up?" class="pad-plus border sixty"></textarea>
			<br><br><br>

			<button class="bold black seventy pad-plus border" name="save">
				<i class="fa fa-heart big-text blue pad-right"></i>
				Save Shot
			</button>
		</form>
		</div>
		<br><br><br>

		<div class="center bold">
		&copy; Angel Works <?php echo date("Y"); ?>
		</div>
</body>
</html>
<?php
	mysql_free_result($retval);
	mysql_close($conn);
?>