<?php 
$target_dir = "Repos/";
$target_path = $target_dir . basename($_FILES['fileToUpload']['name']);
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_path);
echo $_SERVER['PATH_TRANSLATED'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="">
	</head>
	<body>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" name="" value="">
		</form>
	</body>
</html>