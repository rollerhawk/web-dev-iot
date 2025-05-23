<?php
class SensorDataValidator extends Validator
{
    protected function rules(): array
    {
        return [
          'sensor_type'=>['required'],
          'temperature'=>['required','numeric','min:-50','max:100'],
          'humidity'   =>['required','numeric','min:0','max:100'],
          'timestamp'  =>['required','datetime']
        ];
    }
}
?>