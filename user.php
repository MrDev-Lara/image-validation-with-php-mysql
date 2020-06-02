<?php
	include "database.php";
?>

<?php
	class user{
		private $db;
		private $image;
		
		public function __construct(){
			$this->db = new database();
		}
		public function setFile($upload_img){
			$this->image = $upload_img;
		}
		public function insert(){
			$sql = "insert into image(image) values(:image)";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':image',$this->image);
			$result = $stmt->execute();
			if($result){
				echo "uploaded successfully";
			}else{
				echo "failed to upload";
			}
		}
		
		public function select(){
			$sql = "select * from image where image= :image";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':image',$this->image);
		    $stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		
		public function selectall(){
			$sql = "select * from image";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}
		public function deletedatabyid($id){
			$sql = "delete from image where id= :id";
			$stmt = $this->db->PDO->prepare($sql);
			$stmt->bindParam(':id',$id);
			$result = $stmt->execute();
			return $result;
		}
	}
?>