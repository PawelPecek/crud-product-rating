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
    <title>Dodaj produkt</title>
</head>
<body>
    <h1>Dodaj produkt</h1>
    <form method="post" action="/crud-review/productValidation.php">
        <input name="name" placeholder="Nazwa" type="text" />
        <input value="Dodaj" type="submit" />
    </form>
    <a href="/crud-review/list.php">Wróc do listy</a>
</body>
</html>