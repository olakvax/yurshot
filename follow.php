<?php
	session_start();
		$id=$_SESSION['ysagent'];
	if (!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	else if (isset($_POST['follow']) && $_POST['follow']!="" && $_POST['follow']!=$id) {
		include("db.php");
		$time=date("G:i, d M Y");
		$like=mysql_real_escape_string(htmlspecialchars($_POST['follow'],ENT_QUOTES));
		$sql="SELECT * FROM ysuser WHERE who='$like'";
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
			$sql2="SELECT * FROM ysfollower WHERE who='$like' AND follower='$id'";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
			if ($num2>0) {
				$sql3="DELETE FROM ysfollower WHERE who='$like' AND follower='$id'";
				$retval3=mysql_query($sql3);
				$sql7="DELETE FROM ysfollowing WHERE who='$id' AND following='$like'";
				$retval7=mysql_query($sql7);
				$sql7="DELETE FROM ysevent WHERE who='$like' AND notifier='$id' AND body='f'";
				$retval7=mysql_query($sql7);
				if ($retval3 && $retval7) {
						$sql9="UPDATE ysuser SET notification='no' WHERE who='$like'";
						mysql_query($sql9);
					$sql4="SELECT * FROM ysfollower WHERE who='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$sql10="UPDATE ysuser SET list='$num4' WHERE who='$like'";
					mysql_query($sql10);
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
				<i class="fa fa-user blue pad-right-short"></i> Follow <span class="pad-left-long">'.$like_no.'</span>
					';
				}
			}
			else {
				$sql3="INSERT INTO ysfollower (who,follower,time) VALUES ('$like','$id','$time')";
				$retval3=mysql_query($sql3);
				$sql7="INSERT INTO ysfollowing (who,following,time) VALUES ('$id','$like','$time')";
				$retval7=mysql_query($sql7);
				if ($retval3) {
					if ($like!=$id) {
						$time=date("G:i, d M Y");
						$sql5="UPDATE ysuser SET notification='yes' WHERE who='$like'";
						mysql_query($sql5);
						$sql6="INSERT INTO ysevent (who,notifier,body,time) VALUES ('$like','$id','f','$time')";
						mysql_query($sql6);
					}
					$sql4="SELECT * FROM ysfollower WHERE who='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$sql10="UPDATE ysuser SET list='$num4' WHERE who='$like'";
					mysql_query($sql10);
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
				<i class="fa fa-user green pad-right-short"></i> <span class="bold">UnFollow</span> <span class="bold pad-left-long">'.$like_no.'</span>
					';
				}
			}
			mysql_free_result($retval2);
		}
		mysql_free_result($retval);
		mysql_close($conn);
	}
	else if (isset($_POST['unfollow']) && $_POST['unfollow']!="" && $_POST['unfollow']!=$id) {
		include("db.php");
		$like=mysql_real_escape_string(htmlspecialchars($_POST['unfollow'],ENT_QUOTES));
		$sql="SELECT * FROM ysuser WHERE who='$like'";
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
			$sql2="SELECT * FROM ysfollower WHERE who='$like' AND follower='$id'";
			$retval2=mysql_query($sql2);
			$num2=mysql_num_rows($retval2);
						$time=date("G:i, d M Y");
			if ($num2<1) {
				$sql3="INSERT INTO ysfollower (who,follower,time) VALUES ('$like','$id','$time')";
				$retval3=mysql_query($sql3);
				$sql7="INSERT INTO ysfollowing (who,following,time) VALUES ('$id','$like','$time')";
				$retval7=mysql_query($sql7);
				if ($retval3) {
					if ($like!=$id) {
						$time=date("G:i, d M Y");
						$sql5="UPDATE ysuser SET notification='yes' WHERE who='$like'";
						mysql_query($sql5);
						$sql6="INSERT INTO ysevent (who,notifier,body,time) VALUES ('$like','$id','f','$time')";
						mysql_query($sql6);
					}
					$sql4="SELECT * FROM ysfollower WHERE who='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$sql10="UPDATE ysuser SET list='$num4' WHERE who='$like'";
					mysql_query($sql10);
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
				<i class="fa fa-user green pad-right-short"></i> <span class="bold">UnFollow</span> <span class="bold pad-left-long">'.$like_no.'</span>
					';
				}
			}
			else {
				$sql3="DELETE FROM ysfollower WHERE who='$like' AND follower='$id'";
				$retval3=mysql_query($sql3);
				$sql7="DELETE FROM ysfollowing WHERE who='$id' AND following='$like'";
				$retval7=mysql_query($sql7);
				$sql7="DELETE FROM ysevent WHERE who='$like' AND notifier='$id' AND body='f'";
				$retval7=mysql_query($sql7);
				if ($retval3 && $retval7) {
						$sql9="UPDATE ysuser SET notification='no' WHERE who='$like'";
						mysql_query($sql9);
					$sql4="SELECT * FROM ysfollower WHERE who='$like'";
					$retval4=mysql_query($sql4);
					$num4=mysql_num_rows($retval4);
					$sql10="UPDATE ysuser SET list='$num4' WHERE who='$like'";
					mysql_query($sql10);
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
				<i class="fa fa-user blue pad-right-short"></i> Follow <span class="pad-left-long">'.$like_no.'</span>
					';
				}
			}
			mysql_free_result($retval2);
		}
		mysql_free_result($retval);
		mysql_close($conn);
	}
	else if ($id==$_POST['follow'] || $id==$_POST['unfollow']) {
		echo '
		<script>
		location.replace("main.php");
		</script>
		';
	}
	else {
		header("location:main.php");
	}
?>