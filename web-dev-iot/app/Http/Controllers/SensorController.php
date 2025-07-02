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
                $row['last_measurement'] = $ld['measurement'];
                $row['last_timestamp']   = $ld['timestamp'];
            } else {
                $row['last_measurement'] = null;
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

    /**
     * POST /api/sensors
     * Legt einen neuen Sensor an, falls noch nicht vorhanden.
     */
    public function store(): void
    {
        // Nur POST erlauben
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error'=>'Methode nicht erlaubt']);
            return;
        }

        // JSON einlesen
        $input = json_decode(file_get_contents('php://input'), true);
        $type  = trim($input['type'] ?? '');        
        $unit = trim($input['unit'] ?? '');

        // Validierung
        if ($type === '') {
            http_response_code(422);
            echo json_encode(['error'=>'Sensortyp ist erforderlich']);
            return;
        }

        // Prüfen, ob ein Sensor mit diesem Typ bereits existiert
        $existing = $this->sensorRepo->findByType($type);
        if ($existing) {
            http_response_code(409);
            echo json_encode(['error'=>'Sensor existiert bereits']);
            return;
        }

        // Neuen Sensor anlegen
        $sensor = new Sensor();
        $sensor->fill([
            'name' => $type,
            'type' => $type,
            'unit' => $unit
        ]);

        if ($this->sensorRepo->save($sensor)) {
            http_response_code(201);
            echo json_encode($sensor->toArray());
        } else {
            http_response_code(500);
            echo json_encode(['error'=>'Anlegen fehlgeschlagen']);
        }
    }
}

?>