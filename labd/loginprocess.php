<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "labd";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get login inputs
$email = trim($_POST['login_email']);
$pass = trim($_POST['login_pass']);

// Prepare SQL statement
$sql = "SELECT * FROM userinfo WHERE email = ? AND pass = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));
}

// Bind parameters and execute
mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if user exists
if ($row = mysqli_fetch_assoc($result)) {
    // Store email and name in session
    $_SESSION["login_email"] = $email;
    $_SESSION["username"] = $row['name'];

    echo "Login successful! Welcome, " . htmlspecialchars($row['name']) . "!";
    header("refresh: 2; url=request.php");
    exit();
} else {
    echo "Invalid email or password.";
    header("refresh: 2; url=index.html");
    exit();
}

// Clean up
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
