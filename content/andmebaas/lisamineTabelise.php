<?php
//require ('conf.php');
require ('conf2zone_ee.php');


global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"]))
{
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask ->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["loomanimi"]) && !empty($_REQUEST["loomanimi"]))
{
    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, omanik, varv, pilt) VALUES(?, ?, ?, ?)");
    //i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["omanik"], $_REQUEST["varv"], $_REQUEST["pilt"]);
    $paring->execute();
}

//tabeli sisu kuvamine
$paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad");
$paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
$paring->execute();

?>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Loomad andmebaasist</h1>
<table>
    <tr>
        <th></th>
        <th>id</th>
        <th>loomanimi</th>
        <th>omanik</th>
        <th>varv</th>
        <th>loomapilt</th>
    </tr>

<?php

while($paring->fetch())
{
    echo "<tr>";
    echo "<td><a style='color: red' href='?kustuta=$id'>X</a></td>";
    echo"<td>".$id."</td>";
    echo "<td style='color: $varv;'>".htmlspecialchars($loomanimi)."</td>";
    // htmlspecialchars - ei käivita sisestatud koodi <>
    echo "<td>".htmlspecialchars($omanik)."</td>";
    echo "<td>".htmlspecialchars($varv)."</td>";
    echo "<td><img src='$pilt' alt='pilt' width='200px'></td>";
    echo "</tr>";
}
?>
</table>
<!--tabeli lisamisVorm-->
<h2>Uue looma lisamine</h2>
<form action="?" method="post">
    <label for="loomanimi">Loomanimi:</label>
    <input type="text" id="loomanimi" name="loomanimi">
    <br>
    <label for="omanik">Omanik:</label>
    <input type="text" id="omanik" name="omanik">
    <br>
    <label for="varv">Värv:</label>
    <input type="color" id="varv" name="varv">
    <br>
    <label for="pilt">Pilt:</label>
    <textarea id="pilt" name="pilt" cols="30" rows="10">
        sisesta pildi link
    </textarea>
    <br>
    <input type="submit" value="OK">
</form>
</body>
</html>

<?php
$yhendus->close();