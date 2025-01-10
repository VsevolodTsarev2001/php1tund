<?php
session_start();
include('conf2zone_ee.php');
global $yhendus;

if ($_SESSION['roll'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = ""; // Переменная для хранения сообщения

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $pakitud = isset($_POST['pakitud']) && $_POST['pakitud'] == '1' ? 1 : 0;

    $sql = "UPDATE arvutitellimused SET pakitud = $pakitud WHERE id = $id";
    if ($yhendus->query($sql) === TRUE) {
        $message = "Tellimuse staatus uuendatud!";
    } else {
        $message = "Viga: " . $yhendus->error;
    }
}

$sql = "SELECT * FROM arvutitellimused";
$result = $yhendus->query($sql);
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arvutikomplektid - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Arvutikomplektid - Admin</h1>
    <div class="header-info">
        <p>Tere tulemast, admin!</p>
        <a href="logout.php" class="logout-button">Logi välja</a>
    </div>
</header>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Kirjeldus</th>
        <th>Korpus</th>
        <th>Kuvar</th>
        <th>Pakitud</th>
        <th>Uuenda</th>
    </tr>
    </thead>
    <tbody>
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
                                <input type='hidden' name='id' value='{$row['id']}' />
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
    </tbody>
</table>

<!-- Сообщение, если оно установлено -->
<?php if ($message): ?>
    <div class="success-message">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

</body>
</html>
