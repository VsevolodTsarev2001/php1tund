<link rel="stylesheet" href="style.css">

<?php
$kasutaja="seva";
$paroll="123456";
$andmebass="seva";
$serverinimi="localhost";

$conn = new mysqli($serverinimi, $kasutaja, $paroll, $andmebass);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "SELECT 
    COUNT(*) AS total_orders, 
    SUM(korpus) AS total_korpus, 
    SUM(kuvar) AS total_kuvar, 
    SUM(pakitud) AS total_pakitud 
    FROM arvutitellimused";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo "<h1>Статистика</h1>";
echo "Всего заказов: " . $data['total_orders'] . "<br>";
echo "Заказы с корпусом: " . $data['total_korpus'] . "<br>";
echo "Заказы с монитором: " . $data['total_kuvar'] . "<br>";
echo "Упакованные заказы: " . $data['total_pakitud'] . "<br>";

$conn->close();
?>
