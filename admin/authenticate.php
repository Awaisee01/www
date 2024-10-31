<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Password will be hashed and compared

    $sql = "SELECT * FROM `admin` where username = '$username' and password = '$password'";
    
    // echo $sql;
    $result = $conn->query($sql);
    
    

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
    } else {
        header('Location: login.php?error=1');
    }

    $conn->close();
}
?>
