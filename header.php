<?php
//header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>UAS Business Application Programming</title>
	<!-- ===== Bootstrap CSS ===== -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- ===== Animation CSS ===== -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="css/style.css" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="css/default.css" id="theme" rel="stylesheet">
</head>

<body class="mini-sidebar">
    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <!-- ===== Top-Navigation ===== -->

        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="top-left-part">
                    <a class="logo" href="index.php">
                        <b>
                            <img src="images/logo.png" alt="home" />
                        </b>
                        <span>
                            <img src="images/logo-text.png" alt="homepage" class="dark-logo" />
                        </span>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class=" icon-arrow-left"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="right-side-toggle">
                        <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" onclick="goBack()">
                            <i class="icon-action-undo">&nbsp; Back</i>
                        </a>
                        <script>
                            function goBack() {
                              window.history.back();
                          }
                      </script>
                  </li>
              </ul>
          </div>
      </nav>
      <!-- ===== Top-Navigation-End ===== -->

      <!-- ===== Left-Sidebar ===== -->
      <aside class="sidebar">
        <div class="scroll-sidebar">
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <div class="profile-image">
                     
                        <img src="images/users/1.jpg" alt="user-img" class="img-circle">
                        <a href="javascript:void(0);" class="dropdown-toggle u-dropdown text-blue" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="badge badge-danger">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated flipInY">
                            <li><a href="profile.php"><i class="fa fa-user"></i> Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <?php
                            if($_SESSION['type'] == 'master')
                            {
                                ?>
                                <li><a href="user.php"><i class="fa fa-cog"></i> User Settings</a></li>
                                <li role="separator" class="divider"></li>
                                <?php
                            }
                            ?>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                    <p class="profile-text m-t-15 font-16"><a href="javascript:void(0);"><?php echo $_SESSION["user_name"]; ?></a></p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul id="side-menu">

                    <li>
                        <a class="active waves-effect" href="cashflow.php" aria-expanded="false"><i class="icon-wallet fa-fw"></i> <span class="hide-menu"> Cashflow</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>


        <script src="js/jquery-1.10.2.min.js"></script>
        <!-- ===== Menu Plugin JavaScript ===== -->
        <script src="js/sidebarmenu.js"></script>
        <!-- ===== Custom JavaScript ===== -->
        <script src="js/custom.js"></script>
        <!-- ===== Style Switcher JS ===== -->
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>      
        <script src="js/bootstrap.min.js"></script>

    </body>

    </html>