<?php
session_start();

// DB connection details
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "jobseeker";

// Connect to MySQL
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and collect form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $dob = $_POST["dob"];
    $country = $_POST["country"];
    $gender = $_POST["gender"];
    $user_type = $_POST["user_type"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query
    $sql = "INSERT INTO users (username, email, password, user_type, created_at)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_type);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database prepare error: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
