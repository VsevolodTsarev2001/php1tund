<?php
require ('conf.php');
//require ('conf2zone_ee.php');

global $yhendus;

//kustutamine
if(isset($_REQUEST["kustuta"]))
{
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask ->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["uusnimi"]) && !empty($_REQUEST["nimi"]))
{
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg) VALUES(?, ?, ?, ?)");
    //i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Matkajad 1 kaupa</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
<h1>Matkajad 1 kaupa</h1>
<div id="meny">
    <ul>
    <?php
    //tabeli sisu kuvamine
    $paring=$yhendus->prepare("SELECT id, nimi, telefon, pilt,synniaeg FROM osalejad");
    $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
    $paring->execute();

    while($paring->fetch()){


        echo "<li><a href='?inimene_id=$id'> <img src='$pilt' width='100px' alt='pilt'>"."</a></li>";
    }
    ?>
    </ul>
    <?PHP
    echo "<a href='?lisamine=jah='>LISA inimene...</a>"

    ?>

</div>
<div id="sisu">
<?php
//kui klick looma nimele, siis näitame looma info
if(isset($_REQUEST["inimene_id"])){
    $paring=$yhendus->prepare("SELECT id, nimi, telefon, pilt,synniaeg FROM osalejad WHERE id=?");
    $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
    $paring->bind_param("i", $_REQUEST["inimene_id"]);
    $paring->execute();
    //näitame ühe kaupa
    if($paring->fetch()){
        $vanus = date_diff(date_create($synniaeg), date_create('today'))->y;
        echo "<div> Nimi: ".htmlspecialchars($nimi);
        echo "<br>Telefon: ".htmlspecialchars($telefon);
        echo "<br><img src='$pilt'width='100px' alt='pilt'>";
        echo "<br>Sünniaeg: ".htmlspecialchars($synniaeg);
        echo "<br>Vanus: ".$vanus."</br>";
        echo "<br><a style='color: red' href='?kustuta=$id'>X</a>";
        echo "</div>";
    }
}
?>
</div>
<?PHP
//lisamisvorm, mis avatakse kui vajutatud lisa...
if (isset($_REQUEST["lisamine"]))
{
    ?>
    <form action="?" method="post">
        <input type="hidden" value="jah" name="uusnimi">
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


    <?php
}
?>
<footer>
    <?php
    echo "Vsevolod Tsarev &copy; ";
    echo date("Y");
    ?>
    <a href="https://vsevolodtsarev23.thkit.ee/wp/php-mysql-andmebaasiga-sidumine/">konspekt wordpress'is</a>
</footer>
</body>
</html>