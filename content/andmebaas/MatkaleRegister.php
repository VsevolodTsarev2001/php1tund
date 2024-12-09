<?php
//require ('conf.php');
require ('conf2zone_ee.php');

global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"]))
{
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask ->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"]))
{
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg) VALUES(?, ?, ?, ?)");
    //i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]);
    $paring->execute();
}

//tabeli sisu kuvamine
$paring=$yhendus->prepare("SELECT id, nimi, telefon, pilt,synniaeg FROM osalejad");
$paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
$paring->execute();

?>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Matka Andmebaasit</h1>
<table>
    <tr>
        <th></th>
        <th>id</th>
        <th>nimi</th>
        <th>telefon</th>
        <th>pilt</th>
        <th>synniaeg</th>
        <th>vanus</th>
    </tr>

<?php

while($paring->fetch()){
    $vanus = date_diff(date_create($synniaeg), date_create('today'))->y;
    echo "<tr>";
    echo "<td><a style='color: red' href='?kustuta=$id'>X</a></td>";
    echo"<td>".$id."</td>";
    echo "<td>".htmlspecialchars($nimi)."</td>";
    // htmlspecialchars - ei käivita sisestatud koodi <>
    echo "<td>".htmlspecialchars($telefon)."</td>";
    echo "<td><img src='$pilt' alt='pilt'width='200px'></td>";
    echo "<td>".htmlspecialchars($synniaeg)."</td>";
    echo "<td>".$vanus."</td>";
    echo "</tr>";
}
?>
</table>
<!--tabeli lisamisVorm-->
<h2>Uue looma lisamine</h2>
<form action="?" method="post">
    <label for="nimi">Nimi:</label>
    <input type="text" id="nimi" name="nimi">
    <br>
    <label for="telefon">Telefon:</label>
    <input type="text" id="telefon" name="telefon">
    <br>
    <label for="pilt">Pilt:</label>
    <textarea id="pilt" name="pilt" cols="30" rows="10">
           sisesta pildi link
    </textarea>
    <br>
    <label for="synniaeg">Süüniaeg:</label>
    <input type="date" id="synniaeg" name="synniaeg">
    <br>
    <input type="submit" value="OK">
</form>
<footer>
    <?php
    echo "Vsevolod Tsarev &copy; ";
    echo date("Y");
    ?>
    <a href="https://vsevolodtsarev23.thkit.ee/wp/php-mysql-andmebaasiga-sidumine/">konspekt wordpress'is</a>
</footer>
</body>
</html>

<?php
$yhendus->close();