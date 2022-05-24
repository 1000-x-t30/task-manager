<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;
use PDO;
use Carbon\Carbon;
// use App\DAO\TaskDAO;
use App\Entity\Task;


class TaskDAO {

    private $db;

    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    public function findByPK(int $taskId): ?Task {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $taskId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $task = null;
        if($result && $row = $stmt->fetch()) {
            $id = $row["id"];
            $mark = $row["mark"];
            $taskNo = $row["task_no"];
            $name = $row["name"];
            $description = $row["description"];
            $limit = date('Y-m-d', strtotime($row["limit"]));
            $createdAt = $row["created_at"];
            $updatedAt = $row["created_at"];
            
            $task = new Task();
            $task->setId($id);
            $task->setMark($mark);
            $task->setName($name);
            $task->setTaskNo($taskNo);
            $task->setDescription($description);
            $task->setLimit($limit);
            $task->setCreatedAt($createdAt);
            $task->setUpdatedAt($updatedAt);
        }
        return $task;
    }

    public function findByTaskNo(string $mark, int $taskNo): ?Task {
        $sql = "SELECT * FROM tasks WHERE mark = :mark AND task_no = :task_no";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":mark", $mark, PDO::PARAM_STR);
        $stmt->bindValue(":task_no", $taskNo, PDO::PARAM_INT);
        $result = $stmt->execute();
        $task = null;
        if($result && $row = $stmt->fetch()) {
            $id = $row["id"];
            $mark = $row["mark"];
            $taskNo = $row["task_no"];
            $name = $row["name"];
            $description = $row["description"];
            $limit = $row["limit"];
            $createdAt = $row["created_at"];
            $updatedAt = $row["created_at"];
            
            $task = new Task();
            $task->setId($id);
            $task->setMark($mark);
            $task->setName($name);
            $task->setTaskNo($taskNo);
            $task->setDescription($description);
            $task->setLimit($limit);
            $task->setCreatedAt($createdAt);
            $task->setUpdatedAt($updatedAt);
        }
        return $task;
    }

    public function findAll(): array {
        $sql = "SELECT * FROM tasks ORDER BY mark, task_no ASC";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $taskList = [];
        while($row = $stmt->fetch()) {
            $id = $row["id"];
            $mark = $row["mark"];
            $name = $row["name"];
            $taskNo = $row["task_no"];
            $description = $row["description"];
            $limit = date('Y-m-d', strtotime($row["limit"]));
            $createdAt = $row["created_at"];
            $updatedAt = $row["updated_at"];
            
            $task = new Task();
            $task->setId($id);
            $task->setMark($mark);
            $task->setName($name);
            $task->setTaskNo($taskNo);
            $task->setdescription($description);
            $task->setLimit($limit);
            $task->setCreatedAt($createdAt);
            $task->setUpdatedAt($updatedAt);
            $taskList[$id] = $task;
        }
        return $taskList;
    }

    public function insert(Task $task): array | bool {
      $assign = false;
      $sql = "INSERT INTO tasks( mark, name, task_no, description, `limit`) VALUES( :mark, :name, :task_no, :description, :limit)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(":mark", $task->getMark(), PDO::PARAM_STR);
      $stmt->bindValue(":name", $task->getName(), PDO::PARAM_STR);
      $stmt->bindValue(":task_no", $task->getTaskNo(), PDO::PARAM_INT);
      $stmt->bindValue(":description", $task->getDescription(), PDO::PARAM_STR);
      $stmt->bindValue(":limit", $task->getLimit(), PDO::PARAM_STR);
      $result = $stmt->execute();
      if($result) {
          $assign = [
            'mark' => $task->getMark(),
            'taskNo' => $task->getTaskNo()
          ];
      }
      return  $assign;
  }

    public function update(Task $task): bool {
        $sql = "UPDATE tasks SET mark = :mark, name = :name, task_no = :task_no, description = :description, `limit` = :limit WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":mark", $task->getMark(), PDO::PARAM_STR);
        $stmt->bindValue(":name", $task->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":task_no", $task->getTaskNo(), PDO::PARAM_INT);
        $stmt->bindValue(":description", $task->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(":limit", $task->getLimit(), PDO::PARAM_STR);
        $stmt->bindValue(":id", $task->getId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}