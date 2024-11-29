<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Värske teade</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Värske teade</h1>
</header>

<main>
    <div class="teade">
        <h2>Teade:</h2>
        <p>
            <?php require("teade.txt"); ?>
        </p>
    </div>
</main>

<footer>
    <p>
        <?php require("tegija.txt"); ?>
    </p>
</footer>
</body>
</html>
