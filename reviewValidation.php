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
$product = $_POST["product"];
$rating = $_POST["rating"];
$content = $_POST["content"];
if (empty($product)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak nazwy produktu</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if (empty($rating)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak oceny</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if (!is_numeric($rating)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Ocena nie jest cyfrą</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if ($rating < 1) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Ocena nie może być mniejsza niż 1</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if (5 < $rating) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Ocena nie może być większa niż 5</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if (empty($content)) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Brak recenzji</h1>
        <br><br>
        <a href="/crud-review/list.php.html">Powrót</a>
        '
    );
    return;
}
if (strlen($content) > 2000) {
    echo(
        '
        <link rel="Stylesheet" href="style.css" />
        <h1>Recenzja nie może być dłuższa niż 2000 znaków</h1>
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
$login = $_SESSION["login"];
$product = $db -> real_escape_string($product);
$rating = $db -> real_escape_string($rating);
$content= $db -> real_escape_string($content);
if ($db -> query("INSERT INTO review (login, product, rating, content) VALUES ('$login', '$product', '$rating', '$content')") === TRUE) {
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