<?php
	if (isset($_POST['save'])) {
		$file=$_FILES['img']['name'];
		$file_type=$_FILES['img']['type'];
		echo $file_type;
	}
?>


<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	<input type="file" name="img">
	<button name="save">
		Save
	</button>
</form>