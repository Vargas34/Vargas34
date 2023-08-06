<?php

include('config.php');


$conn = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// Process form submission
if (isset($_POST['send'])) {

    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['password']);
    $hash = password_hash($pass, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, phone, email, pass) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $phone, $email, $hash);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }


    mysqli_stmt_close($stmt);
}


mysqli_close($conn);

?>

