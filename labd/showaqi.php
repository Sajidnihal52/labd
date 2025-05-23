<?php
session_start();

if (!isset($_POST['selected']) || count($_POST['selected']) == 0) {
    echo "<h3>No rows selected.</h3>";
    exit;
}

$selected = $_POST['selected'];
if (count($selected) > 10) {
    echo "<h3>You selected more than 10 rows. Limit is 10.</h3>";
    exit;
}

$conn = new mysqli("localhost", "root", "", "labd");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$placeholders = implode(",", array_map('intval', $selected)); 
$sql = "SELECT * FROM aqi WHERE no IN ($placeholders)";
$result = $conn->query($sql);

$bgColor = $_SESSION['color'] ?? '#f4f4f4';
?>

<!DOCTYPE html>
<html>
<head>
    <title>SHOW</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: <?= htmlspecialchars($bgColor) ?>;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selected City and Country</h2>
        <table>
            <tr>
                <th>City</th>
                <th>Country</th>
                <th>AQI</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['City']}</td>
                            <td>{$row['Country']}</td>
                            <td>{$row['AQI']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
