<?php
namespace App\Model;
use PDO;

class UserRepository extends AbstractRepository
{
    /**
     * @param $id
     * @return null|User
     * @throws Exception
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM User WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $statement->execute(array('id' => $id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $row) {
            return null;
        }

        $user = new User();
        $user
            ->setId($row['id'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setPassword($row['password'])
            ->setRole($row['role']);

        return $user;
    }
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
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        if (! $user->getId()) {
            $user->setId($this->pdo->lastInsertId());
        }
        return $user;
    }
}