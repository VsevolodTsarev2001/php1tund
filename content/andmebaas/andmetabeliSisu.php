<?php
require ('conf.php');
//require ('conf2zone_ee.php');

//tabeli sisu kuvamine
global $yhendus;
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
        <th>id</th>
        <th>loomanimi</th>
        <th>omanik</th>
        <th>varv</th>
        <th>loomapilt</th>
    </tr>

<?php

while($paring->fetch()){
    echo "<tr>";
    echo"<td>".$id."</td>";
    echo "<td style='color: $varv;'>".htmlspecialchars($loomanimi)."</td>";
    // htmlspecialchars - ei käivita sisestatud koodi <>
    echo "<td>".htmlspecialchars($omanik)."</td>";
    echo "<td>".htmlspecialchars($varv)."</td>";
    echo "<td><img src='$pilt' alt='pilt'width='200px'></td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>

<?php
$yhendus->close();