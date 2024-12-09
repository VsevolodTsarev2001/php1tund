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
if(isset($_REQUEST["uusloom"]) && !empty($_REQUEST["loomanimi"]))
{
    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, omanik, varv, pilt) VALUES(?, ?, ?, ?)");
    //i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["omanik"], $_REQUEST["varv"], $_REQUEST["pilt"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Loomad 1 kaupa</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<h1>Loomad 1 kaupa</h1>
<div id="meny">
<ul>
    <?php
    // loomade nimed andmebaasist
    $paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad");
    $paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
    $paring->execute();

    while($paring->fetch()){


        echo "<li><a href='?looma_id=$id'>".$loomanimi."</a></li>";
    }
    ?>
</ul>
    <?PHP
    echo "<a href='?lisamine=jah='>LISA loom...</a>"

    ?>

</div>
<div id="sisu"></div>
<?php
//kui klick looma nimele, siis näitame looma info
if(isset($_REQUEST["looma_id"])){
    $paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad WHERE id = ?");
    $paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
    $paring->bind_param("i", $_REQUEST["looma_id"]);
    $paring->execute();
    //näitame ühe kaupa
    if($paring->fetch()){
        echo "<div> Loomanimi: ".$loomanimi;
        echo "<br>Tõug: ".$varv;
        echo "<br><img src='$pilt'width='100px' alt='pilt'>";
        echo "<br>Omanik: ".$omanik;
        echo "<br><a style='color: red' href='?kustuta=$id'>X</a>";
        echo "</div>";

    }
}
?>
<?PHP
//lisamisvorm, mis avatakse kui vajutatud lisa...
if (isset($_REQUEST["lisamine"]))
{
    ?>
    <form action="?" method="post">
        <input type="hidden" value="jah" name="uusloom">
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

<?php
}
?>
</body>
</html>