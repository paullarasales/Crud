<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content -->
</head>
<body>
    <?php
    error_reporting(E_ALL);
    ini_set('display errors', 1);
    require_once "dbcon.php";

    // Initialize variables
    $fname = '';
    $lname = '';
    $position = '';
    $updateMode = false;

    if (isset($_POST['submit'])) {
        if (isset($_POST['update-mode'])) {
            // Update the record
            $id = $_POST['update-mode'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $position = $_POST['position'];

            $query = "UPDATE information SET fname=:fname, lname=:lname, position=:position WHERE id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            

            $updateMode = false;
        } else {
            // Insert a new record
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $position = $_POST['position'];

            $query = "INSERT INTO information (fname, lname, position) VALUES ('$fname', '$lname', '$position')";
            $conn->exec($query);

            echo "Record added successfully.";

            $updateMode = false;
        }

        // Reset the flag for "Add" mode
        
    }

    if (isset($_GET['id'])) {
        // Fetch data for an existing record for updating
        $id = $_GET['id'];
        $query = "SELECT * FROM information WHERE id = $id";
        $stmt = $conn->query($query);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Pre-fill the form fields with existing data
        $fname = $data['fname'];
        $lname = $data['lname'];
        $position = $data['position'];

        // Set the flag for "Update" mode
        $updateMode = true;
    }
    ?>

    <?php if (!$updateMode) : ?>
        <!-- Display the form for adding records -->
        <form action="" method="post">
            First Name: <input type="text" name="fname" value=""><br><br>
            Last Name: <input type="text" name="lname" value=""><br><br>
            Position: <input type="text" name="position" value=""><br><br>
            <input type="submit" name="submit" value="Add">
        </form>
    <?php else : ?>
        <!-- Display the form for updating records on the same page -->
        <form action="" method="post">
            <input type="hidden" name="update-mode" value="<?php echo $id; ?>">
            First Name: <input type="text" name="fname" value="<?php echo $fname; ?>"><br><br>
            Last Name: <input type="text" name="lname" value="<?php echo $lname; ?>"><br><br>
            Position: <input type="text" name="position" value="<?php echo $position; ?>"><br><br>
            <input type="submit" name="submit" value="Update">
        </form>
    <?php endif; ?>

    <div class="data">
        <?php
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
                        echo "<td>
                            <form action='' method='get'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' value='Update'>
                            </form>
                        </td>";
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
