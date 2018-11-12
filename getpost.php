<?php
	$retval2=mysql_query($sql2);
	$num=mysql_num_rows($retval2);
	if ($num==0) {
		echo '
			<br><br>
			<div class="bold border pad-plus sixty-plus">
			<i class="left fa fa-bell-o blue extreme-text pad-right-short"></i>
			There are no Shots available<br>
			All shots loaded.
			</div>'.'
			<br><br><br><br>
		';
	}
	else {
		while ($row2=mysql_fetch_array($retval2)) {
			$who=$row2['who'];
			$sqly="SELECT who,following FROM ysfollowing WHERE who='$id' AND following='$who'";
			$retvaly=mysql_query($sqly);
			$numy=mysql_num_rows($retvaly);
			if ($numy>0 || $who==$id) {
			$postid=$row2['postid'];
			$media=$row2['media'];
			$media_type=$row2['mediatype'];
			$bod=str_replace("&#039;", "'", $row2['body']);
			$body=ys_hash(ys_web(ys_at($bod)));
			$time=$row2['time'];
			$sql3="SELECT who,name,dp FROM ysuser WHERE who='$who'";
			$retval3=mysql_query($sql3);
			$row3=mysql_fetch_array($retval3);
			$name=$row3['name'];
			$pic=$row3['dp'];
			mysql_free_result($retval3);
			$sql4="SELECT * FROM yslike WHERE postid='$postid'";
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
			$sql5="SELECT * FROM yslike WHERE postid='$postid' AND liker='$id'";
			$retval5=mysql_query($sql5);
			$num5=mysql_num_rows($retval5);
			if ($num5==0) {
				$like_btn='
				<button class="pad ten-plus border" value="'.$postid.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'likeunlike.php\',{\'like\':stuff});">
				<i class="fa fa-smile-o blue huge-text pad-right-long"></i>'.$like_no.'
				</button>
				';
			}
			else {
				$like_btn='
				<button class="pad ten-plus border" value="'.$postid.'" onclick="javascript: var stuff=$(this).val();$(this).load(\'likeunlike.php\',{\'unlike\':stuff});">
				<i class="fa fa-smile-o red huge-text pad-right-long"></i>'.$like_no.'
				</button>
				';
			}
			mysql_free_result($retval5);
			$sql6="SELECT * FROM yscomment WHERE postid='$postid'";
			$retval6=mysql_query($sql6);
			$num6=mysql_num_rows($retval6);
			$comment_len=strlen($num6);
			if ($comment_len==4) {
				$comment_no=substr($num6, 0,1)."K";
			}
			else if ($like_len==5) {
				$comment_no=substr($num6, 0,2)."K";
			}
			else if ($comment_len==6) {
				$comment_no=substr($num6, 0,3)."K";
			}
			else if ($comment_len==7) {
				$comment_no=substr($num6, 0,1)."M";
			}
			else if ($comment_len==8) {
				$comment_no=substr($num6, 0,2)."M";
			}
			else if ($comment_len==9) {
				$comment_no=substr($num6, 0,3)."M";
			}
			else if ($comment_len==10) {
				$comment_no=substr($num6, 0,1)."B";
			}
			else {
				$comment_no=$num6;
			}
			$comment_btn='
				<button class="comment ten-plus pad pad-right-short border" value="'.$postid.'" onclick="javascript: var stuff=$(this).val();location.href=\'comment.php?q=\'+stuff+\'&ref_id=werwqfvwcd5ggwj\'";>
				<i class="fa fa-inbox huge-text blue pad-right-long"></i>'.$comment_no.'</button>
			';
			if ($media!="" && $body!="") {
				if ($media_type=="image") {
					echo '
						<div class="border-bottom">
							<img class="small-img left pad-right" src="'.$pic.'" onclick="javascript: location.href=\'search.php?s='.$name.'&ref_id='.str_shuffle("316cbfajoiph").'\'">
							<span class="bold uppercase blue">'.$name.'</span><br>'.$time.'
							<br><br><br><br>
							<div>
							<img class="post-img left" src="'.$media.'">
							<img class="small-post-img" src="'.$media.'">
							<br>
							<img class="small-post-img left" src="'.$media.'">
							</div>
							<br><br><br><br><br><br><br><br><br><br><br><div class="seventy">'.$body.'</div><br><br>'.$comment_btn.$like_btn.'
						</div>
					'.'<br><br><br><br><br><br>';
				}
				else {
					$sid=str_shuffle("gtehe353378299292bhjdpsjsapapaobvwfrqwyuwuwigssy632632623djdj");
					echo '
						<div class="border-bottom">
							<img class="small-img left pad-right" src="'.$pic.'" onclick="javascript: location.href=\'search.php?s='.$name.'&ref_id='.str_shuffle("316cbfajoiph").'\'">
							<span class="bold uppercase blue">'.$name.'</span><br>'.$time.'
							<br><br><br>
							<video class="post-img" src="'.$media.'" id="'.$sid.'" val="play" onclick=\'javascript: var vid=document.getElementById("'.$sid.'");var va=$("#'.$sid.'").attr("val");if(va=="play"){vid.play();$("#'.$sid.'").attr("val","pause");}else{vid.pause();$("#'.$sid.'").attr("val","play");}\'></video><br><br><div class="seventy">'.$body.'</div><br>
							<br>'.$comment_btn.$like_btn.'
						</div>
					'.'<br><br><br><br><br><br><br>';				
				}
			}
			else if ($media!="" && $body=="") {
				if ($media_type=="image") {
					echo '
						<div class="border-bottom">
							<img class="small-img left pad-right" src="'.$pic.'" onclick="javascript: location.href=\'search.php?s='.$name.'&ref_id='.str_shuffle("316cbfajoiph").'\'">
							<span class="bold uppercase blue">'.$name.'</span><br>'.$time.'
							<br><br><br><br>
							<div>
							<img class="post-img left" src="'.$media.'">
							<img class="small-post-img" src="'.$media.'">
							<br>
							<img class="small-post-img left" src="'.$media.'">
							</div>
							<br><br><br><br><br><br><br><br><br><br><br>'.$comment_btn.$like_btn.'
						</div>
					'.'<br><br><br><br><br><br><br>';
				}
				else {
					$sid=str_shuffle("gtehe3533782992929nhhhdduduudu3521fvxzbvwfrqwyuwuwigssy632632623djdj");
					echo '
						<div class="border-bottom">
							<img class="small-img left pad-right" src="'.$pic.'" onclick="javascript: location.href=\'search.php?s='.$name.'&ref_id='.str_shuffle("316cbfajoiph").'\'">
							<span class="bold uppercase blue">'.$name.'</span><br>'.$time.'
							<br><br><br><br>
							<video class="post-img" src="'.$media.'" id="'.$sid.'" val="play" onclick=\'javascript: var vid=document.getElementById("'.$sid.'");var va=$("#'.$sid.'").attr("val");if(va=="play"){vid.play();$("#'.$sid.'").attr("val","pause");}else{vid.pause();$("#'.$sid.'").attr("val","play");}\'></video>
							<br>'.$comment_btn.$like_btn.'
						</div>
					'.'<br><br><br><br><br><br><br>';	
				}
			}
			else {
				echo '
						<div class="border-bottom">
							<img class="small-img left pad-right" src="'.$pic.'" onclick="javascript: location.href=\'search.php?s='.$name.'&ref_id='.str_shuffle("316cbfajoiph").'\'">
							<span class="bold uppercase blue">'.$name.'</span><br>'.$time.'
							<br><br><br><br><div class="seventy">'.$body.'</div><br><br>'.$comment_btn.$like_btn.'
						</div>
					'.'<br><br><br><br><br><br><br>';
			}
		}
		mysql_free_result($retvaly);
		}
		mysql_free_result($retval2);
	}
?>