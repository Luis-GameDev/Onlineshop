<?php
session_start();

// Datenbankverbindung herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_onlineshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten abrufen
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];

    // Prüfen, ob die E-Mail bereits registriert ist
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Wenn die E-Mail existiert, wird der Benutzer zurück zur Registrierung geleitet
        header("Location: register.php?error=Diese Email ist bereits vergeben.");
        exit();
    } else {
        // Neues Benutzerkonto erstellen
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (first_name, last_name, email, password_hash, birthdate)
                VALUES ('$first_name', '$last_name', '$email', '$password_hash', '$birthdate')";

        if ($conn->query($sql) === TRUE) {
            // Benutzer-ID der neu erstellten Benutzers abrufen
            $user_id = $conn->insert_id;

            // Session-Daten setzen für automatischen Login
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;

            // Weiterleitung zur Startseite nach erfolgreicher Registrierung und Login
            header("Location: index.php");
            exit();
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
