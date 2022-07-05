<?php require_once('header.php');
 
// Get Current Class Status
$current_class_status = Student('current_class',$_SESSION['st_loggedin'][0]['id']);
if($current_class_status != null){
	$current_date = date('Y-m-d'); 
	$stm=$pdo->prepare("SELECT * FROM class WHERE start_date <= ? AND end_date >= ? AND id=?");
	$stm->execute(array($current_date,$current_date,$current_class_status));
	$classCount = $stm->rowCount();  
	
}
else{
	$classCount = 0;
}



?>
<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Class Routine</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Class Routine</li>
			</ul>
		</div>	
		<div class="row">
			
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					 
					<div class="wc-title">
						<h4>Class Routine</h4>
					</div>
					<?php if($classCount == 1) :?>
					<?php
						$stm=$pdo->prepare("SELECT class.class_name,subjects.name as subject_name,subjects.code as subject_code,teachers.name as teacher_name,class_routine.time_from,class_routine.time_to,class_routine.day,class_routine.room_no
						FROM class_routine
						INNER JOIN class ON class_routine.class_name=class.id
						INNER JOIN subjects ON class_routine.subject_id=subjects.id
						INNER JOIN teachers ON class_routine.teacher_id=teachers.id
						WHERE class_routine.class_name=?");
						$stm->execute(array($current_class_status));
						$routineList = $stm->fetchAll(PDO::FETCH_ASSOC);
						 
					?>
					<div class="widget-inner">
						<div class="edit-profile m-b30">
							<div class="table-responsive"> 
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Class Name</th>
											<th>Subject Name</th>
											<th>Teacher Name</th>
											<th>Day</th>
											<th>Start Time</th>
											<th>End Time</th>
											<th>Room No</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i=1;
										foreach($routineList as $list) :
										?>
										<tr>
											<td><?php echo $i;$i++;?></td>
											<td><?php echo $list['class_name'];?></td>
											<td><?php echo $list['subject_name'];?></td>
											<td><?php echo $list['teacher_name'];?></td>
											<td><?php echo $list['day'];?></td>
											<td><?php echo $list['time_from'];?></td>
											<td><?php echo $list['time_to'];?></td>
											<td><?php echo $list['room_no'];?></td>
										</tr>
										<?php endforeach;?>
									</tbody>
									 
								</table>
							</div>
						</div>
					</div>
					
					<?php else:?>
					<div class="alert alert-danger">
						Please First Register a Class then you will get the Class Routine.
					</div>
					<?php endif;?>
				</div>
			</div>
			
		</div>
	</div>
</main>
<?php require_once('footer.php');?>