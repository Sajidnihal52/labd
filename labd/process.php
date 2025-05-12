<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['fname']);
    $email   = htmlspecialchars($_POST['email']);
    $dob     = htmlspecialchars($_POST['dob']);
    $country = htmlspecialchars($_POST['country']);
    $color   = htmlspecialchars($_POST['favcolor']);
    $gender  = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Not specified';

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
            }
            .button { 
                background-color: #12af75; 
                color: white; 
                padding: 10px 15px; 
                border: none; 
                cursor: not-allowed;
            }
        </style>
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

            <button class='button' disabled>Confirmed</button>
        </div>
    </body>
    </html>";
}
?>
