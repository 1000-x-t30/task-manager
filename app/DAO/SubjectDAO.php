<?php

namespace App\DAO;

use PDO;
use App\Entity\Subject;


class SubjectDAO {

	private PDO $db;


	public function __construct(PDO $db) {
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->db = $db;
	}

	// public function findByPK(int $id): ?Subject {
	// 	$sql = "SELECT * FROM subjects WHERE id = :id";
	// 	$stmt = $this->db->prepare($sql);
	// 	$stmt->bindValue(":id", $id, PDO::PARAM_INT);
	// 	$result = $stmt->execute();
	// 	$dept = null;
	// 	if($result && $row = $stmt->fetch()) {
	// 		$idDb = $row["id"];
	// 		$dpNo = $row["dp_no"];
	// 		$dpName = $row["dp_name"];
	// 		$dpLoc = $row["dp_loc"];
			
	// 		$dept = new Subject();
	// 		$dept->setId($idDb);
	// 		$dept->setDpNo($dpNo);
	// 		$dept->setDpName($dpName);
	// 		$dept->setDpLoc($dpLoc);
	// 	}
	// 	return$dept;
	// }

	public function findByMark(string $mark): ?Subject {
		$sql = "SELECT * FROM subjects WHERE mark = :mark";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mark", $mark, PDO::PARAM_STR);
		$result = $stmt->execute();
		$subject = null;
		if($result && $row = $stmt->fetch()) {
			$mark = $row["mark"];
			$name = $row["name"];

			$subject = new Subject();
			$subject->setMark($mark);
			$subject->setName($name);
		}
		return $subject;
	}

	public function findAll(): array {
		$sql = "SELECT * FROM subjects ORDER BY mark";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute();
		$subjectList = [];
		while($row = $stmt->fetch()) {
			$mark = $row["mark"];
			$name = $row["name"];

			$subject = new Subject();
			$subject->setMark($mark);
			$subject->setName($name);
			$subjectList[$mark] = $subject;
		}
		return $subjectList;
	}

	public function insert(Subject $subject): int | string {
		$sql = "INSERT INTO subjects (mark, name) VALUES (:mark, :name)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mark", $subject->getMark(), PDO::PARAM_STR);
		$stmt->bindValue(":name", $subject->getName(), PDO::PARAM_STR);
		$result = $stmt->execute();
		if($result) {
			$mark = $subject->getMark();
		}
		else {
			$mark = -1;
		}
		return $mark;
	}

	public function update(Subject $subject): bool {
		$sql = "UPDATE subjects SET name = :name WHERE mark = :mark";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mark", $subject->getMark(), PDO::PARAM_STR);
		$stmt->bindValue(":name", $subject->getName(), PDO::PARAM_STR);
		$result = $stmt->execute();
		return $result;
	}

	public function delete(string $mark): bool {
		$sql = "DELETE FROM subjects WHERE mark = :mark";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":mark", $mark, PDO::PARAM_STR);
		$result = $stmt->execute();
		return $result;
	}


	// public function findDept(): array {
  //       $sql = "SELECT id, dp_no, dp_name FROM depts ORDER BY dp_no";
  //       $stmt = $this->db->prepare($sql);
  //       $result = $stmt->execute();
  //       $dpList = [];
  //       while($row = $stmt->fetch()) {
  //           $id = $row["id"];
  //           $dpNo = $row["dp_no"];
  //           $dpName = $row["dp_name"];

  //           $dept = new Dept();
  //           $dept->setId($id);
  //           $dept->setDpNo($dpNo);
  //           $dept->setDpName($dpName);
  //           $dpList[$dpNo] = $dept;
  //       }
  //       return $dpList;
  //   }


  //   public function findAllByDp(): array {
  //       $sql = "SELECT id, dp_no, dp_name FROM depts ORDER BY dp_no ASC";
  //       $stmt = $this->db->prepare($sql);
  //       $result = $stmt->execute();
  //       $dpList = [];
  //       while($result && $row = $stmt->fetch()) {
  //           $id = $row["id"];
  //           $dpNo = $row["dp_no"];
  //           $dpName = $row["dp_name"];
            
  //           $dept = new Dept();
  //           $dept->setId($id);
  //           $dept->setDpNo($dpNo);
  //           $dept->setDpName($dpName);
  //           $dpList[] = $dept;
  //       }
  //       return $dpList;
  //   }
}