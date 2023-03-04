<nav class="sidebar-nav">
    <ul id="sidebarnav" class="p-t-30">
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="AdminDashboard.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
        <?php
            if($_SESSION['Privl'] == "Student"){
        ?>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewSubject.php" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">View Subject</span></a></li>
        <?php
            }else{
        ?>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewUser.php" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">View Users</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="ViewSubject.php" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">View Subject</span></a></li>
    </ul>
</nav>
<?php
    }
?>