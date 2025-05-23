<?php
class ValidationResult
{
    private $errors = [];
    public function fails(): bool          { return !empty($this->errors); }
    public function getErrors(): array    { return $this->errors; }
    public function addError($field,$msg) { $this->errors[$field][] = $msg; }
}
?>