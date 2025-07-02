<?php
class SensorData extends Model
{
    private $id, $sensorId, $measurement, $timestamp;

    public function fill(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        $this->sensorId   = (int)($data['sensor_id'] ?? 0);
        $this->measurement = (float)$data['measurement'];
        $this->timestamp   = $data['timestamp'];
    }

    public function getSensorId(): int {return $this->sensorId; }

    public function getId(): int {return $this->id; }

    public function toArray(): array
    {
        return [
          'id'=>$this->id,
          'sensor_id'=>$this->sensorId,
          'measurement'=>$this->measurement,
          'timestamp'=>$this->timestamp
        ];
    }
}
?>