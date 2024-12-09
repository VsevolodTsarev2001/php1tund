<?php
//require_once('conf.php');
require_once ('conf2zone_ee.php');
include("p2is.php");
global $yhendus;
// Проверка, есть ли параметр "anecdote" в URL
if (isset($_GET["anecdote"]) && !empty($_GET["anecdote"])) {
    $anecdote_id = (int)$_GET["anecdote"];

    // Получаем анекдот по ID
    $paring = $yhendus->prepare("SELECT id, nimetus, kuupaev, kirjeldus FROM anekdoot WHERE id = ?");
    $paring->bind_param("i", $anecdote_id);
    $paring->bind_result($id, $nimetus, $kuupaev, $kirjeldus);
    $paring->execute();

    // Если анекдот найден, выводим его


    if ($paring->fetch()) {
        echo '<h2>' . htmlspecialchars($nimetus) . '</h2>';
        echo '<p><strong>Kuupäev:</strong> ' . htmlspecialchars($kuupaev) . '</p>';
        echo '<p><strong>Kirjeldus:</strong> ' . htmlspecialchars($kirjeldus) . '</p>';
    } elseif (isset($_GET["lisamine"])) {
        echo "<p>Подключаем файл lisamine.php...</p>";  // Выводим сообщение для отладки
        $file_name = "lisamine.php";
        if (file_exists($file_name)) {
            include($file_name);
        } else {
            echo "<p>Fail ei otsi</p>";
        }
    }

} else {
        echo '<p>Valige navigeerimismenüüst nali.</p>';
    }
?>

<?php require("jalus.php"); ?>