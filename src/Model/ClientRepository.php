<?php

namespace App\Model;

use PDO;

class ClientRepository extends AbstractRepository
{

    public static function clientFromRow($row)
    {
        $client = new Client();
        $client
            ->setId($row['id'])
            ->setUserId($row['userId'])
            ->setClientName($row['clientName']);
        return $client;
    }

    public function save($client)
    {
        if ($client->getId()) {
            $sql = "UPDATE Client SET userId = :userId, clientName = :clientName WHERE id = :id";
            $params = [
                'id' => $client->getId(),
                'userId' => $client->getUserId(),
                'clientName' => $client->getClientName()
            ];
        } else {
            $sql = "INSERT INTO Client(userId, clientName) VALUES (:userId, :clientName)";
            $params = [
                'userId' => $client->getUserId(),
                'clientName' => $client->getClientName()
            ];
        }
        $this->openDatabaseConnection();
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        if (!$client->getId()) {
            $client->setId($this->connection->lastInsertId());
        }
        $this->closeDatabaseConnection();
        return $client;
    }

    public function findById($id)
    {
        $this->openDatabaseConnection();
        $sql = "SELECT * FROM Client WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $client = $this->clientFromRow($row);

        $this->closeDatabaseConnection();
        return $client;
    }

    public function findByUserId($userId)
    {
        $this->openDatabaseConnection();
        $sql = "SELECT * FROM Client WHERE userId = :userId";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('userId' => $userId));
        $clients = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = $this->clientFromRow($row);
        }

        $this->closeDatabaseConnection();
        return $clients;
    }
}