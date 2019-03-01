<?php
if(isset($_POST)){
	include('todoconnect.php');
	$response = "";
	$key = $_POST['key'];
	
	//To remove the task data
	if($_POST['key'] == 'remove'){
		$id = $_POST['id'];
		$sql = "UPDATE `todo_lists` SET `is_visible` = '1' WHERE `todo_lists`.`id` = $id";
		$response = $con->query($sql);
	}
	
	//To insert the task data
	if($_POST['key'] == 'insert'){
		$taskname =  $_POST['inputVal'];
		$sql = "INSERT INTO todo_lists (name)VALUES ('$taskname')";
		$response = $con->query($sql);
	}
	
	//To updated the checked data
	if($_POST['key'] == 'checked'){
		$id = $_POST['id'];
		$sql = "UPDATE `todo_lists` SET `status` = '1' WHERE `todo_lists`.`id` = $id";
		$response = $con->query($sql);
	}
	
	//To show the checked data
	if ($response === TRUE || $_POST['key']=='show') {
		
		$sql = "SELECT id, name, status ,is_visible  FROM todo_lists order by id desc";
		
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			$records = "";
			$total_count = 0;
			$records .= "<ul id='sortable' class='list-unstyled'>";
			while($row = $result->fetch_assoc()) {
				
				if($row['is_visible'] == '0') {
					$id = $row['id'];
					$name = $row['name'];					
					$records .= "<li class='ui-state-default'> <div class='checkbox'>";
					if($row['status'] == "1"){
						$records .= "<span class='glyphicon glyphicon-ok'></span><label style='text-decoration: line-through;text-decoration-color: #f50707;'>".$name."</label>";
					}else{
						$records .= "<label><input type='checkbox' class='checkbox_todo' value='".$id."' />".$name."</label>";
					}
					$records .= "<button id='remove_todo' name='".$id."' class='remove-item btn btn-default btn-xs pull-right'><span class='glyphicon glyphicon-remove'></span></button></div></li>";
					if($row['is_visible'] == '0' && $row['status'] == '0') { $total_count += 1;	}
				} else {
					if($row['is_visible'] == '0' && $row['status'] == '0') { $total_count += 1;	}			
				}				
			}
			$records .= "</ul>";
			echo $records."~~".$total_count;
		} else {
			echo ""."~~"."0";
		}
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
	$con->close();
}
?>