<?php
require_once ('conf.php');
global $yhendus;

//konkurssi kustutamine
if(isset($_REQUEST["kustuta"]))
{
    $kask=$yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $kask ->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

//konkurssi lisamine
if(!empty($_REQUEST["uusKonkurss"])) {
    $paring =$yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisaeg) 
VALUES (?,NOW())");
    $paring->bind_param("s", $_REQUEST["uusKonkurss"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

//Kommeentaaride lisamine
if(isset($_REQUEST["uusKomment"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET kommentaarid=CONCAT(kommentaarid,?) WHERE id=?");
    $kommentLisa="\n".$_REQUEST["komment"];
    $paring->bind_param("si",$kommentLisa,$_REQUEST["uusKomment"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

// tabeli uuendamine +1 punkt
if(isset($_REQUEST["heakonkurss_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET punktid=punktid+1
WHERE id=?;");
    $paring->bind_param('i',$_REQUEST["heakonkurss_id"]);
    $paring->execute();
}

// tabeli uuendamine -1 punkt
if(isset($_REQUEST["halbkonkurss_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET punktid=punktid-1
WHERE id=?;");
    $paring->bind_param('i',$_REQUEST["halbkonkurss_id"]);
    $paring->execute();
}

?>
<!Doctype html>
<html>
<head>
    <link rel="stylesheet" href="konkurssstyle.css">
    <title>TARpv23 jõulu konkursid</title>
</head>
<body>
<h1>TARpv23 jõulu konkursid</h1>
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
        <th>konkursiNimi</th>
        <th>Lisamisaeg</th>
        <th>Punktid</th>
        <th>Kommentaarid</th>
        <th colspan="4">Haldus</th>
    </tr>
    <?php
    //tabeli sisu kuvamine
    $paring=$yhendus->prepare("SELECT id, konkursiNimi, Lisamisaeg, punktid, kommentaarid FROM konkurss WHERE avalik=1");
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

        </td>
        <?php
        echo "<td><a href='?heakonkurss_id=$id' class='button'>Lisa +1 punkt</a></td>";
        echo "<td><a href='?halbkonkurss_id=$id' class='button-small'>Lisa -1 punkt</a></td>";
        echo "<td><a href='?kustuta=$id'>Kustutamine</a></td>";
        echo "</tr>";
    }
    ?>

</table>
</body>
</html>
<?php
$yhendus->close();
?>