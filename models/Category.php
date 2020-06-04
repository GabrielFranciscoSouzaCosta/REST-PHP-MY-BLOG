<?php

	class Category
	{

		private $conn;
		private $table = 'categories';

		public $id;
		public $name;
		public $createdAt;

		public function __construct($db)
		{
			$this->conn = $db;
		}

		public function read()
		{
			$query = 'SELECT `id`, `name`, `created_at` FROM ' . $this->table . ' ORDER BY created_at DESC';

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

		public function read_single()
		{
			$query = "
				SELECT
					categories.name,
					categories.created_at
				FROM
					" . $this->table . "
				WHERE
					categories.id = ?
				LIMIT 0,1
			";

			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $this->id);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->name = $row['name'];
			$this->createdAt = $row['created_at'];
		}

		public function create()
		{
			$sql = "
				INSERT INTO
					" . $this->table . "
				SET
					name = :name
			";
			$stmt = $this->conn->prepare($sql);
			$this->name = htmlspecialchars(strip_tags($this->name));

			$stmt->bindParam(':name', $this->name);

			if($stmt->execute())
			{
				return true;
			}

			printf("Error: %s. \n", $stmt->error);
			return false;
		}

		public function update()
		{
			$query = '
				UPDATE
					' . $this->table . '
				SET
					name = :name
				WHERE
					id = :id
			';
			$stmt = $this->conn->prepare($query);
			$this->name = htmlspecialchars(strip_tags($this->name));

			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute())
			{
				return true;
			}

			printf("Error: %s. \n", $stmt->error);
			return false;
		}

		public function delete()
		{
			$query = "DELETE FROM " . $this->table . " WHERE id = :id";
			$stmt = $this->conn->prepare($query);
			$this->id = htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(':id', $this->id);
			
			if($stmt->execute())
			{
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;
		}

	}
