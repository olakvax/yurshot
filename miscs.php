<?php
	header('Access-Control-Allow-Origin: null');
	if (isset($_REQUEST['q']) && isset($_REQUEST['t']) && isset($_REQUEST['p']) && $_REQUEST['q']!="" && $_REQUEST['t']!="") {
		$p=mysql_real_escape_string(htmlspecialchars($_REQUEST['p'],ENT_QUOTES));
		$real_p="voyage";
		if ($real_p==$p) {
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
			echo "false";
		}
	}
	else {
		echo "<script>
		alert('hacker');
		</script>";
	}
	}
?>