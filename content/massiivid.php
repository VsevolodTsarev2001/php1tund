<div id="yl1">
    <h2>Ülesanne 1.</h2>
    <p>Lisa massiivi 15 HTML värvi ja kuva tsükliga span ja color abil:</p>

    <?php
    // 15 HTML värvi massiiv
    $colors = array(
        "Red", "Green", "Blue", "Yellow", "Purple", "Orange", "Pink",
        "Brown", "Black", "White", "Grey", "Violet", "Indigo", "Teal", "Lime"
    );
    ?>
    <br>
    <a>Tsükkel foreach:</a>
    <br>
    <?php
    // Tsükkel iga värvi kuvamiseks(foreach)
    foreach ($colors as $color) {
        echo "<span style='color: $color;'>$color</span><br>";
    }
    ?>
    <br>
    <a>Tsükkel for:</a>
    <br>
    <?php
    // Tsükkel iga värvi kuvamiseks(for)
    for($i = 0; $i < count($colors); $i++) {
        echo "<span style='color: $colors[$i];'>$colors[$i]</span><br>";
        echo "<div style='background-color: $colors[$i]; width: 75%'>$colors[$i]</div>";
    }

    ?>
</div>

<div id="yl2">
    <h2>Ülesanne 2.</h2>
    PHP - massiivid
    <br>

    Autod massiiviandmed võta lehelt -
    https://www.metshein.com/unit/php-massiivid-ulesanne-5/?id=7071
    <br>

    Teosta järgmised protseduurid:
    <br>
    * Kuva kõik autod loeteluga
    <br>
    * leia autode arv (count)
    <br>
    * kontrolli, kas massiviid on ühepikkused
    <br>
    * leia eraldi Toyotade ja Audide arv nimekirjas
    <br>
    * leia ja väljasta VIN koodid,  mille märkide arv on väiksem kui 17


    <?php
    $auto_markid = array(
        "Subaru","BMW","Acura","Mercedes-Benz","Lexus","GMC","Volvo","Toyota","Volkswagen","Volkswagen","GMC","Jeep","Saab","Hyundai","Subaru","Mercedes-Benz",
        "Honda","Kia","Mercedes-Benz","Chevrolet","Chevrolet","Porsche","Buick","Dodge","GMC","Dodge","Nissan","Dodge","Jaguar","Ford","Honda","Toyota","Jeep",
        "Kia","Buick","Chevrolet","Subaru","Chevrolet","Chevrolet","Pontiac","Maybach","Chevrolet","Plymouth","Dodge","Nissan","Porsche","Nissan","Mercedes-Benz",
        "Suzuki","Nissan","Ford","Acura","Volkswagen","Lincoln","Mazda","BMW","Mercury","Mitsubishi","Ram","Audi","Kia","Pontiac","Toyota","Acura","Toyota","Toyota",
        "Chevrolet","Oldsmobile","Acura","Pontiac","Lexus","Chevrolet","Cadillac","GMC","Jeep","Audi","Acura","Acura","Honda","Dodge","Hummer","Chevrolet","BMW",
        "Honda","Lincoln","Hummer","Acura","Buick","BMW","Chevrolet","Cadillac","BMW","Pontiac","Audi","Hummer","Suzuki","Mitsubishi","Jeep","Buick","Ford"
    );

    $vin_number = array(
        "1GKS1GKC8FR966658", "1FTEW1C87AK375821", "1G4GF5E30DF760067", "1FTEW1CW9AF114701", "WAUGGAFC8CN433989", "3G5DA03E83S704506", "4JGDA2EB0DA207570",
        "1FTEW1E88AK070552", "SAJWA0F77F8732763", "JHMFA3F21BS660717", "JTHBP5C29C5750730", "WA1LFAFP9DA963060", "3D7TT2CT6BG521976", "WVWN7EE961049",
        "2C3CA5CG3BH341234", "YV4952CFXC162587", "KNALN4D71F5805172", "JN1CV6EK7BM903692", "5FRYD3H84EB186765", "WAUL64B83N441878", "WDDGF4HBXCF845665",
        "WAUKF78E45A133973", "JN1BY0AR2AM022612", "WA1EY74L69D931520", "3GYFNGEYXBS290465", "1D7CW2GK4AS059336", "JN8AZ1FY5EW087447", "WAUBF78E57A343355",
        "SCFFBCCD8AG695133", "WBAWC73548E143482", "3GYFNGE38DS093883", "SCBCP73WC348460", "JN8AE2KPXE9353316", "2C3CDXDT2EH018229", "1G6AH5SX7D0325662",
        "WVWED7AJ7DW431402", "1FTKR1AD3AP316066", "WBAKF5C52CE612586", "1FTNX2A57AE16083", "WAUCFAFR1AA166821", "SCFFDAAM3EG486065", "1G4PR5SK5F4821043",
        "1C3CDFCB4ED858321", "1N6AD0CW8EN722090", "1NXBU4EE0AZ438077", "2T1BPRHE7FC131594", "JH4KB1637C451183", "1C4NJCBA7ED747024", "WAUHF68P86A736691",
        "3D7TT2HT1AG96429", "5GADX23L96D250838", "5FRYD3H25FB985936", "1G4GG5E30DF126304", "KNADH5A38B6072755", "WAUBFAFL1BA477979", "3C63DRL4CG674293",
        "1G6AR5SX0E0834815", "1NXBU4EE2AZ309838", "WAUKGBFB4AN797783", "JN1AJ0HP8AM801887", "WAUPL68E25A448831", "WA1C8BFP3FA535374", "WAUHE78P78A019744",
        "TRURD38J081400551", "1G4HP52K95428171", "5N1CR2MN1EC607241", "5UMDU93417L322773", "1G6AJ5S35F09585", "JN1CV6AP3BM234743", "SCBCR63W66C842051",
        "SCFFDCBD2AG509467", "WBA3C1C58CA664091", "1D7RW2BK6BS922303", "WAUDH98E67A546009", "2HNYB1H46CH683844", "3VW467AT4DM257275", "WDDGF4HB7CA515172",
        "2G61W5S88E9666199", "5GADV33W17D256205", "2C3CDXDT9CH683075", "2G4GU5X0E9989574", "WAUJC58E53A641651", "WDDEJ7KB3CA053774", "3D73M3CL6AG890452",
        "5GAER13D19J026924", "1G4HC5EM1BU329204", "3VWML7AJ6CM772736", "3C6TD4HT2CG011211", "JTDZN3EU2FJ023675", "JN8AZ1MU4CW041721", "KNAFX5A82F5991024",
        "1N6AA0CJ1D57470", "WAUEG98E76A780908", "WAUAF78E96A920706", "1GT01XEG8FZ268942", "1FTEW1CW4AF371278", "JN1AZ4EH8DM531691", "WAUEKAFBXAN294295",
        "1N6AA0EDXFN868772", "WBADW3C59DJ422810"
    );
    echo "<h2>Kõik autod:</h2>";
