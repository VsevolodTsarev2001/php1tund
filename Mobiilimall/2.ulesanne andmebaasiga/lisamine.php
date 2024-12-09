<?php
//require_once("conf.php");
require_once("conf2zone_ee.php");
global $yhendus;

// Обработка формы добавления нового анекдота
if (isset($_POST["nimetus"]) && isset($_POST["kuupaev"]) && isset($_POST["kirjeldus"])
    && !empty($_POST["nimetus"]) && !empty($_POST["kuupaev"]) && !empty($_POST["kirjeldus"])) {
    // Вставка нового анекдота в базу данных
    $paring = $yhendus->prepare("INSERT INTO anekdoot(nimetus, kuupaev, kirjeldus) VALUES(?, ?, ?)");
    $paring->bind_param("sss", $_POST["nimetus"], $_POST["kuupaev"], $_POST["kirjeldus"]);
    $paring->execute();

    echo "Anekdoot on lisatud";
}

?>

<link rel="stylesheet" href="kujundus2.css">
<form action="lisamine.php" method="post">
    <label for="nimetus">Nimetus</label>
    <input type="text" id="nimetus" name="nimetus" placeholder="Anekdoodi pealkiri" required>

    <label for="kuupaev">Kuupaev</label>
    <input type="date" id="kuupaev" name="kuupaev" required>

    <label for="kirjeldus">Kirjeldus</label>
    <textarea id="kirjeldus" name="kirjeldus" placeholder="Anekdoodi kirjeldus" required></textarea>

    <input type="submit" value="Lisa anekdoot">
</form>
