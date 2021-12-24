<?php
namespace App\Model;
use PDO;

class UserRepository extends AbstractRepository
{
    /**
     * @param $row
     * @return User
     */
    protected function userFromRow($row) {
        $user = new User();
        $user
            ->setId($row['id'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setPassword($row['password'])
            ->setRole($row['role']);
        return $user;
    }

    /**
     * @param $id
     * @return null|User
     * @throws Exception
     */
    public function findById($id)
    {
        $this->openDatabaseConnection();
        $sql = "SELECT * FROM User WHERE id = :id";
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }
        $user = $this->userFromRow($row);

        $this->closeDatabaseConnection();
        return $user;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function save($user) {
        if ($user->getId()) {
            $sql = "UPDATE User SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";
            $params = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole()
            ];
        }
        else {
            $sql = "INSERT INTO User(username, email, password, role) VALUES (:username, :email, :password, :role)";
            $params = [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role' => $user->getRole()
            ];
        }
        $this->openDatabaseConnection();
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        if (! $user->getId()) {
            $user->setId($this->connection->lastInsertId());
        }
        $this->closeDatabaseConnection();
        return $user;
    }

    /**
     * @param $str
     * @return array
     */
    public function findByUsername($str) {
        $sql = "SELECT * FROM User WHERE LOWER(username) LIKE :str";
        return $this->findByStr($str, $sql);
    }

    /**
     * @param $str
     * @return array
     */
    public function findByEmail($str) {
        $sql = "SELECT * FROM User WHERE LOWER(email) LIKE :str";
        return $this->findByStr($str, $sql);
    }

    /**
     * @param $str
     * @param $sql
     * @return array
     */
    private function findByStr($str, $sql)
    {
        $this->openDatabaseConnection();
        $str = '%' . strtolower($str) . '%';
        $statement = $this->connection->prepare($sql);

        $statement->execute(array('str' => $str));
        $users = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->userFromRow($row);
        }

        $this->closeDatabaseConnection();
        return $users;
    }
}