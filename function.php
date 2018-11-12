<?php
	function ys_hash($str) {
		$str1="/#+([a-zA-Z0-9_]+)/";
		if (preg_match($str1, $str)) {
			$ref_id=str_shuffle("138asdferwcvbl");
			$href="<a class='pad-left pad-right blue bold' href='search.php?q=$1&ref_id=".$ref_id."'>$0</a>";
			$final_result=preg_replace($str1, $href, $str);
			return $final_result;
		}
		else {
			return $str;
		}
	}
	function ys_web($str) {
		$str1="/http:\/\/+([a-zA-Z0-9_.\/]+)/";
		$str2="/https:\/\/+([a-zA-Z0-9_.\/]+)/";
		$str3="/www+([a-zA-Z0-9_.\/]+)/";
		if (preg_match($str1, $str)) {
			$href="<a class='pad-left pad-right blue bold' href='$0'>$0</a>";
			$final_result=preg_replace($str1, $href, $str);
			return $final_result;
		}
		else if (preg_match($str2, $str)) {
			$href="<a class='pad-left pad-right blue bold' href='$0'>$0</a>";
			$final_result=preg_replace($str2, $href, $str);
			return $final_result;
		}
		else if (preg_match($str3, $str)) {
			$href="<a class='pad-left pad-right blue bold' href='http://$0'>$0</a>";
			$final_result=preg_replace($str3, $href, $str);
			return $final_result;
		}
		else {
			return $str;
		}
	}
	function ys_at($str) {
		$str1="/@+([a-zA-Z0-9_]+)/";
		if (preg_match($str1, $str)) {
			$ref_id=str_shuffle("758brywsmfo");
			$href="<a class='pad-left pad-right blue bold' href='search.php?s=$1&ref_id=".$ref_id."'>$0</a>";
			$final_result=preg_replace($str1, $href, $str);
			return $final_result;
		}
		else {
			return $str;
		}
	}
	function ys_encrypt($str) {
		$s1=str_replace("a", "{-}", $str);
		$s2=str_replace("e", "{+}", $s1);
		$s3=str_replace("i", "{_}", $s2);
		$s4=str_replace("o", "{*}", $s3);
		$s5=str_replace("u", "{^}", $s4);
		$s6=str_replace(" ", "{ }", $s5);
		$s7=str_replace("b", "{=}", $s6);
		$s8=str_replace("c", "{&}", $s7);
		$s9=str_replace("s", "{%}", $s8);
		return $s9;
	}
	function ys_decrypt($str) {
		$s1=str_replace("{-}", "a", $str);
		$s2=str_replace("{+}", "e", $s1);
		$s3=str_replace("{_}", "i", $s2);
		$s4=str_replace("{*}", "o", $s3);
		$s5=str_replace("{^}", "u", $s4);
		$s6=str_replace("{ }", " ", $s5);
		$s7=str_replace("{=}", "b", $s6);
		$s8=str_replace("{&}", "c", $s7);
		$s9=str_replace("{%}", "s", $s8);
		return $s9;
	}
?>