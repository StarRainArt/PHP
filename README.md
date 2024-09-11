# Example using db_connection
require_once 'dbconfig.php';

class User {
    private $pdo;

    // Constructor to initialize the database connection
    public function __construct() {
        // Instantiate the Database class and get the PDO connection
        $db = new dbconfig();
        $this->pdo = $db->getConnection();
    }
}