echo "<ol>";
for($i = 0; $i < count($auto_markid); $i++) {
    echo "<li><p>$auto_markid[$i]</p></li>";
}
echo "</ol>";
echo "<br>";
echo "<h2>leia autode arv (count)</h2>";
echo "Autode arv: ".count($auto_markid)."tk";
echo "<br>";
echo "<h2>Kontrolli, kas massiviid on ühepikkused</h2>";
if (count($auto_markid) == count($vin_number)) {
    echo "Massiivid on ühepikulised";
    }
    else{
        echo "Massiivid ei ole ühepikulised";
}
    echo "<br>";
    echo "<h2>leia eraldi Toyotade ja Audide arv nimekirjas</h2>";
    $audiArv = 0;
    $toyotaArv = 0;
    for ($j = 0; $j < count($auto_markid); $j++) {
        if ("Toyota" == $auto_markid[$j]) {
            $toyotaArv++;
        }
        if ("Audi" == $auto_markid[$j]) {
            $audiArv++;
        }
    }
    echo "Toyotade arv: ". $toyotaArv. "<br>";
    echo "Audide arv: ". $audiArv. "<br>";
    echo "<h2>leia ja väljasta VIN koodid,  mille märkide arv on väiksem kui 17 </h2>";
    for ($l = 0; $l < count($vin_number); $l++) {
        if (strlen($vin_number[$l]) < 17) {
            echo $auto_markid[$l] . " - " . $vin_number[$l] . "<br>";
        }
    }
    ?>
    <div id="yl3">
        <h2>Ülesanne 3</h2>
        Kuva img kaustast kõik pildid width=100px.
        <?php
        $asukoht = opendir('content/img');
        $pildidArray = array();
        while($rida = readdir($asukoht)) {
            if($rida != "." && $rida != "..") {
                array_push($pildidArray, $rida);
            }
        }
        echo "<br>";
        for ($n = 0; $n < count($pildidArray); $n++) {
            echo "<img src='content/img/$pildidArray[$n]' width='100px'>";
        }
?>


