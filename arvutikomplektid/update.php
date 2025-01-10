<?php
// Подключаем конфигурацию базы данных
include('conf2zone_ee.php');
global $yhendus;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE arvutitellimused SET pakitud = 1 WHERE id = $id";

    if ($yhendus->query($sql) === TRUE) {
        echo "Статус заказа обновлен.";
    } else {
        echo "Ошибка: " . $yhendus->error;
    }
}
$yhendus->close();
?>
<a href="index.php">Назад</a>
