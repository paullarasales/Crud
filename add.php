<?php

if (isset($_POST["submit"])) {
    require_once "dbcon.php";

    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $position = $_POST["position"];

    $query = "INSERT INTO information (fname, lname, position)
            VALUES (:fname, :lname, :position)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':fname', $firstname);
    $stmt->bindParam(':lname', $lastname);
    $stmt->bindParam(':position', $position);
    $stmt->execute();

    header("Location: index.php");
    exit;
} else {
    echo "Something went wrong";
}