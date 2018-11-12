<?php
	header('Access-Control-Allow-Origin: *');
	include("db.php");
	if (isset($_POST['acceptor'])) {
		$post_acceptor=$_POST['acceptor'];
		$user="angel";
		$pass=md5("angel");
		$acceptor="myfactor";
		if ($post_acceptor!=$acceptor) {
			echo '
				You are an hacker that has been found.
			';
		}
		else {
		$sql="SELECT name,passcode,dp FROM ysuser WHERE name='$user' AND passcode='$pass'";
		$retval=mysql_query($sql);
		$num=mysql_num_rows($retval);
		if ($num<1) {
			echo '
				<span class="sp">
					User Details not Found
				</span>
			';
		}
		else {
			$row=mysql_fetch_array($retval);
			$name=$row['name'];
			$img=$row['dp'];
			echo '
				<img class="img" src="http://127.0.0.1:80/yurshot/'.$img.'">
				<br>'.$name;
		}
		mysql_free_result($retval);
		}
	}
	else {
		echo 'false';
	}
?>