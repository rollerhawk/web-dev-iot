<?php
class Sensor extends Model
{
    private $id, $name, $type, $unit;

    public function fill(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        $this->name = $data['name'] ?? '';
        $this->type = $data['type'] ?? '';        
        $this->unit = $data['unit']   ?? '';  // neu
    }

    public function toArray(): array
    {
        return ['id'=>$this->id,'name'=>$this->name,'type'=>$this->type,'unit'=>$this->unit];
    }

    public function getId(): ?int    { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getType(): string { return $this->type; }
    public function getUnit(): string { return $this->unit; }

    public function setName(string $n): void { $this->name = $n; }
    public function setType(string $t): void { $this->type = $t; }
    public function setUnit(string $u): void { $this->unit = $u; }
}
?>