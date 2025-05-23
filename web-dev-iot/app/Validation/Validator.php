<?php
abstract class Validator
{
    abstract protected function rules(): array;

    public function validate(array $data): ValidationResult
    {
        $res = new ValidationResult();
        foreach ($this->rules() as $field => $rules) {
            $val = $data[$field] ?? null;
            foreach ($rules as $rule) {
                if ($rule==='required' && ( $val==='' || $val===null )) {
                    $res->addError($field,'This field is required.');
                }
                if ($rule==='numeric' && !is_numeric($val)) {
                    $res->addError($field,'Must be numeric.');
                }
                if (strpos($rule,'min:')===0) {
                    $m = (float)substr($rule,4);
                    if ($val < $m) $res->addError($field,"Minimum is $m.");
                }
                if (strpos($rule,'max:')===0) {
                    $M = (float)substr($rule,4);
                    if ($val > $M) $res->addError($field,"Maximum is $M.");
                }
                if ($rule==='datetime' && !DateTime::createFromFormat('Y-m-d\TH:i',$val)) {
                    $res->addError($field,'Invalid date/time format.');
                }
            }
        }
        return $res;
    }
}
?>