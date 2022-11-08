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
$name = $_POST["name"];
if (empty($name)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak nazwy</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
require_once "db.php";
$db= new mysqli(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_DATABASE, DATABASE_PORT);
if ($db->connect_error) {
    die("Błąd połączenia: " . $db->connect_error);
}
$name = $db -> real_escape_string($name);
$result = $db -> query("SELECT product FROM product WHERE product = '$name'");
if ($result->num_rows > 0) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Produkt o takiej nazwie już istnieje</h1>
        <br><br>
        <a href="/crud-review/list.php">Powrót</a>
        '
    );
    return;
}
if ($db -> query("INSERT INTO product (product) VALUES ('$name')") === TRUE) {
    $db->close();
    header("Location: /crud-review/list.php");
} else {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Błąd połączenia w bazie danych</h1>
        <br><br>
        <a href="/crud-review/list.php">Powrót</a>
        '
    );
    return;
}
?>