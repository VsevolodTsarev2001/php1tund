<?php
// Подключаем конфигурацию базы данных
include('conf2zone_ee.php');
global $yhendus;

$sql = "SELECT 
    COUNT(*) AS total_orders, 
    SUM(korpus) AS total_korpus, 
    SUM(kuvar) AS total_kuvar, 
    SUM(pakitud) AS total_pakitud 
    FROM arvutitellimused";

$result = $yhendus->query($sql);
$data = $result->fetch_assoc();

echo "<h1>Статистика</h1>";
echo "Всего заказов: " . $data['total_orders'] . "<br>";
echo "Заказы с корпусом: " . $data['total_korpus'] . "<br>";
echo "Заказы с монитором: " . $data['total_kuvar'] . "<br>";
echo "Упакованные заказы: " . $data['total_pakitud'] . "<br>";

$yhendus->close();
?>
