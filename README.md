# Example using db_connection
require_once 'Database.php';

class User {
    private $pdo;

    // Constructor to initialize the database connection
    public function __construct() {
        // Instantiate the Database class and get the PDO connection
        $db = new Database();
        $this->pdo = $db->getConnection();
    }
}