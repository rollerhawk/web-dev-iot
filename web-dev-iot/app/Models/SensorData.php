<?php
class SensorData extends Model
{
    private $id, $sensorId, $temperature, $humidity, $timestamp;

    public function fill(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        $this->sensorId   = (int)($data['sensor_id'] ?? 0);
        $this->temperature = (float)$data['temperature'];
        $this->humidity    = (float)$data['humidity'];
        $this->timestamp   = $data['timestamp'];
    }

    public function getSensorId(): int {return $this->sensorId; }

    public function toArray(): array
    {
        return [
          'id'=>$this->id,
          'sensor_id'=>$this->sensorId,
          'temperature'=>$this->temperature,
          'humidity'=>$this->humidity,
          'timestamp'=>$this->timestamp
        ];
    }
}
?>