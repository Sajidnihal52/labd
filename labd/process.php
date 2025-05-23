<?php
session_start();
// After validating/sanitizing the input...
if (isset($_POST['favcolor'])) {
    // Save the selected color in the session
    $_SESSION['color'] = $_POST['favcolor'];
}

// Then continue with your normal registration steps,
// like saving other info to the database, etc.

// Redirect to the next page where background will use this color
header("Location: request.php");
exit();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['fname']);
    $email   = htmlspecialchars($_POST['email']);
    $dob     = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $color   = htmlspecialchars($_POST['favcolor']);
    $gender  = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Not specified';
    $pass = htmlspecialchars($_POST['pass']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "labd";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO userinfo (name, email, dob, country, color, gender, pass) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL prepare error: " . $conn->error);  
}
    $stmt->bind_param('sssssss', $name, $email, $dob, $country, $color, $gender, $pass);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Registration Confirmation</title>
        <style>
            body { 
                font-family: papyrus, sans-serif; 
                background-color: #b3d1dd; 
                padding: 20px; 
            }
            .container { 
                background: white;
                padding: 20px; 
                border-radius: 5px; 
                width: 500px; 
                margin: auto;
                box-shadow: 0 0 30px rgba(31, 4, 61, 0.7);
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .button-group {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 20px;
            }
            .button { 
                background-color: #12af75; 
                color: white; 
                padding: 10px 15px; 
                border: none; 
                cursor: pointer;
                border-radius: 4px;
            }
            .button.cancel {
                background-color: #888;
            }
        </style>
        <script>
            function cancelRegistration() {
                window.location.href = 'index.html';
            }

            function confirmRegistration() {
                alert('Registration successful');
                window.location.href = 'index.html';
            }
        </script>
    </head>
    <body>
        <div class='container'>
            <h2>Confirm Your Registration Details</h2>
            <p><strong>Full Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Date of Birth:</strong> {$dob}</p>
            <p><strong>Country:</strong> {$country}</p>
            <p><strong>Favorite Color:</strong> 
                <span style='color: {$color};'>{$color}</span>
                <span style='display:inline-block;width:20px;height:20px;background-color:{$color};border:1px solid #000;margin-left:10px;'></span>
            </p>
            <p><strong>Gender:</strong> {$gender}</p>

            <div class='button-group'>
                <button class='button cancel' onclick='cancelRegistration()'>Cancel</button>
                <button class='button' onclick='confirmRegistration()'>Confirm</button>
            </div>
        </div>
    </body>
    </html>";
}
?>

