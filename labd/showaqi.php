<?php
if (!isset($_POST['selected']) || count($_POST['selected']) == 0) {
    echo "<h3>No rows selected.</h3>";
    exit;
}

$selected = $_POST['selected'];
if (count($selected) > 10) {
    echo "<h3>You selected more than 10 rows. Limit is 10.</h3>";
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "labd");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL IN clause
$placeholders = implode(",", array_map('intval', $selected)); 
$sql = "SELECT * FROM aqi WHERE no IN ($placeholders)";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selected AQI Data</title>
</head>
<body>
    <h2>Selected AQI Rows</h2>
    <table border="1" cellpadding="8">
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
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
