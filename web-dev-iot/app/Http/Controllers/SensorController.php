<?php
// app/Http/Controllers/SensorController.php

class SensorController extends Controller
{
    private SensorRepository     $sensorRepo;
    private SensorDataRepository $dataRepo;

    public function __construct(
        SensorRepository $sensorRepo,
        SensorDataRepository $dataRepo
    ) {
        $this->sensorRepo = $sensorRepo;
        $this->dataRepo   = $dataRepo;
    }

    public function index(): void
    {
        $out = [];
        foreach ($this->sensorRepo->findAll() as $sensor) {
            $row = $sensor->toArray();

            // fetch last reading
            $latest = $this->dataRepo->findLatestBySensor($sensor->getId());
            if ($latest) {
                $ld = $latest->toArray();
                $row['last_temperature'] = $ld['temperature'];
                $row['last_humidity']    = $ld['humidity'];
                $row['last_timestamp']   = $ld['timestamp'];
            } else {
                $row['last_temperature'] = null;
                $row['last_humidity']    = null;
                $row['last_timestamp']   = null;
            }

            $out[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($out);
    }

    public function destroy(int $id): void
    {
        // 1) Alle Sensordaten löschen       
        if ($this->sensorRepo->delete($id) && $this->dataRepo->deleteSensorData($id)) {
            http_response_code(204);
        } else {
            http_response_code(500);
            echo json_encode(['error'=>'Löschen fehlgeschlagen']);
        }
    }
}

?>