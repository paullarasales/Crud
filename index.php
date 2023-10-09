<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud-PHP</title>
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

            table td a {
                text-decoration: none;
            }
    </style>
</head>
<body>
    <form action="add.php" method="post">
        First Name:  <input type="text" name="fname"><br><br>
        Last Name:  <input type="text" name="lname"><br><br>
        Position:  <input type="text" name="position"><br><br>
        <input type="submit" name="submit" value="Add">
    </form>

    <div class="data">
        <?php
            require_once "dbcon.php";

            try {
                $query = "SELECT * FROM information";
                $stmt = $conn->query($query);

                if ($stmt) {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($data) > 0) {
                        echo "<table border='1'>";
                        echo "<tr><th>First Name</th><th>Last Name</th><th>Position</th><th>Update</th><th>Delete</th></tr>";

                        foreach ($data as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["fname"] . "</td>";
                            echo "<td>" . $row["lname"] . "</td>";
                            echo "<td>" . $row["position"] . "</td>";
                            echo "<td><a href='update.php?id=" . $row["id"] . "'>Update</a></td>";
                            echo "<td><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "No Data Found";
                    }
                } else {
                    echo "Error executing the query.";
                }
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        ?>
    </div>
</body>
</html>
