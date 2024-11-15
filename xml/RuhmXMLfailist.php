<?php
// Laadime XML faili
$ruhm = simplexml_load_file("TARpv23.xml");

// Otsingu funktsioon (nimi järgi)
function otsingNimeJargi($paring) {
    global $ruhm;
    $paringVastus = array();
    foreach ($ruhm->opilane as $opilane) {
        if (stripos($opilane->nimi, $paring) !== false) {
            array_push($paringVastus, $opilane);
        }
    }
    return $paringVastus;
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rühma andmed XML failist</title>
    <link rel="stylesheet" href="ruhmstyle.css">
</head>
<body>
<h2>Rühma õpilaste andmed</h2>

<!-- Otsing -->
<form method="post" action="?">
    <label for="otsing">Otsing nime järgi:</label>
    <input type="text" id="otsing" name="otsing" placeholder="Õpilase nimi">
    <input type="submit" value="Otsi">
</form>

<br>

<?php
// Kui otsing on tehtud, kuvame tulemused
if (!empty($_POST['otsing'])) {
    $paringVastus = otsingNimeJargi($_POST['otsing']);
    if (count($paringVastus) > 0) {
        echo "<table>";
        echo "<tr><th>Nimi</th><th>Perekonnanimi</th><th>Vanus</th><th>Silmade värv</th><th>Hobid</th><th>Koduleht</th></tr>";
        foreach ($paringVastus as $opilane) {
            echo "<tr>";
            echo "<td>" . $opilane->nimi . "</td>";
            echo "<td>" . $opilane->perekonnanimi . "</td>";
            echo "<td>" . $opilane->vanus . "</td>";
            echo "<td>" . $opilane->silmade_varv . "</td>";
            echo "<td>" . $opilane->hobbi . "</td>";
            echo "<td><a href='http://" . $opilane->koduleht . "' target='_blank'>" . $opilane->koduleht . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "<p>Otsingutulemust ei leitud.</p>";
    }
}
else
{
    // Kuvame kõik õpilased, kui otsingut ei ole tehtud
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Perekonnanimi</th><th>Vanus</th><th>Silmade värv</th><th>Hobid</th><th>Koduleht</th></tr>";
    foreach ($ruhm->opilane as $opilane) {
        echo "<tr>";
        echo "<td>" . $opilane->nimi . "</td>";
        echo "<td>" . $opilane->perekonnanimi . "</td>";
        echo "<td>" . $opilane->vanus . "</td>";
        echo "<td>" . $opilane->silmade_varv . "</td>";
        echo "<td>" . $opilane->hobbi . "</td>";
        echo "<td><a href='http://" . $opilane->koduleht . "' target='_blank'>" . $opilane->koduleht . "</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>
