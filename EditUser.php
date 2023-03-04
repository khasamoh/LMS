<?php
    include 'session.php';
    include 'Functionality/classes.php';
    $call = new STMS();
    if(isset($_POST['updateuser'])){
        $call->UpdateUser();
    }
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include 'headLink.php';?>
</head>

<body>
    <div id="main-wrapper">
        <header class="topbar" data-navbarbg="skin5">
            <?php include 'Header.php';?>
        </header>
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                 <?php include 'Sidebar.php';?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php
                    global $conn;
                    $userID = $_GET['UserID'];
                    $sql = "SELECT * FROM tbl_User WHERE UserID = '$userID'";
                    $result = $conn->query($sql) or die(mysqli_error($sql));
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                    }
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <form class="form-horizontal" method="post" action="EditUser.php">
                                <input  type="hidden" name="UserID" value="<?php echo $row['UserID'];?>">
                                <div class="card-body">
                                    <h4 class="card-title">Create User</h4>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="FName" value="<?php echo $row['FName'];?>" required placeholder="First Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="LName" value="<?php echo $row['LName'];?>" required placeholder="Last Name Here">
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
                                            <input type="text" class="form-control" name="Address" value="<?php echo $row['Address'];?>" required placeholder="Address Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Phone" class="col-sm-3 text-right control-label col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="Phone" value="<?php echo $row['Phone'];?>" required placeholder="Phone Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="Email" value="<?php echo $row['Email'];?>" required placeholder="Email Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="UserName" class="col-sm-3 text-right control-label col-form-label">User Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="UserName" value="<?php echo $row['UserName'];?>" required placeholder="User Name Here">
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
                                                <option value="<?php echo $row['Privilage'];?>"><?php echo $row['Privilage'];?></option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="Director">Director</option>
                                                <option value="School">School</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Status" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="Status">
                                                <option value="<?php echo $row['Status'];?>"><?php echo $row['Status'];?></option>
                                                <option value="Active">Active</option>
                                                <option value="Deactive">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" name="updateuser" class="btn btn-success"><i class="ti-plus"></i> Update</button>
                                        <button type="reset" onclick="cancel()" class="btn btn-primary">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <footer class="footer text-center">
                <?php include 'footer.php';?>
            </footer>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <script type="text/javascript"> function cancel(){window.location.href='viewUser.php';}</script>
</body>

</html>