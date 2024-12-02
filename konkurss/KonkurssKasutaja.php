<?php
require_once ('conf.php');
global $yhendus;

// Добавление +1 или -1 пункта
if(isset($_REQUEST["heakonkurss_id"])){
    $paring = $yhendus->prepare("UPDATE konkurss SET punktid = punktid + 1 WHERE id=?");
    $paring->bind_param('i', $_REQUEST["heakonkurss_id"]);
    $paring->execute();
}

if(isset($_REQUEST["halbkonkurss_id"])){
    $paring = $yhendus->prepare("UPDATE konkurss SET punktid = punktid - 1 WHERE id=?");
    $paring->bind_param('i', $_REQUEST["halbkonkurss_id"]);
    $paring->execute();
}

// Добавление комментариев
if(isset($_REQUEST["uusKomment"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?");
    $kommentLisa="\n".$_REQUEST["komment"];
    $paring->bind_param("si", $kommentLisa, $_REQUEST["uusKomment"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

// Добавление нового конкурса
if(!empty($_REQUEST["uusKonkurss"])) {
    $paring = $yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisaeg, avalik) VALUES (?, NOW(), 1)");
    $paring->bind_param("s", $_REQUEST["uusKonkurss"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
/*
//Переключение видимости конкурса
if(isset($_REQUEST["muudaAvalik"])){
    $paring = $yhendus->prepare("UPDATE konkurss SET avalik = 1 - avalik WHERE id=?");
    $paring->bind_param('i', $_REQUEST["muudaAvalik"]);
    $paring->execute();

}
*/
?>
<!Doctype html>
<html>
<head>
    <link rel="stylesheet" href="konkurssstyle.css">
    <title>TARpv23 jõulu konkursid - Kasutaja</title>
</head>
<body>
<h1>TARpv23 jõulu konkursid - Kasutaja</h1>
<nav>
    <ul>
        <li><a href="KonkurssAdmin.php">Admin</a></li>
        <li><a href="KonkurssKasutaja.php">Kasutaja</a></li>
    </ul>
</nav>
<form action="?">
    <label for="uusKonkurss">Lisa konkurssi nimi</label>
    <input type="text" name="uusKonkurss" id="uusKonkurss">
    <input type="submit" value="OK">
</form>

<table border="1">
    <tr>
        <th>Konkursi nimi</th>
        <th>Lisamisaeg</th>
        <th>Punktid</th>
        <th>Kommentaarid</th>
        <th colspan="2">Haldus</th>
    </tr>
    <?php
    // Tabeli sisu kuvamine
    $paring = $yhendus->prepare("SELECT id, konkursiNimi, Lisamisaeg, punktid, kommentaarid FROM konkurss WHERE avalik = 1");
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        $konkursiNimi = htmlspecialchars($konkursiNimi);
        $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
        echo "<td>".$konkursiNimi."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$kommentaarid."</td>";
        ?>
        <td>
            <form action="?">
                <input type="hidden" name="uusKomment" value="<?=$id?>">
                <input type="text" name="komment" id="komment">
                <input type="submit" value="Lisa kommentaar">
            </form>
            <form action="?">
                <input type="hidden" name="heakonkurss_id" value="<?=$id?>">
                <input type="submit" value="+1 punkt">
            </form>
            <form action="?">
                <input type="hidden" name="halbkonkurss_id" value="<?=$id?>">
                <input type="submit" value="-1 punkt">
            </form>
        </td>
    <?php } ?>
</table>
</body>
</html>
<?php
$yhendus->close();
?>
