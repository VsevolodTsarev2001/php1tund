<?php
session_start();
if ($_SESSION['roll'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$kasutaja="seva";
$paroll="123456";
$andmebass="seva";
$serverinimi="localhost";

$conn = new mysqli($serverinimi, $kasutaja, $paroll, $andmebass);
if ($conn->connect_error) {
    die("Andmebaasi ühenduse viga: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $pakitud = isset($_POST['pakitud']) && $_POST['pakitud'] == '1' ? 1 : 0;

    $sql = "UPDATE arvutitellimused SET pakitud = $pakitud WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Tellimuse staatus uuendatud!";
    } else {
        echo "Viga: " . $conn->error;
    }
}

$sql = "SELECT * FROM arvutitellimused";
$result = $conn->query($sql);
?>
<link rel="stylesheet" href="style.css">

<h1>Tellimuste nimekiri</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Kirjeldus</th>
        <th>Korpus</th>
        <th>Kuvar</th>
        <th>Pakitud</th>
        <th>Uuenda</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['kirjeldus']}</td>
                <td>" . ($row['korpus'] ? 'Jah' : 'Ei') . "</td>
                <td>" . ($row['kuvar'] ? 'Jah' : 'Ei') . "</td>
                <td>" . ($row['pakitud'] ? 'Jah' : 'Ei') . "</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <label><input type='radio' name='pakitud' value='1' " . ($row['pakitud'] ? 'checked' : '') . "> Jah</label>
                        <label><input type='radio' name='pakitud' value='0' " . (!$row['pakitud'] ? 'checked' : '') . "> Ei</label>
                        <button type='submit'>Uuenda</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Andmed puuduvad</td></tr>";
    }
    ?>
</table>

<a href="logout.php">Logi välja</a>

