<?php 
$host='localhost';
$dbName = 'db_izhgil';
$charset = 'utf8mb4';
$userName = 'izhgil';
$password= 'e720c8';
$dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

$options = [
PDO::ATTR_ERRMODE => PDO ::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try{
$pdo=new PDO($dsn,$userName,$password,$options);
}catch (PDOException $e){
die('Подключение не удалось: ' . $e->getMessage());
}


$sql = 'select * from messages';
$stmt = $pdo->prepare($sql); // Prevent MySQl injection. $stmt means statement
$result = $stmt->execute();

return $pdo;
?>