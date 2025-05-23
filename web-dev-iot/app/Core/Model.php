<?php
abstract class Model
{
    protected $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    abstract public function fill(array $data): void;
    abstract public function toArray(): array;
}
?>