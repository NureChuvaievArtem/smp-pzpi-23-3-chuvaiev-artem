<?php
class DatabaseConnector
{
    private $pdo;

    public function __construct($pathToDbFile)
    {
        $absolutePath = realpath(__DIR__ . "/../" . $pathToDbFile);

        if (!file_exists($absolutePath)) {
            throw new Exception("Database file not found: $absolutePath");
        }

        $this->pdo = new PDO("sqlite:" . $absolutePath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}

$database = new DatabaseConnector("sql/webshop.db");
?>