<?php
// Kontrollime, kas 'code' parameeter on URL-is olemas, et kuvada faili kood
if (isset($_GET['code'])) {
    die(highlight_file(__FILE__, 1)); // Kui 'code' on olemas, kuvame faili kood ja lõpetame töötlemise
}

// Laadime XML faili, kus on õpilaste andmed
$ruhm = simplexml_load_file("TARpv23.xml");

// Otsingu funktsioon (nime järgi)
function otsingNimeJargi($paring) {
    global $ruhm;
    $paringVastus = array();

    // Läbime kõik õpilased XML failist
    foreach ($ruhm->opilane as $opilane) {
        // Kui õpilase nimi sisaldab otsingusõna, siis lisame selle tulemusse
        if (stripos($opilane->nimi, $paring) !== false) {
            array_push($paringVastus, $opilane);
        }
    }

    return $paringVastus;
}

// Funktsioon uue õpilase lisamiseks XML faili
function lisaOpilane($nimi, $perekonnanimi, $vanus, $silmade_varv, $hobbi, $koduleht, $gender) {
    global $ruhm;

    $uusOpilane = $ruhm->addChild('opilane');
    $uusOpilane->addChild('nimi', $nimi);
    $uusOpilane->addChild('perekonnanimi', $perekonnanimi);
    $uusOpilane->addChild('vanus', $vanus);
    $uusOpilane->addChild('silmade_varv', $silmade_varv);
    $uusOpilane->addChild('hobbi', $hobbi);
    $uusOpilane->addChild('koduleht', $koduleht);
    $uusOpilane->addChild('gender', $gender);

    // Salvestame muudatused XML faili
    $ruhm->asXML('TARpv23.xml');
}

// HTML lehe algus
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rühma andmed XML failist</title>
    <link rel="stylesheet" href="ruhmstyle.css"> <!-- Lingime välise CSS faili -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"> </script>
    <script>
        $(document).ready(function() {
            // Funktsioon paneeli avamiseks/sulgemiseks klõpsamisel elemendil klassiga "flip"

            $("#flip").click(function () {
                $(this).next("#panel").slideToggle("slow"); // Avab/sulgeb järgmise elemendi klassiga "panel"
            });
        });
    </script>
</head>
<body>

<h2>Rühma õpilaste andmed</h2>

<!-- Näitame kõiki õpilasi ringidena -->
<div id="ringad">
    <?php
    // Läbime kõik õpilased ja kuvame nende nimed lingina
    foreach ($ruhm->opilane as $opilan) {
        $nimi = $opilan->nimi;
        $koduleht = $opilan->koduleht;
        $gender = $opilan->gender;

        $color = ($gender == "Male") ? "#009ede" : "#ff36d1";

        echo "<div id='circle' style='background-color: $color'>";
        echo "<a href='$koduleht' target='_blank'>$nimi</a>";
        echo "</div><br><br>";
    }
    ?>
</div>

<!-- Otsingu vorm -->
<form method="post" action="?">
    <label for="otsing">Otsing nime järgi:</label>
    <input type="text" id="otsing" name="otsing" placeholder="Õpilase nimi"> <!-- Nime otsingu input -->
    <input type="submit" value="Otsi"> <!-- Otsingu nupp -->
</form>

<!-- Kui otsingutulemus on olemas, kuvame selle -->
<?php
if (!empty($_POST['otsing'])) {
    $paringVastus = otsingNimeJargi($_POST['otsing']); // Otsime õpilaste nimed vastavalt sisestusele
    if (count($paringVastus) > 0) {
        echo "<table>";
        echo "<tr><th>Nimi</th><th>Perekonnanimi</th><th>Vanus</th><th>Silmade värv</th><th>Hobid</th><th>Koduleht</th></tr>";

        // Läbime leitud õpilased ja kuvame nende andmed tabelis
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
    else {
        echo "<p>Otsingutulemust ei leitud.</p>"; // Kui ei leita ühtegi õpilast
    }
}
else {
    // Kui otsingut ei ole tehtud, kuvame kõik õpilased
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Perekonnanimi</th><th>Vanus</th><th>Silmade värv</th><th>Hobid</th><th>Koduleht</th></tr>";

    // Läbime kõik õpilased ja kuvame nende andmed tabelis
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
<!-- Lisamise vorm -->
<div id="flip">lisamine uus õpilane</div>
<div id="panel">
    <h3>Lisa uus õpilane</h3>
    <form method="post" action="">
        <!-- Väli õpilase info sisestamiseks -->
        <label for="nimi">Nimi:</label>
        <input type="text" id="nimi" name="nimi" required><br><br>

        <label for="perekonnanimi">Perekonnanimi:</label>
        <input type="text" id="perekonnanimi" name="perekonnanimi" required><br><br>

        <label for="vanus">Vanus:</label>
        <input type="number" id="vanus" name="vanus" min="1" required><br><br>

        <!-- Выпадающий список для выбора цвета глаз -->
        <label for="silmade_varv">Silmade värv:</label>
        <select id="silmade_varv" name="silmade_varv" required>
            <option value="Sinine">Sinine</option>
            <option value="Roheline">Roheline</option>
            <option value="Pruun">Pruun</option>
            <option value="Hall">Hall</option>
            <option value="Must">Must</option>
        </select><br><br>

        <label for="hobbi">Hobid:</label>
        <input type="text" id="hobbi" name="hobbi" required><br><br>

        <label for="koduleht">Koduleht:</label>
        <input type="url" id="koduleht" name="koduleht" required><br><br>

        <label>Gender:</label><br>
        <input type="radio" id="male" name="gender" value="Male" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female" required>
        <label for="female">Female</label><br><br>

        <input type="submit" value="Lisa õpilane">
    </form>

</div>

<?php
// Kui vorm on esitatud, lisame õpilase
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nimi'])) {
    // Väljade kontroll ja uue õpilase lisamine
    $nimi = trim($_POST['nimi']);
    $perekonnanimi = trim($_POST['perekonnanimi']);
    $vanus = trim($_POST['vanus']);
    $silmade_varv = trim($_POST['silmade_varv']);
    $hobbi = trim($_POST['hobbi']);
    $koduleht = trim($_POST['koduleht']);
    $gender = $_POST['gender'];

    // Kontrollime, kas kõik väljad on täidetud
    if (!empty($nimi) && !empty($perekonnanimi) && !empty($vanus) && !empty($silmade_varv) && !empty($hobbi) && !empty($koduleht) && !empty($gender)) {
        // Kui kõik on täidetud, lisame uue õpilase
        lisaOpilane($nimi, $perekonnanimi, $vanus, $silmade_varv, $hobbi, $koduleht, $gender);
        echo "<p>Õpilane lisatud edukalt!</p>";
    } else {
        echo "<p>Kõik väljad on kohustuslikud!</p>";
    }
}
?>

</body>
</html>
