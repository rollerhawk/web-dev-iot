<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require __DIR__.'/app/Core/Database.php';
require __DIR__.'/app/Core/Model.php';
require __DIR__.'/app/Core/Router.php';
require __DIR__.'/app/Interfaces/RepositoryInterface.php';

require __DIR__.'/app/Models/Sensor.php';
require __DIR__.'/app/Models/SensorData.php';

require __DIR__.'/app/Repositories/SensorRepository.php';
require __DIR__.'/app/Repositories/SensorDataRepository.php';

require __DIR__.'/app/Validation/ValidationResult.php';
require __DIR__.'/app/Validation/Validator.php';
require __DIR__.'/app/Validation/SensorDataValidator.php';

require __DIR__.'/app/Http/Controllers/Controller.php';
require __DIR__.'/app/Http/Controllers/SensorController.php';
require __DIR__.'/app/Http/Controllers/SensorDataController.php';

$dbRepo     = new SensorRepository();
$dataRepo   = new SensorDataRepository();
$router     = new Router();

// serve front-end
$router->add('GET',    '',       fn()=>readfile(__DIR__.'/index.html'));

// API endpoints
$router->add('GET',    '/api/sensors',    fn()=>(new SensorController($dbRepo,$dataRepo))->index());
$router->add('GET',    '/api/sensordata', fn()=>(new SensorDataController($dataRepo,$dbRepo))->index());
$router->add('POST',   '/api/sensordata', fn()=>(new SensorDataController($dataRepo,$dbRepo))->store());

$router->add('DELETE', '/api/sensors', function() use ($dbRepo, $dataRepo) {
    $id = $_GET['delete_sensor_id'] ?? 0;
    (new SensorController($dbRepo, $dataRepo))->destroy($id);
});

$method = $_SERVER['REQUEST_METHOD'];
// strip off any query string
$rawUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// if this is a DELETE to /api/sensors/<id>, normalize it to /api/sensors
if ($method === 'DELETE' && preg_match('#^/api/sensors/(\d+)$#', $rawUri, $m)) {
    // stash the ID so your handler can still grab it
    $_GET['delete_sensor_id'] = (int)$m[1];
    $uri = '/api/sensors';
} else {
    $uri = $rawUri;
}

// now dispatch as before
$router->dispatch($method, $uri);
?>