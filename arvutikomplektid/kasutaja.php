<?php
session_start();
if ($_SESSION['roll'] !== 'kasutaja') {
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
    $kirjeldus = $_POST['kirjeldus'];

    $korpus = isset($_POST['korpus']) && $_POST['korpus'] == '1' ? 1 : 0;
    $kuvar = isset($_POST['kuvar']) && $_POST['kuvar'] == '1' ? 1 : 0;

    $sql = "INSERT INTO arvutitellimused (kirjeldus, korpus, kuvar) VALUES ('$kirjeldus', $korpus, $kuvar)";
    if ($conn->query($sql) === TRUE) {
        echo "Tellimus lisatud!";
    } else {
        echo "Viga: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">

<h1>Esita uus tellimus</h1>
<form method="post">
    <label>Kirjeldus: <input type="text" name="kirjeldus" required></label><br>
    <label>Korpus: <input type="radio" name="korpus" value="1"> Jah</label>
    <label><input type="radio" name="korpus" value="0"> Ei</label><br>
    <label>Kuvar: <input type="radio" name="kuvar" value="1"> Jah</label>
    <label><input type="radio" name="kuvar" value="0"> Ei</label><br>
    <button type="submit">Esita tellimus</button>
</form>

<a href="logout.php">Logi välja</a>
