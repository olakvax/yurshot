<?php
	session_start();
	if (!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	else if (isset($_POST['like']) && $_POST['like']!="") {
		include("db.php");
		$id=$_SESSION['ysagent'];
		$like=mysql_real_escape_string(htmlspecialchars($_POST['like'],ENT_QUOTES));
		$sql="SELECT * FROM yspost WHERE postid='$like'";
		$retval=mysql_query($sql);
		$num=mysql_num_rows($retval);
		if ($num<1) {
			echo "
			<script>
				location.href='';
			</script>
			";
		}
		else {
			$sql2="SELECT * FROM yslike WHERE postid='$like' AND liker='$id'";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			if ($num2>0) {
				$sql3="DELETE FROM yslike WHERE postid='$like' AND liker='$id'";
				$retval3=mysql_query($sql3);
				$sql7="DELETE FROM ysevent WHERE postid='$like' AND notifier='$id' AND body='l'";
				$retval7=mysql_query($sql7);
				if ($retval3) {
						$sql9="UPDATE ysuser SET notification='no' WHERE who='$like'";
						mysql_query($sql9);
					$sql4="SELECT * FROM yslike WHERE postid='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$like_len=strlen($num4);
					if ($like_len==4) {
						$like_no=substr($num4, 0,1)."K";
					}
					else if ($like_len==5) {
						$like_no=substr($num4, 0,2)."K";
					}
					else if ($like_len==6) {
						$like_no=substr($num4, 0,3)."K";
					}
					else if ($like_len==7) {
						$like_no=substr($num4, 0,1)."M";
					}
					else if ($like_len==8) {
						$like_no=substr($num4, 0,2)."M";
					}
					else if ($like_len==9) {
						$like_no=substr($num4, 0,3)."M";
					}
					else if ($like_len==10) {
						$like_no=substr($num4, 0,1)."B";
					}
					else {
						$like_no=$num4;
					}
					mysql_free_result($retval4);
					echo '
					<i class="fa fa-smile-o blue huge-text pad-right-long"></i>'.$like_no;
				}
			}
			else {
				$sql3="INSERT INTO yslike (postid,liker) VALUES ('$like','$id')";
				$retval3=mysql_query($sql3);
				if ($retval3) {
					$row=mysql_fetch_array($retval);
					$who=$row['who'];
					if ($who!=$id) {
						$time=date("G:i, d M Y");
						$sql5="UPDATE ysuser SET notification='yes' WHERE who='$who'";
						mysql_query($sql5);
						$sql6="INSERT INTO ysevent (who,notifier,postid,body,time) VALUES ('$who','$id','$like','l','$time')";
						mysql_query($sql6);
					}
					$sql4="SELECT * FROM yslike WHERE postid='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$like_len=strlen($num4);
					if ($like_len==4) {
						$like_no=substr($num4, 0,1)."K";
					}
					else if ($like_len==5) {
						$like_no=substr($num4, 0,2)."K";
					}
					else if ($like_len==6) {
						$like_no=substr($num4, 0,3)."K";
					}
					else if ($like_len==7) {
						$like_no=substr($num4, 0,1)."M";
					}
					else if ($like_len==8) {
						$like_no=substr($num4, 0,2)."M";
					}
					else if ($like_len==9) {
						$like_no=substr($num4, 0,3)."M";
					}
					else if ($like_len==10) {
						$like_no=substr($num4, 0,1)."B";
					}
					else {
						$like_no=$num4;
					}
					mysql_free_result($retval4);
					echo '
					<i class="fa fa-smile-o red huge-text pad-right-long"></i>'.$like_no;
				}
			}
			mysql_free_result($retval2);
		}
		mysql_free_result($retval);
		mysql_close($conn);
	}
	else if (isset($_POST['unlike']) && $_POST['unlike']!="") {
		include("db.php");
		$id=$_SESSION['ysagent'];
		$like=mysql_real_escape_string(htmlspecialchars($_POST['unlike'],ENT_QUOTES));
		$sql="SELECT * FROM yspost WHERE postid='$like'";
		$retval=mysql_query($sql);
		$num=mysql_num_rows($retval);
		if ($num<1) {
			echo "
			<script>
				location.href='';
			</script>
			";
		}
		else {
			$sql2="SELECT * FROM yslike WHERE postid='$like' AND liker='$id'";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			if ($num2<1) {
				$sql3="INSERT INTO yslike (postid,liker) VALUES ('$like','$id')";
				$retval3=mysql_query($sql3);
				if ($retval3) {
					$row=mysql_fetch_array($retval);
					$who=$row['who'];
					if ($who!=$id) {
						$time=date("G:i, d M Y");
						$sql5="UPDATE ysuser SET notification='yes' WHERE who='$who'";
						mysql_query($sql5);
						$sql6="INSERT INTO ysevent (who,notifier,postid,body,time) VALUES ('$who','$id','$like','l','$time')";
						mysql_query($sql6);
					}
					$sql4="SELECT * FROM yslike WHERE postid='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$like_len=strlen($num4);
					if ($like_len==4) {
						$like_no=substr($num4, 0,1)."K";
					}
					else if ($like_len==5) {
						$like_no=substr($num4, 0,2)."K";
					}
					else if ($like_len==6) {
						$like_no=substr($num4, 0,3)."K";
					}
					else if ($like_len==7) {
						$like_no=substr($num4, 0,1)."M";
					}
					else if ($like_len==8) {
						$like_no=substr($num4, 0,2)."M";
					}
					else if ($like_len==9) {
						$like_no=substr($num4, 0,3)."M";
					}
					else if ($like_len==10) {
						$like_no=substr($num4, 0,1)."B";
					}
					else {
						$like_no=$num4;
					}
					mysql_free_result($retval4);
					echo '
					<i class="fa fa-smile-o red huge-text pad-right-long"></i>'.$like_no;
				}
			}
			else {
				$sql3="DELETE FROM yslike WHERE postid='$like' AND liker='$id'";
				$retval3=mysql_query($sql3);
				$sql7="DELETE FROM ysevent WHERE postid='$like' AND notifier='$id' AND body='l'";
				$retval7=mysql_query($sql7);
				if ($retval3) {
						$sql9="UPDATE ysuser SET notification='no' WHERE who='$like'";
						mysql_query($sql9);
					$sql4="SELECT * FROM yslike WHERE postid='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$like_len=strlen($num4);
					if ($like_len==4) {
						$like_no=substr($num4, 0,1)."K";
					}
					else if ($like_len==5) {
						$like_no=substr($num4, 0,2)."K";
					}
					else if ($like_len==6) {
						$like_no=substr($num4, 0,3)."K";
					}
					else if ($like_len==7) {
						$like_no=substr($num4, 0,1)."M";
					}
					else if ($like_len==8) {
						$like_no=substr($num4, 0,2)."M";
					}
					else if ($like_len==9) {
						$like_no=substr($num4, 0,3)."M";
					}
					else if ($like_len==10) {
						$like_no=substr($num4, 0,1)."B";
					}
					else {
						$like_no=$num4;
					}
					mysql_free_result($retval4);
					echo '
					<i class="fa fa-smile-o blue huge-text pad-right-long"></i>'.$like_no;
				}
			}
			mysql_free_result($retval2);
		}
		mysql_free_result($retval);
		mysql_close($conn);
	}
	else {
		header("location:main.php");
	}
?>