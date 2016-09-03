<?php
// todo
// There are many redundant sql query maybe can do it all by one time ex pre-process
// Prevent each group has the same people or over write
?>
<?php
require_once '../connect.php';
session_start();
if (!isset($_SESSION["u_login"]) || ($_SESSION["u_login"] == "")) {
   header("Location:index.php");
}
if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
   unset($_SESSION["u_login"]);
   unset($_SESSION["Level"]);
   header("Location:index.php");
}
//pull user name
$query_pullMember = "SELECT * FROM member WHERE username ='" . $_SESSION["u_login"] . "'";
$datapool = mysqli_query($connect, $query_pullMember);
#pull data to vars
$pull_all = @mysqli_fetch_assoc($datapool);
$identity = $pull_all["name"];
$my_id = $pull_all["username"];
$pkey = $pull_all["id"];
$project_name = $pull_all["p_name"];
$my_group = $pull_all["gup_number"];
$this_year = $pull_all["year"];
//# whoami
//>_CHEN MING TSE
$whoami = $pull_all["is_leader"];
if ($project_name != "") {
   $project_isset = 1;
} else {
   $project_isset = 0;
}
//////////////////////////////////////////////////////////
if (isset($_GET["action"]) && $_GET["action"] == "new") {
   $query_insert = "UPDATE member SET p_name = '" . $_GET["pname"] . "' , is_leader = '1' WHERE id ='" . $pkey . "'";
   mysqli_query($connect, $query_insert);
   ///assign group/////////////////////////////////////////////////////////////////////
   $query_getindex = "SELECT * FROM member WHERE gup_number != 0 AND year ='" . $this_year . "'";
   $index = mysqli_query($connect, $query_getindex);
   $row = mysqli_num_rows($index);
   $assign_gnum = ++$row;
   $query_setgroup = "UPDATE member SET gup_number ='" . $assign_gnum . "' WHERE id ='" . $pkey . "'";
   mysqli_query($connect, $query_setgroup);
   /////////////////////////////////////////////////////////////////////////////////////
   $query_project_regist = "INSERT INTO project (project_name) VALUES ('" . $_GET["pname"] . "')";
   mysqli_query($connect, $query_project_regist);
   header("Location:grouping.php");
}
//////////////////////////////////////////////////////////
$Errlevel = -1;
if (isset($_GET["membername"]) && $_GET["membername"] != "") {
   if (isset($_GET["action"]) && $_GET["action"] == "addmember") {
      $query_get = "SELECT * FROM member WHERE username ='" . $_GET["membername"] . "' AND year ='" . $this_year . "'";
      $result = mysqli_query($connect, $query_get);
      if (mysqli_num_rows($result) > 0) {
         $Errlevel = 0;
         $query_setgroupuser = "UPDATE member SET gup_number ='" . $my_group . "' WHERE username ='" . $_GET["membername"] . "'";
         $query_setgroup_project = "UPDATE member SET p_name ='" . $project_name . "' WHERE username ='" . $_GET["membername"] . "'";
         mysqli_query($connect, $query_setgroupuser);
         mysqli_query($connect, $query_setgroup_project);
         header("Location:grouping.php");
      } else {
         $Errlevel = 1;
      }
   }
} else {
   $Errlevel = 1;
}
if (!isset($_GET["membername"])) {
   $Errlevel = -1;
}
//////////////////////////////////////////////////////////
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
   $query_delete = "UPDATE member SET gup_number = '0' WHERE username ='" . $_GET["id"] . "'";
   $query_delete_pname = "UPDATE member SET p_name = '' WHERE username ='" . $_GET["id"] . "'";
   mysqli_query($connect, $query_delete);
   mysqli_query($connect, $query_delete_pname);
   header("Location:grouping.php");
}
//////////////////////////////////////////////////////////
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
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <!-- <link href="../css/sb-admin.css" rel="stylesheet">
      -->
      <!-- Custom Fonts -->
      <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <script type="text/javascript">
      function sure(){
      if(confirm("This CAN'T UNDO, are you sure to DELETE MEMBER ?")) return true;
      return false ;
      }
      </script>
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
               <a class="navbar-brand" href="center.php">Title</a>
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
                     <!-- Sync start -->
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user">&nbsp;</i>
                           <?php echo $identity; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="grouping.php"><i class="fa fa-fw fa-group"></i> Group</a>
                           </li>
                           <li>
                              <a href="setting.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                           </li>
                           <li>
                              <a href="?logout=true"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                           </li>
                        </ul>
                     </li>
                      <!-- Sync end -->
                  </ul>
               </div>
               <!-- /.navbar-collapse -->
            </div>
         </nav>
         <div class="container">
            <div class="row">
               <div class="col-md-9 col-md-offset-1">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Group</h3>
                     </div>
                     <div class="panel-body">
                        <?php if ($project_isset == 1) {?>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           <form action="" method="GET" role="form">
                              <div class="form-group">
                                 <label>Project Name</label>
                                 <font color="red"><strong>Already Setup !</strong></font>
                                 <input type="text" class="form-control " disabled="disabled" value="<?php echo $project_name; ?>">
                              </div>
                              <button type="submit" class="btn btn-primary" id="sbtn">Submit</button>
                           </form>
                        </div>
                        <?php }?>
                        <?php if ($project_isset == 0) {?>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           <form action="" method="GET" role="form">
                              <div class="form-group">
                                 <label>Project Name</label>
                                 <input type="text" class="form-control" id="" name="pname">
                                 <div class="checkbox">
                                    <label>
                                       <input type="checkbox" id="cb" onclick="check()">
                                       I Know That Project Name Cant change After Submited
                                    </label>
                                 </div>
                              </div>
                              <input name="action" type="hidden" id="action" value="new">
                              <button type="submit" class="btn btn-primary" id="sbtn">Submit</button>
                           </form>
                        </div>
                        <?php }?>
                     </div>
                  </div>
                  <!-- part 1 -->
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Member Manage</h3>
                     </div>
                     <div class="panel-body">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           <?php if ($whoami == 1) {?>
                           <form action="" method="GET" role="form">
                              <input name="action" type="hidden" id="action" value="addmember">
                              <label>Add Member</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" placeholder="ID" name="membername">
                                 <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"> Add </button>
                                 </span>
                              </div>
                              <br/>
                              <?php if ($Errlevel == 1) {?><font color=red><strong>User Doesnt Exist</strong></font><?php } elseif ($Errlevel == 0) {?>
                              <font color=green><strong>Success</strong></font><?php }?>
                              <!-- /input-group -->
                           </form>
                           <?php }?>
                           <br/>
                        </div>
                        <!-- /.col-lg-6 -->
                        <?php if ($project_name != "") { ?>
                        <table class="table">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>ID</th>
                                 <th>Name</th>
                                 <th>EMail</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $no = 0;
                              //進入第一層迴圈
                              $query_friend = "SELECT * FROM member WHERE gup_number ='" . $my_group . "' AND year ='" . $this_year . "'";
                              $friend = mysqli_query($connect, $query_friend);
                              while ($pull_friends = @mysqli_fetch_assoc($friend)) {$no++;?>
                              <tr>
                                 <!--建立HTML表格的列-->
                                 <td><?php echo $no; ?></td>
                                 <td><?php echo $pull_friends['username']; ?></td>
                                 <td><?php echo $pull_friends['name']; ?></td>
                                 <td><?php echo $pull_friends['email']; ?></td>
                                 <td>
                                    <?php if ($whoami == 1) {?>
                                    <?php if ($my_id == $pull_friends['username']) {?>
                                    <!--Fucker u cant do anything about ur self sorry (LMAO)-->
                                    <?php } else {?>
                                    <a class="btn btn-danger btn-xs" href="?action=delete&id=<?php echo $pull_friends['username'] ?>" onclick="return sure();">Delete</a>
                                    <?php }?>
                                    <?php } else { /*who fucking cares?*/?> <strong>Not Leader</strong> <?php }?>
                                 </td>
                              </tr>
                              <?php /*HTML表格列的結束標記 */}
                              ; //第一層迴圈結束?>
                           </tbody>
                        </table>
                        <?php }?>
                     </div>
                  </div>
                  <!-- part 2 -->
               </div>
            </div>
         </div>
         <script>
         document.getElementById("sbtn").disabled = true;
         function check(){
         if (document.getElementById("cb").checked == true){
         document.getElementById("sbtn").disabled = false;
         }else{
         document.getElementById("sbtn").disabled = true;
         }
         }
         </script>
         <!-- jQuery -->
         <script src="../js/jquery.js"></script>
         <!-- Bootstrap Core JavaScript -->
         <script src="../js/bootstrap.min.js"></script>
      </body>
   </html>