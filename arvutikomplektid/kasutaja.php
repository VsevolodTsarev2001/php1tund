<?php
session_start();
include('conf2zone_ee.php');
global $yhendus;

if (isset($_GET['code'])) {
    die(highlight_file(__FILE__, 1));
}

if ($_SESSION['roll'] !== 'kasutaja') {
    header("Location: login.php");
    exit;
}

$message = "";  // переменная для сообщения

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kirjeldus = $_POST['kirjeldus'];
    $korpus = isset($_POST['korpus']) && $_POST['korpus'] == '1' ? 1 : 0;
    $kuvar = isset($_POST['kuvar']) && $_POST['kuvar'] == '1' ? 1 : 0;

    $sql = "INSERT INTO arvutitellimused (kirjeldus, korpus, kuvar) VALUES ('$kirjeldus', $korpus, $kuvar)";
    if ($yhendus->query($sql) === TRUE) {
        $message = "Tellimus lisatud!";
    } else {
        $message = "Viga: " . $yhendus->error;
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arvutikomplektid - Kasutaja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Arvutikomplektid - Kasutaja</h1>
    <div class="header-info">
        <p>Tere tulemast, <?php echo $_SESSION['roll']; ?>! Esita uus tellimus!</p>
        <a href="logout.php" class="logout-button">Logi välja</a>
    </div>
</header>

<form method="post">
    <label>Kirjeldus: <input type="text" name="kirjeldus" required></label><br>

    <div class="radio-group">
        <label>Korpus:</label><br>
        <label><input type="radio" name="korpus" value="1" required> Jah</label>
        <label><input type="radio" name="korpus" value="0"> Ei</label>
    </div>

    <div class="radio-group">
        <label>Kuvar:</label><br>
        <label><input type="radio" name="kuvar" value="1" required> Jah</label>
        <label><input type="radio" name="kuvar" value="0"> Ei</label>
    </div>

    <button type="submit">Esita tellimus</button>
</form>

<?php if ($message): ?>
    <div class="success-message">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

</body>
</html>
