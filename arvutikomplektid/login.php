<?php
session_start();

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
<link rel="stylesheet" href="style.css">

<form method="post">
    <label>Kasutajanimi: <input type="text" name="kasutajanimi"></label><br>
    <label>Parool: <input type="password" name="parool"></label><br>
    <button type="submit">Logi sisse</button>
</form>
