<?php
class SensorRepository implements RepositoryInterface
{
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function find(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM sensors WHERE id=?');
        $stmt->execute([$id]); $row = $stmt->fetch();
        if (!$row) return null;
        $s = new Sensor(); $s->fill($row); return $s;
    }

    public function findAll(): array
    {
        $out = [];
        foreach ($this->db->query('SELECT * FROM sensors') as $row) {
            $s = new Sensor(); $s->fill($row);
            $out[] = $s;
        }
        return $out;
    }

    public function save($sensor): bool
    {
        if ($sensor->getId()) {
            $stmt = $this->db->prepare('UPDATE sensors SET name=?,type=?,unit=? WHERE id=?');
            return $stmt->execute([$sensor->getName(),$sensor->getType(),$sensor->getId()]);
        }
        $stmt = $this->db->prepare('INSERT INTO sensors (name,type,unit) VALUES (?,?,?)');
        $ok = $stmt->execute([$sensor->getName(),$sensor->getType(),$sensor->getUnit()]);
        if ($ok) $sensor->fill(['id'=>$this->db->lastInsertId(),'name'=>$sensor->getName(),'type'=>$sensor->getType(),'unit'=>$sensor->getUnit()]);
        return $ok;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM sensors WHERE id=?');
        return $stmt->execute([$id]);
    }

    public function findByType(string $type): array
    {
        $stmt = $this->db->prepare('SELECT * FROM sensors WHERE type=?');
        $stmt->execute([$type]);
        $out = [];
        while ($row = $stmt->fetch()) {
            $s = new Sensor(); $s->fill($row);
            $out[] = $s;
        }
        return $out;
    }
}
?>