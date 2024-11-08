<?php
echo "<h2>Mõistatus. Euroopa riik</h2>";

$riik = 'Prantsusmaa';
echo "<ol>";
echo "<li>Esimene täht riigis on ".substr($riik,0,1)."</li>";
echo "<li>Riigi nimi koosneb " . str_word_count($riik) . " sõnast.</li>";
echo "<li>Riigi nimi on " . strlen($riik) . " tähte pikk.</li>";
echo "<li>Riik algab tähest '" . substr($riik, 0, 1) . "' ja lõpeb tähtega '" . substr($riik, -1) . "'.</li>";
echo "<li>Riigi nimes on kaks korda täht 'a'.</li>";
echo "<li>Riigi nime keskmine täht on '" . substr($riik, floor(strlen($riik)/2), 1) . "'.</li>";
echo "</ol>";
?>

<form method="post" action="">
    <label for="guess">Sisesta riigi nimi:</label>
    <input type="text" name="guess" id="guess" placeholder="Sisesta riigi nimi">
    <input type="submit" value="Kontrolli">
</form>

<?php

if (isset($_POST['guess'])) {
    $guess = trim($_POST['guess']); // Убираем лишние пробелы
    if (strtolower($guess) === strtolower($riik)) {
        echo "<p>Hea töö! Oled õigesti ära arvanud riigi: <strong>$riik</strong>.</p>";
    } else {
        echo "<p>Vale vastus</p>";
    }
}
?>
<?php
highlight_file('moistatus.php');
?>
