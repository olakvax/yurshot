<?php
	if (isset($_POST['checkname'])) {
		$name=mysql_real_escape_string(htmlspecialchars($_POST['checkname'],ENT_QUOTES));
		if (!empty($name)) {
			include("db.php");
			$sql="SELECT name FROM ysuser WHERE name='$name'";
			$retval=mysql_query($sql);
			$num=mysql_num_rows($retval);
			if ($num>0) {
				echo '
				<i class="fa fa-times red big-text"></i>
				';
			}
			else {
				echo '
				<i class="fa fa-check green big-text"></i>
				';
			}
			mysql_free_result($retval);
			mysql_close($conn);
		}
		else {
			echo '
			<i class="fa fa-male big-text"></i>
			';
		}
	}
	else if(isset($_POST['checkmail'])) {
		$mail=mysql_real_escape_string(htmlspecialchars($_POST['checkmail'],ENT_QUOTES));
		if (!empty($mail)) {
			include("db.php");
			$sql="SELECT mail FROM ysuser WHERE mail='$mail'";
			$retval=mysql_query($sql);
			$num=mysql_num_rows($retval);
			if ($num>0) {
				echo '
				<i class="fa fa-times red big-text"></i>
				';
			}
			else {
				echo '
				<i class="fa fa-check green big-text"></i>
				';
			}
			mysql_free_result($retval);
			mysql_close($conn);
		}
		else {
			echo '
			<i class="fa fa-envelope"></i>
			';
		}
	}
	else {
		header("location:index.php");
	}
?>