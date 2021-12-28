<?php
namespace App\Model;
use PDO;

class TaskRepository extends AbstractRepository {

    protected function taskFromRow($row) {
        $task = new Task();
        $task
            ->setId($row['id'])
            ->setUserId($row['userId'])
            ->setProjectId($row['projectId'])
            ->setTitle($row['title'])
            ->setStartTime($row['startTime'])
            ->setStopTime($row['stopTime']);
        return $task;
    }

    public function save($task) {
        if ($task->getId()) {
            $sql = "UPDATE Task SET userId = :userId, projectId = :projectId, title = :title, startTime = :startTime, stopTime = :stopTime WHERE id = :id";
            $params = [
                'id' => $task->getId(),
                'userId' => $task->getUserId(),
                'projectId' => $task->getProjectId(),
                'title' => $task->getTitle(),
                'startTime' => $task->getStartTime(),
                'stopTime' => $task->getStopTime()
            ];
        }
        else {
            $sql = "INSERT INTO Task(userId, projectId, title, startTime, stopTime) VALUES (:userId, :projectId, :title, :startTime, :stopTime)";
            $params = [
                'userId' => $task->getUserId(),
                'projectId' => $task->getProjectId(),
                'title' => $task->getTitle(),
                'startTime' => $task->getStartTime(),
                'stopTime' => $task->getStopTime()
            ];
        }
        $this->openDatabaseConnection();
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        if (! $task->getId()) {
            $task->setId($this->connection->lastInsertId());
        }
        $this->closeDatabaseConnection();
        return $task;
    }

    public function findById($id) {
        $this->openDatabaseConnection();
        $sql = "SELECT * FROM Task WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        $task = $this->taskFromRow($row);

        $this->closeDatabaseConnection();
        return $task;
    }

    public function findByUserId($userId)
    {
        $this->openDatabaseConnection();
        $sql = "SELECT * FROM Task WHERE userId = :userId";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('userId' => $userId));
        $tasks = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $tasks[] = $this->taskFromRow($row);
        }

        $this->closeDatabaseConnection();
        return $tasks;
    }

    public function getProjectNameById($id) {
        $this->openDatabaseConnection();
        $sql = "SELECT projectName FROM Task JOIN Project ON Task.projectId = Project.id WHERE Task.id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        $this->closeDatabaseConnection();
        return $row['projectName'];
    }

    public function getClientNameById($id) {
        $this->openDatabaseConnection();
        $sql = "SELECT clientName FROM Task JOIN Project ON Task.projectId = Project.id JOIN Client ON Project.clientId = Client.id WHERE Task.id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        $this->closeDatabaseConnection();
        return $row['clientName'];
    }

    public function getWageById($id) {
        $this->openDatabaseConnection();
        $sql = "SELECT wage FROM Task JOIN Project ON Task.projectId = Project.id WHERE Task.id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        $this->closeDatabaseConnection();
        return $row['wage'];
    }

    public function getNumberOfTasks() {
        $this->openDatabaseConnection();
        $sql = "SELECT COUNT(*) AS number FROM Task";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->closeDatabaseConnection();
        return $row['number'];
    }

    public function getTotalTasksTime() {
        $this->openDatabaseConnection();
        $sql = "SELECT SUM(TIMESTAMPDIFF(SECOND, startTime, stopTime)) AS time FROM Task WHERE stopTime IS NOT NULL";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->closeDatabaseConnection();
        return $row['time'];
    }
}