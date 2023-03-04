<?php
include 'connect.php';

class STMS
{
	function Login(){
		global $conn;
		$UserName = $_POST['UserName'];
		$Password = MD5($_POST['Password']);

		$sql = ("SELECT * FROM tbl_user WHERE UserName = '$UserName' AND Password = '$Password'");
		$result = $conn->query($sql) or die(mysqli_error($conn));

		if($result->num_rows > 0){
			
				session_start(); // SESSION START
				
				$row = mysqli_fetch_assoc($result);
				
				$DbUserID = $row['UserID'];
				$DbUsername = $row['UserName'];
				$DbPassword = $row['Password'];
				$DbPrivilage = $row['Privilage'];
				
				if($DbUsername == $UserName && $DbPassword == $Password ){
					
					$_SESSION['UID'] = $row['UserID'];
					$_SESSION['Name'] = $row['FName']." ".$row['LName'];
					$_SESSION['Privl'] = $row['Privilage'];
					$_SESSION['Status'] = $row['Status'];
					
					if($_SESSION['Privl'] == 'Administrator' && $_SESSION['Status'] == 'Active'){
						header("location:AdminDashboard.php");
					}
					elseif($_SESSION['Privl'] == 'Student' && $_SESSION['Status'] == 'Active'){
						header("location:AdminDashboard.php");
					}
					else{
						$_SESSION['Blocked'] = "done";
					}
				}
				
			
		}else{
					$_SESSION['Error'] = "done";
				}
	}

