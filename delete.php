<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;1,600&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
            }
    </style>
</head>
<body>
            <?php

            require_once "dbcon.php";

            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $query = "DELETE FROM information WHERE id=:id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);

                if ($stmt->execute()) {
                    echo "Deleted successfully";
                    echo "<h1> Go back to main page </h1>";
                    echo "<a href='index.php'> Click here </a>";
                } else {
                    echo "Error Deleting record: " . $stmt->errorInfo()[2];
                    echo "<h1> Go back to main page </h1>";
                    echo "<a href='index.php'> Click here </a>";
                }

            } else {
                echo "Invalid request";
            }

            ?>
</body>
</html>

