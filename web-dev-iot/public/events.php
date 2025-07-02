<?php

// niemals timeout
set_time_limit(0);
ob_implicit_flush(true);

// CORS (falls nötig)
// header('Access-Control-Allow-Origin: *');

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Autoloader / Requires
require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/Model.php';
require __DIR__ . '/../app/Models/SensorData.php';
require __DIR__ . '/../app/Models/Sensor.php';
require __DIR__.'/../app/Interfaces/RepositoryInterface.php';
require __DIR__ . '/../app/Repositories/SensorDataRepository.php';
require __DIR__ . '/../app/Repositories/SensorRepository.php';

// Initialer Stand: vom Client mit Last-Event-ID übermittelt?
$lastId = isset($_SERVER['HTTP_LAST_EVENT_ID'])
    ? (int)$_SERVER['HTTP_LAST_EVENT_ID']
    : 0;

$repo = new SensorDataRepository();
$sensorRepo = new SensorRepository();

while (true) {
    // Neue Datensätze abholen
    $new = $repo->findSinceId($lastId);

    foreach ($new as $sd) {
        $dataArray = $sd->toArray();
        
        $sensor = $sensorRepo->find($sd->getSensorId());
        $dataArray['sensor_type'] = $sensor ? $sensor->getType() : '';
        $dataArray['unit'] = $sensor ? $sensor->getUnit() : '';
        
        $data = json_encode($dataArray);

        // SSE-Format: id: <id>\ndata: <json>\n\n
        echo "id: {$sd->getId()}\n";
        echo "data: {$data}\n\n";

        // Fortschritt merken
        $lastId = $sd->getId();
    }

    // 1 Sekunde warten, bevor erneut geprüft wird
    sleep(1);

    @ob_flush();
    @flush();
}
