<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
require_once 'connect.php';
session_start();
if (!isset($_SESSION["u_login"]) || ($_SESSION["u_login"] == "") || ($_SESSION["Level"] != "99")) {
   header("Location:index.php");
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
   unset($_SESSION["u_login"]);
   unset($_SESSION["Level"]);
   header("Location:index.php");
}
//pull user name
$query_pullMember = "SELECT * FROM member WHERE username ='" . $_SESSION["u_login"] . "';";
$datapool = mysqli_query($connect, $query_pullMember);
#pull data to vars
$pull_all = @mysqli_fetch_assoc($datapool);
$identity = $pull_all["name"];
//////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Admin</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/sb-admin.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   <body>
      <div id="wrapper">
         <!-- Navigation -->
         <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="admin_member.php">Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                  <ul class="dropdown-menu message-dropdown">
                  </ul>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                  <ul class="dropdown-menu alert-dropdown">
                     <li>
                     </li>
                  </ul>
               </li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $identity; ?><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                     <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                     </li>
                     <li class="divider"></li>
                     <li>
                        <a href="?logout=true"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                     </li>
                  </ul>
               </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
               <ul class="nav navbar-nav side-nav">
                  <li >
                     <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-user-md"></i> Member Manager <i class="fa fa-fw fa-caret-down"></i></a>
                     <ul id="demo" class="collapse">
                        <li>
                           <a href="admin_member.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Member List</a>
                        </li>
                        <li>
                           <a href="admin_new.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Member</a>
                        </li>
                     </ul>
                  </li>
                  <li class="active">
                     <a href="group_setting.php"><i class="fa fa-users" aria-hidden="true"></i> Group Manage</a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-file" aria-hidden="true"></i> Files</a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-area-chart" aria-hidden="true"></i> Score</a>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </nav>
         <div id="page-wrapper">
            <div class="container-fluid">
               <!-- Page Heading -->
               <div class="row">
                  <div class="col-lg-12">
                     <h1 class="page-header">
                     Group Settings
                     </h1>
                     <ol class="breadcrumb">
                        <li>
                           <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                           <i class="fa fa-file"></i> Blank Page
                        </li>
                     </ol>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->
            <div class="row">
               <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                  <h3>Group Setting</h3>
                  <form role="form">
                     <form action="" method="POST" role="form">
                        <div class="form-group">
                           <label for="">Group Numbers</label>
                           <input type="text" class="form-control" id="" placeholder="Input field">
                           <br/>
                           <label for="">People in Groups</label>
                           <input type="text" class="form-control" id="" placeholder="Input field">
                        </div>
                     </form>
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
               </div>
            </div>
         </div>
         <!-- /#page-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>