	function AddUser($check = ""){
		global $conn;
		$FName = $_POST['FName'];
		$LName = $_POST['LName'];
		$Gender = $_POST['Gender'];
		$Address = $_POST['Address'];
		$Phone = $_POST['Phone'];
		$UserName = $_POST['UserName'];
		$Password = MD5($_POST['Password']);
		if($check = "Signup"){
			$Privl = "Student";
			$Status = "Deactive";
		}else{
			$Privl = $_POST['Privilage'];
		$Status = $_POST['Status'];
		}
		

		$sql = "SELECT * FROM tbl_User WHERE UserName = '$UserName'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$_SESSION['Exist'] = "done";
			
		}else{
			$sql = "INSERT INTO tbl_user VALUES('','$FName','$LName','$Gender','$Address','$Phone','$UserName','$Password','$Privl','$Status')";
			$result = $conn->query($sql);
			if ($result == true) {
				$_SESSION['Success'] = "done";

			}else{
				echo "<script>alert('Data NOT Saved')</script>";
			}
		}
	}

	function ViewUser(){
		global $conn;
		$sql = "SELECT * FROM tbl_user";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"
					<tr>
						<td>{$row['FName']} {$row['LName']}</td>
						<td>{$row['Gender']}</td>
						<td>{$row['Address']}</td>
						<td>{$row['Phone']}</td>
						<td>{$row['UserName']}</td>
						<td>{$row['Privilage']}</td>
						<td><a data-toggle='modal' data-target='#ModalEditUser".$row['UserID']."' data-toggle='tooltip' data-placement='top' title='Edit'>
                                         <i class='far fa-edit'></i></a>";
							if($row['Status'] == 'Active'){
		                   		 echo "<a data-toggle='modal' data-target='#ModalAccessDeactive".$row['UserID']."' data-toggle='tooltip' data-placement='top' title='Active' style='color:Green'>
                                         <i class='fas fa-ban'></i></a>";
		                    	} 
		                   	if($row['Status'] == 'Deactive'){
		                    	echo "<a data-toggle='modal' data-target='#ModalAccessActive".$row['UserID']."' data-toggle='tooltip' data-placement='top' title='Deactive' style='color:red'>
                                         <i class='fas fa-ban'></i></a>";
		                    	}
		                    if($row['Privilage'] == 'School'){
	                    	echo "<a data-toggle='modal' data-target='#ModalAssignToSchool".$row['UserID']."' data-toggle='tooltip' data-placement='top' title='Assign to School'>
                                     <i class='fas fa-sign-in-alt'></i></a>";
	                    	}      
						echo "</td>";
					echo "</tr>";

					echo "
						<div class='modal fade in' id='ModalEditUser".$row['UserID']."' tabindex='-1' role='dialog'>
			                <div class='modal-dialog'>
			                <div class='card'>
			                <div class='modal-content'>
                            <form class='form-horizontal' method='post' action='ViewUser.php'>
                                <input  type='hidden' name='UserID' value='".$row['UserID']."'>
                                <div class='card-body'>
                                    <h4 class='card-title'>Update User</h4>
                                    <div class='form-group row'>
                                        <label for='fname' class='col-sm-3 text-right control-label col-form-label'>First Name</label>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' name='FName' value='".$row['FName']."' required placeholder='First Name Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='lname' class='col-sm-3 text-right control-label col-form-label'>Last Name</label>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' name='LName' value='".$row['LName']."' required placeholder='Last Name Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='Gender' class='col-sm-3 text-right control-label col-form-label'>Gender</label>
                                        <div class='col-sm-9'>
                                            <select class='form-control' name='Gender'>
                                                <option value='Male'>Male</option>
                                                <option value='Female'>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='Address' class='col-sm-3 text-right control-label col-form-label'>Address</label>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' name='Address' value='".$row['Address']."' required placeholder='Address Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='Phone' class='col-sm-3 text-right control-label col-form-label'>Phone</label>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' name='Phone' value='".$row['Phone']."' required placeholder='Phone Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='UserName' class='col-sm-3 text-right control-label col-form-label'>User Name</label>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' name='UserName' value='".$row['UserName']."' required placeholder='User Name Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='password' class='col-sm-3 text-right control-label col-form-label'>Password</label>
                                        <div class='col-sm-9'>
                                            <input type='password' class='form-control' name='Password' required placeholder='Password Here'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='Privilage' class='col-sm-3 text-right control-label col-form-label'>Privilage</label>
                                        <div class='col-sm-9'>
                                            <select class='form-control' name='Privilage'>
                                                <option value='".$row['Privilage']."'>".$row['Privilage']."</option>
                                                <option value='Administrator'>Administrator</option>
                                                <option value='Director'>Director</option>
                                                <option value='School'>School</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='Status' class='col-sm-3 text-right control-label col-form-label'>Status</label>
                                        <div class='col-sm-9'>
                                            <select class='form-control' name='Status'>
                                                <option value='".$row['Status']."'>".$row['Status']."</option>
                                                <option value='Active'>Active</option>
                                                <option value='Deactive'>Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class='border-top'>
                                    <div class='card-body'>
                                        <button type='submit' name='updateuser' class='btn btn-success'><i class='ti-pencil'></i> Update</button>
                                        <button type='reset' data-dismiss='modal' class='btn btn-primary'>Cancel</button>
                                    </div>
                                </div>
                                </div>
	                            </form>
	                        	</div>
				                </div>
				                </div>
			                </div>

			                <!-- Modal Access To User-->

			                <div class='modal fade' id='ModalAccessDeactive".$row['UserID']."' tabindex='-1'>
		                        <div class='modal-dialog'>
		                        	<div class='card'>
		                            <div class='modal-content'>
		                                <form action='ViewUser.php' method='post'><div class='modal-body' <div class='card-body'>
		                                	<h4 class='card-title'>User Access</h4>
		                                    <div class='form-group'>
		                                        <div class='form-line'>
		                                            <h4 class='center'>Are you sure want to Deactive this user ?
		                                            <input type='hidden' name='UserID' class='form-control' value='".$row['UserID']."'>
		                                        </div>
		                                    </div>
		                                    </div>
		                                    <div class='border-top'>
			                                    <div class='card-body'>
			                                        <button type='submit' name='Deactive' class='btn btn-success'>Yes</button>
			                                        <button type='reset' data-dismiss='modal' class='btn btn-primary'>No</button>
			                                    </div>
                               				</div>
		                                </form>
		                            </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class='modal fade' id='ModalAccessActive".$row['UserID']."' tabindex='-1'>
		                        <div class='modal-dialog'>
		                        	<div class='card'>
		                            <div class='modal-content'>
		                                <form action='ViewUser.php' method='post'><div class='modal-body' <div class='card-body'>
		                                	<h4 class='card-title'>User Access</h4>
		                                    <div class='form-group'>
		                                        <div class='form-line'>
		                                            <h4 class='center'>Are you sure want to Active this user ?
		                                            <input type='hidden' name='UserID' class='form-control' value='".$row['UserID']."'>
		                                        </div>
		                                    </div>
		                                    </div>
		                                    <div class='border-top'>
			                                    <div class='card-body'>
			                                        <button type='submit' name='Active' class='btn btn-success'>Yes</button>
			                                        <button type='reset' data-dismiss='modal' class='btn btn-primary'>No</button>
			                                    </div>
                               				</div>
		                                </form>
		                            </div>
		                            </div>
		                        </div>
		                    </div>";
			}
		}
	}
	
	function ModifyUserAccess(){
		global $conn;
		if(isset($_POST['Deactive'])){
	        $UserID = $_POST['UserID'];
	        if($UserID != $_SESSION['UID']){
	        $sql = "UPDATE tbl_User SET Status='Deactive' WHERE UserID = '$UserID'";
	        $result = $conn->query($sql);
	        }
	        else{
	            $_SESSION['Disable'] = "done";
	        }
    	}
	    if(isset($_POST['Active'])){
	        $UserID = $_POST['UserID'];
	        $sql = "UPDATE tbl_User SET Status='Active' WHERE UserID = '$UserID'";
	        $result = $conn->query($sql);
	    }
	}
	function UpdateUser(){
		global $conn;
		$userID = $_POST['UserID'];
		$FName = $_POST['FName'];
		$LName = $_POST['LName'];
		$Gender = $_POST['Gender'];
		$Address = $_POST['Address'];
		$Phone = $_POST['Phone'];
		$UserName = $_POST['UserName'];
		$Password = MD5($_POST['Password']);
		$Privl = $_POST['Privilage'];
		$Status = $_POST['Status'];

		$sql = "UPDATE tbl_user SET FName='$FName',LName='$LName',Gender='$Gender',Address='$Address',Phone='$Phone',UserName='$UserName',Password='$Password',Privilage='$Privl',Status='$Status' WHERE UserID = '$userID'";
		$result = $conn->query($sql);
		if ($result == true) {
			$_SESSION['Updated'] = "done";
			header("location:ViewUser.php");
		}else{
			echo "<script>alert('User NOT Updated')</script>";
		}
	}

	function AddSubject(){
		global $conn;
		$SubjectCode = $_POST['SubjectCode'];
		$SubjectName = $_POST['SubjectName'];
		$UserID = $_SESSION['UID'];
		
		$sql = "SELECT * FROM tbl_Subject WHERE SubjectCode = '$SubjectCode'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$_SESSION['Exist'] = "done";
			
		}else{
			$sql = "INSERT INTO tbl_Subject VALUES('','$SubjectCode','$SubjectName','$UserID')";
			$result = $conn->query($sql) or die(mysqli_error($sql));
			if ($result == true) {
				$_SESSION['Success'] = "done";
			}else{
				echo "<script>alert('Data NOT Saved')</script>";
			}
		}
	}

	function ViewSubject(){
		global $conn;
		$sql = "SELECT * FROM tbl_Subject WHERE SubjectCode != 'None'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"
					<tr>
						<td>{$row['SubjectCode']}</td>
						<td>{$row['SubjectName']}</td>";
						if($_SESSION['Privl'] == "Administrator"){
						echo "<td><a data-toggle='modal' data-target='#ModalEditSubject".$row['SubjectID']."' data-toggle='tooltip' data-placement='top' title='Edit'>
                                         <i class='far fa-edit'></i></a>
							<a href='ViewNotes.php?SubjID=".$row['SubjectID']."&Nm=".$row['SubjectName']."' data-toggle='tooltip' data-placement='top' title='View Notes'>
                                         <i class='fas fa-eye'></i></a> 
                        </td>";
						}
						else{
							echo "<td><a href='ViewNotes.php?SubjID=".$row['SubjectID']."&Nm=".$row['SubjectName']."' data-toggle='tooltip' data-placement='top' title='View Notes'>
							<i class='fas fa-eye'></i></a> 
		   					</td>";
						}
					echo"</tr>";
					echo "<!-- Modal Edit Subject-->
		                <div class='modal fade in' id='ModalEditSubject".$row['SubjectID']."'>
			                <div class='modal-dialog'>
			                <div class='card'>
		                      <div class='modal-content'>
		                      <form class='form-horizontal' action='#' method='post'>
		                        <div class='card-body'>
                                <h4 class='card-title'>Update Subject</h4>
	                                <div class='form-group'>
                                        <div class='form-line'>
                                            <input class='form-control' name='SubjectID' value='".$row['SubjectID']."' type='hidden' required=''>
			                           </div>
	                                </div>
	                                <div class='form-group'>
                                        <div class='form-line'>
                                        <label for='TotalStu' text-right control-label col-form-label'>Subject Code :</label>
                                        	<input class='form-control' name='SubjectCode' value='".$row['SubjectCode']."' type='text' required=''>
			                           </div>
	                                </div>
	                                <div class='form-group'>
                                        <div class='form-line'>
                                        <label for='TotalStu' text-right control-label col-form-label'>Subject Name :</label>
                                        	<input class='form-control' name='SubjectName' value='".$row['SubjectName']."' type='text' required=''>
			                           </div>
	                                </div>

		                          </div>
		                        	<div class='border-top'>
	                                    <div class='card-body'>
	                                        <button type='submit' name='UpdateSubject' class='btn btn-success'>Update</button>
	                                        <button type='reset' class='btn btn-primary' data-dismiss='modal'>Cancel</button>
	                                    </div>
                       				</div>
		                      </form>
		                      </div>
			                </div>
			                </div>
			            </div>";

			}
		}
	}

	function UpdateSubject(){
		global $conn;
		$SubjectID = $_POST['SubjectID'];
		$SubjectCode = $_POST['SubjectCode'];
		$SubjectName = $_POST['SubjectName'];;

		$sql = "UPDATE tbl_Subject SET SubjectCode='$SubjectCode',SubjectName='$SubjectName' WHERE SubjectID = '$SubjectID'";
		$result = $conn->query($sql);
		if ($result == true) {
			$_SESSION['Updated'] = "done";
		}else{
			echo "<script>alert('Subject NOT Updated')</script>";
		}
	}

	function AddNotes(){
		global $conn;
		$Title = $_POST['Title'];
		$FileType = $_POST['FileType'];
		$UploadDate = date('Y-m-d');
		$SubjID = $_POST['SubjID'];
		$doc_name = $_FILES['FileName']['name'];
        $doc_extension = pathinfo($doc_name,PATHINFO_EXTENSION);
		$FilePath = "";
		if ($_FILES['FileName']['tmp_name'] != ""){
			if($FileType == "File"){
				if ($doc_extension != "jpg" && $doc_extension != "svg" && $doc_extension != "SVG" && $doc_extension != "png" && $doc_extension != "jpeg"
                    && $doc_extension != "gif" && $doc_extension != "JPG" && $doc_extension != "PNG" && $doc_extension != "JPEG"&& $doc_extension != "gif") {
						$FilePath = "Notes/Docs/".time()."_".$_FILES['FileName']['name'];
						move_uploaded_file($_FILES['FileName']['tmp_name'], $FilePath);
					}else{
						echo "<script>alert('File Format Not Supported')</script>";
					}
				
			}else{
				if ($doc_extension != "mp4" && $doc_extension != "avi" && $doc_extension != "mov" && $doc_extension != "3gp" ) {
						echo "<script>alert('File Format Not Supported')</script>";
					}else{
						$FilePath = "Notes/Videos/".time()."_".$_FILES['FileName']['name'];
						move_uploaded_file($_FILES['FileName']['tmp_name'], $FilePath);
					}
				
			}
            
        }else{
            $FilePath = "";
        }

		$sql = "SELECT * FROM tbl_Material WHERE Title = '$Title'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$_SESSION['Exist'] = "done";
		}else{
				$sql = "INSERT INTO tbl_Material VALUES('','$Title','$FileType','$FilePath','$UploadDate','$SubjID')";
				$result = $conn->query($sql) or die(mysqli_error($conn));
				if ($result == true) {
					$_SESSION['Success'] = "done";
				}else{
					echo "<script>alert('Data NOT Saved')</script>";
				}
		}
	}

	function ViewNotes($FileType = "",$ID = ""){
		global $conn;
		if($FileType == "File"){
			$sql = "SELECT * FROM tbl_Material WHERE FileType = '$FileType'AND SubjectID = '$ID'";
		}else{
			$sql = "SELECT * FROM tbl_Material WHERE FileType = '$FileType'AND SubjectID = '$ID'";
		}
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"
					<tr>
						<td><a href='{$row['FlName']}' target='_blank'>{$row['Title']}</a></td>
						<td>{$row['FileType']}</td>
						<td>{$row['UploadDate']}</td>";
						if($_SESSION['Privl'] == "Administrator"){
							echo "<td><a data-toggle='modal' data-target='#ModalEditNotes".$row['MtrID']."' data-toggle='tooltip' data-placement='top' title='Edit'>
											<i class='far fa-edit'></i></a>
								<a href='{$row['FlName']}' target='_blank' data-toggle='tooltip' data-placement='top' title='Download'>
											<i class='fas fa-angle-double-down'></i></a>
							</td>";
						}else{
							echo "<td><a href='{$row['FlName']}' target='_blank' data-toggle='tooltip' data-placement='top' title='Download'>
							<i class='fas fa-angle-double-down'></i></a>
							</td>
							";
						}
						echo "</tr>";

			}
		}
	}

	function ViewVideosNotes($ID = ""){
		global $conn;
			$sql = "SELECT * FROM tbl_Material WHERE FileType = 'video' AND SubjectID = '$ID'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"<div style='display:inline-block;'>
					<video width='300' height='200' controls autoplay>
						<source src='{$row['FlName']}' type=''video/mp4>
					</video>
					<center><p>{$row['UploadDate']} {$row['Title']}</p></center>
					</div>
					";
			}
		}
	}

