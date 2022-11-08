<?php
session_start();
$login = $_POST["login"];
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
$result = $db->query("SELECT id FROM user WHERE login = '$login' AND password = '$password'");
if ($result->num_rows === 0) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Hasło lub login nieprawidłowe</h1>
        <br><br>
        <a href="/crud-review/login.html">Powrót</a>
        '
    );
    return;
}
$_SESSION["login"] = $login;
$db->close();
header("Location: /crud-review/list.php");
?>