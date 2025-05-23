<?php
interface RepositoryInterface
{
    public function find(int $id);
    public function findAll(): array;
    public function save($entity): bool;
    public function delete(int $id): bool;
}
?>