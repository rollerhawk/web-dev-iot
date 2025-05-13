@startuml

Sensor "1" *-- "many" SensorData: contains

class Database
{
    ­– private static ?PDO $instance = null
    + public static function getConnection(): PDO
}

abstract class Model
{
    ­– protected PDO $db
    + public function __construct(PDO $db)
    + abstract public function fill(array $data): void
    + abstract public function toArray(): array
}

class Sensor extends Model
{
    – int     $id
    – string  $name
    – string  $type
    + public function fill(array $data): void
    + public function toArray(): array

    + public function getId(): int
    + public function getName(): string
    + public function getType(): string
    + public function setName(string $n): void
    + public function setType(string $t): void

    + /** 1→* */ public function getData(): array   // returns SensorData[]
}

class SensorData extends Model
{
    – int       $id
    – int       $sensorId
    – float     $temperature
    – float     $humidity
    – DateTime  $timestamp
    + public function fill(array $data): void
    + public function toArray(): array

    + public function getId(): int
    + public function getSensorId(): int
    + public function getTemperature(): float
    + public function getHumidity(): float
    + public function getTimestamp(): DateTime
    + public function setTemperature(float $t): void
    + public function setHumidity(float $h): void
    + public function setTimestamp(DateTime $ts): void
}

interface RepositoryInterface
{
    + public function find(int $id): ?Model
    + public function findAll(): array
    + public function save(Model $m): bool
    + public function delete(int $id): bool
}

class SensorRepository implements RepositoryInterface
{
    – PDO $db
    + public function __construct(PDO $db)
    + public function find(int $id): ?Sensor
    + public function findAll(): array      // Sensor[]
    + public function save(Sensor $s): bool
    + public function delete(int $id): bool
    + public function findByType(string $type): array  // Sensor[]
}

class SensorDataRepository implements RepositoryInterface
{
    – PDO $db
    + public function __construct(PDO $db)
    + public function find(int $id): ?SensorData
    + public function findAll(): array      // SensorData[]
    + public function save(SensorData $d): bool
    + public function delete(int $id): bool
    + public function findBySensor(int $sensorId): array  // SensorData[]
    + public function findRecent(\DateTime $since): array // SensorData[]
}

class ValidationResult
{
    – array $errors = []
    + public function fails(): bool
    + public function getErrors(): array
    + public function addError(string $field, string $msg): void
}

abstract class Validator
{
    + abstract protected function rules(): array
    + public function validate(array $data): ValidationResult
}

class SensorDataValidator extends Validator
{
    + protected function rules(): array
}

abstract class Controller
{
    – RepositoryInterface $repo
    + public function __construct(RepositoryInterface $r)
}

class SensorController extends Controller
{
    + public function index(): void         // GET /sensors – overview cards
    + public function show(int $id): void   // GET /sensors/{id}
    + public function create(): void        // GET /sensors/create (Blade form)
    + public function store(array $req): void // POST /sensors
}

class SensorDataController extends Controller
{
    + public function index(): void           // GET /sensordata – sortable table + AJAX
    + public function create(): void          // GET /sensordata/create
    + public function store(array $req): void // POST /sensordata
}
@enduml
