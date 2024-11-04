<?php
echo "Mõistatus. Euroopa riik";
//6 подсказок при помощи текстовых функций
//выводить списком <ul> / <ol>
$riik='Prantsusmaa';
echo "<ol>";
echo "<li>Esimene täht riigis on ".substr($riik,0,1)."</li>";
echo "<li>Riigi nimi koosneb " . str_word_count($riik) . " sõnast.</li>";
echo "<li>Riigi nimi on " . strlen($riik) . " tähte pikk.</li>";
echo "<li>Riik algab tähest '" . substr($riik, 0, 1) . "' ja lõpeb tähtega '" . substr($riik, -1) . "'.</li>";
echo "<li>Riigi nimes on kaks korda täht 'a'.</li>";
echo "<li>Riigi nime keskmine täht on '" . substr($riik, floor(strlen($riik)/2), 1) . "'.</li>";
echo "</ol>";
//str_replace()
