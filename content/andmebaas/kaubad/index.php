<?php
require_once ('conf2zone_ee.php');
require("abifunktsioonid.php");


// Обработка добавления группы
if(isset($_REQUEST["grupilisamine"])) {
    if(!empty($_REQUEST["uuegrupinimi"])) {
        $grupinimi = $_REQUEST["uuegrupinimi"];
        $grupid = kysiGruppideAndmed();
        $grupinimiEksisteerib = false;

        foreach ($grupid as $grupp) {
            if ($grupp->grupinimi === $grupinimi) {
                $grupinimiEksisteerib = true;
                break;
            }
        }

        if (!$grupinimiEksisteerib) {
            lisaGrupp($grupinimi);
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Grupp nimega '$grupinimi' eksisteerib juba.";
        }
    }
}

// Обработка добавления товара
if(isset($_REQUEST["kaubalisamine"])) {
    if(!empty($_REQUEST["nimetus"]) && !empty($_REQUEST["hind"])) {
        lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Kauba nimi ja hind ei tohi olla tühjad.";
    }
}

// Обработка удаления товара
if(isset($_REQUEST["kustutusid"])) {
    kustutaKaup($_REQUEST["kustutusid"]);
}

// Обработка изменения товара
if(isset($_REQUEST["muutmine"])) {
    if(!empty($_REQUEST["nimetus"]) && !empty($_REQUEST["hind"])) {
        muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
        header("Location: index.php");
        exit();
    }
}

// Получаем товары и группы с учетом сортировки
$otsisona = isset($_REQUEST["otsisona"]) ? $_REQUEST["otsisona"] : '';
$sorttulp = isset($_REQUEST["sorttulp"]) ? $_REQUEST["sorttulp"] : 'nimetus';
$kaubad = kysiKaupadeAndmed($sorttulp, $otsisona);
$grupid = kysiGruppideAndmed();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaupade haldus</title>
    <link rel="stylesheet" href="kaub.css">
</head>
<body>

<!-- Отображаем сообщение об ошибке -->
<?php if(isset($error_message)): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
<?php endif; ?>

<h1>Kaupade haldus</h1>

<!-- Форма добавления товара -->
<form action="index.php" method="get">
    <h2>Kauba lisamine</h2>
    <label for="nimetus">Nimetus:</label>
    <input type="text" name="nimetus" required>

    <label for="kaubagrupi_id">Kaubagrupp:</label>
    <?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id"); ?>

    <label for="hind">Hind:</label>
    <input type="text" name="hind" required>

    <input type="submit" name="kaubalisamine" value="Lisa kaup">
</form>

<!-- Форма добавления группы -->
<form action="index.php" method="get">
    <h2>Kaubagruppi lisamine</h2>
    <label for="uuegrupinimi">Uus grupinimi:</label>
    <input type="text" name="uuegrupinimi" required>
    <input type="submit" name="grupilisamine" value="Lisa grupp">
</form>

<!-- Форма поиска и сортировки -->
<form action="index.php" method="get">
    <h2>Kaupade otsing</h2>
    <label for="otsisona">Otsisõna:</label>
    <input type="text" name="otsisona" value="<?php echo htmlspecialchars(isset($_REQUEST["otsisona"]) ? $_REQUEST["otsisona"] : ''); ?>">

    <label for="sorttulp">Sorteeri:</label>
    <select name="sorttulp">
        <option value="nimetus" <?php if($_REQUEST['sorttulp'] == 'nimetus') echo 'selected'; ?>>Nimetus</option>
        <option value="hind" <?php if($_REQUEST['sorttulp'] == 'hind') echo 'selected'; ?>>Hind</option>
        <option value="grupinimi" <?php if($_REQUEST['sorttulp'] == 'grupinimi') echo 'selected'; ?>>Grupp</option>
    </select>

    <input type="submit" value="Otsi">
</form>

<!-- Таблица товаров -->
<h2>Kaupade loetelu</h2>
<table>
    <tr>
        <th>Haldus</th>
        <th>Nimetus</th>
        <th>Kaubagrupp</th>
        <th>Hind</th>
    </tr>

    <?php foreach($kaubad as $kaup): ?>
        <tr>
            <td>
                <a href="index.php?kustutusid=<?=$kaup->id?>" onclick="return confirm('Kas ikka soovid kustutada?')">x</a>
                <a href="index.php?muutmisid=<?=$kaup->id?>">Muuda</a>
            </td>
            <td><?=htmlspecialchars($kaup->nimetus)?></td>
            <td><?=htmlspecialchars($kaup->grupinimi)?></td>
            <td><?=htmlspecialchars($kaup->hind)?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
// Форма изменения товара
if(isset($_REQUEST["muutmisid"])) {
    $muudetudid = $_REQUEST["muutmisid"];
    $kaup = null;

    // Находим товар для изменения
    foreach ($kaubad as $k) {
        if ($k->id == $muudetudid) {
            $kaup = $k;
            break;
        }
    }

    if ($kaup):
        ?>
        <!-- Форма изменения товара -->
        <h2>Muuda kaup</h2>
        <form action="index.php" method="get">
            <input type="hidden" name="muudetudid" value="<?= $kaup->id ?>">

            <label for="nimetus">Nimetus:</label>
            <input type="text" name="nimetus" value="<?= htmlspecialchars($kaup->nimetus) ?>" required>

            <label for="kaubagrupi_id">Kaubagrupp:</label>
            <?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id", $kaup->kaubagrupi_id); ?>

            <label for="hind">Hind:</label>
            <input type="text" name="hind" value="<?= htmlspecialchars($kaup->hind) ?>" required>

            <input type="submit" name="muutmine" value="Muuda kaup">
        </form>
    <?php endif; } ?>

</body>
</html>
