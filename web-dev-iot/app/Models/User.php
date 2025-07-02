<?php

class User
{
    private int    $id;
    private string $username;
    private string $password_hash;
    private string $role;

    public function fill(array $data): void
    {
        $this->id            = (int)($data['id'] ?? 0);
        $this->username      = $data['username'] ?? '';
        $this->password_hash = $data['password_hash'] ?? '';
        $this->role          = $data['role'] ?? 'user';
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'password_hash' => $this->password_hash,
            'role'          => $this->role,
        ];
    }

    // Getter
    public function getId(): int           { return $this->id; }
    public function getUsername(): string  { return $this->username; }
    public function getPasswordHash(): string { return $this->password_hash; }
    public function getRole(): string      { return $this->role; }
}
