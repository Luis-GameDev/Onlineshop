<?php
session_start(); // Startet die Session zu Beginn der Datei
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Registrierung - Onlineshop</title>
    <style>
        html, body {
            padding: 0;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header {
            width: 100%;
            background-color: #333;  
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
            position: fixed;
            top: 0;
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
            margin-top: 80px; /* Abstand von Header */
            text-align: center; /* Zentriert den Text im Formular */
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #5a52e4;
        }

        .message {
            margin: 15px 0;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
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
    </style>
</head>
<body>
    
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="#">Shopping Cart</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <div class="form-container">
        <h1>Registrierung</h1>

        <!-- Fehlermeldung oder Erfolgsmeldung -->
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="message error">' . htmlspecialchars($_GET['error']) . '</div>';
        } elseif (isset($_GET['success'])) {
            echo '<div class="message success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>

        <form method="POST" action="register_backend.php">
            <label for="first_name">Vorname:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Nachname:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">E-Mail-Adresse:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>

            <label for="birthdate">Geburtsdatum:</label>
            <input type="date" id="birthdate" name="birthdate" required>

            <button type="submit">Registrieren</button>
        </form>

        <small>Haben Sie bereits einen Account? <a href="login.php">Jetzt einloggen!</a></small>
    </div>

</body>
</html>
