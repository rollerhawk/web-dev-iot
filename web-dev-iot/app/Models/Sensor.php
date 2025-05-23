<?php
class Sensor extends Model
{
    private $id, $name, $type;

    public function fill(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        $this->name = $data['name'] ?? '';
        $this->type = $data['type'] ?? '';
    }

    public function toArray(): array
    {
        return ['id'=>$this->id,'name'=>$this->name,'type'=>$this->type];
    }

    public function getId(): ?int    { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getType(): string { return $this->type; }

    public function setName(string $n): void { $this->name = $n; }
    public function setType(string $t): void { $this->type = $t; }
}
?>