<?php
class SensorDataValidator extends Validator
{
    protected function rules(): array
    {
        return [
          'sensor_type'=>['required'],
          'measurement'=>['required','numeric','min:-50','max:100'],
          'timestamp'  =>['required','datetime']
        ];
    }
}
?>