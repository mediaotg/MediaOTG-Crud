<?php
class Project{
	// connect
	private $conn;
	private $table_name = "projects";

	// object properties
	public $id;
	public $name;
	public $content;
	public $thumbnail;
	public $logo;
	public $gallery;
	public $create;

	// constructor
	public function __construct($db){
		$this->conn = $db;
	}

	function delete(){
		$query = "DELETE FROM ".$this->table_name." WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$this->id=htmlspecialchars(strip_tags($this->id));
		$stmt->bindParam(1, $this->id);

		if($stmt->execute()){
			return true;
		} return false;
	}

	function update(){
		$query = "UPDATE ".$this->table_name." SET name = :name, content = :content, thumbnail = :thumbnail, logo = :logo, gallery = :gallery WHERE id = :id";
		$stmt = $this->conn->prepare($query);

		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->content=$this->content;
		$this->thumbnail=htmlspecialchars(strip_tags($this->thumbnail));
		$this->logo=htmlspecialchars(strip_tags($this->logo));
		$this->gallery=htmlspecialchars(strip_tags($this->gallery));
		$this->id=htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':content', $this->content);
		$stmt->bindParam(':thumbnail', $this->thumbnail);
		$stmt->bindParam(':logo', $this->logo);
		$stmt->bindParam(':gallery', $this->gallery);
		$stmt->bindParam(':id', $this->id);

		if($stmt->execute()){
			return true;
		} else {
			return false;
		}
	}

	function readOne(){
		$query = "SELECT name, content, thumbnail, logo, gallery FROM ".$this->table_name." WHERE id = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->name = $row['name'];
		$this->content = $row['content'];
		$this->thumbnail = $row['thumbnail'];
		$this->logo = $row['logo'];
		$this->gallery = $row['gallery'];
	}

	function create(){
		// insert record
		$query = "INSERT INTO ".$this->table_name." SET name=:name, content=:content, thumbnail=:thumbnail, logo=:logo, gallery=:gallery, created=:created";
		$stmt = $this->conn->prepare($query);

		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->content=$this->content;
		$this->thumbnail=htmlspecialchars(strip_tags($this->thumbnail));
		$this->logo=htmlspecialchars(strip_tags($this->logo));
		$this->gallery=htmlspecialchars(strip_tags($this->gallery));

		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":content", $this->content);
		$stmt->bindParam(":thumbnail", $this->thumbnail);
		$stmt->bindParam(":logo", $this->logo);
		$stmt->bindParam(":gallery", $this->gallery);
		$stmt->bindParam(":created", $this->created);

		if($stmt->execute()){
			return true;
		} else {
			echo "<pre>";
			print_r($stmt->errorInfo());
			echo "</pre>";

			return false;
		}
	}

	function readAll(){
		$query = "SELECT id, name, content, thumbnail, logo, gallery, created FROM ".$this->table_name." ORDER BY id DESC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

}
?>