<?php
session_start();
if(empty($_SESSION["login"])) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Nie zalogowano</h1>
        <br><br>
        <a href="/crud-review/login.html">Powrót</a>
        '
    );
    return;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Stylesheet" href="style.css" />
    <title>Dodaj recenzje</title>
</head>
<body>
    <h1>Dodaj recenzje</h1>
    <form method="post" action="/crud-review/reviewValidation.php">
        <?php
            echo '<input type="hidden" name="login" value="' . $_SESSION["login"] . '">'
        ?>
        <select name="product">
            <option disabled selected hidden>Product</option>
            <?php
                require_once "db.php";
                $db = new mysqli(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_DATABASE, DATABASE_PORT);
                if ($db->connect_error) {
                    die("Błąd połączenia: " . $db->connect_error);
                }
                $result = $db -> query("SELECT product FROM product ORDER BY product");
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["product"] . '">' . $row["product"] . '</option>';
                }
                $db -> close();
            ?>
        </select>
        <p>Ocena:</p><p id="range-out">1</p>
        <input id="range-in" type="range" value="1" name="rating" min="1" step="1" max="5" />
        <script>
            document.querySelector("#range-in").addEventListener("input", e=>{
                document.querySelector("#range-out").textContent = e.target.value;
            });
        </script>
        <textarea name="content" placeholder="Recenzja:"></textarea>
        <input value="Dodaj" type="submit" />
    </form>
    <a href="/crud-review/list.php">Wróc do listy</a>
</body>
</html>