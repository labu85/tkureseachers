<?php
require_once('connect.php');
session_start();
if(!isset($_SESSION["u_login"]) || ($_SESSION["u_login"]=="")){
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
   <!-- <link href="css/sb-admin.css" rel="stylesheet">  
   -->
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
      <nav class="navbar navbar-default" role="navigation">
         <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">Title</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
               <form class="navbar-form navbar-left" role="search">
                  <div class="form-group">
                     <input type="text" class="form-control" placeholder="Search"></div>
               </form>
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i><b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="#"></a>
                        </li>
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-plus"></i><b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Setup Groups</a>
                        </li>
                        <li>
                           <a href="#"><i class="fa fa-upload"></i> Upload Files</a>
                        </li>
                     </ul>
                  </li>

                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user">&nbsp;</i>
                        <?php echo $identity; ?> <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        <li>
                           <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                           <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li>
                           <a href="?logout=true"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->          
            </div>
        </nav>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->            
                            <div class="panel-heading"> <strong>Toolbox</strong>
                            </div>
                            <div class="list-group">
                                <a href="member_grouping.php" class="list-group-item"> <i class="fa fa-list-alt" aria-hidden="true"></i> Set up a Group</a>
                                <a href="member_file.php" class="list-group-item"><i class="fa fa-file" aria-hidden="true"></i> File</a>
                                <a href="member_score.php" class="list-group-item"><i class="fa fa-area-chart" aria-hidden="true"></i> Score</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Group</h3>
                            </div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <!-- jQuery -->
         <script src="js/jquery.js"></script>
         <!-- Bootstrap Core JavaScript -->
         <script src="js/bootstrap.min.js"></script>
      </body>
   </html>