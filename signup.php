<?php
// Connect to the database

$mysqli = new mysqli("localhost","root","","cat_registry");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


// Handling login form
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the user's password to protect it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create an INSERT query
    $query = "INSERT INTO user_details (email, password) VALUES (?, ?)";  // Use placeholders

    // Prepare the query
    $stmt = mysqli_prepare($mysqli, $query);

    if ($stmt) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "User registered successfully!";
            header("Location: main.html");
        } else {
            echo "Registration failed. Please try again.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in database query preparation.";
    }
}

// Close the database connection (you should close it after handling the form)
mysqli_close($mysqli);
?>
