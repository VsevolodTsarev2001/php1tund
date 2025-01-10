<?php
session_start();
if (isset($_GET['code'])) {
    die(highlight_file(__FILE__, 1));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kasutajanimi = $_POST['kasutajanimi'];
    $parool = $_POST['parool'];

    if ($kasutajanimi === 'admin' && $parool === '12345') {
        $_SESSION['roll'] = 'admin';
        header("Location: admin.php");
    } elseif ($kasutajanimi === 'opilane' && $parool === '54321') {
        $_SESSION['roll'] = 'kasutaja';
        header("Location: kasutaja.php");
    } else {
        echo "Vale kasutajanimi või parool.";
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arvutikomplektid - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Arvutikomplektid - Logi sisse</h1>
<form method="post">
    <label>Kasutajanimi: <input type="text" name="kasutajanimi"></label><br>
    <label>Parool: <input type="password" name="parool"></label><br>
    <button type="submit">Logi sisse</button>
</form>
</body>
</html>
