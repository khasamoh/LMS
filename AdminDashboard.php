<?php
    include 'session.php';
    include 'Functionality/classSchool.php';
    $call = new STMS();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>School And Teacher Monitoring System</title>
    <!-- Custom CSS -->
    <link href="assets/extra-libs/calendar/calendar.css" rel="stylesheet" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <style type="text/css">
        .A{width:100%}
        .D{margin:108px 0 0 0px;}
    </style>
</head>

<body>
    <div id="main-wrapper">
        <header class="topbar" data-navbarbg="skin5">
            <?php include 'Header.php';?>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <?php include 'Sidebar.php';?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <?php 
                    if($_SESSION['Privl'] == "Administrator"){
                    ?>
                    <div class="col-md-6 col-lg-3">
                       
                            <a  class="nav-link waves-effect waves-dark A" href="ViewUser.php"> 
                                <div class="card card-hover">
                                    <div class="box bg-cyan text-center">
                                        <h1 class="font-light text-white"><i class="mdi mdi-account-key"></i></h1>
                                        <h6 class="text-white">USER</h6>
                                    </div>
                                </div>
                            </a>
                            
                    </div>
                    <div class="col-md-6 col-lg-3">
                            <a  class="nav-link waves-effect waves-dark A"  href="ViewSubject.php"> 
                                <div class="card card-hover">
                                    <div class="box bg-success text-center">
                                        <h1 class="font-light text-white"><i class="mdi mdi-book-open-variant"></i></h1>
                                        <h6 class="text-white">SUBJECT</h6>
                                    </div>
                                </div>
                            </a>
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="col-md-6 col-lg-3">
                            <a  class="nav-link waves-effect waves-dark A"  href="ViewSubject.php"> 
                                <div class="card card-hover">
                                    <div class="box bg-success text-center">
                                        <h1 class="font-light text-white"><i class="mdi mdi-book-open-variant"></i></h1>
                                        <h6 class="text-white">SUBJECT</h6>
                                    </div>
                                </div>
                            </a>
                    </div> 
                    <?php
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            
                                <?php
                                if($_SESSION['Privl'] == "Administrator"){
                                ?>
                                <h5 class="card-title">List Of Users <a data-toggle='modal' data-target='#ModalAddUser' data-toggle='tooltip' data-placement='top' title='Add new user'><span style="margin-left:30px;color:#499dff"><i class="mdi mdi-plus"></i> Create New</span>
                                         </a></h5>
                                <?php
                                    }else{       
                                ?>
                                <h5 class="card-title">List Of Subject</h5>
                                <?php
                                    }
                                ?>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <?php 
                                            if($_SESSION['Privl'] != "Student"){
                                            ?>
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>User Name</th>
                                                <th>Privilage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $call->ViewUser();?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                        <?php
                                            }else{
                                        ?>
                                            <thead>
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $call->ViewSubject();?>
                                        </tbody>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal fade in' id='ModalAddUser' tabindex='-1' role='dialog'>
                    <div class='modal-dialog'>
                        <div class='card'>
                            <div class='modal-content'>
                                <form class='form-horizontal' method='post' action='ViewUser.php'>
                                    <div class="card-body">
                                        <h4 class="card-title">Create User</h4>
                                        <div class="form-group row">
                                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">First Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="FName" required placeholder="First Name Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lname" class="col-sm-3 text-right control-label col-form-label">Last Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="LName" required placeholder="Last Name Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Gender" class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="Gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Address" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="Address" required placeholder="Address Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Phone" class="col-sm-3 text-right control-label col-form-label">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="Phone" required placeholder="Phone Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="UserName" class="col-sm-3 text-right control-label col-form-label">User Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="UserName" required placeholder="User Name Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="Password" required placeholder="Password Here">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Privilage" class="col-sm-3 text-right control-label col-form-label">Privilage</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="Privilage">
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Student">Student</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="Status" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="Status">
                                                    <option value="Active">Active</option>
                                                    <option value="Deactive">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='border-top'>
                                        <div class='card-body'>
                                            <button type="submit" name="adduser" class="btn btn-success"><i class="ti-plus"></i> Add</button>
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                        </div>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <?php include 'footer.php';?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="dist/js/jquery.ui.touch-punch-improved.js"></script>
    <script src="dist/js/jquery-ui.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="assets/libs/moment/min/moment.min.js"></script>
    <script src="assets/libs/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="dist/js/pages/calendar/cal-init.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>$('#zero_config').DataTable();</script>

</body>

</html>