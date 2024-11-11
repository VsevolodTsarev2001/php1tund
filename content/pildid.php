<h2>Töö pildifailidega</h2>
<!-- Link ülesande juurde -->
<a href="https://www.metshein.com/unit/php-pildifailidega-ulesanne-14/">PHP – Töö pildifailidega</a>

<!-- Vorm pildi valimiseks -->
<form method="post" action="">
    <select name="pildid"> <!-- Rippmenüü, kus saab valida pildi -->
        <option value="">Vali pilt</option>
        <?php
        // Määrame kausta, kus pildid asuvad
        $kataloog = 'content/img';

        // Kontrollime, kas kaust eksisteerib
        if (is_dir($kataloog)) {
            // Avame kausta lugemiseks
            $asukoht = opendir($kataloog);

            // Lugege kõiki faile kaustas
            while (($rida = readdir($asukoht)) !== false) {
                // Välistame eraldi failid "." ja ".."
                if ($rida != '.' && $rida != '..') {
                    // Kuvame iga pildi nime valiku nimekirjas
                    echo "<option value='$rida'>$rida</option>\n";
                }
            }
            // Sulgeme kausta lugemiseks
            closedir($asukoht);
        } else {
            // Kui kausta ei leita, siis kuvatakse teadet
            echo "<option disabled>Kaust ei leitud!</option>";
        }
        ?>
    </select>
    <!-- Nupp, et vorm saata -->
    <input type="submit" value="Vaata">
</form>

<?php
// Kui vorm on saadetud ja pilt on valitud
if (!empty($_POST['pildid'])) {
    // Saame valitud pildi nime
    $pilt = $_POST['pildid'];
    // Määrame pildi täpse aadressi
    $pildi_aadress = 'content/img/'. $pilt;

    // Kontrollime, kas pilt eksisteerib
    if (file_exists($pildi_aadress)) {
        // Kui pilt eksisteerib, siis saame pildi omadused (suurus, formaat jne)
        $pildi_andmed = getimagesize($pildi_aadress);

        // Pildi laiuse ja kõrguse väärtused
        $laius = $pildi_andmed[0];
        $korgus = $pildi_andmed[1];
        $formaat = $pildi_andmed[2];

        // Maksimaalsed mõõdud, kuhu pilt mahub
        $max_laius = 120;
        $max_korgus = 90;

        // Arvutame mõõtude suhte (skalatsioon)
        if ($laius <= $max_laius && $korgus <= $max_korgus) {
            // Kui pilt on juba piisavalt väike, siis ei muudeta mõõtmeid
            $ratio = 1;
        } elseif ($laius > $korgus) {
            // Kui pilt on laiem, siis piiratakse laius
            $ratio = $max_laius / $laius;
        } else {
            // Kui pilt on kõrgem, siis piiratakse kõrgus
            $ratio = $max_korgus / $korgus;
        }

        // Arvutame uus suurus
        $pisi_laius = round($laius * $ratio);
        $pisi_korgus = round($korgus * $ratio);

        // Kuvame originaalpildi omadused
        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $laius px<br>";
        echo "Kõrgus: $korgus px<br>";
        echo "Formaat: " . ($formaat == 1 ? 'GIF' : ($formaat == 2 ? 'JPG' : ($formaat == 3 ? 'PNG' : 'Tundmatu'))) . "<br>";

        // Kuvame muudetud pildi omadused ja väikese pildi
        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutatud suhe: $ratio <br>";
        echo "Laius: $pisi_laius px<br>";
        echo "Kõrgus: $pisi_korgus px<br>";
        echo "<img width='$pisi_laius' height='$pisi_korgus' src='$pildi_aadress' alt='Pisipilt'><br>";
    } else {
        // Kui faili ei leitud, siis kuvatakse veateade
        echo '<p style="color: DarkRed;">Valitud faili ei leitud!</p>';
    }
}
?>

<h2>Ülesanne 14. Suvaline pilt – koosta kood, mis valib kataloogist suvalise pildi</h2>

<?php
// Funktsioon, mis valib suvalise pildi kataloogist
function getRandomImage($dir) {
    // Loeme kõik failid kataloogis ja välistame "." ja ".."
    $files = array_diff(scandir($dir), array('.', '..'));
    // Filtreerime ainult pildifailid (JPG, PNG, GIF)
    $images = array_filter($files, function($file) use ($dir) {
        $filePath = $dir . '/' . $file;
        return is_file($filePath) && in_array(mime_content_type($filePath), ['image/jpeg', 'image/png', 'image/gif']);
    });

    // Vali suvaline pilt massiivist
    $randomImage = array_rand($images);
    // Tagasta suvalise pildi täpne aadress
    return $dir . '/' . $images[$randomImage];
}

// Kui kasutaja on nuppu vajutanud, siis valime suvalise pildi
if (isset($_POST['random_image'])) {
    // Valime suvalise pildi kataloogist
    $randomImage = getRandomImage('content/img');
    // Kuvame suvalise pildi
    echo "<h3>Suvaline pilt:</h3>";
    echo "<img src='$randomImage' alt='Suvaline pilt' style='max-width: 500px;'><br>";
}
?>

<!-- Nuup "Näita suvaline pilt", mis toob suvalise pildi -->
<form method="post" action="">
    <input type="submit" name="random_image" value="Näita suvaline pilt">
</form>

<h2>Pisipildid veergudes (3 veergu)</h2>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
    <?php
    // Loeme kõik pildid kataloogist
    $kataloog = 'content/img';
    if (is_dir($kataloog)) {
        // Avame kausta lugemiseks
        $asukoht = opendir($kataloog);
        $images = [];
        while (($rida = readdir($asukoht)) !== false) {
            // Välistame eraldi failid "." ja ".."
            if ($rida != '.' && $rida != '..') {
                // Lisame kõik pildid massiivi
                $images[] = $rida;
            }
        }
        // Sulgeme kausta lugemiseks
        closedir($asukoht);

        // Kuvame pildid 3 veerus
        $max_width = 120;  // Maksimaalne laius pisipildil
        $max_height = 90;  // Maksimaalne kõrgus pisipildil
        foreach ($images as $image) {
            // Iga pildi täpne aadress
            $imagePath = 'content/img/'.$image;
            // Saame pildi mõõdud
            $imageSize = getimagesize($imagePath);
            $width = $imageSize[0];
            $height = $imageSize[1];

            // Arvutame miniatuuri suuruse, et see sobiks veergu
            $ratio = min($max_width / $width, $max_height / $height);
            $thumbWidth = round($width * $ratio);
            $thumbHeight = round($height * $ratio);

            // Kuvame pisipildi koos lingiga, mis avab täissuuruses pildi
            echo "<div style='flex: 1 0 calc(33.33% - 10px); text-align: center;'>";
            echo "<a href='$imagePath' target='_blank'>";
            echo "<img src='$imagePath' alt='$image' width='$thumbWidth' height='$thumbHeight' style='cursor: pointer;'>";
            echo "</a>";
            echo "</div>";
        }
    }
    ?>
</div>
