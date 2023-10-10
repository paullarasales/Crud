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
    <h1>Update Record</h1>

    <?php
        require_once "dbcon.php";
        
        if (isset($_POST["update"])) {
            $id = $_POST["id"];
            $fname = $_POST["fname"];
            $lname = $_POST["lname"]; 
            $position = $_POST["position"];

            $query = "UPDATE information SET fname=:fname, lname=:lname, position=:position WHERE id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                header('Location: index.php'); 
                exit();
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } else {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $query = "SELECT * FROM information WHERE id=:id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
              ?>
              <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    First Name: <input type="text" name="fname" value="<?php echo $row["fname"]; ?>"><br><br>
                    Last Name: <input type="text" name="lname" value="<?php echo $row["lname"]; ?>"><br><br>
                    Position: <input type="text" name="position" value="<?php echo $row["position"]; ?>"><br><br>
                    <input type="submit" name="update" value="Update Employee">
              </form>
              <?php
                } else {
                    echo "Record not found.";
                }
            } else {
                echo "Invalid request.";
            }
        }
    ?>
    <a href="index.php">Back to Main Page</a>
</body>
</html>
