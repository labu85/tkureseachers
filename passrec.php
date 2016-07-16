<?php

require_once('connect.php');

function makePass($length){

	$conbination = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%&ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	$str = "";

	while(strlen($str)<$length){

		$str .= substr($conbination,rand(0,strlen($conbination)),1);

	}

	return ($str);

}

if((isset($_POST['recovery'])) && ($_POST['recovery'] != "")){

	$query_pull = "SELECT * FROM member WHERE username ='".$_POST["recovery"]."'";

	$datapool = mysqli_query($connect,$query_pull);

	#pull data to vars

	$pull_all = @mysqli_fetch_assoc($datapool);

	$pull_id = $pull_all["username"];

	$pull_name = $pull_all["name"];

	$pull_email = $pull_all["email"];

	if($pull_id == $_POST["recovery"]){

		$newpass = makePass(18);

		$query_update = "UPDATE member SET pwd ='".md5($newpass)."' WHERE username ='".$pull_id."'";

		mysqli_query($connect,$query_update);

		$to      = $pull_email;

		$message = "Dear User ".$pull_name." Your New password is \"".$newpass."\" please update your password.";

		$subject = "DO NOT REPLY - PASSWORD RECOVER ";

		if(@mail($to, $subject, $message)){

			header("Location:passrec.php?finished=1");

		}else{

			header("Location:passrec.php?finished=0");

		}

	}else{

		header("Location:passrec.php?errMsg=1");

	}

}

?>

<!DOCTYPE html>

<!-- Local bootstrap CSS & JS -->

<link rel="stylesheet" media="screen" href="css/bootstrap.min.css">

<link rel="stylesheet" media="screen" href="css/signin.css">

<script src="js/jquery.js"></script>

<script src="js/bootstrap.min.js"></script>

<html>

	<head>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>LogIn</title>

		<meta name="description" content="">

		<meta name="keywords" content="">

		

	</head>

	<body>

		<div class="container">

			<div class="form-signin">

				<div class="panel panel-primary ">

					<div class="panel-heading">

						<h3 class="panel-title">Login</h3>

					</div>

					<div class="panel-body">

						<!--Panel content-->

						<form action="" method="POST" name="form">

							<div class="form-group">

								<?php

								if ((isset($_GET["errMsg"])) && ($_GET["errMsg"] == "1")) {?>

								<p class="warning"><strong>Username not found !</strong></p><?php } ?>

								<?php

								if ((isset($_GET["finished"])) && ($_GET["finished"] == "0")) {?>

								<p class="warning"><strong><font>Error occur, Contact admin !</font></strong></p><?php } ?>

								<?php

								if ((isset($_GET["finished"])) && ($_GET["finished"] == "1")) {?>

								<p class="warning"><strong><font color="green">
									Mail send to your email !<?php print " Redirect in 5 sec.\n" ; header("Refresh:5;url = index.php");} ?><br/>
								</p></font></strong>
								<label for="">Username</label>

								<input type="text" class="form-control" id="" placeholder="" name="recovery" >

								<br/>

								<button type="submit" class="btn btn-lg btn-primary btn-block">Send</button>

								<br/>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

									<strong>Notice:</strong>

									<br/>

									This will send a Recover Mail to your registed email address.<br/><br/>If you have any question please contact admin

								</div>

							</div>

						</form>

					</div>

				</div>

			</div>

		</div>

	</body>

</html>