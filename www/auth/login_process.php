<?php
session_start();
// Change these credentials to your actual database connection details
$conn = mysqli_connect('db', 'pet', 'pet', 'petshop');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect to a secure page
                $_SESSION['email'] = $row['email'];
                header("Location: ../home/index.php");
            } else {
                echo "Invalid password. <a href='index.php'>Try again</a>";
            }
        } else {
            echo "Email not found. <a href='register.php'>Register here</a>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
