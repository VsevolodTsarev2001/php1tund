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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE arvutitellimused SET pakitud = 1 WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Статус заказа обновлен.";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}
$conn->close();
?>
<a href="index.php">Назад</a>
