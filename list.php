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
    <title>Lista</title>
</head>
<body>
    <h1>Lista</h1>
    <select id="filter">
            <option value="" selected>Bez filtra produktu</option>
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
    <div id="avg-container" style="display:none">
        <p>Średnia wartość produktu</p>
        <p id="avg-out"></p>
    </div>
    <table>
        <tr>
            <th>Użytkownik</th>
            <th>Produkt</th>
            <th>Ocena</th>
            <th>Recenzja</th>
        </tr>
        <?php
            require_once "db.php";
            $db = new mysqli(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_DATABASE, DATABASE_PORT);
            if ($db->connect_error) {
                die("Błąd połączenia: " . $db->connect_error);
            }
            $result = $db -> query("SELECT * FROM review");
            while ($row = $result->fetch_assoc()) {
                echo('
                    <tr>
                        <td>' . $row["login"] . '</td>
                        <td>' . $row["product"] . '</td>
                        <td>' . $row["rating"] . '</td>
                        <td>' . $row["content"] . '</td>
                    </tr>
                ');
            }
            $db -> close();
        ?>
    </table>
    <a href="/crud-review/formProduct.php">Dodaj produkt</a>
    <a href="/crud-review/formReview.php">Dodaj recenzje</a>
    <a href="/crud-review/logout.php">Wyloguj się</a>
    <script>
        const rows = Array.from(document.querySelectorAll("tr")).filter((el, ind)=>ind!=0);
        document.querySelector("#filter").addEventListener("change", e=>{
            const filter = e.target.value;
            let sum = 0;
            let counter = 0;
            for (let i = 0; i < rows.length; i++) {
                if (filter == "") {
                    rows[i].style.display = "";
                } else {

                    if (filter != rows[i].querySelectorAll("td")[1].textContent) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "";
                        sum += parseInt(rows[i].querySelectorAll("td")[2].textContent);
                        counter++;
                    }
                }
            }
            if(filter == "") {
                document.querySelector("#avg-container").style.display = "none";
            } else {
                document.querySelector("#avg-container").style.display = "";
                document.querySelector("#avg-out").textContent = sum/((counter == 0) ? 1 : counter);
            }
        });
    </script>
</body>
</html>