<?php

include __DIR__ . '/Framework/Database.php';

use Framework\Database;

$db = new Database('mysql', [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phpcosts'
], 'root', 'root');

$sqlFile = file_get_contents("./database.sql");
$db->connection->query($sqlFile);

// try {
//     $db->connection->beginTransaction();
//     $db->connection->query("INSERT INTO products Values(99, 'GLOVES')");

//     $search = "Gloves";

//     $query = "SELECT * FROM products WHERE name=:name";

//     $stmt = $db->connection->prepare($query);

//     $stmt->bindValue('name', $search, PDO::PARAM_STR);

//     $stmt->execute();

//     var_dump($stmt->fetchAll(PDO::FETCH_OBJ));

//     $db->connection->commit();
// } catch (Exception $e) {
//     if ($db->connection->inTransaction()) {
//         $db->connection->rollBack();
//     }

//     echo "Transaction failed";
// }
