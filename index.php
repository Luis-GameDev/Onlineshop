<?php
session_start(); // Start the session at the beginning of the script
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Onlineshop</title>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        html, body {
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #searchInput {
            width: 300px;
            padding: 8px;
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        #searchResults {
            width: 300px;
            position: absolute;
            z-index: 999;
            background-color: white;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 4px;
            display: none;
            max-height: 200px;
            overflow-y: auto;
        }

        #searchResults div {
            padding: 8px;
            cursor: pointer;
        }

        #searchResults div:hover {
            background-color: #f0f0f0;
        }

        #searchResults div:active {
            background-color: #e0e0e0;
        }

        header {
            width: 100%;
            background-color: #333;  
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
            display: flex;
            justify-content: space-between; /* Aligns items on both sides */
            align-items: center; /* Centers vertically */
        }

        nav {
            display: flex;
            justify-content: flex-start;  /* Aligns nav items to the left */
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

        .username {
            color: white;
            font-size: 16px;
            margin-left: 20px;
            margin-right: 1em;
        }

        /* Right-aligned user info or login link */
        .user-info {
            display: flex;
            align-items: center;
            justify-content: flex-end; /* Aligns content to the right */
        }

        .user-info a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="#">Shopping Cart</a>
        </nav>
        
        <div class="user-info">
            <?php
            // If the user is logged in, display their name in the username div
            if (isset($_SESSION['first_name'])) {
                echo '<div class="username">Hallo, ' . htmlspecialchars($_SESSION['first_name']) . '!</div>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </div>
    </header>

    <input type="text" id="searchInput" name="searchName" placeholder="Search" autocomplete="off"/>
    <div id="searchResults"></div>

    <script>
        $("#searchInput").on("input", function() {
            var query = $(this).val(); 

            if (query.length > 0) {
                $.ajax({
                    type: "GET",
                    url: "search_items.php", 
                    data: { searchQuery: query },
                    success: function(response) {
                        if (response) {
                            $("#searchResults").html(response).show(); 
                        } else {
                            $("#searchResults").html("No results found.").show(); 
                        }
                    }
                });
            } else {
                $("#searchResults").hide(); 
            }
        });

        $(document).on("click", function(event) {
            if (!$(event.target).closest('#searchInput, #searchResults').length) {
                $("#searchResults").hide();
            }
        });

        $(document).on("click", "#searchResults div", function() {
            var selectedText = $(this).text();
            $('#searchInput').val(selectedText);
            $("#searchResults").hide(); 
        });
    </script>
</body>
</html>
