<?php
// Подключаем конфигурацию базы данных
include('conf2zone_ee.php');
global $yhendus;

$sql = "SELECT * FROM arvutitellimused";
$result = $yhendus->query($sql);

echo "<h1>Tellimuste nimekiri</h1>";
echo "<table>";
echo "<tr><th>ID</th><th>Kirjeldus</th><th>Korpus</th><th>Kuvar</th><th>Pakitud</th></tr>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['kirjeldus']}</td>
                <td>" . ($row['korpus'] ? 'Jah' : 'Ei') . "</td>
                <td>" . ($row['kuvar'] ? 'Jah' : 'Ei') . "</td>
                <td>" . ($row['pakitud'] ? 'Jah' : 'Ei') . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data available</td></tr>";
}
echo "</table>";

$yhendus->close();
?>
