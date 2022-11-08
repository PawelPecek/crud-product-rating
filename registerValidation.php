<?php
session_start();
$login = $_POST["login"];
if ($_POST["password"] !== $_POST["repeat-password"]) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Hasła są niezgodne</h1>
        <br><br>
        <a href="/crud-review/register.html">Powrót</a>
        '
    );
    return;
}
$password = $_POST["password"];
if (empty($login)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak loginu</h1>
        <br><br>
        <a href="/crud-review/register.html">Powrót</a>
        '
    );
    return;
}
if (empty($password)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak hasła</h1>
        <br><br>
        <a href="/crud-review/register.html">Powrót</a>
        '
    );
    return;
}

require_once "db.php";
$db= new mysqli(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_DATABASE, DATABASE_PORT);
if ($db->connect_error) {
    die("Błąd połączenia: " . $db->connect_error);
}
$login = $db -> real_escape_string($login);
$password = hash('sha512', $password);
$result = $db -> query("SELECT id FROM user WHERE login = '$login' AND password = '$password'");
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
if ($db -> query("INSERT INTO user (login, password) VALUES ('$login', '$password')") === TRUE) {
    $_SESSION["login"] = $login;
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