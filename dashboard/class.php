<?php require_once('header.php');

if(isset($_POST['create_btn'])){
	$class_id = $_POST['class_id'];
	$student_id = $_SESSION['st_loggedin'][0]['id'];
	// New Class Registration
	$insert = $pdo->prepare("INSERT INTO new_class_registration(student_id,register_class) VALUES(?,?)");
	$insert->execute(array($student_id,$class_id));
	// Update Student Class
	$update = $pdo->prepare("UPDATE students SET current_class=? WHERE id=?");
	$update->execute(array($class_id,$student_id));


	$success = "Class Registration Success!";
}
// Get Current Class Status
$current_class_status = Student('current_class',$_SESSION['st_loggedin'][0]['id']);
if($current_class_status != null){
	$current_date = date('Y-m-d'); 
	$stm=$pdo->prepare("SELECT * FROM class WHERE start_date <= ? AND end_date >= ? AND id=?");
	$stm->execute(array($current_date,$current_date,$current_class_status));
	$classCount = $stm->rowCount();  
	$classDetails = $stm->fetchAll(PDO::FETCH_ASSOC);
}
else{
	$classCount = 0;
}



?>
<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Class</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Class</li>
			</ul>
		</div>	
		<div class="row">
			
			<div class="col-lg-6 m-b30">
				<div class="widget-box">
					<?php if($classCount != 1) :?>
					<!-- New Class Registration	 -->
					<div class="wc-title">
						<h4>New Class Registration</h4>
					</div>
					<?php if(isset($success)) : ?>
					<div class="alert alert-success"><?php echo $success;?></div>
					<?php endif;?>
					<div class="widget-inner">
						<form class="edit-profile m-b30" method="POST" action="">
							<div class="row"> 
								<div class="form-group col-12">
									<label class="col-form-label" for="class_id">Select Class</label>
									<div>
										<?php 
											$current_date = date('Y-m-d'); 
											$stm=$pdo->prepare("SELECT * FROM class WHERE start_date <= ? AND end_date >= ?");
											$stm->execute(array($current_date,$current_date));
											$result = $stm->fetchAll(PDO::FETCH_ASSOC); 

										?>
										<select name="class_id" id="class_id" class="form-control">
											<?php   
											foreach($result as $row) :
											?>
											<option value="<?php echo $row['id'];?>"><?php echo $row['class_name'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								  
								<div class="seperator"></div>
								 
								<div class="col-12"> 
									<button type="submit" name="create_btn" class="btn">Save changes</button>
								</div>
							</div>
						</form>
					</div>
					<!-- New Class Registration	 -->		
					<?php else :?>
					<div class="wc-title">
						<h4>Class Details</h4>
					</div>

					<div class="widget-inner">
						<div class="edit-profile m-b30">
							<div class="table-responsive"> 
								<table class="table">
									<tr>
										<td><b>Class Name:</b></td>
										<td><?php echo $classDetails[0]['class_name'];?></td>
									</tr>
									<tr>
										<td><b>Subjects:</b></td>
										<td><?php
										$subject_list = json_decode($classDetails[0]['subjects']); 
										 foreach($subject_list as $new_subject){
											 echo getSubjectName($new_subject)."<br>";
										 } 
										
										
										?></td>
									</tr>
									<tr>
										<td><b>Start Date:</b></td>
										<td><?php echo $classDetails[0]['start_date'];?></td>
									</tr>
									<tr>
										<td><b>End Date:</b></td>
										<td><?php echo $classDetails[0]['end_date'];?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<?php endif;?>
					
				</div>
			</div>
			
		</div>
	</div>
</main>
<?php require_once('footer.php');?>