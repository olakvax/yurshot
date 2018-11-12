<?php
	session_start();
	if(!isset($_SESSION['ysagent'])) {
		header("location:index.php");
		exit();
	}
	else if (isset($_REQUEST['q']) || $_REQUEST['q']!="" || $_REQUEST['t']!="") {
		$file_path=mysql_real_escape_string(htmlspecialchars($_REQUEST['q'],ENT_QUOTES));
		if (file_exists($file_path)) {
			$typ=mysql_real_escape_string(htmlspecialchars($_REQUEST['t'],ENT_QUOTES));
			if ($typ=="image") {
				$type="image/jpg";
			}
			else {
				$type="video/mp4";
			}
			$size=filesize($file_path);
			header("Cache-Control: public");
        	header("Content-Description: File Transfer");
        	header("content-Type: $type");
        	header("content-length: $size");
        	header("Content-Transfer-Encoding: binary"); 
        	header("Content-Disposition: attachment; filename = $file_path");
        	readfile($file_path);
        	exit();
		}
		else {
			header("location:main.php");
		}
	}
else if(isset($_POST['start'])) {
	session_start();
	include("db.php");
			$sql="SELECT postid FROM yspost";
			$retval=mysql_query($sql);
			$num=mysql_num_rows($retval);
	if ($_SESSION['ysmore']>$num) {
	$_SESSION['ysmore']=0;
	echo '
	<script>
	location.href="";
	</script>
	';
	}
	else {
	$start=$_SESSION['ysmore']+5;
	$_SESSION['ysmore']=$start;
	echo '
	<script>
	location.href="";
	</script>
	';
}
mysql_free_result($retval);
mysql_close($conn);
}
else if(isset($_REQUEST['prev'])) {
	session_start();
	$start=$_SESSION['ysmore']-5;
	$_SESSION['ysmore']=$start;
	echo '
	<script>
	location.href="";
	</script>
	';
}
else if (isset($_REQUEST['refresh'])) {
	session_start();
	$_SESSION['ysmore']=0;
	echo '
	<script>
	location.href="";
	</script>
	';
}
elseif (isset($_POST['d'])) {
	$d=mysql_real_escape_string(htmlspecialchars($_POST['d'],ENT_QUOTES));
	include("db.php");
	$sql="SELECT postid,media FROM yspost WHERE postid='$d'";
	$retval=mysql_query($sql);
	$num=mysql_num_rows($retval);
	if ($num<1) {
		header("location:main.php");
		exit();
	}
	else {
		$row=mysql_fetch_array($retval);
		$df=$row['media'];
		if ($df!="") {
		$sql2="DELETE FROM yspost WHERE postid='$d'";
		$retval2=mysql_query($sql2);
		$sql3="DELETE FROM ysevent WHERE postid='$d'";
		$retval3=mysql_query($sql3);
		$sql4="DELETE FROM yslike WHERE postid='$d'";
		$retval4=mysql_query($sql4);
		$sql5="DELETE FROM yscomment WHERE postid='$d'";
		$retval5=mysql_query($sql5);
		unlink($df);
	}
	else {
		$sql2="DELETE FROM yspost WHERE postid='$d'";
		$retval2=mysql_query($sql2);
		$sql3="DELETE FROM ysevent WHERE postid='$d'";
		$retval3=mysql_query($sql3);
		$sql4="DELETE FROM yslike WHERE postid='$d'";
		$retval4=mysql_query($sql4);
		$sql5="DELETE FROM yscomment WHERE postid='$d'";
		$retval5=mysql_query($sql5);
	}
	}
	mysql_free_result($retval);
	mysql_close($conn);
}
	else {
		header("location:main.php");
	}
?>