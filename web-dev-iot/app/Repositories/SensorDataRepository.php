<?php
class SensorDataRepository implements RepositoryInterface
{
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function find(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM sensordata WHERE id=?');
        $stmt->execute([$id]); $row = $stmt->fetch();
        if (!$row) return null;
        $sd = new SensorData(); $sd->fill($row);
        return $sd;
    }

    public function findAll(): array
    {
        $out = [];
        foreach ($this->db->query('SELECT * FROM sensordata ORDER BY timestamp DESC') as $row) {
            $sd = new SensorData(); $sd->fill($row);
            $out[] = $sd;
        }
        return $out;
    }

    // app/Repositories/SensorDataRepository.php
    public function findLatestBySensor(int $sensorId): ?SensorData
    {
        $stmt = $this->db->prepare(
        'SELECT * FROM sensordata WHERE sensor_id = ? ORDER BY timestamp DESC LIMIT 1'
        );
        $stmt->execute([$sensorId]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        $sd = new SensorData();
        $sd->fill($row);
        return $sd;
    }


    public function save($sd): bool
    {
        $a = $sd->toArray();
        if ($a['id']) {
            $stmt = $this->db->prepare(
              'UPDATE sensordata SET sensor_id=?,temperature=?,humidity=?,timestamp=? WHERE id=?'
            );
            return $stmt->execute([$a['sensor_id'],$a['temperature'],$a['humidity'],$a['timestamp'],$a['id']]);
        }
        $stmt = $this->db->prepare(
          'INSERT INTO sensordata (sensor_id,temperature,humidity,timestamp) VALUES(?,?,?,?)'
        );
        $ok = $stmt->execute([$a['sensor_id'],$a['temperature'],$a['humidity'],$a['timestamp']]);
        if ($ok) $sd->fill(array_merge($a,['id'=>$this->db->lastInsertId()]));
        return $ok;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM sensordata WHERE id=?');
        return $stmt->execute([$id]);
    }

    public function deleteSensorData(int $sensorId): bool
    {
        $stmt = $this->db->prepare('DELETE FROM sensordata WHERE sensor_id=?');
        return $stmt->execute([$sensorId]);
    }
}
?>