
<?php
require "logout.inc.php";
require "functions.inc.php";
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <title>TARpv23 jõulu konkursid</title>
    <link rel="stylesheet" href="konkurssstyle.css">
</head>
<body>
<h2>Login</h2>
<nav>
    <ul>
        <?php
        if (isset($_SESSION["useruid"])) {
            if ($_SESSION["role"] == "admin") {
                echo '<li><a href="KonkurssAdmin.php">Admin</a></li>';
            }
            if ($_SESSION["role"] == "kasutaja") {
                echo '<li><a href="KonkurssKasutaja.php">Kasutaja</a></li>';
                echo '<li><a href="konkursInfo.php">Info</a></li>';
            } else {
                echo '<li><a href="konkursInfo.php">Info</a></li>';
            }
            echo '
            <li>
                <form method="POST">
                    <input type="submit" class="submit-btn2" name="logout" value="Logout">
                </form>
            </li>';
        } else {
            echo '<li><a href="login.php">Login</a></li>';
            echo '<li><a href="signup.php">Registreeri</a></li>';
        }
        ?>
    </ul>
</nav>
<main>
    <div class="userLScontainer">
        <form action="login.inc.php" method="post">
            <div class="con">
                <div class="field-set">
                    <span class="input-item"><i class="fa fa-user-circle"></i></span>
                    <input class="form-input" id="txt-input" type="text" name="uid" placeholder="Kasutaja nimi" required>
                </div>
                <div class="field-set">
                    <span class="input-item"><i class="fa fa-key"></i></span>
                    <input class="form-input" type="password" placeholder="Parool" id="pwd" name="pwd" required>
                </div>
                <div class="">
                    <button class="submit-btn" type="submit" name="submit">Logi sisse</button>
                </div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p class='error-message'>Täida kõik väljad</p>";
                    }
                    if ($_GET["error"] == "wronglogin") {
                        echo "<p class='error-message'>Valed andmed</p>";
                    }
                }
                ?>
            </div>
        </form>
    </div>
</main>
</body>
</html>
<style>
    .submit-btn2 {
        color: white;
        background-color: red;
        border: none;
        font-size: 16px;
        font-weight: bold;
    }
</style>
