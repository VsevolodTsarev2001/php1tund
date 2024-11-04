<?php
echo "Tere hommikust!";
echo "<br>";
$muutuja='PHP on skriptikeel';
echo "<strong>";
echo $muutuja;
echo "</strong>";
echo "<br>";
// Tekstifunktsioonid
echo "<h2>Tekstifunktsiioonid</h2>";
$tekst='Esmaspäev on 4.november';
echo $tekst;
//Kõik tähed on suured
echo "<br>";
echo strtoupper($tekst);//ei tunne ä täht
echo "<br>";
echo mb_strtoupper($tekst);//tunneb ä
//Kõik tähed on väikised
echo "<br>";
echo strtolower($tekst);
//Iga sõna algab suure tähega
echo "<br>";
echo ucwords($tekst);
//teksti pikkus
echo "<br>";
echo "Teksti pikkus - ".strlen($tekst);

//eraldame esimesed 5 tähte
echo "<br>";
echo "Esimesed 5 tähte - ".substr($tekst,0,5);
//leiame on positsiooni
echo "<br>";
$otsing='on';
echo "On asukoht lauses on ".strpos($tekst,$otsing);
// eralda esimene sõna kuni $otsing
echo "<br>";
echo substr($tekst,0,strpos($tekst,$otsing));
//eralda peale esimest sõna, alates 'on'
echo "<br>";
echo substr($tekst,strpos($tekst,$otsing));
echo "<h2>Kasutame veebis kasutavaid näidised</h2>";
//
//sõnade arv lauses
echo "sõnade arv lauses - ".str_word_count($tekst);
// iseseisvalt - teksti kärpimine
echo "<br>";
$tekst2 = '    Põhitoetus võetakse ära 11.11 kui võlgneva   ';
echo "<pre>$tekst2</pre>";
echo "<pre>".trim($tekst2)."</pre>";
echo "<pre>".ltrim($tekst2)."</pre>";
echo "<pre>".rtrim($tekst2)."</pre>";

//Teksti kärpimine
echo "<br>";
echo trim($tekst2, "P, t..k");	//oman should soften but not weake

//Tekst kui massiiv