//=================== Function For Count Everything in whole System ===============>

	function Count($what = ""){
		global $conn;
		$YearNow = date('Y');
		if($what == "ComingTech"){
			$SchlID =  $_SESSION['SchlID'];
			$sql = "SELECT * FROM tbl_School INNER JOIN ((tbl_Sch_Tch inner join tbl_Teacher using(TchID)) inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Null'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}elseif ($what == "SchlTech") {
			$SchlID =  $_SESSION['SchlID'];
			$sql = "SELECT * FROM tbl_School INNER JOIN (((tbl_Sch_Tch inner join tbl_Teacher using(TchID))inner join tbl_subject using(SubjectID))inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Approved'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Science") {
			$SchlID =  $_SESSION['SchlID'];
			$sql = "SELECT * FROM tbl_School INNER JOIN (((tbl_Sch_Tch inner join tbl_Teacher using(TchID))inner join tbl_subject using(SubjectID))inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Approved' AND tbl_Tch_Education.EduCategory = 'SCIENCE'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Art") {
			$SchlID =  $_SESSION['SchlID'];
			$sql = "SELECT * FROM tbl_School INNER JOIN (((tbl_Sch_Tch inner join tbl_Teacher using(TchID))inner join tbl_subject using(SubjectID))inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Approved' AND tbl_Tch_Education.EduCategory = 'ART'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "School") {
			$sql = "SELECT * FROM tbl_School";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Private") {
			$sql = "SELECT * FROM tbl_School  WHERE tbl_School.CtgName = 'Private'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Government") {
			$sql = "SELECT * FROM tbl_School  WHERE tbl_School.CtgName = 'Government'";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Teacher") {
			$sql = "SELECT * FROM tbl_Teacher";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "Assigned") {
			$sql = "SELECT TchID FROM tbl_Teacher inner join tbl_Sch_Tch using(TchID)";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "UnAssigned") {
			$sql = "SELECT * FROM tbl_Teacher WHERE tbl_Teacher.TchID NOT IN(SELECT TchID FROM tbl_Teacher inner join tbl_Sch_Tch using(TchID))";
			$result = $conn->query($sql);
			echo $result->num_rows;
		}
		elseif ($what == "OverRoll") {
			$SchlID =  $_SESSION['SchlID'];
			$sql = "SELECT * FROM tbl_School INNER JOIN ((tbl_Sch_Year inner join tbl_YearClass using(SchYrID)) inner join tbl_Class using(ClassID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID";
			$result = $conn->query($sql);
			$OverRoll = 0;
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$OverRoll += $row['TotalStudent'];
				}
				echo $OverRoll;
			}
		}
		
	}

}

?>