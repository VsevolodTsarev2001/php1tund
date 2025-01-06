<link rel="stylesheet" href="style.css">

<?php
// Подключение к базе данных
$kasutaja="seva";
$paroll="123456";
$andmebass="seva";
$serverinimi="localhost";

$conn = new mysqli($serverinimi, $kasutaja, $paroll, $andmebass);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Вывод данных из таблицы
$sql = "SELECT * FROM arvutitellimused";
$result = $conn->query($sql);

echo "<h1>Список заказов</h1>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Описание</th><th>Корпус</th><th>Кувар</th><th>Пакет</th></tr>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['kirjeldus']}</td>
                <td>" . ($row['korpus'] ? 'Да' : 'Нет') . "</td>
                <td>" . ($row['kuvar'] ? 'Да' : 'Нет') . "</td>
                <td>" . ($row['pakitud'] ? 'Готово' : 'Не готово') . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Нет данных</td></tr>";
}
echo "</table>";

$conn->close();
?>
