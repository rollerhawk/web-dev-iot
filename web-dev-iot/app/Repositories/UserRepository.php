<?php

class UserRepository
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return null;
        $user = new User();
        $user->fill($row);
        return $user;
    }
}
