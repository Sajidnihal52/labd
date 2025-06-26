<?php
session_start();

// Hardcoded admin and employer users
$hardcoded_users = [
    'admin' => ['email' => 'admin@example.com', 'password' => 'admin123'],
    'employer' => ['email' => 'employer@example.com', 'password' => 'employer123']
];

// DB connection parameters
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "jobseeker";

// Get POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$userType = $_POST['userType'] ?? '';

// Validation
if (!$email || !$password || !$userType) {
    die('Please fill all required fields.');
}

// Admin or Employer Login (Hardcoded)
if ($userType === 'admin' || $userType === 'employer') {
    if (
        isset($hardcoded_users[$userType]) &&
        $hardcoded_users[$userType]['email'] === $email &&
        $hardcoded_users[$userType]['password'] === $password
    ) {
        $_SESSION['email'] = $email;
        $_SESSION['userType'] = $userType;
        $_SESSION['username'] = ucfirst($userType) . "User"; // default display name

        // Redirect to dashboard
        header("Location: dashboard_{$userType}.php");
        exit();
    } else {
        echo '<p style="color:red; text-align:center;">Invalid admin/employer credentials. Please <a href="login.html">try again</a>.</p>';
        exit();
    }
}

// Jobseeker Login (From Database)
elseif ($userType === 'jobseeker') {
    // Connect to DB
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL to fetch id and password
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? AND user_type = 'jobseeker' LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Validate user
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            $_SESSION['userType'] = $userType;
            $_SESSION['userId'] = $userId; // ✅ For tracking jobseeker
            $_SESSION['username'] = explode('@', $email)[0]; // Optional friendly name

            header("Location: dashboard_jobseeker.php");
            exit();
        } else {
            echo '<p style="color:red; text-align:center;">Incorrect password. Please <a href="login.html">try again</a>.</p>';
        }
    } else {
        echo '<p style="color:red; text-align:center;">No jobseeker account found with that email. Please <a href="login.html">try again</a>.</p>';
    }

    $stmt->close();
    $conn->close();
}

// Invalid user type
else {
    echo '<p style="color:red; text-align:center;">Invalid user type selected. Please <a href="login.html">try again</a>.</p>';
}
?>
