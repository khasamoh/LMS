<?php
include 'connect.php';
include 'classes.php';
class STMSchool extends STMS
{

	function SubjectSeclection(){
		global $conn;
		$sql = "SELECT * FROM tbl_Subject WHERE SubjectCode != 'None'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"<option value='".$row['SubjectID']."'>{$row['SubjectCode']} : {$row['SubjectName']}</option>";
			}
		}
	}
	
	function ViewSchoolTeacher(){
		global $conn;
		$SchlID =  $_SESSION['SchlID'];
		$sql = "SELECT * FROM tbl_School INNER JOIN (((tbl_Sch_Tch inner join tbl_Teacher using(TchID))inner join tbl_subject using(SubjectID))inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Approved'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$Age = date('Y') - date('Y', strtotime($row['Dob']));
				echo"
					<tr>
						<td>{$row['EmpNo']}</td>
						<td>{$row['FName']} {$row['LName']}</td>
						<td>{$row['Gender']}</td>
						<td>{$row['Address']}</td>
						<td>{$Age}</td>
						<td>{$row['Phone']}</td>
						<td>{$row['Email']}</td>
						<td>
                            <a data-toggle='modal' data-target='#ModalViewMore".$row['TchID']."' data-toggle='tooltip' data-placement='top' title='View More'>
                                <i class='fas fa-eye'></i></a>
                                <a data-toggle='modal' data-target='#ModalAssignSubject".$row['TchID']."' data-toggle='tooltip' data-placement='top' title='Assign Subject'>
                                <i class='fas fa-sign-in-alt'></i></a>
						</td>
					</tr>";
					echo " <!-- Modal ViewMore-->
			                <div class='modal fade' id='ModalViewMore".$row['TchID']."' tabindex='-1'>
		                        <div class='modal-dialog'>
		                        	<div class='card'>
		                            <div class='modal-content'>
		                            <div class='modal-body' 
		                            <div class='card-body row'>
		                                	<h3 class='card-title'>Information of Teacher <i style='color:#499dff'>{$row['FName']} {$row['LName']}</i></h3>
										<div class='row'>
			                                <div class='col-md-6'>
			                                    <div class='row'>
												<label>RegNo :</label>
												<p> {$row['EmpNo']}</p>
												</div>
			                                    <div class='row'>
												<label>Full Name :</label>
												<p> {$row['FName']} {$row['LName']}</p>
												</div>
												<div class='row'>
												<label>Gender :</label>
												<p> {$row['Gender']}</p>
												</div>
												<div class='row'>
												<label>Address :</label>
												<p> {$row['Address']}</p>
												</div>
												<div class='row'>
												<label>Age :</label>
												<p> {$Age}</p>
												</div>
												<div class='row'>
												<label>Phone :</label>
												<p> {$row['Phone']}</p>
												</div>
												<div class='row'>
												<label>Email :</label>
												<p> {$row['Email']}</p>
												</div>

											</div>
											<div class='col-md-6'>
			                                    <div class='row'>
												<label>EducationLevel :</label>
												<p> {$row['EduLevel']}</p>
												</div>
												<div class='row'>
												<label>EducationTitle :</label>
												<p> {$row['EduTitle']}</p>
												</div>
												<div class='row'>
												<label>Year :</label>
												<p> {$row['EduYear']}</p>
												</div>
												<div class='row'>
												<label>Category :</label>
												<p> {$row['EduCategory']}</p>
												</div>
												<div class='row'>
												<label>Teaching Subject :</label>
												<p> {$row['SubjectName']}</p>
												</div>
											</div>
										</div>

									</div>
		                            </div>
		                                    <div class='border-top'>
			                                    <div class='card-body'>
			                                        <button type='reset' data-dismiss='modal' class='btn btn-primary'>Cancel</button>
			                                    </div>
                               				</div>
		                            </div>
		                            </div>
		                        </div>
		                    </div>

		                    <!-- Modal Assing Subject To Teacher-->

			                <div class='modal fade in' id='ModalAssignSubject".$row['TchID']."'>
				                <div class='modal-dialog'>
				                <div class='card'>
			                      <div class='modal-content'>
			                      <form class='form-horizontal' action='ViewTeacher.php' method='post'>
			                        <div class='card-body'>
	                                <h4 class='card-title'>Assign Subject To <i style='color:#499dff'>{$row['FName']} {$row['LName']}</i></h4> 
			                           <div class='form-group'>
		                                        <div class='form-line'>
		                                            <input class='form-control' name='TchID' value='".$row['TchID']."' type='hidden' required=''>
		                                            <label for='School' text-right control-label col-form-label'>Choose Subject :</label>
		                                            <select class='select2 form-control custom-select' name='SubjectID' style='width: 100%; height:36px;'>";
													$call = new STMSchool();
			                                    	$call->SubjectSeclection();
				                           echo" </select>
				                           </div>
		                                  </div>
			                          </div>
			                        	<div class='border-top'>
		                                    <div class='card-body'>
		                                        <button type='submit' name='AssignSubject' class='btn btn-success'>Assign</button>
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

	function AssignSubjectToTeacher(){
		global $conn;
		$SubjectID = $_POST['SubjectID'];
		$TchID = $_POST['TchID'];

		$sql = "UPDATE tbl_Sch_Tch SET SubjectID='$SubjectID' WHERE TchID = '$TchID'";;
		$result = $conn->query($sql);
		if ($result == true) {
			$_SESSION['Assigned'] = "done";
		}else{
			echo "<script>alert('Subject NOT Assigned')</script>";
		}
	}

	function ViewCommingSchoolTeacher(){
		global $conn;
		$SchlID =  $_SESSION['SchlID'];
		$sql = "SELECT * FROM tbl_School INNER JOIN ((tbl_Sch_Tch inner join tbl_Teacher using(TchID)) inner join tbl_Tch_Education using(TchID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID AND tbl_Sch_Tch.Status = 'Null'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$Age = date('Y') - date('Y', strtotime($row['Dob']));
				echo"
					<tr>
						<td>{$row['EmpNo']}</td>
						<td>{$row['FName']} {$row['LName']}</td>
						<td>{$row['Gender']}</td>
						<td>{$row['Address']}</td>
						<td>{$Age}</td>
						<td>{$row['Phone']}</td>
						<td>{$row['Email']}</td>
						<td>
                            <a data-toggle='modal' data-target='#ModalViewMore".$row['TchID']."' data-toggle='tooltip' data-placement='top' title='View More'>
                                <i class='fas fa-eye'></i></a>
                                <a data-toggle='modal' data-target='#ModalApproveTeacherToSchool".$row['TchID']."' data-toggle='tooltip' data-placement='top' title='Approve Teacher to School'>
                                <i class='fas fa-angle-double-down'></i></a>
						</td>
					</tr>";
					echo " <!-- Modal ViewMore-->
			                <div class='modal fade' id='ModalViewMore".$row['TchID']."' tabindex='-1'>
		                        <div class='modal-dialog'>
		                        	<div class='card'>
		                            <div class='modal-content'>
		                            <div class='modal-body' 
		                            <div class='card-body row'>
		                                	<h3 class='card-title'>Information of Teacher <i style='color:#499dff'>{$row['FName']} {$row['LName']}</i></h3>
										<div class='row'>
			                                <div class='col-md-6'>
			                                    <div class='row'>
												<label>RegNo :</label>
												<p> {$row['EmpNo']}</p>
												</div>
			                                    <div class='row'>
												<label>Full Name :</label>
												<p> {$row['FName']} {$row['LName']}</p>
												</div>
												<div class='row'>
												<label>Gender :</label>
												<p> {$row['Gender']}</p>
												</div>
												<div class='row'>
												<label>Address :</label>
												<p> {$row['Address']}</p>
												</div>
												<div class='row'>
												<label>Age :</label>
												<p> {$Age}</p>
												</div>
												<div class='row'>
												<label>Phone :</label>
												<p> {$row['Phone']}</p>
												</div>
												<div class='row'>
												<label>Email :</label>
												<p> {$row['Email']}</p>
												</div>

											</div>
											<div class='col-md-6'>
			                                    <div class='row'>
												<label>EducationLevel :</label>
												<p> {$row['EduLevel']}</p>
												</div>
												<div class='row'>
												<label>EducationTitle :</label>
												<p> {$row['EduTitle']}</p>
												</div>
												<div class='row'>
												<label>Year :</label>
												<p> {$row['EduYear']}</p>
												</div>
												<div class='row'>
												<label>Category :</label>
												<p> {$row['EduCategory']}</p>
												</div>
											</div>
										</div>

									</div>
		                            </div>
		                                    <div class='border-top'>
			                                    <div class='card-body'>
			                                        <button type='reset' data-dismiss='modal' class='btn btn-primary'>Cancel</button>
			                                    </div>
                               				</div>
		                            </div>
		                            </div>
		                        </div>
		                    </div>

		                    <!-- Modal Approve Teacher To School-->

			                <div class='modal fade in' id='ModalApproveTeacherToSchool".$row['TchID']."'>
				                <div class='modal-dialog'>
				                <div class='card'>
			                      <div class='modal-content'>
			                      <form class='form-horizontal' action='ViewComingTeacher.php' method='post'>
			                        <div class='card-body'>
	                                <h4 class='card-title'>Approve <i style='color:#499dff'>{$row['FName']} {$row['LName']}</i> To School</h4>
		                                <div class='form-group'>
	                                        <div class='form-line'>
	                                            <input class='form-control' name='TchID' value='".$row['TchID']."' type='hidden' required=''>
	                                            <label for='ReportDate' text-right control-label col-form-label'>Report Date :</label>
	                                            <input type='date' class='form-control' name='ReportDate' value='".$row['ReportDate']."' readonly required'>
				                           </div>
		                                </div>
		                                <div class='form-group'>
	                                        <div class='form-line'>
	                                            <label for='ReportDate' text-right control-label col-form-label'>Comments :</label>
	                                            <textarea class='form-control' name='Comment'></textarea>
				                           </div>
		                                </div>
			                          </div>
			                        	<div class='border-top'>
		                                    <div class='card-body'>
		                                        <button type='submit' name='ApproveTeacher' class='btn btn-success'>Approve</button>
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

	function AddSubjectToSchool(){
		global $conn;
		$SubjectID = $_POST['SubjectID'];
		$SchlID = $_POST['SchlID'];
		$SchlTchID = 1;
		
		$sql = "INSERT INTO tbl_Sch_Subj VALUES('','$SchlID','$SubjectID','0')";
		$result = $conn->query($sql) or die(mysqli_error($conn));
		if ($result == true) {
			$_SESSION['Success'] = "done";
		}else{
			echo "<script>alert('Data NOT Saved')</script>";
		}
	}

	function ApproveTeacherToSchool(){
		global $conn;
		$TchID = $_POST['TchID'];
		$Comment = $_POST['Comment'];

		$sql = "UPDATE tbl_Sch_Tch SET Status='Approved',Coment='$Comment' WHERE TchID = '$TchID'";
		$result = $conn->query($sql);
		if ($result == true) {
			$_SESSION['Approved'] = "done";
		}else{
			echo "<script>alert('Teacher NOT Assigned')</script>";
		}
	}

	function ViewClass($category = ""){
		global $conn;

		if($category == "Primary"){
			$sql = "SELECT * FROM tbl_Class LIMIT 4,10";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					echo"<li class='sidebar-item'><a href='AddTotalStudentClass.php?ID=".$row['ClassID']."&Nm=".$row['ClassName']."' class='sidebar-link'><i class='mdi mdi-note-outline'></i><span class='hide-menu'>{$row['ClassName']}</span></a></li>";
				}
			}
		}elseif ($category == "Secondary") {
			$sql = "SELECT * FROM tbl_Class LIMIT 4";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					echo"<li class='sidebar-item'><a href='AddTotalStudentClass.php?ID=".$row['ClassID']."&Nm=".$row['ClassName']."' class='sidebar-link'><i class='mdi mdi-note-outline'></i><span class='hide-menu'>{$row['ClassName']}</span></a></li>";
				}
			}
		}
		
	}

	function AddTotalStudent(){
		global $conn;
		$TotalStu = $_POST['TotalStu'];
		$ClassID = $_POST['ClassID'];
		$SchlID = $_POST['SchlID'];
		$YearNow = date('Y');

		//Select School Academic Year
		$sql = "SELECT * FROM tbl_School INNER JOIN tbl_Sch_Year USING(SchlID) WHERE tbl_School.SchlID = '$SchlID' AND tbl_Sch_Year.SchYear = '$YearNow'";
		$result = $conn->query($sql) or die(mysqli_error($conn));
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$SchlYearID = $row['SchYrID'];
			$sql = "SELECT * FROM tbl_Sch_Year INNER JOIN tbl_YearClass USING(SchYrID) WHERE tbl_Sch_Year.SchYrID = '$SchlYearID' AND tbl_YearClass.ClassID = '$ClassID'";
			$result = $conn->query($sql) or die(mysqli_error($conn));
			if($result->num_rows > 0){
				$_SESSION['Exist'] = "done";
				header('location:SchoolClasses.php');
			}else{
				//Insert Total Student to Another Class Same Academic Year
				$sql1 = "INSERT INTO tbl_YearClass VALUES('','$TotalStu','$SchlYearID','$ClassID')";
				$result1 = $conn->query($sql1) or die(mysqli_error($conn));
				if ($result1 == true) {
					$_SESSION['Success'] = "done";
					header('location:SchoolClasses.php');

				}else{
					echo "<script>alert('Total Student NOT Saved')</script>";
				}
			}
			
		}else{
			//Insert School Year
			$sql = "INSERT INTO tbl_Sch_Year VALUES('','$YearNow','No Coments','$SchlID')";
			$result = $conn->query($sql) or die(mysqli_error($conn));
			$SchlYearID = $conn->insert_id;

			//Insert Total Student to Class
			$sql1 = "INSERT INTO tbl_YearClass VALUES('','$TotalStu','$SchlYearID','$ClassID')";
			$result1 = $conn->query($sql1) or die(mysqli_error($conn));
			if ($result1 == true) {
				$_SESSION['Success'] = "done";
				header('location:SchoolClasses.php');

			}else{
				echo "<script>alert('Total Student NOT Saved')</script>";
			}
	
		}
	}

	function UpdateTotalStudent(){
		global $conn;
		$YryClassID = $_POST['YryClassID'];
		$ClassID = $_POST['ClassID'];
		$TotalStu = $_POST['TotalStu'];

		$sql = "UPDATE tbl_YearClass SET TotalStudent='$TotalStu' WHERE YryClassID = '$YryClassID' AND ClassID = '$ClassID'";
		$result = $conn->query($sql);
		if ($result == true) {
			$_SESSION['Updated'] = "done";
		}else{
			echo "<script>alert('Total Student NOT Updated')</script>";
		}
	}

	function ViewSchoolClasses(){
		global $conn;
		$SchlID =  $_SESSION['SchlID'];
		$YearNow = date('Y');
		$sql = "SELECT * FROM tbl_School INNER JOIN ((tbl_Sch_Year inner join tbl_YearClass using(SchYrID)) inner join tbl_Class using(ClassID))USING(SchlID) WHERE tbl_School.SchlID = $SchlID";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo"
					<tr>
						<td>{$row['SchYear']}</td>
						<td>{$row['ClassName']}</td>
						<td>{$row['TotalStudent']}</td>
						<td>
                            <a data-toggle='modal' data-target='#ModalEditTotalStudent".$row['ClassID']."' data-toggle='tooltip' data-placement='top' title='Edit'>
                                         <i class='far fa-edit'></i></a>
						</td>
					</tr>";
					echo "<!-- Modal Edit Total Student to Class-->

		                <div class='modal fade in' id='ModalEditTotalStudent".$row['ClassID']."'>
			                <div class='modal-dialog'>
			                <div class='card'>
		                      <div class='modal-content'>
		                      <form class='form-horizontal' action='SchoolClasses.php' method='post'>
		                        <div class='card-body'>
                                <h4 class='card-title'>Update Total Student To <i style='color:#499dff'>{$row['ClassName']}</i> Class</h4>
	                                <div class='form-group'>
                                        <div class='form-line'>
                                            <input class='form-control' name='ClassID' value='".$row['ClassID']."' type='hidden' required=''>
                                            <input class='form-control' name='YryClassID' value='".$row['YryClassID']."' type='hidden' required=''>
                                            <input class='form-control' name='SchlID' value='".$_SESSION['SchlID']."' type='hidden' required=''>
			                           </div>
	                                </div>
	                                <div class='form-group'>
                                        <div class='form-line'>
                                        <label for='TotalStu' text-right control-label col-form-label'>Total Students :</label>
                                        	<input class='form-control' name='TotalStu' value='".$row['TotalStudent']."' type='number' required=''>
			                           </div>
	                                </div>
		                          </div>
		                        	<div class='border-top'>
	                                    <div class='card-body'>
	                                        <button type='submit' name='UpdateTotalStu' class='btn btn-success'>Update</button>
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

}

?>