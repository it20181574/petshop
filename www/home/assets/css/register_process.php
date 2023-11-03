<?php
session_start();
// Change these credentials to your actual database connection details
$conn = mysqli_connect('db', 'chathu', 'chathu', 'spicecenter');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email is already registered
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered. <a href='register.php'>Try again</a>";
    } else {
        $insert_query = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            // echo "Registration successful. <a href='index.php'>Login here</a>";
            header("Location: index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
