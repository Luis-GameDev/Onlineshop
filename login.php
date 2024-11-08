<?php
// Start the session to store user data once logged in
session_start();

// Datenbankverbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_onlineshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";  // Initialize an error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eingaben
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Clean the input to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Benutzer in der Datenbank suchen
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Passwort überprüfen
        if (password_verify($password, $row['password_hash'])) {
            // Login erfolgreich
            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Falsches Passwort!";
        }
    } else {
        $error_message = "Email-Adresse nicht gefunden!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Onlineshop</title>    
    <style>
        html, body {
            padding: 0;
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f7fa;
        }

        header {
            width: 100%;
            background-color: #333;  
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
        }

        nav {
            display: flex;
            justify-content: center;  
            align-items: center;     
        }

        nav a {
            color: white;  
            text-decoration: none;  
            padding: 10px 20px;  
            margin: 0 15px;  
            border-radius: 5px;  
            font-size: 16px;  
            transition: background-color 0.3s ease, color 0.3s ease;  
        }

        nav a:hover {
            background-color: #007bff;  
            color: #fff;  
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; 
            margin: 30px auto;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #6c63ff;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #5a52e4;
        }

        small {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }

        small a {
            color: #6c63ff;
            text-decoration: none;
        }

        small a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="#">Shopping Cart</a>
            <a href="#">Login</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <button type="submit">Login</button>
        </form>

        <!-- Show error message if login failed -->
        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <small>Haben Sie noch keinen Account? <a href="register.php">Jetzt registrieren!</a></small>
    </div>
</body>
</html>
