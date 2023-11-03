<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

echo "Welcome, $email!";
echo "<a href='logout.php'>Logout</a>";
