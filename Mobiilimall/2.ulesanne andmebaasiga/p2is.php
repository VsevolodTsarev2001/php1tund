<?php
//require_once('conf.php');
require_once('conf2zone_ee.php');

global $yhendus;

//костатация анекдота по ID
if(isset($_REQUEST["kustuta"])) {
    $kask = $yhendus->prepare("DELETE FROM anekdoot WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta"]);
    $kask->execute();
}

// добавление нового анекдота

$paring = $yhendus->prepare("SELECT id, nimetus, kuupaev, kirjeldus FROM anekdoot");
$paring->bind_result($id, $nimetus, $kuupaev, $kirjeldus);
$paring->execute();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <title>Аnekdooty</title>
    <link rel="stylesheet" href="kujundus2.css">
</head>
<body>
<div id="header">
    <div class="nav">
        <ul>
            <li><a href="kodu.php">Kodu</a></li>
            <?php
            $anecdote = isset($_GET["anecdote"]) ? (int)$_GET["anecdote"] : 0;

            while ($paring->fetch()) {
                echo '<li><a href="kodu.php?anecdote='. $id. '">' . htmlspecialchars($nimetus) . '</a></li>';
            }

            echo '<li><a href="?lisamine">Lisa uus anekdoot...</a></li>';
            ?>
        </ul>
    </div>
</div>
<div class="clear"></div>
</body>
</html>


