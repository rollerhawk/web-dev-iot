<?php
class SensorDataController extends Controller
{
    private $dataRepo, $sensorRepo;
    public function __construct($dataRepo, $sensorRepo)
    {
        $this->dataRepo   = $dataRepo;
        $this->sensorRepo = $sensorRepo;
    }

    public function index()
    {
        $list = $this->dataRepo->findAll();  // returns SensorData[]
        $out  = [];
    
        foreach ($list as $sd) {
            $row = $sd->toArray();           // [id, sensor_id, temperature, …]
            // fetch the Sensor to get its type
            $sensor = $this->sensorRepo->find($sd->getSensorId());
            $row['sensor_type'] = $sensor ? $sensor->getType() : '';
            $out[] = $row;
        }
    
        header('Content-Type: application/json');
        echo json_encode($out);
    }

    public function store()
    {
        $in = json_decode(file_get_contents('php://input'), true);
        $v  = (new SensorDataValidator())->validate($in);
        if ($v->fails()) {
            http_response_code(422);
            echo json_encode(['errors'=>$v->getErrors()]);
            return;
        }

        $type = $in['sensor_type'];
        $found = $this->sensorRepo->findByType($type);
        if (count($found)) {
            $sensor = $found[0];
        } else {
            $sensor = new Sensor();
            $sensor->fill(['name'=>$type,'type'=>$type]);
            $this->sensorRepo->save($sensor);
        }

        $sd = new SensorData();
        $sd->fill([
          'sensor_id'=>$sensor->getId(),
          'temperature'=>$in['temperature'],
          'humidity'=>$in['humidity'],
          'timestamp'=>$in['timestamp']
        ]);

        if ($this->dataRepo->save($sd)) {
            http_response_code(201);
            echo json_encode($sd->toArray());
        } else {
            http_response_code(500);
            echo json_encode(['error'=>'Could not save data']);
        }
    }
}
?>