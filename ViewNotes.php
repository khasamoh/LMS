<?php
    include 'session.php';
    include 'Functionality/classes.php';
    $call = new STMS();
        if(isset($_POST['AddNotes'])){
           $call->AddNotes();
        }
        if(isset($_POST['updateTeacher'])){
           $call->UpdateTeacher();
        }
        if(isset($_POST['updateTeacher'])){
            $call->UpdateTeacher();
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of Files Notes For <i style='color:#c08934'><?php echo $_GET['Nm'];?></i>
                                <?php
                                    if($_SESSION['Privl'] == "Administrator"){
                                ?>
                                <a data-toggle='modal' data-target='#ModalAddNotes' data-toggle='tooltip' data-placement='top' title='Add new Notes'><span style="margin-left:30px;color:#499dff"><i class="mdi mdi-plus"></i> Add New</span></a>
                                <?php
                                    }
                                ?>
                                <a href="ViewNotesVideos.php?SubjID=<?php echo $_GET['SubjID'].'&Nm='.$_GET['Nm'];?>"><span style="margin-left:30px;"><i class="mdi mdi-video"></i> Videos Notes</span></a></h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Titel</th>
                                                <th>File Type</th>
                                                <th>Uploaded Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $call->ViewNotes("File",$_GET['SubjID']);?>
                                        </tbody>
                                        <tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal fade in' id='ModalAddNotes' tabindex='-1' role='dialog'>
                <div class='modal-dialog'>
                    <div class='card'>
                        <div class='modal-content'>
                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" class="form-control"<?php echo"value='".$_GET['SubjID']."'"?> name="SubjID" required>
                            <div class="card-body">
                                <h4 class="card-title">Add Notes</h4>
                                <div class="form-group row">
                                    <label for="SbjCode" class="col-sm-3 text-right control-label col-form-label">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="Title" required placeholder="Title Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="FileType" class="col-sm-3 text-right control-label col-form-label">File Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="FileType">
                                            <option value="File">File</option>
                                            <option value="Video">Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="File" class="col-sm-3 text-right control-label col-form-label">Upload</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="FileName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" name="AddNotes" class="btn btn-success">Upload</button>
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center">
                <?php include 'footer.php';?>
            </footer>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">$(".select2").select2();</script>
    <script> $('#zero_config').DataTable();</script>

    <?php
        if (isset($_SESSION['Updated'])){
    ?>
    <script>
        Swal.fire({toast:true, type:"success", title:"The Notes Updated", animation:true, showConfirmButton: false, position:"top", timer:3000, timerProgressBar:true,});
    </script>
        <?php
        }
        unset($_SESSION['Updated']);
    ?>
    <?php
        if (isset($_SESSION['Success'])) {
    ?>
    <script>
       Swal.fire({toast:true, type:"success", title:"The Notes Uploaded", animation:true, showConfirmButton: false, position:"top", timer:3000, timerProgressBar:true,});
    </script>
    <?php
   
        }
        if (isset($_SESSION['Exist'])) {
    ?>
    <script>
        Swal.fire({toast:true, type:"info", title:"This Notes Exist", animation:true, showConfirmButton: false, position:"top", timer:3000, timerProgressBar:true,});
    </script>
        <?php
        }
        unset($_SESSION['Success']);
        unset($_SESSION['Exist']);
    ?>

</body>

</html>