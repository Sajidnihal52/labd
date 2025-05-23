<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "labd";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = trim($_POST['login_email']);
$pass = trim($_POST['login_pass']);

$sql = "SELECT * FROM userinfo WHERE email = ? AND pass = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));  // <- This will show you the real problem
}

mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION["login_email"] = $email;
    echo "Login successful! Welcome, " . htmlspecialchars($row['name']) . "!";
    header("refresh: 2; url = request.php");
    exit();
} else {
    echo "Invalid email or password.";
    header("refresh: 2; url = index.html");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
