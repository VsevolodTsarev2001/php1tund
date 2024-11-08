<?php
echo "<h2>Ajafunktsioonid</h2>";
echo "<div id='kuupaev'>";
echo "Täna on ".date("d.m.Y")."<br>";
date_default_timezone_set("Europe/Tallinn"); //mm.dd.yyyy h;mm
echo "<strong>";
echo "Tänane Tallinna kuupäev ja kellaaeg on ". date("d.m.Y G:i", time())."<br>";
echo "</strong>";
echo "date('d.m.Y G:i', time());";
echo "<br>";
echo "d - kuupäev 1-31";
echo "<br>";
echo "m - kuu numbrina 1-12";
echo "<br>";
echo "Y - aasta neljakohane";
echo "<br>";
echo "G - tunniformaat 0-23";
echo "<br>";
echo "i - minutid 0-59";
echo "</div>";
?>
<div id="hooaeg">
    <h2>Väljasta vastavalt hooajale pilt(kevad/suvi/sügis/talv)</h2>

<?php
$today=new DateTime();
echo "Täna on ".$today->format('m-d.Y');
//hooaja punktid - сезон
$spring = new DateTime('March 20');
$summer = new DateTime('June 21');
$autumn = new DateTime('September 22');
$winter = new DateTime('December 23');
echo "<br>";
switch(true){
    //kevad
    case $today>=$spring && $today<=$summer:
        echo "Kevad";
        echo "<div style='margin: 10px 0 0 0;'>";
        $pildi_aadress='content/img/kevad.jpg';
        echo "</div>";
        break;


        //suvi
    case $today>=$summer && $today<=$autumn:
        echo "Suvi";
        echo "<div style='margin: 10px 0 0 0;'>";
        $pildi_aadress='content/img/suvi.jpg';
        echo "</div>";
        break;
        //Sügis
    case $today>=$autumn && $today<=$winter:
        echo "Sügis";
        echo "<div style='margin: 10px 0 0 0;'>";
        $pildi_aadress='content/img/sugis.jpg';
        echo "</div>";
        break;
        //talv
    case $today>=$winter && $today<=$spring:
        echo "Talv";
        echo "<div style='margin: 10px 0 0 0;'>";
        $pildi_aadress='content/img/talv.jpg';
        echo "</div>";
        break;
}
?>
    <img src="<?=$pildi_aadress?>" alt='hooaja pilt' width="450px">
</div>
<div id="koolivaheaeg">
    <h2>Mitu päeva on koolivaheajani 23.12.2024</h2>
    <?php
    $kdate=date_create_from_format('d.m. Y', '23.12.2024');
    $date=date_create();
    $diff=date_diff($kdate,$date);
    echo "jääb ".$diff->format("%a")." päeva";
    echo "<br>";
    echo "jääb ".$diff->days." päeva"
    ?>
</div>
<div id="minuSünnipäev">
    <h2>Mitu päeva on minu sünnipäevani 11.09.2025</h2>
    <?php
    $ldate=date_create_from_format('d.m. Y', '11.09.2025');
    $date=date_create();
    $diff=date_diff($ldate,$date);
    echo "Jääb ".$diff->format("%a")." päeva";
    echo "<br>";
    echo "Jääb ".$diff->days." päeva"
    ?>
</div>
<div id="vanus">
    <h2>Kasutaja vanuse leidmine</h2>
    <form method="post" action="">
        Sisesta oma sünnikuupäev
        <input type="date" name="synd" placeholder="dd.mm.yyyy">
        <input type="submit" value="OK">
    </form>
    <?php
    if (isset($_REQUEST["synd"])){
        if(empty ($_REQUEST["synd"])){

            echo "sisesta oma Sünnipäeva kuupäev";
        }
        else{
            $sdate=date_create($_REQUEST["synd"]);
            $date=date_create();
            $interval=date_diff($sdate,$date);
            echo "Sa oled ".$interval->format("%y")." aastat vana";
        }
    }
    ?>
</div>
<div>
    <h2>Massivi abil näidata kuu nimega tänases kuupäevas.</h2>
    <?php

    $kuud=array(1=>"jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember");
    $paev=date('d');
    $year=date('Y');
    $kuu=$kuud[date('n')];
    echo "Praegu on ".$paev.".".$kuu.".".$year;
    ?>
</div>