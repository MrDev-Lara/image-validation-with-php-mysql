<?php
	include "user.php";
	$user = new user();
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$permit = array('jpg','jpeg','png');
			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_tmp = $_FILES['image']['tmp_name'];
			$explode = explode('.',$file_name);
			$lowercase = strtolower(end($explode));
			$uniqe_img = substr(md5(time()),0,10).'.'.$lowercase;
			$upload_img = "image/".$uniqe_img;
			
			if(empty($file_name)){
				echo "file cannot be empty";
			}
			elseif($file_size>1000000){
				echo "file size cannot be greater than 1kb";
			}
			elseif(in_array($lowercase,$permit) === false){
				echo "only ".implode(', ',$permit). " are supported";
			}
			else{
			$user->setFile($upload_img);
			move_uploaded_file($file_tmp,$upload_img);
			$result = $user->insert();
			if($result){
				return $result;
			    }
			}
		}
	?>
	
	<?php
		if(isset($_GET['action']) && $_GET['action']=='delete'){
			$id = $_GET['id'];
			$result = $user->deletedatabyid($id);
			if($result){
				echo "data deleted successfully";
			}
		}
	?>
	<h2>Uploading image file and handling it with PHP by moni uddin</h2>
	
	
	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="image"/>
		<input type="submit" name="submit" value="upload"/>
	</form>
	<?php
		$result = $user->select();
		if($result){
	?>
	<img src="<?php echo $result->image; ?>" alt="" height="100px" width="200px"/>
		<?php } ?>
		
		<table style="margin-top:30px;">
			<thead>
				<tr>
					<th style="padding:40px;">ID</th>
					<th style="padding:40px;">IMAGE</th>
					<th style="padding:40px;">ACTION</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					$result = $user->selectall();
					foreach($result as $key=>$value){
						$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><img src="<?php echo $value['image'] ?>" alt="" height="40px" width="40px"/></td>
					<td><?php echo "<a href='index.php?action=delete&id=".$value['id']."' onClick='return confirm(\"Are you sure you want to delete?\")'>DELETE</a>"; ?></td>
				</tr>
				
				<?php } ?>
			</tbody>
		</table>
</body>
</html>