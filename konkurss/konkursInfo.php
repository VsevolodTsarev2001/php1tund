<?php
ob_start();
//require "conf.php";
require_once "conf2zone_ee.php";
global $yhendus;
require_once ('logout.inc.php');

?>

<?php
//table UPDATE +1 punktid
if (isset($_REQUEST["heaKonkurss_id"])) {
    $paring = $yhendus->prepare("UPDATE konkurss set punktid = punktid+1 WHERE id=?;");
    $paring -> bind_param("i", $_REQUEST["heaKonkurss_id"]);
    $paring -> execute();
}
?>

<?php
//tabeli UPDATE -1 punktid
if (isset($_REQUEST["halbKonkurss_id"])) {
    $paring = $yhendus->prepare("UPDATE konkurss set punktid = punktid -1 WHERE id=?;");
    $paring -> bind_param("i", $_REQUEST["halbKonkurss_id"]);
    $paring -> execute();
}
?>

<?php
//tabeli INSERT
if(!empty($_REQUEST["uusKonkurss"])){
    $paring = $yhendus -> prepare("INSERT INTO konkurss (konkursiNimi, lisamisaeg) values (?, NOW());");
    $paring -> bind_param("s", $_REQUEST["uusKonkurss"]);
    $paring -> execute();

}
?>

<?php
//Komment INSERT
ob_start();
if (isset($_REQUEST["uusKomment"])){
    $paring = $yhendus ->prepare("UPDATE konkurss SET komentaarid = CONCAT(komentaarid,?) WHERE id=?; ");
    $komentLisa = "\n".$_REQUEST["komment"];
    $paring -> bind_param("si", $komentLisa, $_REQUEST["uusKomment"]);
    $paring -> execute();
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}
ob_end_flush();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TARpv23 jõulu konkursid</title>
    <link rel="stylesheet" href="konkurssstyle.css">
</head>
<body>
<h2>Jõulu konkurss</h2>

<nav>
    <ul>
        <?php
        if (isset($_SESSION["useruid"])) {
            if ($_SESSION["role"] == "admin") {
                echo '<li><a href="KonkurssAdmin.php">Admin</a></li>';
            }
            if ($_SESSION["role"] == "kasutaja") {
                echo '<li><a href="KonkurssKasutaja.php">Kasutaja</a></li>';
                echo '<li><a href="konkursInfo.php">Info</a></li>';
            } else {
                echo '<li><a href="konkursInfo.php">Info</a></li>';
            }
            echo '
            <li>
                <form method="POST">
                    <input type="submit" class="submit-btn2" name="logout" value="Logout">
                </form>
            </li>';
        } else {
            echo '<li><a href="konkursInfo.php">Info</a></li>';
            echo '<li><a href="login.php">Login</a></li>';
            echo '<li><a href="signup.php">Registreeri</a></li>';
        }
        ?>
    </ul>
</nav>
<?php

if (isset($_SESSION['useruid'])) {
    echo '<div class="styled-form"><p>Tere tulemast ' . $_SESSION["useruid"] . '</p></div>';
}
else {

}
?>

<br>
<div class="joulukuusk" onclick="changeImage()">
</div>
<table>
    <tr>
        <th>Konkursi nimi</th>
    </tr>
    <?php
    $paring = $yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid FROM konkurss WHERE avalik = 1");
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $komentaarid);
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        $konkursiNimi = htmlspecialchars($konkursiNimi);
        $komentaarid = nl2br(htmlspecialchars($komentaarid));

        echo "<td><a href='?konkurss_id=" . $id . "'>" . $konkursiNimi . "</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<?php
if (isset($_REQUEST["konkurss_id"])) {
    $paring = $yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid FROM konkurss WHERE id = ?");
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $komentaarid);
    $paring->bind_param("i", $_REQUEST["konkurss_id"]);
    $paring->execute();

    if ($paring->fetch()) {
        echo "<div id='sisu' style='border: solid #71797E; padding: 10px;'>";
        echo "<h3></h3>";
        echo "<p><strong>Konkursi nimi: </strong> " . htmlspecialchars($konkursiNimi) . "</p>";
        echo "<p><strong>Lisamis aeg: </strong> " . $lisamisaeg . "</p>";
        echo "<p><strong>Punktid: </strong> " . $punktid . "</p>";
        echo "<p><strong>Komentaarid: </strong><br>" . nl2br(htmlspecialchars($komentaarid)) . "</p>";
        ?>
        <form action="?" method="post">
            <input type="hidden" name="uusKomment" value=<?="$id"?>>
            <input type="text" name="komment" id="komment" class="komentStyle">
            <input type="submit" value="Lisa" class="">
        </form>
        <?php
        echo "<p><a class='button-link' href='?heaKonkurss_id=$id'>+1 punkt</a></p>";
        echo "<p><a class='button-link' href='?halbKonkurss_id=$id'>-1 punkt</a></p>";
        echo "</div>";
    } else {
        echo "<p></p>";
    }
}
?>

</body>
</html>

<?php
ob_end_flush();
$yhendus -> close();?>

<script>
    function changeImage() {
        var image = document.getElementById('image');
        image.src = 'https://i.pinimg.com/originals/5e/16/a0/5e16a022d3d594fae2d4ad61d244cfb9.gif';
    }
</script>
<style>


</style>
