<?php
require_once('connect.php');
session_start();
if(!isset($_SESSION["u_login"]) || ($_SESSION["u_login"]=="") || ($_SESSION["Level"] != "99")){
header("Location:index.php");
}
if(isset($_GET["logout"]) && ($_GET["logout"] == "true")){
unset($_SESSION["u_login"]);
unset($_SESSION["Level"]);
header("Location:index.php");
}
//pull user name
$query_pullMember = "SELECT * FROM member WHERE username ='".$_SESSION["u_login"]."';";
$datapool = mysqli_query($connect,$query_pullMember);
#pull data to vars
$pull_all = @mysqli_fetch_assoc($datapool);
$identity = $pull_all["name"];
if(isset($_GET["action"]) && ($_GET["action"]=="edit") ){
//pull user name
$query_pullToEdit = "SELECT * FROM member WHERE username ='".$_GET["id"]."'";
$datapool_edit = mysqli_query($connect,$query_pullToEdit);
#pull data to vars
$pull_edit = @mysqli_fetch_assoc($datapool_edit);
$id       = $pull_edit["username"];
$name     = $pull_edit["name"];
$group    = $pull_edit["gid"];
$email    = $pull_edit["email"];
}
if(isset($_GET["new_id"]) && $_GET["new_id"] != ""){
$n_id    = $_GET["new_id"];
$n_name  = $_GET["new_name"];
$n_gid   = $_GET["new_gid"];
$n_email = $_GET["new_email"];

$query_update = sprintf("UPDATE member SET gid='%s',name='%s',email='%s' WHERE username='%s'",$n_gid,$n_name,$n_email,$n_id);
mysqli_query($connect,$query_update);
header("Location: admin_member.php");
}
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
   </head>
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
                  <li class="active">
                     <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-users"></i> Member Manager <i class="fa fa-fw fa-caret-down"></i></a>
                     <ul id="demo" class="collapse">
                        <li>
                           <a href="admin_member.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Member List</a>
                        </li>
                        <li>
                           <a href="admin_new.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Member</a>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-fw fa-table"></i> Tables</a>
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
                     Member Manage
                     <small>All Members</small>
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
               <!-- /.row -->
               <div class="row">
                  <div class="col-md-6">
                     <form action="" method="GET" role="form">
                        <legend>Edit Data</legend>
                        <div class="form-group">
                           <label for="">ID</label>
                           <?php 
                              if(isset($_GET["action"])){?>
                                 <input type="text" class="form-control" id="" name="new_id" value="<?php echo $id ?>"  readonly><br/>
                           <?php }?>
                           <?php if(!isset($_GET["action"])){?>
                                 <input type="text" class="form-control" id="" value="" name="new_id"><br/>
                           <?php }?>
                           <label for="">Name</label>
                           <input type="text" class="form-control" id="" value="<?php if(isset($_GET["action"])) echo $name ?>" name="new_name"><br/>
                           <label for="">Group</label>
                           <input type="text" class="form-control" id="" value="<?php if(isset($_GET["action"])) echo $group ?>" name="new_gid"><br/>
                           <label for="">E-Mail</label>
                           <input type="text" class="form-control" id="" value="<?php if(isset($_GET["action"])) echo $email ?>" name="new_email"><br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                        </div>
                        <div align="right">
                           <button type="submit" class="btn btn-success">Update</button>
                           &nbsp;&nbsp;
                           <button type="button" class="btn btn-danger" onclick="location.href='admin_member.php'">Abort</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->
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