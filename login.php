<?php
$mysqli = new mysqli("localhost","root","","cat_registry");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the hashed password from the database for the entered email
    $query = "SELECT * FROM user_details WHERE email = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $user['password'])) {
            // Successful login, redirect to main page
            header("Location: main.html");
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please check your email and try again.";
    }
}

// Close the database connection
mysqli_close($mysqli);
?>